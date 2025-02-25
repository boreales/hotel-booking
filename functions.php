<?php

// Fonction pour obtenir le prix de base de la chambre
function getRoomPrice($roomType) {
    switch ($roomType) {
        case "Standard":
            return 50;
        case "Deluxe":
            return 100;
        case "Suite":
            return 200;
        default:
            return 0;
    }
}

// Fonction pour appliquer la majoration/réduction selon la saison
function applySeasonalPrice($basePrice, $season) {
    $highSeason = ["June", "July", "August", "December"];
    $lowSeason = ["January", "February", "November"];

    if (in_array($season, $highSeason)) {
        return $basePrice * 1.25; // +25%
    } elseif (in_array($season, $lowSeason)) {
        return $basePrice * 0.85; // -15%
    }
    return $basePrice;
}

// Fonction pour calculer les options supplémentaires
function calculateExtras($nights, $extras) {
    $totalExtras = 0;

    if (isset($extras["breakfast"])) {
        $totalExtras += $extras["breakfast"] * 10 * $nights;
    }
    if (isset($extras["spa"])) {
        $totalExtras += 30;
    }
    if (isset($extras["seaView"])) {
        $totalExtras += 20 * $nights;
    }

    return $totalExtras;
}

// Fonction pour calculer le prix final
function calculateTotalPrice($roomType, $nights, $dayOfArrival, $extras, $season, $roomsRequested, $previousBookings, $roomAvailability) {

    $baseRoomPrice = getRoomPrice($roomType);
    $adjustedPrice = applySeasonalPrice($baseRoomPrice, $season);
    $basePrice = $adjustedPrice * $nights * $roomsRequested;

    // Supplément week-end
    $weekendDays = ["Friday", "Saturday", "Sunday"];
    $weekendSurcharge = in_array($dayOfArrival, $weekendDays) ? 0.2 * $basePrice : 0;

    // Réduction fidélité
    $loyaltyDiscount = ($previousBookings > 5) ? 0.1 * ($basePrice + $weekendSurcharge) : 0;

    // Calcul des extras
    $extrasCost = calculateExtras($nights, $extras) * $roomsRequested;

    // Taxes et frais de service
    $taxes = 0.05 * ($basePrice + $weekendSurcharge + $extrasCost - $loyaltyDiscount);
    $serviceFee = 20;

    // Prix final
    $finalPrice = ($basePrice + $weekendSurcharge + $extrasCost - $loyaltyDiscount + $taxes + $serviceFee);

    return [
        "basePrice" => $basePrice,
        "weekendSurcharge" => $weekendSurcharge,
        "loyaltyDiscount" => $loyaltyDiscount,
        "extrasCost" => $extrasCost,
        "taxes" => $taxes,
        "serviceFee" => $serviceFee,
        "finalPrice" => $finalPrice
    ];
}

function renderBooking($roomType, $nights, $dayOfArrival, $extraOptions, $season, $roomsRequested, $previousBookings, $result, $roomAvailability) {
    $booking = [];
    $booking['type'] = $roomType;
    $booking['nb_rooms'] = $roomsRequested;
    $booking['available'] = $roomAvailability;
    $booking['begin_date'] = date('Y-m-d');
    $booking['end_date'] = date('Y-m-d', strtotime('+' . $nights . ' days'));
    $booking['nights'] = $nights;
    $booking['day_of_arrival'] = $dayOfArrival;
    $booking['season'] = $season;
    $booking['discount'] = $previousBookings > 6 ? '10%' : '0%';
    $booking['final_price'] = $result["finalPrice"];
    $booking['day_of_arrival'] = $dayOfArrival;
    $booking['extras'] = $extraOptions;
    $booking['previousBookings'] = $previousBookings;

    include 'templates/bookingTable.php';
}
