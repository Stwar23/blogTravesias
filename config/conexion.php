<?php
$host = 'localhost';
$dbname = 'BLOG';
$username = 'root';
$password = 'root3103';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $pe) {
    die("No se pudo conectar a $dbname :" . $pe->getMessage());
}
?>