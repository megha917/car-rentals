<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('db_config.php');

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'agency') {
    echo '<script type="text/javascript">
            alert("Unauthorized access. Redirecting to login page.");
            window.location.href = "login.php";
          </script>';
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $model = $_POST['model'];
    $number = $_POST['number'];
    $seating_capacity = $_POST['seating_capacity'];
    $rent_per_day = $_POST['rent_per_day'];

    $sql = "INSERT INTO cars (model, number, seating_capacity, rent_per_day) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssis", $model, $number, $seating_capacity, $rent_per_day);

    if ($stmt->execute()) {
        echo '<script type="text/javascript">
                alert("Car added successfully!");
                window.location.href = "index.php"; // Redirect to a page, e.g., home or car listing
              </script>';
    } else {
        echo '<script type="text/javascript">
                alert("Error: ' . $conn->error . '");
              </script>';
    }

    $stmt->close();
    $conn->close();
}
?>

<?php include('header.php'); ?>

<div class="container my-5 w-50">
    <h2 class="fs-1 text-center my-2">Add New Car</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="model" class="form-label fs-5 fw-normal">Vehicle Model</label>
            <input type="text" class="form-control" id="model" name="model" placeholder="Enter vehicle model" required>
        </div>
        <div class="mb-3">
            <label for="number" class="form-label fs-5 fw-normal">Vehicle Number</label>
            <input type="text" class="form-control" id="number" name="number" placeholder="Enter vehicle number" required>
        </div>
        <div class="mb-3">
            <label for="seating_capacity" class="form-label fs-5 fw-normal">Seating Capacity</label>
            <input type="number" class="form-control" id="seating_capacity" name="seating_capacity" placeholder="Enter seating capacity" required>
        </div>
        <div class="mb-3">
            <label for="rent_per_day" class="form-label fs-5 fw-normal">Rent Per Day (in ₹)</label>
            <input type="number" class="form-control" id="rent_per_day" name="rent_per_day" placeholder="Enter rent per day" required>
        </div>
        <button type="submit" class="btn btn-primary text-center px-5 mt-3">Add Car</button>
    </form>
</div>

<?php include('footer.php'); ?>
