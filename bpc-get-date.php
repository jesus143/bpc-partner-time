<?php

    /**  */
    require_once($_SERVER['DOCUMENT_ROOT'] . "/wp-load.php");
    require_once($_SERVER['DOCUMENT_ROOT'] .  "/wp-content/plugins/bpc-partner-time/helper.php");

    /** @var  $datenow */
    $datenow = $_GET['datenow'];
    $partner_id = $_GET['partnerid'];
	$datepiece = explode("/", $datenow); // 22/01/2017 -dd/mm/yyyy
	$datetofetch = $datepiece[2].'-'.$datepiece[1].'-'.$datepiece[0]; //2017-01-16 - yyyy-mm-dd
	$mydb = new wpdb('dbo639369002','1qazxsw2!QAZXSW@','db639369002','db639369002.db.1and1.com');
	$rows = $mydb->get_results("SELECT * FROM wp_bpc_appointment_settings WHERE partner_id = $partner_id
			&& date = '$datetofetch'");

//    print_r_pre($rows);

    if(!empty($rows)) {

//        print " not empty from wp_bpc_appointment_settings database table ";

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
            $updatedtime = $updatetimepiece[0].':'.$updatetimepiece[1];
        endforeach;

    } else {

        print " not empty from wp_bpc_appointment_setting_standard database table ";

        /** get standard settings */
        $rows = $mydb->get_results("SELECT * FROM wp_bpc_appointment_setting_standard WHERE partner_id = $partner_id", ARRAY_A );
        print_r_pre($rows);

        /** Get day based on query date */
        $dt  = strtotime($datetofetch);
        $day = date("D", $dt);
        $day  = strtolower($day);

        /** Get specific open_from and open_to based on standard settings results */
        $call_back_length = $rows[$day . '_open_from'];
        $call_back_delay   = $rows[$day . '_open_to'];

        /** if call back lenght is empty then set 15 mins default call back lenght */
        $call_back_delay   = $rows['call_back_delay'];

        /** if call back delay is empty then set 15 mins default call back delay */
        $call_back_length   = $rows['call_back_length'];
    }


    /** if call back lenght is empty then set 15 mins default call back lenght */
	if($call_back_length == '') {
		$call_back_length = '15 mins';
	}

    /** if call back delay is empty then set 15 mins default call back delay */
	if($call_back_delay == '') {
		$call_back_delay = '15 mins';
	}

//    print "begin $open_from, interval $call_back_length, end $open_to date to fetch $datetofetch <br>";

	/** initialized open from and open to as date */
	$begin = new DateTime($open_from);
	$end   = new DateTime($open_to);

	/** compose the interval as date */
	$interval = DateInterval::createFromDateString($call_back_length);

	/** set begin, interval and end as date period */
	$times = new DatePeriod($begin, $interval, $end);

	?>
	<ul class="left-time">
	<?php
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
			if(($time->format('H:i') >= $currenttime) and ($date == $currentdate)) {
				if( ($updateddate == $currentdate) and ($time->format('H:i') >= $updatedtime) and ($time->format('H:i') <= $callbackdelayandupdatedtimetotal) ) {
					//'In between the Call Back Delay';
				} else {
					$counter++;
					$container = 1;
					$timeA = $time->format('h:i A');
					$timeField[] = "<li><input name='time' value='$timeA' type='radio' id='e3ve-time' class='e3ve-cl-time' onclick='timeFunction(); bpc_tick_time_set_bg(\"$counter\")'  ><span class='e3ve-cl-times' id='e3ve-cl-times-$counter'>$timeA</span></li>";
				}
			} else if($date <> $currentdate) {
				$timeA = $time->format('h:i A');
				$counter++;
				$timeField[] = "<li><input name='time' value='$timeA' type='radio' id='e3ve-time' class='e3ve-cl-time' onclick='timeFunction(); bpc_tick_time_set_bg(\"$counter\")' ><span class='e3ve-cl-times' id='e3ve-cl-times-$counter'>$timeA</span></li>";
			}
		}

    /**
    * if timme field is not empty then display date times
    */
	if(!empty($timeField)) {

	    /** @var  $timeResultsArr */
		$timeResultsArr = bpc_getTimeResults($timeField);

		/**  */
		bpc_print_time($timeResultsArr);

	}

	/**
    * if time field is empty then display, No Schedule Display
    */
	else {

		bpc_print_no_time_display();

	}
	?>
    <script>
        /**
        *
        */
        function timeFunction()
        {
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
/**
 *
 *
 */
function bpc_print_no_time_display()
{
?>
	<div class="home-time-box">
		<div class="home-time-box-heading">
			<div class="home-time-box-heading-left">
			</div>
			<div class="home-time-box-heading-right">
				<h3></h3>
			</div>
		</div>
		<div class="home-time-content">
			<div class="e3ve-home-time" style="height: 197px;">
				<h1>No Schedule Display</h1>
			</div>
		</div>
	</div>
<?php
}

/**
 *
* @param $timeResultsArr
 */
function bpc_print_time($timeResultsArr)
{
	$arrowNext = -1;
	$arrowPrev = -1;
	foreach($timeResultsArr as $key1 => $valueArr1) {
		$arrowNext = ($valueArr1['arrow_next'] > -1) ? $valueArr1['arrow_next'] : -1;
		$arrowPrev = ($valueArr1['arrow_prev'] > -1) ? $valueArr1['arrow_prev'] : -1;
		$style     = ($key1 == 0) ? 'display:block' : 'display:none';
		?>
		<div class="home-time-box" id="bpc-home-time-box-display-<?php print $key1; ?>" style="<?php print $style; ?>">
		  <div class="home-time-box-heading">
			<div class="home-time-box-heading-left">
			  <h3>
				  <?php if($arrowPrev > -1) { ?>
					<a href="#" onclick="pbc_home_time_show('<?php print $arrowPrev; ?>')" >Earlier</a>
				  <?php } ?>
			  </h3>
			</div>
			<div class="home-time-box-heading-right">
			  <h3>
				  <?php if($arrowNext > -1) { ?>
					 <a href="#" onclick="pbc_home_time_show('<?php print $arrowNext; ?>')">Later</a>
				  <?php } ?>
			  </h3>
			</div>
		  </div>
		  <div class="home-time-content">
			<div class="e3ve-home-time">
				<?php
				foreach($valueArr1 as $key2 => $valueArr2) {
					if(!empty($valueArr2)) {
						if($key2 == 'lineA' or $key2 == 'lineB') {
							foreach ($valueArr2 as $key3 => $valueArr3) {
								if($key2 == 'lineA') {
									if($key3 === 'ul-class') {
										print '<ul class="left-time">';
									} else {
										print $valueArr3;
									}
								}
								if($key2 == 'lineB') {
									if($key3 === 'ul-class') {
										print '<ul class="right-time">';
									} else {
										print $valueArr3;
									}
								}
							}
							print "</ul>";
						}
					}
				}
				?>
			</div>
		  </div>
		</div>
	<?php
	}
}

/**
* @param $timeField
 * @return array
 */
function bpc_getTimeResults($timeField)
{
	/* Filter display */
	$fieldContainer = [];
	$newContainer = 0;
	$lineCounter = 0;
	$lineGroupName = '';
	$arrowNexCounter = 0;
	$arrowPrevCounter = 0;
		foreach($timeField as $key => $field) {
			if ($key % 10 == 0 and $key != 0) {
				// since found new container then open arrow next, increment arrow next counter
				$arrowNexCounter++;
				// add next arrow nex to previous container
				$fieldContainer[$newContainer]['arrow_next']  = $arrowNexCounter;
				// add new container counter
				$newContainer++;
				// add previews arrow to this new container
				$fieldContainer[$newContainer]['arrow_prev']  = $arrowPrevCounter;
				// since found new container then open arrow prev, and point arrow to the current container
				$arrowPrevCounter++;
				// reset line counter
				$lineCounter = 0;
			}
			// increment line counter
			$lineCounter++;
			if($lineCounter < 6) {
				// A line
				$lineGroupName = 'lineA';
				$ulContainerClass = 'left-time';
			} else {
				// B line
				$lineGroupName = 'lineB';
				$ulContainerClass = 'right-time';
			}
			// add class ul container
			if($lineCounter == 1 or $lineCounter == 6) {
				$fieldContainer[$newContainer][$lineGroupName]['ul-class'] = $ulContainerClass;
			}
			// add time button
			$fieldContainer[$newContainer][$lineGroupName][] = $field;
		}
		return $fieldContainer;
}