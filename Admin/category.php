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

<?php
// Include database connection
require_once 'connect.php';

// ตรวจสอบว่ามีการส่งค่ามาจากฟอร์มหรือไม่
if(isset($_POST['filter_category'])){
    $filterCategory = $_POST['filter_category'];

    // ถ้าเลือก "ทั้งหมด" ให้ดึงข้อมูลทั้งหมด
    if($filterCategory === "ทั้งหมด"){
        $stmt = $conn->prepare("SELECT * FROM category");
    } else {
        // ถ้าไม่ใช่ "ทั้งหมด" ให้ใช้ WHERE clause ใน SQL เพื่อกรองข้อมูลตามหมวดหมู่ที่ถูกเลือก
        $stmt = $conn->prepare("SELECT * FROM category WHERE Cate_status = :filterCategory");
        $stmt->bindParam(':filterCategory', $filterCategory, PDO::PARAM_STR);
    }

    $stmt->execute();

    $filterCategory = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // ถ้าไม่มีการกรอง ดึงข้อมูลทั้งหมด
    $stmt = $conn->prepare("SELECT * FROM category");
    $stmt->execute();

    $filterCategory = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// ดึงข้อมูลหมวดหมู่ทั้งหมด
$stmtCategories = $conn->prepare("SELECT DISTINCT Cate_status FROM category");
$stmtCategories->execute();
$categories = $stmtCategories->fetchAll(PDO::FETCH_COLUMN);

if(isset($_POST['clear_filter'])){
    
    header("Location: category.php");
    exit();
}
?>


<?php include('testmenu.php'); ?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Property management system</title>
    
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
        table, th, td {
            border: 1px solid black;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        h1{
            margin-left: 20%;
            margin-top: 5%;
        }
    
        form{
            padding: 15px;
            margin-left: 19%;
            margin-top: 10px;
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

    <h1>Category  <a href="Addcategory.php" class="btn btn-info">+Add Member</a></h1>
<br>
    <form method="post" style="display: inline;">
    <label for="filter_category">Filter by category:</label>
    <select name="filter_category" id="filter_category">
    <button type="submit">Filter</button>
    <form method="post" style="display: inline;">
    <button type="submit" name="clear_filter">Clear Filter</button>
</form>
        <?php
        require_once 'connect.php';

        // Query to get distinct categories
        $stmt = $conn->prepare("SELECT DISTINCT Cate_status FROM category");
        $stmt->execute();

        // Loop through the result and create options
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $category = $row['Cate_status'];
            echo "<option value='$category'>$category</option>";
        }
        ?>
    </select>
<form method="post"><button type="submit">Filter</button>   <button type="submit" name="clear_filter">Clear Filter</button></form>
</form>


    

<br>







<table>
    <thead>
        <tr>
            <th width="5%">ID</th>
            <th width="15%">Name</th>
            <th width="5%">Edit</th>
            <th width="5%">Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($filterCategory as $category): ?>
            <tr>
                <td><?= $category['Cate_id']; ?></td>
                <td><?= $category['Cate_status']; ?></td>
                <td><a href="Editcategory.php?Cate_id=<?= $category['Cate_id'];?>">Edit</a></td>
                <td><a href="Delcategory.php?Cate_id=<?= $category['Cate_id']; ?>" onclick="return confirm('Are you sure you want to delete this data?')">Delete</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>