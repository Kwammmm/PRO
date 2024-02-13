<?php
// Ensure connect.php contains your database connection logic
require_once 'connect.php';

// Check if the required POST variables are set
if (isset($_POST['re_serial'], $_POST['re_status']) && !empty($_POST['re_serial']) && !empty($_POST['re_status'])) {
    // Retrieve the values from POST
    $re_serial = $_POST['re_serial'];
    $re_status = $_POST['re_status'];

    // Prepare and execute the SQL query
    $stmt = $conn->prepare("UPDATE item SET item_status = ? WHERE item_serial = ?");
    $stmt->execute([$re_status, $re_serial]);

    // Provide a response
    echo "Update Status successfully", $re_serial,$re_status;
}
?>