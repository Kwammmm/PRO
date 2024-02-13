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

if (isset($_POST['filter_item'])) {
    $filteritem = $_POST['filter_item'];

    if ($filteritem === "ทั้งหมด") {
        $stmt = $conn->prepare("SELECT * FROM item");
    } else {

        $stmt = $conn->prepare("SELECT * FROM item WHERE item_status = :filteritem");
        $stmt->bindParam(':filteritem', $filteritem, PDO::PARAM_STR);
    }

    $stmt->execute();

    $filteritem = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $stmt = $conn->prepare("SELECT * FROM item");
    $stmt->execute();

    $filteritem = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$stmtCategories = $conn->prepare("SELECT DISTINCT item_status FROM item");
$stmtCategories->execute();
$categories = $stmtCategories->fetchAll(PDO::FETCH_COLUMN);

?>
<?php

if (isset($_POST['clear_filter'])) {
    header("Location: product.php");
    exit();
} 
?>



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
    <h1>Product list <a href="Add_Product.php" class="btn btn-info">+Add Member</a>  <a href="Print.php" class="btn btn-info">PrintBarcode</a></h1>
    <br>
    <form method="post" style="display: inline;">
        <label for="filter_item">Filter by category:</label>
        <select name="filter_item" id="filter_item">
            <button type="submit">Filter</button>
            <form method="post" style="display: inline;">
                <button type="submit" name="clear_filter">Clear Filter</button>
            </form>
            <br>
            <?php
            require_once 'connect.php';

            $stmt = $conn->prepare("SELECT DISTINCT item_status FROM item");
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $item = $row['item_status'];
                echo "<option value='$item'>$item</option>";
            }
            ?>
        </select>
        <form method="post"><button type="submit">Filter</button> <button type="submit" name="clear_filter">Clear Filter</button></form>
    </form>

    <table>
        <thead>
            <tr>
                <th width="7%">ID</th>
                <th width="15%">Property</th>
                <th width="15%">Detail</th>
                <th width="15%">category</th>
                <th width="20%">serialnumber</th>
                <th width="10%">owner</th>
                <th width="10%">status</th>
                <th width="5%">Edit</th>
                <th width="5%">Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($filteritem as $item) : ?>
                <tr>
                    <td><?= $item['item_id']; ?></td>
                    <td><?= $item['item_name']; ?></td>
                    <td><?= $item['item_detail']; ?></td>
                    <td><?= $item['item_category']; ?></td>
                    <td><?= $item['item_serial']; ?></td>
                    <td><?= $item['item_owner']; ?></td>
                    <td><?= $item['item_status']; ?></td>
                    <td><a href="Editproduct.php?item_id=<?php echo $item['item_id']; ?>">แก้ไข</a></td>
                    <td><a href="Delproduct.php?item_id=<?php echo $item['item_id']; ?>" onclick="return confirm('คุณแน่ใจหรือไม่ที่จะลบข้อมูลนี้?')">ลบ</a></td>

                </tr>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>

</html>