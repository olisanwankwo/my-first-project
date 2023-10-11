<?php
session_start();

if (!isset($_SESSION["email"])) {
    header("Location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emailNotifications = isset($_POST["email_notifications"]) ? 1 : 0;
    $profileVisibility = $_POST["profile_visibility"];
    $theme = $_POST["theme"];
    $language = $_POST["language"];

    $userSettings = [
        "email_notifications" => $emailNotifications,
        "profile_visibility" => $profileVisibility,
        "theme" => $theme,
        "language" => $language,
    ];

    $updateSuccessMessage = "Settings updated successfully!";
}

header("Location: settings.php?message=" . urlencode($updateSuccessMessage));
exit();
?>
