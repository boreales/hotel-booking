<?php

session_start();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Hôtel Booking</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="css/main.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="jumbotron" style="background-image: url('https://images.unsplash.com/photo-1517840901100-8179e982acb7?w=900&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8aG90ZWx8ZW58MHx8MHx8fDA%3D'); background-size: cover; background-position:top; color: white; text-align:center;">
        <h1 class="text-center">Hôtel Booking</h1>
    </div>
    <nav>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="booking.php?id=19">Booking Details</a>
            </li>
            <?php if (isset($_SESSION['user'])) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            <?php else : ?>
            <li class="nav-item">
                <a class="nav-link" href="user.php">Register</a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn btn-secondary" href="login.php">Login</a>
            </li>
            <?php endif; ?>
        </ul>
    </nav>
