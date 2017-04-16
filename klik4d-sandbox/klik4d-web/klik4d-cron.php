<?php
/**
*   Cronfile to be executed from linux cron
*   <gui.wuff@gmail.com> 16/04/2017
*   This is development example file, releases can be found in folder klik4d-class
**/
    // Klik4D class inclusion. Initialize
    require_once('klik4d-class.php');
    $klik4d = new Klik4d();

    // can be extended with additional function such as sending email to web admin
?>