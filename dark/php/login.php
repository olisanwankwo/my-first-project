<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $conn = new mysqli('localhost', 'root', '', 'test');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM register WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            $_SESSION["email"] = $email;
            $_SESSION["name"] = $row["name"];
            $_SESSION["age"] = $row["age"];
            $_SESSION["gender"] = $row["gender"]; 
            $_SESSION["city"] = $row["city"]; 
            $_SESSION["country"] = $row["country"]; 
            header("Location: ../account.php");
            exit();
        } else {
            echo '<p style="color: red;">Invalid password</p>';
        }
    } else {
        echo '<p style="color: red;">Email not found</p>';
    }

    $conn->close();
}
?>
