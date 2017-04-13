<?php get_header(); ?>
<div id="home-content">
<form action="" method="post">
  <div id="inner-wrapper">
    <div id="home-content-inner" class="home-step-1">
      <div id="home-intro">
        <?php $businessProfile = get_option('of_businessProfile') ?>
        <?php query_posts('category_name='.$businessProfile.'&posts_per_page=1'); ?>
        <?php while (have_posts()) : the_post(); ?>
        <!-- Add your content here -->
        <div class="home-table-image">
          <img src="<?php echo $imageprof; ?>">
        </div>
        <div class="home-table-description">
          <div class="home-table-business-name">
            <h2>
              <?php 
                //the_title();
                echo $company_name; 
              ?>
            </h2>
          </div>
          <div class="home-table-business-info">
            <?php 
              //the_excerpt(); 
              echo $company_description;
            ?>
          </div>
        </div>
        <?php endwhile;?>
        <div class="home-table-checkbox">
          <ul class="ht-checkbox">
            <li><?php echo $ratings1; ?></li>
            <li><?php echo $ratings2; ?></li>
            <li><?php echo $ratings3; ?></li>
            <li><?php echo $ratings4; ?></li>
            <li><?php echo $ratings5; ?></li>
          </ul>
        </div>
      </div>
      <div id="home-date"> 
        <?php //echo get_option('of_step1left') ?> 
        <h3>Choose Date</h3>
        <div id="datepicker"></div>
        <p style="display: none;">Date Choosen: <input type="text" name="callbackdate" id="callbackdate"></p>
      </div>
      <div id="home-arrow-1"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/home-arrow.png" alt="" width="" height=""></div>
      <div id="home-time"> <?php echo get_option('of_step1right') ?> </div>
      <!--<div class="proceed-btn-1">Confirm Time & Date</div>-->
    </div>
    <div id="home-content-inner" class="home-step-2">
      <div class="prev-steps-wrapper">
        <div class="step-1-prev-btn"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/prev-btn-green-tick.png" width="21" height="21"> Step 1: Choose Time & Date (<span id="timeselected"></span> on <span id="datepicked"></span>)</div>
      </div>
      <div class="home-step-3-heading">
        <h2><?php echo get_option('of_step2heading') ?></h2>
      </div>
      <div class="home-step-3-content-container"> <?php echo get_option('of_step3content') ?>
        <div class="proceed-btn-3">Confirm Enquiry Type</div>
      </div>
    </div>
    <div id="home-content-inner" class="home-step-3">
      <div class="prev-steps-wrapper">
        <div class="step-1-prev-btn"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/prev-btn-green-tick.png" width="21" height="21"> Step 1: Choose Time & Date (<span id="timeselected1"></span> on <span id="datepicked1"></span>)</div>
        <div class="step-2-prev-btn"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/prev-btn-green-tick.png" width="21" height="21"> STEP 2: Choose Method (Logged In as BookPhoneCall.com User)</div>
      </div>
      <div class="home-step-2-heading">
        <h2><?php echo get_option('of_step3heading') ?></h2>
      </div>
      <div class="step-2-content-container">
        <div class="home-first-request"> <?php echo get_option('of_step2left') ?>
          <div class="fr-btns">
            <div class="fr-continue-fb-btn">


              <?php do_shortcode('[bpc_fb_l_facebook_ui]'); ?>



<!--                <fb:login-button autologoutlink="true" size="large" scope="public_profile,email,user_birthday" onlogin="checkLoginState();">-->
<!--                </fb:login-button>-->



                <!--<img src="http://www.caterkart.com/images/login-facebook.png" onclick="FB.login()" />-->
                <div id="fb-status" style="display: none;"></div>
            </div>
            <div class="fr-continue-btn"> <a href="<?php echo get_option('of_continuebtn') ?>" class="proceed-btn-2">Continue</a> </div>
          </div>
        </div>
        <div class="home-step-2-or">
          <h4>OR</h4>
        </div>
        <div class="home-step-2-login">
          <div class="home-step-2-login-inner"> <?php echo get_option('of_step2right') ?> </div>
        </div>
      </div>
    </div>
    <div id="home-content-inner" class="home-step-4">
      <div class="prev-steps-wrapper">
        <div class="step-1-prev-btn"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/prev-btn-green-tick.png" width="21" height="21"> Step 1: Choose Time & Date (<span id="timeselected2"></span> on <span id="datepicked2"></span>)</div>
        <div class="step-2-prev-btn"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/prev-btn-green-tick.png" width="21" height="21"> STEP 2: Choose Method (Logged In as BookPhoneCall.com User)</div>
        <div class="step-3-prev-btn"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/prev-btn-green-tick.png" width="21" height="21"> STEP 3: Enquiry Type (Consumer)</div>
      </div>
      <div class="home-step-4-heading">
        <h2><?php echo get_option('of_step4heading') ?></h2>
      </div>
      <div class="home-step-4-content-container">
        <div class="ca-fields-container">
          <ul class="ca-fields-inner-left">
            <?php echo get_option('of_step4left') ?>
          </ul>
          <ul class="ca-fields-inner-right">
            <?php echo get_option('of_step4right') ?>
          </ul>
        </div>
        <div class="bpc-agreement-input">
          <input name="agreement" value="agreement" type="checkbox" id="agreement">
        </div>
        <div class="bpc-agreement-label"><?php echo get_option('of_step4agreement') ?></div>
        <div class="bookphonecall-btn">
          <input class="bpc-btn" name="bookphonecallsubmit" id="bookphonecallsubmit" value="Book Phone Call Now" type="submit">
        </div>
      </div>
    </div>
  </div>
  </form>
</div>




<?php get_footer(); ?>
