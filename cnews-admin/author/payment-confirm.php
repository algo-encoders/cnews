<?php
use \CNEWS\Payments;


if(!empty($_POST) && isset($_POST['txn_type']) && isset($_POST['txn_id'])){
    if(Payments::verify_transaction($_POST) && Payments::check_txin_id($_POST['txn_id'])){
        Payments::add_payment($_POST);
    }
}
