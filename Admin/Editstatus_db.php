<?php
require_once 'connect.php';

if (isset($_POST['status_name']) && isset($_POST['newstatus_name'])) {
    $new_status_name = $_POST['newstatus_name'];
    $status_name = $_POST['status_name'];
    $stmt = $conn->prepare("UPDATE tbl_statusmember SET status_name=? WHERE status_name =?");
    $stmt->execute([$new_status_name, $status_name]);
}
?>
