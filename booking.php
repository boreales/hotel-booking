<?php

require 'config/db.php';
require 'functions.php';
include 'header.php';

$bookingId = htmlspecialchars($_GET['id']);

$query = $db->prepare(
    'SELECT * FROM booking INNER JOIN booking_room ON booking_room.id_booking = booking.id INNER JOIN room ON booking_room.id_room = room.id WHERE booking.id = :id'
);
$query->bindParam('id', $bookingId);
$query->execute();

// Récupération de la réservation par un tableau associatif
$booking = $query->fetch(PDO::FETCH_ASSOC);

$roomType = $booking['type'];
$beginDate = new DateTime($booking['begin_date']);
$endDate = new DateTime($booking['end_date']);
$nights = $beginDate->diff($endDate)->days;
$dayOfArrival = $beginDate->format('l');

//Récupération des options de la réservation
$optionsQuery = $db->prepare(
    'SELECT * FROM booking_option INNER JOIN opt_in ON booking_option.option_id = opt_in.id WHERE booking_option.booking_id = :id'
);
$optionsQuery->bindParam('id', $bookingId);
$optionsQuery->execute();
$options = $optionsQuery->fetchAll(PDO::FETCH_ASSOC);
foreach ($options as $extra) {
    $extraOptions[$extra['name']] = $extra['quantity'];
}
$season = $beginDate->format('F');
$roomsRequested = $booking['nb_rooms'];
$roomAvailability = $booking['available'];


// Récupération du nombre de réservations précédentes
$userId = 1;
$previousQuery = $db->prepare('SELECT * FROM booking WHERE user_id = :user_id');
$previousQuery->bindParam('user_id', $userId);
$previousQuery->execute();

$previousBookings = $previousQuery->rowCount();

// Calcul du prix final
$result = calculateTotalPrice($roomType, $nights, $dayOfArrival, $extraOptions, $season, $roomsRequested, $previousBookings, $roomAvailability);

$db = null;

?>

<div class='container'>

    <div class="block-content">
        <img src='uploads/vojtech-bruzek-Yrxr3bsPdS0-unsplash.jpg' alt='Hotel room' style='width: 300px;'><br>
        <h2>Booking details</h2>

        <?php
            echo "<h3>From " . $beginDate->format('d/m/Y') . " to " . $endDate->format('d/m/Y') . "</h3>";
            renderBooking($roomType, $nights, $dayOfArrival, $extraOptions, $season, $roomsRequested, $previousBookings, $result, $roomAvailability);
        ?>

    </div>
</div>

<?php
include 'footer.php';
