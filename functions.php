<?php
/*-----------------------------------------------------------------------------------*/
/* Options Framework Functions
/*-----------------------------------------------------------------------------------*/
/* Set the file path based on whether the Options Framework is in a parent theme or child theme */
if ( STYLESHEETPATH == TEMPLATEPATH ) {
	define('OF_FILEPATH', TEMPLATEPATH);
	define('OF_DIRECTORY', get_bloginfo('template_directory'));
} else {
	define('OF_FILEPATH', STYLESHEETPATH);
	define('OF_DIRECTORY', get_bloginfo('stylesheet_directory'));
}

/* These files build out the options interface.  Likely won't need to edit these. */
require_once (OF_FILEPATH . '/admin/admin-functions.php');		// Custom functions and plugins
require_once (OF_FILEPATH . '/admin/admin-interface.php');		// Admin Interfaces (options,framework, seo)

/* These files build out the theme specific options and associated functions. */
require_once (OF_FILEPATH . '/admin/theme-options.php'); 		// Options panel settings and custom settings
require_once (OF_FILEPATH . '/admin/theme-functions.php'); 	// Theme actions based on options settings

//add support for featured images
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size(120);

//Get Partner's Info
    $path = $_SERVER["REQUEST_URI"];
    $preg = preg_split('/[^a-z0-9]/', $path);
      foreach ($preg  as $key => $namee) {
        if(($key == 3) && ($namee != '')) {
          $partner_id = $namee;
        }
      }

    $mydb = new wpdb('dbo640728737','1qazxsw2!QAZXSW@','db640728737','db640728737.db.1and1.com');
    $rows = $mydb->get_results("SELECT * FROM wp_user_profiles_mirror WHERE partner_id = ".$partner_id."");
    foreach ($rows as $obj) :
        $partner_id = $obj->partner_id;
        $company_name = $obj->company_name;
        $company_description = $obj->company_description;
        $full_name = $obj->full_name;
        $email_address = $obj->email_address;
        $mobile_phone = $obj->mobile_phone;
        $ratings1 = $obj->ratings1;
        $ratings2 = $obj->ratings2;
        $ratings3 = $obj->ratings3;
        $ratings4 = $obj->ratings4;
        $ratings5 = $obj->ratings5;
        $imageprof = $obj->image;
    //echo '<pre>';
     //var_dump($obj);
    //echo '</pre>';
    endforeach; 

//add to database bpccustomer, bpcbooking
if (isset ($_POST['bookphonecallsubmit'])) 
{
    $passwordtoken = bin2hex(openssl_random_pseudo_bytes(16));
    $title = $_POST['title'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $passwordtoken;
    $fbemail = $_POST['fbemail'];
    $dateofbirth = $_POST['birthday'];
    $gender = $_POST['gender'];
    $contact1 = $_POST['contactname1'];
    $contact2 = $_POST['contactname2'];
    $contact3 = $_POST['contactname3'];

    function bpcinsertcustomer( $title, $firstname, $lastname, $email, $password, $fbemail, $dateofbirth, $gender, $contact1, $contact2, $contact3 ) 
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'bpccustomer';
        $wpdb->insert( $table_name, array(
            'title' => $title,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'password' => $password,
            'fbemail' => $fbemail,
            'dateofbirth' => $dateofbirth,
            'gender' => $gender,
            'contact1' => $contact1,
            'contact2' => $contact2,
            'contact3' => $contact3
        ));      
    }
    bpcinsertcustomer( $title, $firstname, $lastname, $email, $password, $fbemail, $dateofbirth, $gender, $contact1, $contact2, $contact3 );

    global $wpdb;
    $table_name = $wpdb->prefix . 'bpccustomer';
    $myrows = $wpdb->get_results("SELECT bpccustomerid, email FROM ".$table_name." WHERE email = '$email' ORDER BY bpccustomerid DESC LIMIT 1");
        foreach ($myrows as $obj) :
            $bpccustomeridtoget = $obj->bpccustomerid;
        endforeach;

    $datetocallback = explode("/", $_POST['callbackdate']);
    $datetocallback = $datetocallback[2].'-'.$datetocallback[1].'-'.$datetocallback[0];
    $callbackdate = $datetocallback;
    $callbacktime = $_POST['time'];
    $partner_id = $partner_id;
    $enquirytype = $_POST['enquirytype'];
    $enquiry = $_POST['yourenquiry'];
    $company = '';
    $status = 'pending';
    $bpccustomerid = $bpccustomeridtoget;

    function bpcinsertcbooking( $callbackdate, $callbacktime, $partner_id, $enquirytype, $enquiry, $company, $status, $bpccustomerid ) 
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'bpcbooking';
        $wpdb->insert( $table_name, array(
            'callbackdate' => $callbackdate,
            'callbacktime' => $callbacktime,
            'partnersid' => $partner_id,
            'enquirytype' => $enquirytype,
            'enquiry' => $enquiry,
            'company' => $company,
            'status' => $status,
            'bpccustomerid' => $bpccustomerid
        ));
    }
    bpcinsertcbooking( $callbackdate, $callbacktime, $partner_id, $enquirytype, $enquiry, $company, $status, $bpccustomerid );
    $url = home_url('/thank-you/');   
    redirect($url); 
}

function redirect($url){
    $string = '<script type="text/javascript">';
    $string .= 'window.location = "' . $url . '"';
    $string .= '</script>';
    echo $string;
}