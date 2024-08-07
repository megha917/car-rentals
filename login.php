<?php include('header.php') ?>

<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('db_config.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];
    $user_type = $_POST['userType'];

    $sql = "SELECT * FROM users WHERE email = ? AND user_type = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $user_type);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_type'] = $user['user_type'];

            if ($user['user_type'] == 'agency') {
                echo "<script type='text/javascript'>window.location.href = 'view_booked_cars.php';</script>";
            } else {
                echo "<script type='text/javascript'>window.location.href = 'available_cars.php';</script>";
            }
        } else {
            echo "<script type='text/javascript'>alert('Invalid password.');</script>";
        }
    } else {
        echo "<script type='text/javascript'>alert('Invalid email or user type.');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>


<style>
    .login-container {
        margin-top: 50px;
    }

    .login-card {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }

    .login-header {
        background-color: #343a40;
        color: white;
        padding: 20px;
        border-radius: 10px 10px 0 0;
        text-align: center;
    }

    .login-form {
        padding: 30px;
    }

    .form-control:focus {
        box-shadow: none;
        border-color: #343a40;
    }

    .btn-primary {
        background-color: #343a40;
        border: none;
    }

    .btn-primary:hover {
        background-color: #23272b;
    }
</style>
</head>

<div class="container login-container mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card login-card">
                <div class="card-header login-header">
                    <h2>Login</h2>
                </div>
                <div class="card-body login-form">
                    <form method="post" action="">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email address" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Login as</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="userType" id="agency" value="agency" required>
                                    <label class="form-check-label" for="agency">Agency</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="userType" id="customer" value="customer" required>
                                    <label class="form-check-label" for="customer">Customer</label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>