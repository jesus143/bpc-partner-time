<?php
/*
* Plugin Name: Partner Time Schedule
* Description: This plugin is to display the time schedule of each partner.
* Version: 1.0
* Author: MJ Suarez
* Author URI: 
*/
define( 'PLUGIN_DIR', dirname(__FILE__).'/' );  
define( 'PLUGIN_URL', get_site_url().'/wp-content/plugins/bpc-partner-time/');
add_shortcode("BPC_Partner_Time_Schedule", "bpc_partner_time_func");

function bpc_partner_time_func() 
{	
?>
	<script src="<?php print PLUGIN_URL;?>public/js/bpc_partner_time.js" > </script>
	<h3>Choose Time</h3>
	<div id="bpc-select-date-response">
        <div class="home-time-box">
          <div class="home-time-box-heading">
            <div class="home-time-box-heading-left">
              <h3><a href="#">Earlier</a></h3>
            </div>
            <div class="home-time-box-heading-right">
              <h3><a href="#">Later</a></h3>
            </div>
          </div>
          <div class="home-time-content">
            <div class="e3ve-home-time">
              	<h2 align="center" style="color: #fff;">Please Select a Call Back Date.</h2>
				<img src="https://bookphonecall.com/wp-content/uploads/2017/01/Calendar-PNG-Image.png" class="aligncenter" width="200">
            </div>
          </div>
        </div>		
	</div>
	<script>
	function timeFunction() { 
		if ( $("#callbackdate").val().length > 0 ) {
				document.getElementById('datepicked').innerHTML = $datenow;
				document.getElementById('timeselected').innerHTML = ($("input[name=time]:checked").val());
				jQuery('.home-step-2').delay(500).slideDown(500);
				jQuery('.home-step-1').delay(500).slideUp(500);
				jQuery('.home-step-3').delay(500).slideUp(500);
				jQuery('.home-step-4').delay(500).slideUp(500);
		}	
	}
	</script>
<?php
}