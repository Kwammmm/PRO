<?php
// Include database connection
require_once 'connect.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the form
    $member_name = $_POST['member_name'];
    $member_sername = $_POST['member_sername'];
    $member_user = $_POST['member_user'];
    $member_pass = $_POST['member_pass'];
    $member_status = $_POST['member_status'];

    // Validate the data (you should add more validation based on your requirements)
    if (empty($member_name) || empty($member_sername) || empty($member_user) || empty($member_pass) || empty($member_status)) {
        echo "Please fill in all the fields.";
        // You might want to redirect back to the form or handle the error appropriately
    } else {
        // Insert data into the database
        $stmt = $conn->prepare("INSERT INTO tbl_member (member_name, member_sername, member_user, member_pass, member_status) VALUES (:member_name, :member_sername, :member_user, :member_pass, :member_status)");
        $stmt->bindParam(':member_name', $member_name, PDO::PARAM_STR);
        $stmt->bindParam(':member_sername', $member_sername, PDO::PARAM_STR);
        $stmt->bindParam(':member_user', $member_user, PDO::PARAM_STR);
        $stmt->bindParam(':member_pass', $member_pass, PDO::PARAM_STR);
        $stmt->bindParam(':member_status', $member_status, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "Data added successfully.";
            // You might want to redirect to a success page or do something else
        } else {
            echo "Error adding data.";
            // You might want to redirect back to the form or handle the error appropriately
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Member</title>
    <!-- Include Bootstrap CSS here if needed -->
</head>
<body>
    <h2>Add Member</h2>

    <!-- Add your HTML form here -->
    <form method="post">
        <label for="member_name">Name:</label>
        <input type="text" name="member_name" required>

        <label for="member_sername">Surname:</label>
        <input type="text" name="member_sername" required>

        <label for="member_user">Username:</label>
        <input type="text" name="member_user" required>

        <label for="member_pass">Password:</label>
        <input type="password" name="member_pass" required>

        <label for="member_status">Status:</label>
        <input type="text" name="member_status" required>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
