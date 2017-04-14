<?php
// Klik4D Draw testing classes without wordpress

// Class file
require_once('class-klik4d-general.php');	

// Construct
$fetchdata = new Klik4d_Draw();
$data = $fetchdata->update_data();

var_dump($data);
?>