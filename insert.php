<?php

include 'config.php';


$number = json_decode(file_get_contents("https://api.coinmarketcap.com/v1/ticker/sonm/?convert=EUR"), true);
$price = $number[0]['price_eur'];
$price = (float)$price;
$price = number_format($price * 100,1);
echo $price;

$statement = $pdo->prepare("INSERT INTO sonm(sonmValue)
                            VALUES ('". $price."')");

$statement->execute();