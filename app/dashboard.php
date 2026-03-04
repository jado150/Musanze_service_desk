<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

include __DIR__ . '/../config/db.php';
include __DIR__ . '/../app/Booking.php';

$booking = new Booking($conn);

// Handle actions
if(isset($_GET['action'])){
    $id = $_GET['id'];
    if($_GET['action'] == 'complete'){
        mysqli_query($conn, "UPDATE bookings SET status='Completed' WHERE id=$id");
    } elseif($_GET['action'] == 'delete'){
        mysqli_query($conn, "DELETE FROM bookings WHERE id=$id");
    }
    header("Location: dashboard.php");
    exit();
}

// Get all bookings
$allBookings = $booking->getAllBookings();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
</head>
<body>

<h2>Welcome, <?php echo $_SESSION['admin']; ?>!</h2>
<p><a href="logout.php">Logout</a></p>

<h3>All Bookings</h3>

<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Service</th>
        <th>Date</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    <?php foreach($allBookings as $b): ?>
    <tr>
        <td><?php echo $b['id']; ?></td>
        <td><?php echo $b['name']; ?></td>
        <td><?php echo $b['phone']; ?></td>
        <td><?php echo $b['service']; ?></td>
        <td><?php echo $b['date']; ?></td>
        <td><?php echo isset($b['status']) ? $b['status'] : 'Pending'; ?></td>
        <td>
            <?php if(!isset($b['status']) || $b['status'] != 'Completed'): ?>
                <a href="?action=complete&id=<?php echo $b['id']; ?>">Complete</a> |
            <?php endif; ?>
            <a href="?action=delete&id=<?php echo $b['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>