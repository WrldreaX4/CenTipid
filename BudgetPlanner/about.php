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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
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
            <h1>CenTipid</h1>
        </div>

        <div class="about">
            <h1>About Us</h1>
            <p>
            This project aims to help people, especially those with low incomes,
            overcome common budgeting challenges. Many struggle to organize, track, 
            and manage their money, leading to financial instability and stress.
            Without a solid budgeting plan, they risk falling into debt and
            failing to save for important goals like retirement or education.
            By addressing these issues, the project empowers individuals
            to take control of their finances and build a more secure future.
            </p>
        </div>

        <div class="card_container">
            <h1>Members</h1>
            <div class="boni">
                <img class="pfp" src="/image/Boni.png">
                <h2>Angelo Syrean B. Bonifacio</h2>
                <p>
                My name is Angelo Syrean Bonifacio, I'm 20 years old, studying Information Technology
                at Gordon College, and I always prioritize my tasks and academic requirements
                 despite having various hobbies.
                </p>
            </div>

            <div class="gwen">
                <img class="pfp" src="/image/Gwen.jpg">
                <h2>Gwynette Princess E. Rivera</h2>
                <p>
                I am a creative individual confident in various fields, including UI/UX design,
                Microsoft Office, and public speaking. My diverse skill set allows me to create
                intuitive user interfaces, manage information efficiently, and deliver engaging
                presentations. 
                </p>
            </div>

            <div class="jape">
                <img class="pfp" src="/image/Jape.png">
                <h2>Jhon Patrick G. Dela Cruz</h2>
                <p>
                I approach each project with passion and dedication, 
                ensuring meticulous attention to detail and efficient completion.
                My commitment to excellence drives me to consistently deliver
                high-quality results in every endeavor.
                </p>
            </div>

            <div class="andrea">
                <img class="pfp" src="/image/Andrea.jpg">
                <h2>Jasmin Andrea A. Turalba</h2>
                <p>
                A determined full-stack developer dedicated to achieving goals
                both frontend and backend development. With my skill set and
                unwavering commitment, I tackle challenges head-on to deliver innovative 
                solutions.
                </p>
            </div>
            
            <div class="edmar">
                <img class="pfp" src="/image/Edmar.png">
                <h2>Edmar M.<br>Pantoja</h2>
                <p>
                I effortlessly blend social interactions with task completion. 
                Known for my adaptable nature, I reliably meet deadlines and
                achieve objectives with ease and efficiency, fostering a 
                harmonious balance between work and social life.
                </p>
            </div>
         </div>

            <div class="contacts">
                <h3>Contact Us</h3>
                <p>099x-xxxx-xxx ● CenTipid@gmail.com ● <br> 321 xxxx, Olongapo City</p>
            </div>

</header>
</body>
</html>