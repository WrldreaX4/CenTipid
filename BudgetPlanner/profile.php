<?php
session_start();

// Include the 'config.php' file with the correct path
include 'php/config.php';

if (!isset($_SESSION['unique_id'])) {
    header("location: login.php");
    exit();
}

$user_id = $_SESSION['unique_id']; // Retrieve 'unique_id' from the session

$message = array(); // Initialize an array to store messages.

if (isset($_POST['update_profile'])) {
    $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
    $update_lname = mysqli_real_escape_string($conn, $_POST['update_lname']);
    $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);

    // Update user's name and email
    $updateProfileQuery = "UPDATE users SET fname = '$update_name', lname = '$update_lname', email = '$update_email' WHERE unique_id = $user_id";

    if (mysqli_query($conn, $updateProfileQuery)) {
        $message[] = 'Profile information updated successfully.';
    } else {
        $message[] = 'Failed to update profile information: ' . mysqli_error($conn);
    }

    $old_pass = $_POST['old_pass'];
    $update_pass = mysqli_real_escape_string($conn, md5($_POST['update_pass']));
    $new_pass = mysqli_real_escape_string($conn, md5($_POST['new_pass']));
    $confirm_pass = mysqli_real_escape_string($conn, md5($_POST['confirm_pass']));

    if (!empty($update_pass) || !empty($new_pass) || !empty($confirm_pass)) {
        if ($update_pass !== $old_pass) {
            $message[] = 'Old password does not match.';
        } elseif ($new_pass !== $confirm_pass) {
            $message[] = 'New password and confirm password do not match.';
        } else {
            // Update the user's password
            $updatePasswordQuery = "UPDATE users SET password = '$new_pass' WHERE unique_id = $user_id";

            if (mysqli_query($conn, $updatePasswordQuery)) {
                $message[] = 'Password updated successfully.';
            } else {
                $message[] = 'Failed to update password: ' . mysqli_error($conn);
            }
        }
    }

    // Handle profile image update
    if ($_FILES['update_image']['size'] > 0) {
        $update_image = $_FILES['update_image']['name'];
        $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
        $update_image_folder = 'php/images/' . $update_image;

        if (move_uploaded_file($update_image_tmp_name, $update_image_folder)) {
            // Update the image in the database
            $updateImageQuery = "UPDATE users SET img = '$update_image' WHERE unique_id = $user_id";

            if (mysqli_query($conn, $updateImageQuery)) {
                $message[] = 'Image updated successfully.';
            } else {
                $message[] = 'Failed to update image: ' . mysqli_error($conn);
            }
        } else {
            $message[] = 'Failed to upload image.';
        }
    }
}

$select = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = $user_id");

if (mysqli_num_rows($select) > 0) {
    $fetch = mysqli_fetch_assoc($select);
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
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>CenTipid Update profile</title>
   <link rel="icon" type="image/x-icon" href="image/Cent-Tipid.png">
   <link rel="stylesheet" href="css/profile.css">

</head>
<body>
<header>
        <div class="containers">
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

<section class="dashboard">
<div class="update-profile">

   <?php
      $select = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
      if(mysqli_num_rows($select) > 0){
         $fetch = mysqli_fetch_assoc($select);
      }
   ?>

   <form action="" method="post" enctype="multipart/form-data">
     
      
        <?php
         if ($fetch['img'] == '') {
            echo '<img src="php/images/' . $row['img'] . '" alt="">';
         }else{
            echo '<img src="php/images/'.$fetch['img'].'">';
         }
         ?>

         <div class="prof">
        <span>Change Your Picture :</span>
            <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="imageBox">
        </div>
        
        <?php
         if(isset($message)){
            foreach($message as $message){
               echo '<div class="message">'.$message.'</div>';
            }
         }
      ?>
      <div class="flex">
         <div class="inputBox">
            <span>Your First Name :</span>
            <input type="text" name="update_name" value="<?php echo $fetch['fname']; ?>" class="box">
            <span>Your Last Name :</span>
            <input type="text" name="update_lname" value="<?php echo $fetch['lname']; ?>" class="box">
            <span>Your Email :</span>
            <input type="email" name="update_email" value="<?php echo $fetch['email']; ?>" class="box">
            
         </div>
         <div class="inputBox">
            <input type="hidden" name="old_pass" value="<?php echo $fetch['password']; ?>">
            <span>Old password :</span>
            <input type="password" name="update_pass" placeholder="Enter Previous password" class="box">
            <span>New password :</span>
            <input type="password" name="new_pass" placeholder="Enter New password" class="box">
            <span>Confirm password :</span>
            <input type="password" name="confirm_pass" placeholder="Confirm New password" class="box">
         </div>
      </div>
      
      <input type="submit" value="Update Profile" name="update_profile" class="btn">
   </form>

</div>
        </header>
<script src="js/home.js"></script>
    
</body>
</html>
