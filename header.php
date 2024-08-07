<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$isLoggedIn = isset($_SESSION['user_id']);
$userType = $isLoggedIn ? $_SESSION['user_type'] : null;
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Car Rentals</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
    <style>
        .navbar-brand {
            font-size: 1.5rem;
        }

        .nav-link {
            margin-left: 0.5rem;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold fs-4" href="index.php">
                <img src="images/logo.png" alt="" class="img-fluid" style="width: 5rem;">
                Car <span class="text-success">Rentals</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <?php if ($isLoggedIn) : ?>
                        <!-- Links for agency members -->
                        <?php if ($userType === 'agency') : ?>
                            <li class="nav-item active mx-1"><a href="available_cars.php" class="nav-link">Available Cars</a></li>
                            <li class="nav-item mx-1"><a href="add_new_car.php" class="nav-link">Add New Car</a></li>
                            <li class="nav-item mx-1"><a href="view_booked_cars.php" class="nav-link">View Booked Cars</a></li>
                        <?php else : ?>
                            <!-- Links for customers -->
                            <li class="nav-item active mx-1"><a href="index.php" class="nav-link">Home</a></li>
                            <li class="nav-item mx-1"><a href="available_cars.php" class="nav-link">Available Cars</a></li>
                        <?php endif; ?>
                        <li class="nav-item mx-1"><a href="logout.php" class="btn btn-outline-light">Logout</a></li>
                    <?php else : ?>
                        <!-- Links for guests -->
                        <li class="nav-item active mx-1"><a href="index.php" class="nav-link">Home</a></li>
                        <li class="nav-item mx-1"><a href="available_cars.php" class="nav-link">Available Cars</a></li>
                        <li class="nav-item mx-1"><a href="login.php" class="btn btn-outline-light">Login</a></li>
                        <li class="nav-item mx-1"><a href="#" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#registerModal">Register</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Register as Customer or Agency Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="registerModalLabel">Register As</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Please choose an option to proceed with registration:</p>
                    <div class="d-flex justify-content-around">
                        <a href="customer_register.php" class="btn btn-primary">Register as User</a>
                        <a href="agency_register.php" class="btn btn-secondary">Register as Agency Member</a>
                    </div>
                </div>
            </div>
        </div>
    </div>