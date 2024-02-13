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
if(empty($_SESSION['member_id']) && empty($_SESSION['member_name']) && empty($_SESSION['member_sername'])){
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

<?php include('menu_mem.php'); ?>
<?php
require_once 'connect.php';

// ตรวจสอบว่ามีการส่งค่าค้นหามาหรือไม่
if(isset($_POST['search'])){
    $search = $_POST['search'];

    // ใช้ LIKE clause ใน SQL เพื่อทำการค้นหา
    $stmt = $conn->prepare("SELECT member_id,member_classS, member_name, member_sername FROM tbl_member WHERE member_name LIKE :search OR member_sername LIKE :search");
    $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
} else {
    // ถ้าไม่มีการค้นหา ดึงข้อมูลทั้งหมด
    $stmt = $conn->prepare("SELECT member_id,member_classS, member_name, member_sername FROM tbl_member");
}

$stmt->execute();
$filteredMembers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property management system</title>
    <style>
        body {
            font-family: 'Tahoma', Arial, sans-serif;
        }
        table {
            width: 1100px;
            margin-left: 5%;
            margin-right: auto;
            padding-top: 10%;
            border-collapse: collapse;
            background-color: #f2f2f2;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th{
            background-color: #A4A4A4;
            font-size: 20px;
            text-align: center;
        }
        h1{
            margin-top: 7%;
            color: white;
            text-align: center;
            padding: 0.6%
        }
    
        form{
            padding: 15px;
            margin-left: 5%;
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

.button:hover {background-color: #3e8e41}

.button:active {
  background-color: #3e8e41;
  box-shadow: 0 5px #666;
  transform: translateY(4px);
}
    </style>
</head>
<body>

<div style="width: 1217px; height: 60px; background: #6D7BC8; border-radius: 4px ; margin-left: 19%;">
<div style="color: black; font-size: 20px; font-family: Inter; font-weight: 600; word-wrap: break-word ;">
    <h1>Member List</h1>
    <!-- นำฟอร์มค้นหาไว้ที่ด้านบนของตาราง -->
    </div>
</div>
<div style="width: 1217px; height: auto; background: #FFFFFF; border: 1px solid black; border-radius: 4px;margin-left: 19%;">
    <form method="post">
        <label for="search">Search: </label>
        <input type="text" name="search" id="search" placeholder="ป้อนชื่อหรือนามสกุล">
        <button type="submit">search</button>
    </form>

    <table>
        <thead>
            <tr>
                <th width="7%">ID</th>
                <th width="7%">Class</th>
                <th width="15%">Name</th>
                <th width="15%">Surname</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($filteredMembers as $member): ?>
                <tr>
                    <td><?= $member['member_id']; ?></td>
                    <td><?= $member['member_classS']; ?></td>
                    <td><?= $member['member_name']; ?></td>
                    <td><?= $member['member_sername']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        </div>
    </table>
</body>
</html>
