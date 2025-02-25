<?php
include 'header.php';
include 'functions.php';
require 'config/db.php';

// Disponibilités des chambres
$rooms = $db->query("SELECT * FROM room")->fetchAll();
echo "<hr><div class='row'>";
foreach ($rooms as $room) {
    switch ($room['type']) {
        case 'Standard':
            $img = 'uploads/vojtech-bruzek-Yrxr3bsPdS0-unsplash.jpg';
            break;
        case 'Deluxe':
            $img = 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?q=80&w=3540&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D';
            break;
        case 'Suite':
            $img = 'https://images.unsplash.com/photo-1568495248636-6432b97bd949?q=80&w=3474&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D';
            break;
        default:
            $img = 'uploads/vojtech-bruzek-Yrxr3bsPdS0-unsplash.jpg';
            break;
    }


    echo "<div class='col-md-4'><div class='card'>";
    echo "<h3>".$room['type']."</h3>";
    echo "<img src=".$img." alt='Hotel room' height='200px'><br>";
    echo "<p>".$room['price']."€ per night</p><br><br>";
    echo "<a class='btn btn-info' href='bookingForm.php?type=".$room['type']."'>Book now</a>";
    echo "</div></div>";
}
echo "</div><hr>";
include 'footer.php';
