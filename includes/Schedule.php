<?php
/**
 * Created by PhpStorm.
 * User: JESUS
 * Date: 3/25/2017
 * Time: 2:07 AM
 */

namespace App;


class Schedule {

    protected $datesFinal = [];
    protected $dates = [];
    protected $resultStandard = [];
    protected $resultCustom = [];
    protected $totalDays = 60;

    function __construct($resultStandard, $resultCustom)
    {
        /**
         * Final dates outputs
         */
        $datesFinal = [];

        /**
         * init
         */
        $dates = [];

        /**
         * result from db in standard
         */
        $this->resultStandard = $resultStandard;

        /**
         * result from db in custom
         */
        $this->resultCustom = $resultCustom;

        /**
         * Set timezone as uk
         */
         $this->setTimeZone();
    }


    public function setOpenDays($totalDays=0)
    {

        if(empty($totalDays)) {
            $totalDays = $this->totalDays;
        }

        /**
         * get date today
         */
        $dates[0]['date']       =  date("Y-m-d");
        $dates[0]['close']      = 'no';
        $dates[0]['day']        = strtolower(date('l', strtotime($dates[0]['date'])));

        // get 7 days from date today

        for($i=1; $i<$totalDays; $i++) {
            $dates[$i]['date'] = date('Y-m-d', strtotime($dates[0]['date'] . ' + '. $i . ' days'));
            $dates[$i]['close'] = 'no';
            $dates[$i]['day'] = strtolower(date('l', strtotime($dates[$i]['date'])));
        }
        //$this->print_r_pre($dates, "get 7 days");
        return $dates;
    }

    /**
     * filter date by standard
     */
    public function filterByStandard()
    {
        $dates = $this->setOpenDays();
        foreach($dates as $index => $date) {
            $dates[$index]['close'] = ($this->resultStandard[0][$date['day'] . '_close'] == 'yes') ? "yes" : "no";
        }

        //        $this->print_r_pre($dates, "after filter with standard");
        return $dates;
    }

    /**
     * filter date by custom and do override with the standard filter
     */
    public function filterByCustom() {

        $dates = $this->filterByStandard();

        foreach($dates as $index => $date) {
            foreach($this->resultCustom as $custom){
                if($date['date'] == $custom['date']) {
                    $dates[$index]['close']      = $custom['close'];
                }
            }
        }
        return $dates;
    }

    /**
     * remove all closed date
     */
    public function removeAllClosed()
    {
        $dates = $this->filterByCustom();
        $datesFinal = [];

        foreach($dates as $index => $date) {
            if($date['close'] == 'no') {
                $datesFinal[] = $date;
            }
        }
        return $datesFinal;
    }


    public function getFinalDates()
    {
        return $this->removeAllClosed();
    }


    public function getFinalDatesFlatten()
    {
        $dates = $this->removeAllClosed();
        $finalDates = [];
        foreach($dates as $date) {
            $finalDates[] = $date['date'];
        }

        return $finalDates;
    }

    public function getFinalDatesFlattenToJson()
    {
        return json_encode($this->convertToCalendarDateFormat());
    }

    public function convertToCalendarDateFormat() {

        $finalDate = [];
        $dates = $this->removeAllClosed();

        foreach($dates as $date) {
            $newDate = date("Y-n-j", strtotime($date['date']));
            $newDate1 = explode("-", $newDate);
            $newDate2 = $newDate1[2] . '-' . $newDate1[1] . '-' . $newDate1[0];
            $finalDate[] = $newDate2;
        }

        return $finalDate;
    }

    public function setTimeZone($timeZone='Europe/London')
    {
        date_default_timezone_set($timeZone);
    }

    /**
     * Pre functions
     * @param $array
     * @param $message
     */
    public function print_r_pre($array, $message = null) {
        print "<pre>";
        print "\n $message \n";
        print_r($array);
        print "</pre>";
    }
}
//
//$resultStandard = [
//    [
//        'monday_close'      => 'yes',
//        'tuesday_close'     => 'yes',
//        'wednesday_close'   => '',
//        'thursday_close'    => '',
//        'friday_close'      => '',
//        'saturday_close'    => '',
//        'sunday_close'      => ''
//    ]
//];
//
//$resultCustom = [
//    [
//        'date'  => '2017-03-24',
//        'close' => 'yes'
//    ],
//    [
//        'date'  => '2017-03-25',
//        'close' => 'yes'
//    ]
//];
//
//$schedule = new Schedule($resultStandard, $resultCustom);
//
//$schedule->print_r_pre($schedule->getFinalDatesFlattenToJson(), "Final Output");


