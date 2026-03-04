<!-- ISHIMWE REMY GENTIL    25/33045 -->

<?php
session_start();
include __DIR__ . '/../config/db.php';

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM admins WHERE username='$username' AND password='$password' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 1){
        $_SESSION['admin'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
</head>
<body>

<h2>Admin Login</h2>
<?php if(isset($error)){ echo "<p>$error</p>"; } ?>

<form action="" method="post">
    <label>Username</label><br>
    <input type="text" name="username" required><br><br>

    <label>Password</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit" name="login">Login</button>
</form>

</body>
</html>