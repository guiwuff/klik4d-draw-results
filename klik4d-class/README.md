# Klik4D PHP Class

> Standalone Klik4D PHP Class, offer greater flexibility but requires knowledge on PHP Scripting.

## Usage

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

## Draw Result Array

$klik4d->get_result() will return an array;

```php
<?php
	var_dump($drawResult);
?>
```

Example array elements

```
array(2) {
  ["lastUpdated"]=>
  int(1492311977)
  ["resultsArray"]=>
  array(7) {
    [0]=>
    array(3) {
      ["pool"]=>
      string(5) "SG 45"
      ["time"]=>
      int(1492041600)
      ["result"]=>
      string(4) "8061"
    }
    [1]=>
    array(3) {
      ["pool"]=>
      string(5) "SG 4D"
      ["time"]=>
      int(1492214400)
      ["result"]=>
      string(4) "4074"
    }
    [2]=>
    array(3) {
      ["pool"]=>
      string(5) "SG 49"
      ["time"]=>
      int(1492041600)
      ["result"]=>
      string(4) "5958"
    }
    [3]=>
    array(3) {
      ["pool"]=>
      string(5) "KL 4D"
      ["time"]=>
      int(1492214400)
      ["result"]=>
      string(4) "7409"
    }
    [4]=>
    array(3) {
      ["pool"]=>
      string(7) "KL TOTO"
      ["time"]=>
      int(1492128000)
      ["result"]=>
      string(4) "3812"
    }
    [5]=>
    array(3) {
      ["pool"]=>
      string(5) "HK 4D"
      ["time"]=>
      int(1492214400)
      ["result"]=>
      string(4) "9390"
    }
    [6]=>
    array(3) {
      ["pool"]=>
      string(7) "HK TOTO"
      ["time"]=>
      int(1492214400)
      ["result"]=>
      string(4) "7073"
    }
  }
}

```