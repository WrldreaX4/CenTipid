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
     <link rel="stylesheet" href="css/home.css">
    <title>CenTipid Home</title>
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
                    <a href="home.php" class="active">Home</a>
                    <a href="profile.php">Profile</a>
                    <a href="about.php">About</a>
                    <a href="php/logout.php?logout_id=<?php echo $row['unique_id']; ?>">Logout</a>
                </div>
                <div class="navbar_acc">
                <img src="php/images/<?php echo $row['img']; ?>" alt="">

                </div>
            </div>
        </div>

        <div class="container">
            <div class="hero_section">
                <div class="acc_details">
                <img src="php/images/<?php echo $row['img']; ?>" alt="">
                    <div class="acc_txt">
                        <h3>Hello, <span><?php echo $row['fname'] . ' ' . $row['lname']; ?></span> </h3>
                        <h5>Welcome to CenTipid!</h5>
                    </div>
                </div>

                <div class="updates">
                    <div>Update</div>
                    <p>Stay connected for Upcoming Updates and Notification.</p>
                </div>
            </div>
        </div>

        <div class="container">
        <div class="error_message">
                <p>Plese Enter Budget Amount</p>
                </div>
          <ul class="cards">
            <li>
            <i class="bx bx-money"></i>
            <span class="info">
                <h3><span>₱ </span><span class="budget_card">0</span></h3>
                <p>Budget</p>
            </span>

            </li>
            <li>
                <i class="bx bx-credit-card"></i>
                <span class="info">
                    <h3><span>₱ </span><span class="expenses_card">0</span></h3>
                    <p>Expenses</p>
                </span>
                </li>

             <li>
                <i class="bx bx-dollar"></i>
                <span class="info">
                    <h3><span>₱ </span><span class="balance_card">0</span></h3>
                    <p>Balance</p>
                </span>                    
                </li>
          </ul>
        </div>

        <div class="containers">
                <div class="budget_content">
                    <div class="ur_budget">
                        <form>
                            <label for="budget">Your Budget :</label>
                            <input type="number" placeholder="Enter Budget" class="budget_input">
                            <button class="btn" id="btn_budget">Calculate</button>
                        </form>
                    </div>
                    <div class="ur_expenses">
                        <form>
                            <label for="expenses">Expenses Details :</label>
                            <input type="text" placeholder="Expenses Name" class="expenses_input">
                            <input type="number" placeholder="Amount" class="expenses_amount">
                            <button class="btn" id="btn_expenses">Add Expenses</button>
                        </form>
                    </div>
                </div>

                <section class="table_content">
                    <div class="tbl_data">
                        <h3>Budget Table</h3>
                        <!-------<ul class="tbl_tr_content">
                            <li>1</li>
                            <li>Keyboard</li>
                            <li>$ <span>900</span></li>
                            <li>
                                <button type="button" class="btn_edit">
                                <i class="bx bx-pen"></i>
                                </button>
                                <button type="button" class="btn_delete">
                                <i class="bx bx-trash"></i>
                                </button>
                            </li>

                        </ul>----->
                    </div>
                </section>
        </div>
    </header>
    <script src="javascript/home.js"></script>
</body>
</html>