<?php

try {
    $db = new PDO('mysql:host=localhost;dbname=hotel', 'root', 'root');
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
