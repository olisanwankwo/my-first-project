<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["email"])) {
    header("Location: login.php"); // Redirect to the login page if not logged in
    exit();
}

// Simulate user settings (you would store these in a database)
$userSettings = [
    "email_notifications" => true,
    "profile_visibility" => "public",
    "theme" => "light", // Added theme setting
    "language" => "english", // Added language setting
];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Settings</title>
    <link rel="stylesheet" type="text/css" href="styles.css"> <!-- Include your CSS file -->
</head>
<body>
    <header>
        <h1>Settings</h1>
    </header>

    <nav>
        <ul>
            <li><a href="account.php">Back to Account</a></li>
        </ul>
    </nav>

    <main>
        <section class="settings">
            <h2>Settings</h2>
            <form method="post" action="update_settings.php">
                <label for="email_notifications">Email Notifications:</label>
                <input type="checkbox" name="email_notifications" <?php echo ($userSettings["email_notifications"]) ? 'checked' : ''; ?>>
                <br>
                <label for="profile_visibility">Profile Visibility:</label>
                <select name="profile_visibility">
                    <option value="public" <?php echo ($userSettings["profile_visibility"] == 'public') ? 'selected' : ''; ?>>Public</option>
                    <option value="private" <?php echo ($userSettings["profile_visibility"] == 'private') ? 'selected' : ''; ?>>Private</option>
                </select>
                <br>
                <label for="theme">Theme:</label>
                <select name="theme">
                    <option value="light" <?php echo ($userSettings["theme"] == 'light') ? 'selected' : ''; ?>>Light</option>
                    <option value="dark" <?php echo ($userSettings["theme"] == 'dark') ? 'selected' : ''; ?>>Dark</option>
                </select>
                <br>
                <label for="language">Language:</label>
                <select name="language">
                    <option value="english" <?php echo ($userSettings["language"] == 'english') ? 'selected' : ''; ?>>English</option>
                    <option value="spanish" <?php echo ($userSettings["language"] == 'spanish') ? 'selected' : ''; ?>>Spanish</option>
                </select>
                <br>
                <input type="submit" value="Save Settings">
            </form>
        </section>
    </main>

</body>
</html>
