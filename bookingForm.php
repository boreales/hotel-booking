<?php
include 'header.php';
$roomType = htmlspecialchars($_GET['type']);
?>

<form method="post" action="addBooking.php">
    <div class="form-group">
        <label>Begin Date</label>
        <input type="date" name="begin_date" class="form-control">
    </div>
    <div class="form-group">
        <label>End Date</label>
        <input type="date" name="end_date" class="form-control">
    </div>
    <div class="form-group">
        <label>Room Type</label>
        <select name="room_type" class="form-control">
            <option <?php if($roomType == "Standard"): ?> selected <?php endif; ?> value="Standard">Standard</option>
            <option <?php if($roomType == "Deluxe"): ?> selected <?php endif; ?> value="Deluxe">Deluxe</option>
            <option <?php if($roomType == "Suite"): ?> selected <?php endif; ?> value="Suite">Suite</option>
        </select>
    </div>
    <div class="form-group">
        <label>Number of Rooms</label>
        <input type="number" name="nb_rooms" class="form-control">
    </div>
    <div class="form-group">
        <label>Extras</label>
        <div class="form-check form-check-inline">
            <input type="checkbox" name="extras[]" value="breakfast" class="form-check-input">
            <label>Breakfast</label>
        </div>
        <div class="form-check form-check-inline">
            <input type="checkbox" name="extras[]" value="spa" class="form-check-input">
            <label>Spa</label>
        </div>
        <div class="form-check form-check-inline">
            <input type="checkbox" name="extras[]" value="seaView" class="form-check-input">
            <label>Sea view</label>
        </div>
    </div>
    <button class="btn btn-info" type="submit">Book now</button>
</form>
<hr>

<?php
include 'footer.php';
?>
