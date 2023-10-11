<?php
session_start();

if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

$inboxMessages = [
    ["sender" => "John", "message" => "Hi, how are you?", "timestamp" => "2023-09-30 10:15:00"],
    ["sender" => "Alice", "message" => "When are we meeting for lunch?", "timestamp" => "2023-09-29 14:30:00"],
    ["sender" => "Bob", "message" => "Can you help me with a coding problem?", "timestamp" => "2023-09-28 16:45:00"],
];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Messages</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <header>
        <h1>Messages</h1>
    </header>

    <nav>
        <ul>
            <li><a href="account.php">Back to Account</a></li>
        </ul>
    </nav>

    <main>
        <section class="inbox">
            <h2>Inbox</h2>
            <ul>
                <?php foreach ($inboxMessages as $message): ?>
                    <li>
                        <strong><?php echo $message["sender"]; ?>:</strong>
                        <p><?php echo $message["message"]; ?></p>
                        <small><?php echo $message["timestamp"]; ?></small>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> YourWebsiteName</p>
    </footer>
</body>
</html>
