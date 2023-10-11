<?php
session_start();
function validatePassword($password) {
    $password_pattern = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/";

    return preg_match($password_pattern, $password);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $city = $_POST['city'];
    $country = $_POST['country'];

    if (validatePassword($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $conn = new mysqli('localhost', 'root', '', 'test');
        if ($conn->connect_error) {
            die('Connection Failed: ' . $conn->connect_error);
        } else {
            $check_email_query = "SELECT * FROM register WHERE email = ?";
            $check_email_stmt = $conn->prepare($check_email_query);
            $check_email_stmt->bind_param("s", $email);
            $check_email_stmt->execute();
            $result = $check_email_stmt->get_result();

            if ($result->num_rows > 0) {
                $response = array("message" => "Email already exists. Please use a different email.");
            } else {
                $stmt = $conn->prepare("INSERT INTO register(name, email, age, password, gender, city, country) VALUES(?,?,?,?,?,?,?)");
                $stmt->bind_param("ssissss", $name, $email, $age, $hashed_password, $gender, $city, $country);
                $stmt->execute();

                $response = array("message" => "Registration successful.");

                header("Content-Type: application/json");
                echo json_encode($response);
                exit();

                $stmt->close();
            }

            $check_email_stmt->close();
            $conn->close();
        }
    } else {
        $response = array("message" => "Invalid password. It must contain at least 8 characters, including at least one letter, one digit, and one special character (@, $, !, %, *, #, ?, or &).");
        header("Content-Type: application/json");
        echo json_encode($response);
    }
}
?>
