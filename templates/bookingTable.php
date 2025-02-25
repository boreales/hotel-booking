<table class="table">
    <tr>
        <th>Room Type</th>
        <th>Rooms requested</th>
        <th>Nights</th>
        <th>Season</th>
        <th>Arrival Day</th>
        <th>Extras</th>
        <th>Discount</th>
        <th>Taxes</th>
        <th>Service fees</th>
        <th>Final Price</th>
    </tr>
    <?php
        echo "<tr>";
        echo "<td>" . $booking['type'] . "</td>";
        echo "<td>" . $booking['nb_rooms'] . "</td>";
        echo "<td>" . $booking['nights'] . "</td>";
        echo "<td>" . $booking['season'] . "</td>";
        echo "<td>" . $booking['day_of_arrival'] . "</td>";
        echo "<td>";
        foreach($booking['extras'] as $key => $extra) { echo $key."<br>"; }
        echo "</td>";
        echo "<td>" . $booking['discount'] . "<br>(".$booking['previousBookings']." previous bookings)</td>";
        echo "<td>(5%) applied</td>";
        echo "<td>20€</td>";
        echo "<td>" . number_format($booking["final_price"], 2) . "€ </td>";
        echo "</tr>";
    ?>
</table>
