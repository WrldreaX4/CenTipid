<?php
session_start();
include "php/config.php";

if (!isset($_SESSION['unique_id'])) {
    header("location: login.php");
    exit();
}

$sql = "SELECT * FROM users WHERE unique_id = '{$_SESSION['unique_id']}'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css"> 
     <link rel="stylesheet" href="css/about.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <title>CenTipid About</title>
    <link rel="icon" type="image/x-icon" href="image/Cent-Tipid.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    
</head>
<body>
<header>
        <div class="container">
            <div class="navbar">
                <div class="navbar_logo">
                    <h2>CenTipid.</h2>
                </div>
                <div class="menu_items">
                    <a href="home.php">Home</a>
                    <a href="profile.php">Profile</a>
                    <a href="about.php">About</a>
                    <a href="php/logout.php?logout_id=<?php echo $row['unique_id']; ?>">Logout</a>
                </div>
                <div class="navbar_acc">
                <img src="php/images/<?php echo $row['img']; ?>" alt="">
                </div>
            </div>
        </div>

        <div class="img_logo">
            <img src="image/Cent-Tipid(nobg).png" alt="CenTipid Logo">
        </div>

</header>
</body>
</html>