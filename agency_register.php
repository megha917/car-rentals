<?php include('header.php') ?>

<?php
include('db_config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $id_number = $_POST['id_number'];
    $address = $_POST['address'];
    $password = $_POST['password'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $userType = 'agency';

    $sql = "INSERT INTO users (full_name, phone, email, id_number, address, password, user_type) VALUES ('$fullName', '$phone', '$email', '$idNumber', '$address', '$hashedPassword', '$userType')";

    if ($conn->query($sql) === TRUE) {
        echo "<script type='text/javascript'>
                window.location.href = 'login.php';
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();;
}
?>

<style>
    .registration-container {
        margin-top: 50px;
    }

    .registration-card {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }

    .registration-header {
        background-color: #007bff;
        color: white;
        padding: 20px;
        border-radius: 10px 10px 0 0;
        text-align: center;
    }

    .registration-form {
        padding: 30px;
    }

    .form-control:focus {
        box-shadow: none;
        border-color: #007bff;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }
</style>
</head>

<body>

    <div class="container registration-container mb-3">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card registration-card">
                    <div class="card-header registration-header">
                        <h2>Agency Registration</h2>
                    </div>
                    <div class="card-body registration-form">
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="fullName" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="fullName" name="fullName" placeholder="Enter your full name" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email address" required>
                            </div>
                            <div class="mb-3">
                                <label for="idNumber" class="form-label">ID Number</label>
                                <input type="text" class="form-control" id="idNumber" name="idNumber" placeholder="Enter your ID number" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter your address" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?>