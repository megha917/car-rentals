<?php
session_start();
include('db_config.php');

// Fetch available cars
$sql = "SELECT * FROM cars WHERE is_booked = 0";
$result = $conn->query($sql);

// Handle delete request
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['car_id'])) {
    $car_id = $_GET['car_id'];
    $sql = "DELETE FROM cars WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $car_id);

    if ($stmt->execute()) {
        $_SESSION['alert'] = 'Car deleted successfully!';
        $_SESSION['alert_type'] = 'success';
    } else {
        $_SESSION['alert'] = 'Error deleting the car.';
        $_SESSION['alert_type'] = 'danger';
    }
}

// Handle rent car request
if (isset($_POST['rent_car'])) {
    if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'customer') {
        $_SESSION['alert'] = 'Please log in to book a car.';
        $_SESSION['alert_type'] = 'warning';
        header('Location: login.php');
        exit();
    } else {
        $car_id = $_POST['car_id'];

        // Mark the car as booked
        $sql = "UPDATE cars SET is_booked = 1 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $car_id);

        if ($stmt->execute()) {
            $_SESSION['alert'] = 'Car booked successfully!';
            $_SESSION['alert_type'] = 'success';
        } else {
            $_SESSION['alert'] = 'Error booking the car.';
            $_SESSION['alert_type'] = 'danger';
        }
    }
}
?>

<style>
    .card {
        margin-bottom: 1rem;
    }

    .btn {
        margin-right: 0.5rem;
    }

    .rent-options {
        display: none;
    }

    .rent-options.visible {
        display: block;
    }

    .form-group {
        margin-bottom: 1rem;
    }
</style>
</head>

<body>
    <?php include('header.php'); ?>

    <div class="container my-5">
        <?php if (isset($_SESSION['alert'])) : ?>
            <div class="alert alert-<?= $_SESSION['alert_type'] ?> alert-dismissible fade show" role="alert">
                <?= $_SESSION['alert'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['alert']);
            unset($_SESSION['alert_type']); ?>
        <?php endif; ?>

        <h2>Available Cars</h2>
        <div class="row">
            <?php if ($result->num_rows > 0) : ?>
                <?php while ($car = $result->fetch_assoc()) : ?>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($car['model']) ?></h5>
                                <p class="card-text">Number: <?= htmlspecialchars($car['number']) ?><br>
                                    Seating Capacity: <?= htmlspecialchars($car['seating_capacity']) ?><br>
                                    Rent Per Day: ₹<?= htmlspecialchars($car['rent_per_day']) ?>
                                </p>
                                <div class="d-flex justify-content-start">
                                    <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'agency') : ?>
                                        <a href="edit_car.php?id=<?= $car['id'] ?>" class="btn btn-warning me-2"><i class="bi bi-pencil-square"></i> Edit</a>
                                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-car-id="<?= $car['id'] ?>"><i class="bi bi-trash"></i> Delete</button>
                                    <?php else : ?>
                                        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_type'] === 'customer') : ?>
                                            <form method="POST" action="available_cars.php" class="d-inline">
                                                <input type="hidden" name="car_id" value="<?= $car['id'] ?>">
                                                <div class="rent-options visible">
                                                    <div class="form-group">
                                                        <label for="start_date_<?= $car['id'] ?>">Start Date</label>
                                                        <input type="date" id="start_date_<?= $car['id'] ?>" name="start_date" class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="num_days_<?= $car['id'] ?>">Number of Days</label>
                                                        <select id="num_days_<?= $car['id'] ?>" name="num_days" class="form-select" required>
                                                            <?php for ($i = 1; $i <= 30; $i++) : ?>
                                                                <option value="<?= $i ?>"><?= $i ?> Day<?= $i > 1 ? 's' : '' ?></option>
                                                            <?php endfor; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <button type="submit" name="rent_car" class="btn btn-primary">Rent Car</button>
                                            </form>
                                        <?php else : ?>
                                            <form method="POST" action="available_cars.php" class="d-inline">
                                                <input type="hidden" name="car_id" value="<?= $car['id'] ?>">
                                                <button type="submit" name="rent_car" class="btn btn-primary">Rent Car</button>
                                            </form>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <p>No available cars at the moment.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this car?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a id="confirmDelete" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Configure delete button in modal
            var deleteModal = document.getElementById('deleteModal');
            deleteModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var carId = button.getAttribute('data-car-id');
                var confirmDelete = document.getElementById('confirmDelete');
                confirmDelete.href = 'available_cars.php?action=delete&car_id=' + carId;
            });
        });
    </script>
    <?php include('footer.php'); ?>