<?php

namespace CNEWS;

class Payments
{

    public static function post_payment(){
        $paypal_config = paypal_configurations();

        $current_user = User::get_user();

        $current_user_type = $current_user['user_type'];

        if(isset($_POST['pay_with_paypal'])){

            if(!isset($_POST['cnews_nonce']) || !cnews_verify_nonce($_POST['cnews_nonce'], 'cnews_nonce_action')){
                die('Sorry, your nonce did not verify');
            }else{

                if(is_logged_in() && ($current_user_type == 'N/A' || User::current_user_can('author') || User::current_user_can('reader'))){


                    // Grab the post data so that we can set up the query string for PayPal.
                    // Ideally we'd use a whitelist here to check nothing is being injected into
                    // our post data.

                    $cnews_subscription = $_POST['cnews_subscription'];
                    foreach ($cnews_subscription as $key => $value) {
                        $cnews_subscription[$key] = stripslashes($value);
                    }

                    $data_default = $_POST['data'];
                    foreach ($data_default as $key => $value) {
                        $data_default[$key] = stripslashes($value);
                    }

                    $subscription = $cnews_subscription['type'];
                    $subscription = explode('|', $subscription);
                    $subscription_type = $subscription[0];
                    $subscription_amount = $subscription[1];
                    $subscription_years = $cnews_subscription['years'];
                    $year_string = $subscription_years == 1 ? 'year' : 'years';
                    $subscription_type = $subscription_type == 'Both' ? 'Joint' : $subscription_type;
                    $item_name = $subscription_type. " subscription for the period of $subscription_years $year_string";

                    $data = [];
                    // Set the PayPal account.
                    $data['business'] = $paypal_config['email'];

                    // Set the PayPal return addresses.
                    $data['return'] = stripslashes($paypal_config['return_url']);
                    $data['cancel_return'] = stripslashes($paypal_config['cancel_url']);
                    $data['notify_url'] = stripslashes($paypal_config['notify_url']);

                    // Set the details about the product being purchased, including the amount
                    // and currency so that these aren't overridden by the form data.
                    $data['item_name'] = $item_name;
                    $data['a3'] = $subscription_amount * $subscription_years;
                    $data['p3'] = $subscription_years;
                    $data['t3'] = 'Y';
                    $data['currency_code'] = 'USD';


                    $data_default['item_number'] = $subscription_type.'|'.User::get_current_user_id().'|'.$subscription_years;

                    $data_default['item_number'] = base64_encode($data_default['item_number']);

                    // Build the query string from the data.
                    $data = array_merge($data_default, $data);


                    $queryString = http_build_query($data);

                    // Redirect to paypal IPN
                    header('location:' . $paypal_config['paypal_url'] . '?' . $queryString);
                    exit();

                }else{

                    CNotices::add_notice('not_authorized', 'error');
                }

            }

        }

    }

    public static function verify_transaction($data) {
        $paypal_config = paypal_configurations();
        $paypalUrl = $paypal_config['paypal_url'];

        $req = 'cmd=_notify-validate';
        foreach ($data as $key => $value) {
            $value = urlencode(stripslashes($value));
            $value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i', '${1}%0D%0A${3}', $value); // IPN fix
            $req .= "&$key=$value";
        }

        $ch = curl_init($paypalUrl);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
        $res = curl_exec($ch);

        if (!$res) {
            $errno = curl_errno($ch);
            $errstr = curl_error($ch);
            curl_close($ch);
            throw new Exception("cURL error: [$errno] $errstr");
        }

        $info = curl_getinfo($ch);

        // Check the http response
        $httpCode = $info['http_code'];
        if ($httpCode != 200) {
            throw new Exception("PayPal responded with http code $httpCode");
        }

        curl_close($ch);

        return $res === 'VERIFIED';
    }


    public static function check_txin_id($txnid) {
        $result = MDB()->queryFirstRow("SELECT * FROM payments WHERE txnid=%s", $txnid);
        return empty($result);
    }


    public static function  add_payment($data) {

        if(!empty($data)){

            $item_number = cnews_get_value('item_number', $data);
            $item_data = explode('|', base64_decode($item_number));

            $type = $item_data[0];
            $user = $item_data[1];
            $years = $item_data[2];



            if($user){
               $user_data = MDB()->queryFirstRow("SELECT * FROM users WHERE ID=%i", $user);

               if(!empty($user_data)){
                   $last_expiry = $user_data['subscription_expiry'];
                   if($last_expiry){
                       $last_expiry = strtotime($last_expiry);
                   }else{
                       $last_expiry = time();
                   }

                   $new_expiry = strtotime("+$years years", $last_expiry);
                   $new_expiry = cnews_db_time_stamp($new_expiry);

                   $payment_data = [
                       'txnid' => cnews_get_value('txn_id', $data),
                       'user_id' => $user,
                       'subscription_type' => $type,
                       'payment_status' => cnews_get_value('payment_status', $data),
                       'item_number' => cnews_get_value('item_number', $data),
                       'payment_title' => cnews_get_value('transaction_subject', $data),
                       'expiry_date' => $new_expiry,
                       'payer_email' => cnews_get_value('payer_email', $data),
                       'payer_id' => cnews_get_value('payer_id', $data),
                       'subscr_id' => cnews_get_value('subscr_id', $data),
                       'paid_amount' => cnews_get_value('payment_gross', $data),
                       'payment_date_paypal' => cnews_get_value('payment_date', $data),
                       'years' => $years,
                   ];


                    MDB()->query("INSERT INTO `payments` (`txnid`, `user_id`, `subscription_type`, `payment_status`,
                        `item_number`, `payment_title`, `payment_date`, `expiry_date`, `payer_email`, `payer_id`, `subscr_id`,
                        `paid_amount`, `years`, `payment_date_paypal`) VALUES (%s_txnid, %i_user_id, %s_subscription_type,
                                                                               %s_payment_status, %s_item_number, %s_payment_title, current_timestamp(),
                                                                               %s_expiry_date, %s_payer_email, %s_payer_id,
                                                                               %s_subscr_id, %s_paid_amount, %i_years, %s_payment_date_paypal)", $payment_data);
                   MDB()->query("UPDATE users set subscription_expiry=%s, subscription_status=%i, user_type=%s WHERE ID=%i", $new_expiry, 1, $type, $user);

               }
            }



        }
        return false;
    }

}