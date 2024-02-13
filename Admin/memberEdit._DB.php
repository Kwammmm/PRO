<?php

require_once 'connect.php';


if (isset($_POST['member_name']) && isset($_POST['member_sername']) && isset($_POST['member_id']) && isset($_POST['member_classS']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['member_status'])) {
    $member_id = $_POST['member_id'];
    $member_name = $_POST['member_name'];
    $member_sername = $_POST['member_sername'];
    $member_classS = $_POST['member_classS'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $member_status = $_POST['member_status'];

    
    $stmt = $conn->prepare("UPDATE tbl_member SET member_name=?, member_sername=?, member_classS=?, username=?, password=?, member_status=? WHERE member_id=?");
    $stmt->execute([$member_name, $member_sername, $member_classS, $username, $password, $member_status, $member_id]);


}
?>
