<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    
    $token = bin2hex(random_bytes(32));
    
    session_start();
    $_SESSION["reset_token"] = $token;
    $_SESSION["reset_email"] = $email;
    
    $reset_link = "http://localhost/dark/new-password.html?token=$token";
    
    $conn = new mysqli('localhost', 'root', '', 'test');
    if ($conn->connect_error) {
        die('Connection Failed: ' . $conn->connect_error);
    }
    
    $expirationTimestamp = date('Y-m-d H:i:s', strtotime('+1 hour'));
    
    $stmt = $conn->prepare("INSERT INTO password_reset_tokens (email, token, expires_at) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $token, $expirationTimestamp);
    
    if ($stmt->execute()) {
        $to = $email;
        $subject = "Password Reset Link";
        $message = "Click the following link to reset your password: $reset_link";
        
        $headers = "From: olisadnwanwko@gmail.com";
        $headers .= "\r\nReply-To: your_email@example.com";
        
        if (mail($to, $subject, $message, $headers)) {
            $response = array("message" => "Check your email for a password reset link.");
        } else {
            $response = array("message" => "Failed to send the password reset link. Please try again later.", "type" => "danger");
        }
    } else {
        $response = array("message" => "Failed to insert the token into the database.", "type" => "danger");
    }

    $stmt->close();
    $conn->close();

    header("Content-Type: application/json");
    echo json_encode($response);
}
?>
