<?php
    // Class File
    require_once('klik4d-class.php');

    // Initiate Object
    $klik4d = new Klik4d();

    $drawResult = $klik4d->get_result();

    echo $drawResult;


?>