<?php
session_start();

function validatePassword($password) {
    $password_pattern = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/";
    return preg_match($password_pattern, $password);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newPassword = $_POST["newPassword"];
    $email = $_SESSION["reset_email"];
    $token = $_SESSION["reset_token"];

    if (validatePassword($newPassword)) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $conn = new mysqli('localhost', 'root', '', 'test');
        if ($conn->connect_error) {
            die('Connection Failed: ' . $conn->connect_error);
        } else {
            $stmt = $conn->prepare("SELECT * FROM password_reset_tokens WHERE email = ? AND token = ? AND used = 0 AND NOW() <= expires_at");
            $stmt->bind_param("ss", $email, $token);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $stmt = $conn->prepare("UPDATE register SET password = ? WHERE email = ?");
                $stmt->bind_param("ss", $hashedPassword, $email);

                if ($stmt->execute()) {
                    $stmt = $conn->prepare("UPDATE password_reset_tokens SET used = 1 WHERE email = ? AND token = ?");
                    $stmt->bind_param("ss", $email, $token);
                    $stmt->execute();

                    echo "<h2>Password change successful.</h2>";
                    echo "<p>You can now <a href='../login.html'>login</a> with your new password.</p>";
                } else {
                    echo "<h2>Password change failed.</h2>";
                    echo "<p>Please try again.</p>";
                }
            } else {
                echo "<h2>Invalid or expired reset token.</h2>";
                echo "<p>Please request a new password reset link.</p>";
            }

            $conn->close();
        }
    } else {
        echo "Invalid password. It must contain at least 8 characters, including at least one letter, one digit, and one special character (@, $, !, %, *, #, ?, or &).";
    }
} else {
    echo "<h2>Invalid request.</h2>";
}
?>
