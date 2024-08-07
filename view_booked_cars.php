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

// Fetch the booked cars
$sql = "SELECT cars.model, cars.number, users.full_name, users.email, users.phone 
        FROM cars
        INNER JOIN users ON cars.id = users.id
        WHERE cars.is_booked = 1";

$result = $conn->query($sql);
?>


<style>
    .booked-cars-list {
        margin-bottom: 20px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .booked-cars-item {
        margin-bottom: 15px;
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    .booked-cars-item:last-child {
        border-bottom: none;
    }
</style>

<?php include('header.php'); ?>

<div class="container my-5">
    <h2 class="text-center mb-4">Booked Cars</h2>
    <?php if ($result->num_rows > 0) : ?>
        <?php while ($row = $result->fetch_assoc()) : ?>
            <div class="booked-cars-list">
                <div class="booked-cars-item">
                    <h4>Car Model: <?php echo htmlspecialchars($row['model']); ?></h4>
                    <p>Vehicle Number: <?php echo htmlspecialchars($row['number']); ?></p>
                    <p>Customer Name: <?php echo htmlspecialchars($row['full_name']); ?></p>
                    <p>Email: <?php echo htmlspecialchars($row['email']); ?></p>
                    <p>Phone: <?php echo htmlspecialchars($row['phone']); ?></p>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else : ?>
        <div class="alert alert-info" role="alert">
            No cars have been booked yet.
        </div>
    <?php endif; ?>
</div>

<?php include('footer.php'); ?>



<?php
$conn->close();
?>