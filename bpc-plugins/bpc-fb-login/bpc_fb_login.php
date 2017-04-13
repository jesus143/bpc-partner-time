<?php
/**
 * Plugin Name: BPC Facebook Login
 * Plugin URI:
 * Description: Facebook Login for bpc
 * Version: 1.0
 * Author: Jesus Erwin Suarez
 * Author URI:
 * License:
 */

define('bpc_fb_l_plugin_url', get_site_url() . '/wp-content/plugins/bpc-fb-login');
add_shortcode("bpc_fb_l_facebook_ui", "bpc_fb_l_facebook_ui_func");

function bpc_fb_l_facebook_ui_func()
{
    ?>

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> -->
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                // appId      : '677199829119257',
                appId      : '1844321809114387',
                cookie     : true,
                xfbml      : true,
                version    : 'v2.8'
            });
            FB.getLoginStatus(function(response) {
                statusChangeCallback(response);
            });
        };
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
        function bpc_fb_l_fb_login(){
            FB.login(function(response) {
                if (response.authResponse) {
                    console.log('Welcome!  Fetching your information.... ');
                    //console.log(response); // dump complete info
                    access_token = response.authResponse.accessToken; //get access token
                    user_id = response.authResponse.userID; //get FB UID
                    FB.api('/me?fields=id,first_name,last_name,email,gender,birthday', function(response) {
                        //user_email = response.email; //get user email
                        // you can store this data into your database
                        // procceed step 3
                        console.log(" start trigger click continue ");
                        // $('.proceed-btn-2').trigger( "click");
                       var l = document.getElementById('proceed-btn-2');
                       l.click();
                        console.log('Successful login for: ' + response.first_name + ' ' + response.last_name + response.email + response.gender + response.birthday);
                        document.getElementById('fb-status').innerHTML =
                            '<p>See Facebook user information below:</p> ' +
                            'Full Name: ' + response.first_name + ' ' + response.last_name + '<br>Email Address: ' + response.email + '<br>Gender: ' + response.gender + '<br>Birthday: ' + response.birthday;
                        document.getElementById('e3ve-first-name').value = response.first_name;
                        document.getElementById('e3ve-last-name').value = response.last_name;
                        document.getElementById('e3ve-email').value = response.email;
                        document.getElementById('e3ve-fbemail').value = response.email;
                        document.getElementById('e3ve-gender').value = response.gender;
                        document.getElementById('e3ve-birthday').value = response.birthday;


                        //                        if (response.gender == 'male') {
                        //                            document.getElementById('e3ve-title').value = 'Mr';
                        //                        } else if (response.gender == 'female') {
                        //                            document.getElementById('e3ve-title').value = 'Ms';
                        //                        }


                        var optionMale = 'Mr';
                        var optionFemale = ['Ms', "Miss", "Mrs"];
                        var selectGender = '#e3ve-title'; 
                        $(selectGender).html("");
                        if (response.gender == 'male') {
                            $(selectGender).append(new Option(optionMale, optionMale));
                        } else if (response.gender == 'female') {
                            for(var i = 0; i <optionFemale.length; i++) {
                                $(selectGender).append($(new Option(optionFemale[i], optionFemale[i])));
                            }
                        }


                        // $('.home-step-4').delay(1500).slideUp(500);     
                    });
                } else {
                    //user hit cancel button
                    console.log('User cancelled login or did not fully authorize.');
                }
            }, {
                scope: 'public_profile,email,user_birthday'
            });
        }
        (function() {
            var e = document.createElement('script');
            e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
            e.async = true;
            document.getElementById('fb-root').appendChild(e);
        }());
       // function continueNow(){
       //     alert("clicked continue");
       // }
    </script>

    <style>
    .btn:hover {
        background:#357ebd;
    }
    </style>



    <!-- Latest compiled and minified CSS -->
<!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">-->

    <!-- Optional theme -->
<!--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">-->

    <!-- Latest compiled and minified JavaScript -->
<!--    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>-->

    <link rel="stylesheet" type="text/css" href="https://lipis.github.io/bootstrap-social/bootstrap-social.css" />

    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    

    <div style="margin-top: 21px;"> 
        <a class="btn btn-block btn-social btn-facebook" onclick="bpc_fb_l_fb_login()" style="cursor: pointer;background-color:#3b5998;border-color: rgba(0,0,0,0.2);width: 231px;pad;padding: 8px  15px 8px 15%;">
            <span class="fa fa-facebook" style="line-height: 11px;font-size: 12px;text-align: left;width: 0px;background: #3b5998;"></span> Save Time & Continue with Facebook >
        </a>
    </div>
    <!-- <div class="fr-continue-btn"> <input type="button" onclick="continueNow()" class="proceed-btn-2" id="proceed-btn-2" value="Continue" />  </div>  -->
<?php
}