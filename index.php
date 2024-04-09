<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to Algonquin Social Media Website</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="welcome-box">
            <h1>Welcome to Algonquin Social Media Website</h1>
            <p>If you have never used this before, you have to <a href="NewUser.php">sign up</a> first.</p>
            <p>If you have already signed up, you can <a href="Login.php">log in</a> now.</p>
        </div>
        
        <!-- This ensures that footer is at the bottom -->
        <div class="footer">
            <?php include 'footer.php'; ?>
        </div>
    </div>
</body>
</html>
