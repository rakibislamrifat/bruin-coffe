<?php 
require '../db/db.php';

$id = $_GET['id'];

$sql = "DELETE FROM orders WHERE id = $id";


if (mysqli_query($conn, $sql)) {
    header("Location: ../dashboard/dashboard.php");
} else {
    echo "Error deleting order: " . mysqli_error($conn);
}

mysqli_close($conn);

