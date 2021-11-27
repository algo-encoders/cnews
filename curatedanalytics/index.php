<?php
    cnews_header();
?>
      <!--====== MAIN PART START ======-->
      <main>
       <!--====== ANALYTICS INTRO START ======-->
         <section id="privacy">
         <center>
         <div class="thecuratedflow_img_area">
                        <img src="../static/images/topanalytics.png" alt="top" class="img-fluid">
                     </div>
                     </center>
            <div class="container">
               <div class="privacy_wrap">
                  <div class="row">
                     <div class="col-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="privacy_heading">
                        <h1>The Curated Analytics Panel</h1>
                        <br></br>
                        <p class="b">The goal of this panel is to provide users easy interaction with our newly released Curated News Dataset. It focuses on news headlines. News headlines are some of the most widely and consistently consumed pieces of information on the internet. Shouldn't you know more about how it affects you and your behaviors? We think so. Hence, the analytics panel was born.</p><br></br>
         <section class="download_area">
               <h1>Are you a researcher?</h1>
               <div class="row">
                  <div class="col-lg-8 col-md-8 col-12">
                     <p class="b">Our dataset is available as a download. Guidelines for use are available in the codebook attached.</p>
                  </div>
                  <div class="col-lg-4 col-md-4 col-12">
                     <a href="../static/dataset/CuratedNewsDataset.zip">
                     <button class="btn download_button t">
                     <img src="../static/images/download.png" width="50px" height="50px">&nbsp;
                     Download</button>
                     </a>
                  </div>
               </div>
         </section>
                        </div>
                     </div>
                  </div>
         </section>
         <!--====== ANALYTICS POST INTRO END ======-->
         <!--====== PRIVACY PART START ======-->
         <div id="chart-wrapper">
            <div class="content-area">
               <div class="container-fluid">

                  <div class="main">

                     <div class="leaning-chart mb-5">

                        <section class="row mb-3">
                           <div class="col-md-12">
                              <div class="h1 text-white d-inline-block border-bottom border-primary" style="border-bottom-width: 3px !important;">Leaning Chart</div>
                           </div>
                        </section>

                        <section class="row mb-3">
                           <div class="col-md-4">
                              <label for="leaning_selection" class="text-white">Leaning Category</label><br>
                              <select name="" id="leaning_selection" multiple></select>
                           </div>
                           <div class="col-md-3 text-left pt-3">

                              <br>
                              <button class="btn btn-primary load_graph_leaning">Load Graph</button>
                           </div>
                        </section>

                        <div class="row mt-4 mb-3">
                           <div class="col-md-12">
                              <div class="box shadow mt-4">
                                 <div id="line-leaning-graph" class=""></div>
                              </div>
                           </div>
                        </div>

                        <section class="row">
                           <div class="col-md-12">
                              <hr class="bg-light"/>
                           </div>
                        </section>
                     </div>

                     <div class="source_chart mb-5">

                        <section class="row mb-3">
                           <div class="col-md-12">
                              <div class="h1 text-white d-inline-block border-bottom border-primary" style="border-bottom-width: 3px !important;">Source Chart</div>
                           </div>
                        </section>

                        <section class="row mb-3">
                           <div class="col-md-4">
                              <label for="source_selection" class="text-white">Source Category</label><br>
                              <select name="" id="source_selection" multiple></select>
                           </div>
                           <div class="col-md-3 text-left pt-3">

                              <br>
                              <button class="btn btn-primary load_graph_source">Load Graph</button>
                           </div>
                        </section>

                        <div class="row mt-4 mb-3">
                           <div class="col-md-12">
                              <div class="box shadow mt-4">
                                 <div id="line-source-graph" class=""></div>
                              </div>
                           </div>
                        </div>

                        <section class="row">
                           <div class="col-md-12">
                              <hr class="bg-light"/>
                           </div>
                        </section>
                     </div>

                     <div class="topic_chart mb-5">

                        <section class="row mb-3">
                           <div class="col-md-12">
                              <div class="h1 text-white d-inline-block border-bottom border-primary" style="border-bottom-width: 3px !important;">Topic Chart</div>
                           </div>
                        </section>

                        <section class="row mb-3">
                           <div class="col-md-4">
                              <label for="topic_selection" class="text-white">Topic Category</label><br>
                              <select name="" id="topic_selection" multiple></select>
                           </div>
                           <div class="col-md-3 text-left pt-3">

                              <br>
                              <button class="btn btn-primary load_graph_topic">Load Graph</button>
                           </div>
                        </section>

                        <div class="row mt-4 mb-3">
                           <div class="col-md-12">
                              <div class="box shadow mt-4">
                                 <div id="line-topic-graph" class=""></div>
                              </div>
                           </div>
                        </div>

                        <section class="row">
                           <div class="col-md-12">
                              <hr class="bg-light"/>
                           </div>
                        </section>
                     </div>

                     <div class="president_chart mb-5">

                        <section class="row mb-3">
                           <div class="col-md-12">
                              <div class="h1 text-white d-inline-block border-bottom border-primary" style="border-bottom-width: 3px !important;">President Chart</div>
                           </div>
                        </section>

                        <section class="row mb-3">
                           <div class="col-md-4">
                              <label for="president_selection" class="text-white">President Category</label><br>
                              <select name="" id="president_selection" multiple></select>
                           </div>
                           <div class="col-md-3 text-left pt-3">

                              <br>
                              <button class="btn btn-primary load_graph_president">Load Graph</button>
                           </div>
                        </section>

                        <div class="row mt-4 mb-3">
                           <div class="col-md-12">
                              <div class="box shadow mt-4">
                                 <div id="line-president-graph" class=""></div>
                              </div>
                           </div>
                        </div>

                        <section class="row">
                           <div class="col-md-12">
                              <hr class="bg-light"/>
                           </div>
                        </section>
                     </div>

                     <section class="row my-3">
                        <div class="col-md-4">
                           <input type="search" class="form-control search_news" placeholder="Enter your search here...">
                        </div>
                        <div class="col-md-3 text-left">
                           <button class="btn btn-primary search_news_btn">Search</button>
                        </div>
                     </section>

                     <section class="row my-3 result_row d-none">
                        <div class="col-md-12">
                           Showing <span class="showing">20</span> from <span class="from_results">0</span> results
                        </div>
                     </section>

                     <section class="row my-3">
                        <div class="col-md-12">
                           <hr class="bg-light">
                        </div>
                     </section>

                     <section class="row">
                        <div class="col-md-12 result_box">

                           <div class="alert alert-light text-center">Search results</div>

                        </div>
                     </section>



                     <section class="row load_more" style="display: none">
                        <div class="col-md-12 text-center">
                        <hr class="bg-light">
                        <section class="row my-3 result_row d-none">
                           <div class="col-md-12">
                              Showing <span class="showing">20</span> from <span class="from_results">0</span> results
                           </div>
                        </section>
                        <button class="btn btn-block btn-primary" data-current="1" data-total="">Load More...</button>
                        </div>
                     </section>






                  </div>
               </div>
            </div>
         </div>

         <!--====== PRIVACY PART END ======-->
      </main>
      <!--====== MAIN PART END ======-->

<?php

    cnews_footer();


?>

