<?php

require 'config/db.php';
require 'functions.php';
$userId = 1;

if(isset($_POST['begin_date']) && isset($_POST['end_date']) && isset($_POST['room_type']) && isset($_POST['nb_rooms'])) {
    //Sécuriser les données entrantes
    $beginDate = htmlspecialchars($_POST['begin_date']);
    $endDate = htmlspecialchars($_POST['end_date']);
    $nbRooms = htmlspecialchars($_POST['nb_rooms']);
    $roomType = htmlspecialchars($_POST['room_type']);
    $extras = $_POST['extras'];

    //Vérifier la disponibilité des chambres
    $availableQuery = $db->query("SELECT available FROM room WHERE type = '$roomType'");
    $available = $availableQuery->fetch()['available'];

    if ($available < $nbRooms) {
        echo 'Not enough rooms available';
        die;
    }

    $beginDateObject = new DateTime($beginDate);
    $endDateObject = new DateTime($endDate);
    $nights = $beginDateObject->diff($endDateObject)->days;
    $month = $beginDateObject->format('F');

    // Récupération du nombre de réservations précédentes
    $userId = 1;
    $previousQuery = $db->prepare('SELECT * FROM booking WHERE user_id = :user_id');
    $previousQuery->bindParam('user_id', $userId);
    $previousQuery->execute();

    $previousBookings = $previousQuery->rowCount();

    $price = calculateTotalPrice($roomType, $nights, $beginDateObject->format('l'), [], $month, $nbRooms, $previousBookings, $available);
    $price = $price['finalPrice'];

    $query = $db->prepare('INSERT INTO booking (begin_date, end_date, nb_rooms, user_id, price) VALUES (:beginDate, :endDate, :nbRooms, :userId, :price)');
    $query->bindParam('beginDate', $beginDate);
    $query->bindParam('endDate', $endDate);
    $query->bindParam('nbRooms', $nbRooms);
    $query->bindParam('userId', $userId);
    $query->bindParam('price', $price);
    $query->execute();

    $bookingId = $db->lastInsertId();
    foreach ($extras as $extra) {
        $extra = htmlspecialchars($extra);
        $query = $db->query("SELECT * FROM opt_in WHERE name='$extra'");
        $extraId = $query->fetch()['id'];
        $quantity = $nbRooms;

        $query = $db->prepare('INSERT INTO booking_option (booking_id, option_id, quantity) VALUES (:bookingId, :extraId, :quantity)');
        $query->bindParam('bookingId', $bookingId);
        $query->bindParam('extraId', $extraId);
        $query->bindParam('quantity', $quantity);
        $query->execute();
    }

    $availableQuery = $db->query("UPDATE room SET available = available - $nbRooms WHERE type = '$roomType'");
    $availableQuery->execute();

    header('Location: index.php');
}
