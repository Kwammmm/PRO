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
            margin-top: 1.3%;
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
    <h1>Product</h1>
    <!-- นำฟอร์มค้นหาไว้ที่ด้านบนของตาราง -->
    </div>
</div>
<div style="width: 1217px; height: auto; background: #FFFFFF; border: 1px solid black; border-radius: 4px;margin-left: 19%;">
    <form method="post">
        <label for="search">Search: </label>
        <input type="text" name="search" id="search" placeholder="ป้อนชื่อหรือนามสกุล">
        <button type="submit">search</button>
    </form>

    <?php
    require_once 'connect.php';

    // ตรวจสอบว่ามีการล็อกอินหรือไม่
    if(isset($_SESSION['member_name'])){
        // ถ้ามีการล็อกอินแล้ว
        $member_name = $_SESSION['member_name'];

        // ใช้ JOIN เพื่อรวมข้อมูลจากตาราง tbl_member และ item
        $stmt = $conn->prepare("SELECT report.*, item.item_serial FROM report
                                INNER JOIN item ON report.re_serial = item.item_serial
                                INNER JOIN tbl_member ON item.item_owner = tbl_member.member_name
                                WHERE tbl_member.member_name = :member_name");
        $stmt->bindParam(':member_name', $member_name, PDO::PARAM_STR);
        $stmt->execute();
        $filteredReports = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // ตรวจสอบว่ามีข้อมูลหรือไม่
        if ($filteredReports) {
            echo "<table>";
            echo "<thead>";
            echo "<tr>";
            echo "<th width='7%'>ID</th>";
            echo "<th width='15%'>Name</th>";
            echo "<th width='15%'>Detail</th>";
            echo "<th width='15%'>Category</th>";
            echo "<th width='20%'>Serialnumber</th>";
            echo "<th width='10%'>Owner</th>";
            echo "<th width='10%'>Status</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            foreach ($filteredReports as $report) {
                echo "<tr>";
                echo "<td>{$report['re_id']}</td>";
                echo "<td>{$report['re_studentname']}</td>"; 
                echo "<td>{$report['re_serial']}</td>";
                echo "<td>{$report['re_borrow']}</td>";
                echo "<td>{$report['re_return']}</td>";
                echo "<td>{$report['re_status']}</td>";
                echo "<td>{$report['item_serial']}</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "ไม่พบข้อมูล Item Owner";
        }
    } else {
        // ถ้ายังไม่ได้ล็อกอิน
        echo "กรุณาเข้าสู่ระบบ";
    }
    ?>
</div>
</body>
</html>
