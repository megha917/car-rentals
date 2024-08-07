<?php
session_start();
include('db_config.php');

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'agency') {
    echo '<script type="text/javascript">
            alert("Unauthorized access. Redirecting to login page.");
            window.location.href = "login.php";
          </script>';
    exit();
}

if (isset($_GET['id'])) {
    $car_id = $_GET['id'];

    $sql = "SELECT * FROM cars WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $car_id);
    $stmt->execute();
    $car = $stmt->get_result()->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $model = $_POST['model'];
    $number = $_POST['number'];
    $seating_capacity = $_POST['seating_capacity'];
    $rent_per_day = $_POST['rent_per_day'];

    $sql = "UPDATE cars SET model = ?, number = ?, seating_capacity = ?, rent_per_day = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssidi", $model, $number, $seating_capacity, $rent_per_day, $car_id);

    if ($stmt->execute()) {
        echo '<script type="text/javascript">
                alert("Car updated successfully!");
                window.location.href = "available_cars.php";
              </script>';
    } else {
        echo '<script type="text/javascript">
                alert("Error: ' . $conn->error . '");
              </script>';
    }
}
?>

<?php include('header.php'); ?>

<div class="container my-5">
    <h2>Edit Car</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="model" class="form-label">Vehicle Model</label>
            <input type="text" class="form-control" id="model" name="model" value="<?= htmlspecialchars($car['model']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="number" class="form-label">Vehicle Number</label>
            <input type="text" class="form-control" id="number" name="number" value="<?= htmlspecialchars($car['number']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="seating_capacity" class="form-label">Seating Capacity</label>
            <input type="number" class="form-control" id="seating_capacity" name="seating_capacity" value="<?= htmlspecialchars($car['seating_capacity']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="rent_per_day" class="form-label">Rent Per Day</label>
            <input type="number" class="form-control" id="rent_per_day" name="rent_per_day" value="<?= htmlspecialchars($car['rent_per_day']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

<?php include('footer.php'); ?>