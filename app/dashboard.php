<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

include __DIR__ . '/../config/db.php';
include __DIR__ . '/../app/Booking.php';

$booking = new Booking($conn);

// Handle status update
if(isset($_POST['update_status'])){
    $id = intval($_POST['id']);
    $status = $_POST['status'];
    $stmt = $conn->prepare("UPDATE bookings SET status=? WHERE id=?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
    header("Location: dashboard.php");
    exit();
}

// Handle delete
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM bookings WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
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
        <th>Service</th>
        <th>Total</th>
        <th>Date</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    <?php foreach($allBookings as $b): ?>
    <tr>
        <td><?php echo $b['id']; ?></td>
        <td><?php echo $b['Client']; ?></td>
        <td><?php echo $b['Services']; ?></td>
        <td><?php echo $b['Total']; ?></td>
        <td><?php echo $b['date']; ?></td>
        <td><?php echo $b['status']; ?></td>
        <td>
            <form method="post" style="margin:0;">
                <input type="hidden" name="id" value="<?php echo $b['id']; ?>">
                <select name="status" onchange="this.form.submit()">
                    <?php 
                        $current = isset($b['status']) ? $b['status'] : 'Pending';
                        $statuses = ['Pending','Completed','Cancelled'];
                        foreach($statuses as $s){
                            $selected = ($s == $current) ? 'selected' : '';
                            echo "<option value='$s' $selected>$s</option>";
                        }
                    ?>
                </select>
                <input type="hidden" name="update_status">
            </form>
        </td>
        <td>
            <a href="?delete=<?php echo $b['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>