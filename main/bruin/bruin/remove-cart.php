<?php
include '../bruin/db/db.php';

if (isset($_POST['cart_id'])) {
    $cart_id = $_POST['cart_id'];

    $sql = "DELETE FROM cart WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cart_id);
    $stmt->execute();
    $stmt->close();

    header("Location: my-cart.php");
    exit;
}
?>

