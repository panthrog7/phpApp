<?php

$dbServername = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'duties_db';

$conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);


if ($mysqli->connect_err) {
    echo "Verbindung passt nicht!";
} else {
    echo "Verbindung passt!";
}
