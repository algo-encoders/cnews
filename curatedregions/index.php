<?php

    cnews_header();

    global $region_name;

    $all_states = file_get_contents(home_path('/curatedregions/curatedregionsdatabase.json'));
    $all_states = json_decode($all_states, true);
    $states_code = file_get_contents(home_path('/curatedregions/states.json'));
    $states_code = json_decode($states_code, true);
    $region_name = '';

    $current_state_name = array_filter($states_code, function ($single_state) use($region_code) {
        global $region_name;
        if(strtolower($region_code) == strtolower($single_state['Code'])){
            $region_name = $single_state['State'];
        }
    });

    $current_state_data = array();

    if($region_name):

    $current_state_data = array_filter($all_states, function ($single_state_data) {
        global $region_name;


        if($single_state_data['State'] == $region_name):

            return $single_state_data;
        endif;

    });

    endif;


?>
<!--====== MAIN PART ENDS ======-->
<main>
    <!--====== NEWS PART START ======-->
    <section id="heading_news">
        <div class="container">
            <div class="wrap_news">

                <?php

                if(!empty($current_state_data)):

                    ?>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="news_head">
                                    <h1 class="heading_title">U.S. State: <?php echo $region_name; ?></h1>
                                    <p class="heaading_shortInfo">Here is a list of all local news available in the state of <?php echo $region_name; ?>.</p>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-12">

                                <?php

                                foreach($current_state_data as $single_data):

                                ?>

                                <a href='<?php echo cnews_get_value('Link', $single_data); ?>'><?php echo cnews_get_value('Name', $single_data); ?></a><br></br>

                                <?php
                                    endforeach;
                                ?>
                            </div>
                        </div>

                    <?php

                else:

                ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="news_head">
                            <p class="heaading_shortInfo alert alert-danger">No Matching Record found.</p>
                        </div>
                    </div>
                </div>

                <?php
                endif;
                ?>

            </div>
        </div>
    </section>
    <!--====== NEWS PART ENDS ======-->
</main>
<!--====== MAIN PART ENDS ======-->

<?php cnews_footer(); ?>
