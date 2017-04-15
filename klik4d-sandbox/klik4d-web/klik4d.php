<?php
    // Class File
    require_once('klik4d-class.php');

    // Initiate Object
    $klik4d = new Klik4d();

    $drawResult = $klik4d->get_result();

    var_dump($drawResult[3]);

    echo "<hr>";
    echo $drawResult[1];
    echo "<hr>";
    echo $drawResult[2];

?>