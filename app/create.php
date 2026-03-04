<?php
include __DIR__ . '/../config/db.php';
require_once __DIR__ . '/Booking.php';

$booking = new Booking($conn);

if(isset($_POST['save'])) {
    $name    = $_POST['name'];
    $phone   = $_POST['phone'];
    $service = $_POST['service'];
    $date    = $_POST['date'];

    if($booking->saveBooking($name, $phone, $service, $date)) {
        $message = "Booking saved successfully!";
    } else {
        $message = "Failed to save booking!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Form</title>
</head>
<body>

<?php if(isset($message)) { echo "<p>$message</p>"; } ?>

<form action="" method="post">
    <label>Full Name</label><br>
    <input type="text" name="name" required><br><br>

    <label>Phone Number</label><br>
    <input type="text" name="phone" required><br><br>

    <label>Service</label><br>
    <select name="service" id="service" required>
        <option value="">-- Choose Service --</option>
        <option value="Event">Event</option>
        <option value="Hotel">Hotel</option>
        <option value="Transport">Transport</option>
        <option value="Product">Product</option>
    </select>
    <p id="estimate" style="margin-top:5px; font-size:14px; color:green;">Estimated Cost: $0</p>
<br>

    <label>Booking Date</label><br>
    <input type="date" name="date" required><br><br>

    <button type="submit" name="save">Submit Booking</button>
</form>

<script src="assets/js/app.js"></script>
</body>
</html>