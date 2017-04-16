<?php
    // Class File
    require_once('klik4d-class.php');

    // Initiate Object
    $klik4d = new Klik4d();

    //$drawResult = $klik4d->get_result();

    // echo $drawResult;

        /**
    *    $arr1 = array ('a'=>1,'b'=>2,'c'=>3,'d'=>4,'e'=>5);
    *    file_put_contents("array.json",json_encode($arr1));
    *    # array.json => {"a":1,"b":2,"c":3,"d":4,"e":5}
    *   $arr2 = json_decode(file_get_contents('array.json'), true);
    *   $arr1 === $arr2 # => true
    **/

    $arr2 = json_decode(file_get_contents('klik4d-draw.json'), true);
    var_dump($arr2);



?>