<?php
session_start();
require_once 'inc/spotify-auth.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Anaana's Music Zone</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="banner">
        <h1>Welcome to Anaana's Music Zone</h1>
        <p>Premium beats from Sweden to Somalia.</p>
    </div>

    <div class="user-info">
        <h2>Your Spotify Display Name:</h2>
        <?php
        if ($user && isset($user->display_name)) {
            echo "<p>" . htmlspecialchars($user->display_name) . "</p>";
        } else {
            echo "<p class='error'>Error: Unable to retrieve display name.</p>";
        }
        ?>
    </div>

    <div class="playlist">
        <h2>Featured Playlist</h2>
        <?php
        if ($playlist) {
            echo "<p>" . htmlspecialchars($playlist->name) . "</p>";
            echo "<iframe src='https://open.spotify.com/embed/playlist/" . $playlist->id . "' width='300' height='380' frameborder='0' allowtransparency='true' allow='encrypted-media'></iframe>";
        } else {
            echo "<p class='error'>Page not available. Something went wrong, please try again later.</p>";
        }
        ?>
    </div>

    <div class="buttons">
        <a href="index.php">Home</a>
        <a href="help.php">Help</a>
    </div>

    <footer>
        <p>© 2025 Anaana Vibes. All rights reserved.</p>
    </footer>
</body>
</html>
