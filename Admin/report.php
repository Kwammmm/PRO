<?php
session_start();
echo '
<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
//เช็คว่ามีตัวแปร session อะไรบ้าง
//print_r($_SESSION);
//exit();
//สร้างเงื่อนไขตรวจสอบสิทธิ์การเข้าใช้งานจาก session
if (empty($_SESSION['member_id']) && empty($_SESSION['member_name']) && empty($_SESSION['member_sername'])) {
    echo '<script>
                setTimeout(function() {
                swal({
                title: "คุณไม่มีสิทธิ์ใช้งานหน้านี้",
                type: "error"
                }, function() {
                window.location = "login.php"; //หน้าที่ต้องการให้กระโดดไป
                });
                }, 1000);
                </script>';
    exit();
}

?>


<?php include('testmenu.php'); ?>
<?php
require_once 'connect.php';

// Initialize $searchResults variable
$searchResults = [];

// Check if search term is provided
if(isset($_POST['search'])){
    $search = $_POST['search'];
    

    // Prepare SQL query to search for records matching the search term
    $sql = "SELECT re_id, re_studentid, re_studentname, re_serial, re_borrow, re_return, re_status FROM report WHERE re_serial LIKE '%$search%' OR re_studentname LIKE '%$search%'";
    $stmt = $conn->prepare($sql);

    // Execute the query
    $stmt->execute();

    // Fetch the search results
    $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // If no search term is provided, fetch all records
    $stmt = $conn->prepare("SELECT re_id, re_studentid, re_studentname, re_serial, re_borrow, re_return, re_status FROM report");
    $stmt->execute();

    // Fetch all records
    $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>


<!DOCTYPE html>
<html lang="th">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property management system</title>

    <head>
    <style>
        body {
            font-family: 'Tahoma', Arial, sans-serif;
        }

        table {
            width: 75%;
            margin-left: 20%;
            margin-right: auto;
            padding-top: 10%;
            border-collapse: collapse;
            background-color: #f2f2f2;
        }

        table,
        th,
        td {
            border: 1px solid black;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        h1 {
            margin-left: 20%;
            margin-top: 5%;
        }

        form {
            padding: 15px;
            margin-left: 19%;
            margin-top: 1px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 15px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            outline: none;
            color: #fff;
            background-color: #4CAF50;
            border: none;
            border-radius: 15px;
            box-shadow: 0 9px #999;
        }

        .button:hover {
            background-color: #3e8e41
        }

        .button:active {
            background-color: #3e8e41;
            box-shadow: 0 5px #666;
            transform: translateY(4px);
        }
    </style>
</head>

<body>
    <h1>Report</h1>
    <br>
  
    <form action="" method="post">
    <input type="text" name="search" id="search" placeholder="name,serial">
    <button type="submit">Search</button>
</form>
    <table>
        <thead>
            <tr>
                <th width="7%">ID</th>
                <th width="15%">student ID </th>
                <th width="15%">student name</th>
                <th width="15%">serialnumber</th>
                <th width="20%">Borrow</th>
                <th width="10%">Return</th>
                <th width="10%">status</th>
                
            </tr>
        </thead>
        <tbody>
        <?php foreach ($searchResults as $status): ?>
                <tr>
                    <td><?= $status['re_id']; ?></td>
                    <td><?= $status['re_studentid']; ?></td>
                    <td><?= $status['re_studentname']; ?></td>
                    <td><?= $status['re_serial']; ?></td>
                    <td><?= $status['re_borrow']; ?></td>
                    <td><?= $status['re_return']; ?></td>
                    <td><?= $status['re_status']; ?></td>
                </tr>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>

</html>