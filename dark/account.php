<?php
session_start();

if (!isset($_SESSION["email"])) {
    header("Location: login.html");
    exit();
}

$userData = [
    "name" => $_SESSION["name"],
    "age" => $_SESSION["age"],
    "gender" => $_SESSION["gender"],
    "city" => $_SESSION["city"],
    "country" => $_SESSION["country"],
];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>User Account</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <header>
        <h1>Welcome, <?php echo $userData["name"]; ?></h1>
    </header>
    <div class="icon">
        <h2><a href="home.html" class="logo">Redbiller</a></h2>
      </div>
    <nav>
        <ul>
            <li><a href="#">Profile</a></li>
            <li><a href="messages.php">Messages</a></li> 
            <li><a href="settings.php">Settings</a></li> 
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <main>
        <section class="user-info">
        <h2 style="margin-top: 67px;">User Information</h2>
            <p>age: <?php echo $userData["age"]; ?></p>
            <p>Gender: <?php echo $userData["gender"]; ?></p>
            <p>City: <?php echo $userData["city"]; ?></p>
            <p>Country: <?php echo $userData["country"]; ?></p>
        </section>

    </main>

</body>
</html>
