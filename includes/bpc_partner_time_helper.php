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

