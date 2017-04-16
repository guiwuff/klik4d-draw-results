<?php
/**
*   To give example on how to display the array in PHP
*   <gui.wuff@gmail.com> 16/04/2017
*   This is release file
**/

// Open json file to get the most recent updated data
// Store content in $drawResult var

// if this file is not in the same directory with json file,
// can use $url and get the array using the same command
// json_decode() and file_get_contents

$url = 'klik4d-draw.json';
// example if different folder, using url
// $url = 'http://www.domain.com/klik4d/klik4d-draw.json''
$drawResult = json_decode(file_get_contents($url), true);
$date = new DateTime();
$date->setTimestamp($drawResult["lastUpdated"]);
$date->setTimezone(new DateTimeZone('Asia/Jakarta'));
$updateTime = $date->format('d/m/Y G:H:i');
?>

<?php
// iterate the array and display using HTML Tables
?>

<h1>Hasil Draw Klik4D</h1>
<pre>Last Update : <?php echo $updateTime." GMT+7"; ?></pre>

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
        <td><?php echo $row["time"]; ?></td>
        <td><?php echo $row["pool"]; ?></td>
        <td class="result"><?php echo $row["result"]; ?></td>
    </tr>
<?php
    endforeach;
?>
</table>