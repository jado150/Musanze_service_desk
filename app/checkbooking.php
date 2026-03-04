<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: ../admin_login.php");
    exit();
}

include __DIR__ . '/../config/db.php';

// Make sure ID and action are set
if(isset($_GET['id']) && isset($_GET['status'])){
    $id = intval($_GET['id']);
    $status = $_GET['status'];

    $stmt = $conn->prepare("UPDATE records SET status=? WHERE id=?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
}

header("Location: dashboard.php");
exit();
?>