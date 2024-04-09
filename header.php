<?php
session_start(); // Start the session.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Algonquin Social Media</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Additional stylesheet links can go here -->
</head>
<body>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="Index.php">
                <img src="logo.png" alt="Logo" style="height: 50px;">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="Index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="MyFriends.php">My Friends</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="MyAlbums.php">My Albums</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="MyPictures.php">My Pictures</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="UploadPictures.php">Upload Pictures</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="Logout.php">Log Out</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="Login.php">Log In</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </div>
    <!-- The rest of your HTML content goes here -->
