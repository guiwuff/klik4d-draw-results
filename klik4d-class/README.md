# Klik4D PHP Class

> Standalone Klik4D PHP Class, offer greater flexibility but requires knowledge on PHP Scripting.

## TL;DR

[https://en.wikipedia.org/wiki/TL;DR](https://en.wikipedia.org/wiki/TL;DR)

**You need to:**

*  Have at least 2 file in one folder `klik4d-cron.php` and `klik4d-class.php`
*  Able to call the cron file from linux cron using `wget -O /dev/null http://klik4d.local:3300/klik4d-cron.php` - please do replace the url with your own url
*  Able to iterate the array taken from `klik4d-draw.json` which hold the results array of the class, if not you can view the example `example.php`

## Update Draw Result

- In order to update the draw result, initialize Klik4d class from a php file
- The initialization of the class will fetch current draw result to klik4d website and store the result array into a json file called klik4d-draw.json in the same folder along with lastUpdated information
- For regular update call the php file from linux cron using wget, sample of the cron php can be view in [klik4d-cron.php](klik4d-cron.php)

Cron command sampe using wget (set in cpanel)

```
wget -O /dev/null http://klik4d.local:3300/klik4d-cron.php

```

## Class Usage

Complete php example usage is inside `example.php` file. 

```php
<?php
	// Klik4D class inclusion. Initialize
	require_once('klik4d-class.php');
	$klik4d = new Klik4d();
	$drawResults = $klik4d->get_result();
?>
```

`get_result()` is the only public method of Klik4d class. 

## Displaying Draw Result

Results Array would look like this

```
array{
	["lastUpdated"] => unixtime-updated,
	["resultsArray"]=> array(
		[0] => array(
			["pool"]=> pool-name,
			["time"]=> draw-unixtime,
			["result"]=> draw-result
		),
		[1] => array(
			["pool"]=> pool-name,
			["time"]=> draw-unixtime,
			["result"]=> draw-result
		)
	)
}
```
Full array results can be found in [array-result.txt](array-result.txt)

Get the last updated draw result from `klik4d-draw.json` you don't need to call Klik4D class everytime you want to see the draw result.


```php
<?php
	$url = 'klik4d-draw.json';
	// example if different folder, using url
	// $url = 'http://www.domain.com/klik4d/klik4d-draw.json''
	$drawResult = json_decode(file_get_contents($url), true);
?>
```


To display the resuly basically you just need to iterate `$drawResult` array, and also you have a last updated index inside it, convert using DateTime:: to get a readable time string and correct time zone;

```php
<?php
	$date = new DateTime();
	$date->setTimestamp($drawResult["lastUpdated"]);
	$date->setTimezone(new DateTimeZone('Asia/Jakarta'));
	$updateTime = $date->format('d/m/Y G:H:i');
	
	echo "Last Update : ".$updateTime;
?>
```
Will display : 
```
Last Update : 16/04/2017 15:15:26 GMT+7
```


## Display in HTML Table

As long as you iterate the results array correctly, you can display them using any kind of HTML element, the example file is using table;

```php
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

```



