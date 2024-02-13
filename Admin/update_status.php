<?php
// Connect to your database
require_once 'connect.php';

// Check if the barcode value is received
if (isset($_POST['barcode'])) {
    $barcode = $_POST['barcode'];

    $stmt = $conn->prepare("UPDATE item SET item_status = 'มีให้ยืม' WHERE item_serial = :barcode");
    $stmt->bindParam(':barcode', $barcode, PDO::PARAM_STR);
    if ($stmt->execute()) {
        echo "Status updated successfully for barcode: $barcode";
    } else {
        echo "Failed to update status for barcode: $barcode";
    }
} else {
    echo "No barcode value received";
}
?>
