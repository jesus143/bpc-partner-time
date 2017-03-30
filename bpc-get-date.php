<?php

    /**
     * Require files external and internal
     */
    require_once($_SERVER['DOCUMENT_ROOT'] . "/wp-load.php");
    require_once($_SERVER['DOCUMENT_ROOT'] .  "/wp-content/plugins/bpc-partner-time/helper.php");
    require_once("includes/bpc_partner_time_helper.php");


    /**
     * Initialized data and variables
     */

    $datenow      = $_GET['datenow'];

    $partner_id   = $_GET['partnerid'];

    $datepiece    = explode("/", $datenow); // 22/01/2017 -dd/mm/yyyy

    $datetofetch  = $datepiece[2] . '-' . $datepiece[1] . '-' . $datepiece[0]; //2017-01-16 - yyyy-mm-dd

    $mydb         = new wpdb('dbo639369002', '1qazxsw2!QAZXSW@', 'db639369002', 'db639369002.db.1and1.com');

    $morning      = '';

    $afternoon    = '';

    $evening      = '';

    /**
     * Get current user standard settings
     */
    $standardSetting = $mydb->get_results("SELECT * FROM wp_bpc_appointment_setting_standard WHERE partner_id = $partner_id ", ARRAY_A);
    $book_time_type  = $standardSetting[0]['book_time_type'];
    // $book_time_type  = 'Book Exact Time';

    //    print "<pre>";
    //        print_r($standardSetting);
    //    print "</pre>";
    //    print "<br>book time type $book_time_type<br>";
    //    print "<br>date selected  $datetofetch ";
    //    $newDateNow = date("Y-m-d", strtotime($datenow));
    //    print "<br>date selected new date 1  $newDateNow ";
    //    print "Test";

    /**
     * Check if standard book time type is "book time of day"
     * If book time type is book time of day
     * then set check display morning, noon, evening
     */
     if($book_time_type == 'Book Time Of Day')
     {
         //print "<br>inside book time of day if condition";
        /**
         * Get current day of the selected date
         */
         $day = strtolower(date('l', strtotime($datetofetch)));

         //print "<Br> current day selected " . $day;

        /**
         * Get selected checked for morning, noon and evening in specific day to standard
         * check current uk time and get status morning, noon or evening
         * then only display button the match the day status of uk time
         * so if uk time is noon then only display noon and evening
         * display ui for morning, noon, evening
         */
         $Hour = date('G');

         //print "<br> current horu $Hour";


         if ( $Hour >= 5 && $Hour <= 11 ) {
             // allow morning, noon and evening
             //echo "<br>Good Morning";

             $morning   =  $standardSetting[0][$day . '_morning'];
             $afternoon =  $standardSetting[0][$day . '_afternoon'];
             $evening   =  $standardSetting[0][$day . '_evening'];

         } else if ( $Hour >= 12 && $Hour <= 18 ) {

             // allow noon and evening
             //echo "<br>Good Afternoon";
             $afternoon =  $standardSetting[0][$day . '_afternoon'];
             $evening   =  $standardSetting[0][$day . '_evening'];

         } else if ( $Hour >= 19 || $Hour <= 4 ) {

             // allow evening
             //echo "<br>Good Evening";
             $evening   =  $standardSetting[0][$day . '_evening'];

         }

         /**
          * Generate and display ui
          */
        ?>



         <style>
             .time-day-button li {
                 display: inline;;
             }
             .e3ve-home-time h1 {
                 color:white !important;
             }
         </style>
         <?php


         /**
          * If morning, afternoon, and evening is empty
          */
         if($morning == '' && $afternoon == '' && $evening == '')
         {
             bpc_print_no_time_display();
         }
         else
         { ?>



            <div class="home-time-box" >
                <div class="home-time-box-heading" style="height: 43px;">

                </div>
                <div class="home-time-content" style="padding:19px; height: 154px;">
                    <div class="e3ve-home-time">
                        <ul class="left-time time-day-button" style="width:100% !important">

                         <?php
                         if($morning == 'yes')
                         {
                             print '<li>
                                <input name="time" value="Morning" type="radio" id="e3ve-time" class="e3ve-cl-time" onclick="timeFunction();bpc_tick_time_set_bg(1)">
                                <span class="e3ve-cl-times" id="e3ve-cl-times-1">Morning</span>
                            </li>';
                         }
                         if($afternoon == 'yes')
                         {
                             // print '<input name="time" value="Afternoon" type="radio" id="e3ve-time" class="e3ve-cl-time" onclick="timeFunction() ">';
                             print '<li>
                                <input name="time" value="Afternoon" type="radio" id="e3ve-time" class="e3ve-cl-time" onclick="timeFunction();bpc_tick_time_set_bg(2)">
                                <span class="e3ve-cl-times" id="e3ve-cl-times-2">Afternoon</span>
                            </li>';
                         }
                         if($evening == 'yes')
                         {
                             print '<li>
                                <input name="time" value="Evening" type="radio" id="e3ve-time" class="e3ve-cl-time" onclick="timeFunction(); bpc_tick_time_set_bg(3)">
                                <span class="e3ve-cl-times" id="e3ve-cl-times-3">Evening</span>
                            </li>';
                         }

                         ?>
                        </ul>
                    </div>
                </div>
            </div>
            <?php


    }
    }
    else
    {

        print "<br>inside book exact time ";

        $rows = $mydb->get_results("SELECT * FROM wp_bpc_appointment_settings WHERE partner_id = $partner_id
			&& date = '$datetofetch'");

        // print_r_pre($rows);

        if (!empty($rows)) {

            //print " not empty from wp_bpc_appointment_settings database table ";

            /** Initialized the retrieved data from database table phone settings in testing */
            foreach ($rows as $obj) :
                $date = $obj->date;
                $open_from = $obj->open_from;
                $open_to = $obj->open_to;
                $call_back_length = $obj->call_back_length;
                $call_back_delay = $obj->call_back_delay;
                $updated_at = $obj->updated_at;
                $updatepiece = explode(" ", $updated_at); // 2017-01-21 16:44:31 -yyyy-mm-dd hh:mm:ss
                $updateddate = $updatepiece[0]; //2017-01-21
                $updatedpiece = $updatepiece[1]; //16:44:31
                $updatetimepiece = explode(":", $updatedpiece);
                $updatedtime = $updatetimepiece[0] . ':' . $updatetimepiece[1];
            endforeach;

        } else {

            // print " empty from wp_bpc_appointment_setting_standard database table ";

            /** get standard settings */
            $resultStandard = $mydb->get_results("SELECT * FROM wp_bpc_appointment_setting_standard WHERE partner_id = $partner_id", ARRAY_A);
            $rows = $resultStandard[0];

            /** Get day based on query date */
            $day = strtolower(date('l', strtotime($datetofetch)));

            /** Get specific open_from and open_to based on standard settings results */
            $open_from = $rows[$day . '_open_from'];
            $open_to = $rows[$day . '_open_to'];

            /** if call back lenght is empty then set 15 mins default call back lenght */
            $call_back_delay = $rows['call_back_delay'];

            /** if call back delay is empty then set 15 mins default call back delay */
            $call_back_length = $rows['call_back_length'];
        }


        /**
         * if call back lenght is empty then set 15 mins default call back lenght
         */
        if ($call_back_length == '') {
            $call_back_length = '15 mins';
        }

        /**
         * if call back delay is empty then set 15 mins default call back delay
         */
        if ($call_back_delay == '') {
            $call_back_delay = '15 mins';
        }

        // print "begin $open_from, interval $call_back_length, end $open_to date to fetch $datetofetch <br>";

        /**
         * initialized open from and open to as date
         */
        $begin = new DateTime($open_from);
        $end = new DateTime($open_to);

        /**
         * compose the interval as date
         */
        $interval = DateInterval::createFromDateString($call_back_length);

        /**
         * set begin, interval and end as date period
         */
        $times = new DatePeriod($begin, $interval, $end);

        print '<ul class="left-time">';

        //print "test date breaks";
        /**
         * Inialized data
         */
        $currenttime = date('H:i');
        $currentdate = date("Y-m-d");
        $callbackdelayandcurrenttime = strtotime($call_back_delay, strtotime($updatedtime));
        $callbackdelayandupdatedtimetotal = date('H:i', $callbackdelayandcurrenttime);
        $container = 0;
        $counter = 0;

        // print_r_pre($times);

        /**
         * Calculate date times
         */
        foreach ($times as $time) {
            if (($time->format('H:i') >= $currenttime) and ($date == $currentdate)) {
                if (($updateddate == $currentdate) and ($time->format('H:i') >= $updatedtime) and ($time->format('H:i') <= $callbackdelayandupdatedtimetotal)) {
                    //'In between the Call Back Delay';
                } else {
                    $counter++;
                    $container = 1;
                    $timeA = $time->format('h:i A');
                    $timeField[] = "<li><input name='time' value='$timeA' type='radio' id='e3ve-time' class='e3ve-cl-time' onclick='timeFunction(); bpc_tick_time_set_bg(\"$counter\")'  ><span class='e3ve-cl-times' id='e3ve-cl-times-$counter'>$timeA</span></li>";
                }
            } else if ($date <> $currentdate) {
                $timeA = $time->format('h:i A');
                $counter++;
                $timeField[] = "<li><input name='time' value='$timeA' type='radio' id='e3ve-time' class='e3ve-cl-time' onclick='timeFunction(); bpc_tick_time_set_bg(\"$counter\")' ><span class='e3ve-cl-times' id='e3ve-cl-times-$counter'>$timeA</span></li>";
            }
        }

        /**
         * if timme field is not empty then display date times
         */
        if (!empty($timeField)) {

            /** @var  $timeResultsArr */
            $timeResultsArr = bpc_getTimeResults($timeField);

            /**  */
            bpc_print_time($timeResultsArr);

        } else {
            /**
             * if time field is empty then display, No Schedule Display
             */
            bpc_print_no_time_display();

        }

    }


