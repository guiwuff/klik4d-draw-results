<?php
/**
*   To give example on how to display the array in PHP
*   <gui.wuff@gmail.com> 16/04/2017
*   This is development example file, releases can be found in folder klik4d-class
**/

// Open json file to get the most recent updated data
// Store content in $drawResult var

// if this file is not in the same directory with json file,
// can use $url and get the array using the same command
// json_decode() and file_get_contents

//function to convert unixtime to readable timestring GMT +7
function timereadable($unixtime) {
    $date = new DateTime();
    $date->setTimestamp($unixtime);
    $date->setTimezone(new DateTimeZone('Asia/Jakarta'));
    $readable["full"] = $date->format('d/m/Y G:H:i');
    $readable["date"] = $date->format('d/m/Y');
    return $readable;
}

$url = 'klik4d-draw.json';
// example if different folder, using url
// $url = 'http://www.domain.com/klik4d/klik4d-draw.json''
$drawResult = json_decode(file_get_contents($url), true);
$updateTime = timereadable($drawResult["lastUpdated"]);

?>

<?php
// iterate the array and display using HTML Tables
?>

<h1>Hasil Draw Klik4D</h1>
<pre>Last Update : <?php echo $updateTime["full"]." GMT+7"; ?></pre>

<style>
    .table-border {
        border: 3px solid #d4d4d4;
        font-size: 14px;
        font-weight: normal;
        min-width: 400px;
    }

    .table-border tr td {
        padding: 8px;
        border-collapse: collapse;
        border: 1px solid #e4e4e4;
    }

    .table-border tr.headtab td{
        font-weight: bold;
        border-bottom : 2px solid #d4d4d4;
        background-color: #f4f4f4;
    }
    .result {
        font-size: 24px;
        font-weight: 200;
        color: #757575;
        letter-spacing: 1px;
    }
</style>

<table class="table-border">
    <tr class="headtab">
        <td>DATE</td>
        <td>POOL NAME</td>
        <td>RESULT</td>
    </tr>
<?php
    // iterate row
    foreach ($drawResult["resultsArray"] as $row) :
?>
    <tr>
        <td>
            <?php 
                $drawTime = timereadable($row["time"]);
                echo $drawTime["date"]; 
            ?>
        </td>
        <td><?php echo $row["pool"]; ?></td>
        <td class="result"><?php echo $row["result"]; ?></td>
    </tr>
<?php
    endforeach;
?>
</table>

<hr>

<h1>SG 45 Draw Result</h1>
<pre>Draw Date : <?php $drawTime = timereadable($drawResult["resultsArray"][0]["time"]);
                echo $drawTime["date"];?></pre>

<div>
<?php
    // Display using image file
    // Function to convert number to image
    function numtoimg($number){
        $imagefolder = "images-number/";
        $srcimage = $imagefolder.$number.".png";
        return $srcimage;
    }

?>
<?php
    $resultsg45 = $drawResult["resultsArray"][0]["result"];
    $i=0;
    while ( $i<4 ) :
        $number = substr($resultsg45,$i,1);
?>
        <img src="<?php echo numtoimg($number);?>">
<?php
        $i++;
    endwhile; 
    ?>
</div>