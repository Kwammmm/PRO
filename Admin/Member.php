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

// Check if a filter class is selected
if(isset($_POST['filter_class'])){
    $filterClass = $_POST['filter_class'];

    // If "All" is selected, fetch all members
    if($filterClass === "All"){
        $stmt = $conn->prepare("SELECT member_id, member_classS, member_name, member_sername, username, password, member_status FROM tbl_member");
    } else {
        // If a specific member class is selected, filter by that class
        $stmt = $conn->prepare("SELECT member_id, member_classS, member_name, member_sername, username, password, member_status FROM tbl_member WHERE member_classS = :filterClass");
        $stmt->bindParam(':filterClass', $filterClass, PDO::PARAM_STR);
    }

    $stmt->execute();

    // Fetch filtered members
    $filteredMembers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // If no filter is applied, fetch all members
    $stmt = $conn->prepare("SELECT member_id, member_classS, member_name, member_sername, username, password, member_status FROM tbl_member");
    $stmt->execute();

    // Fetch all members
    $filteredMembers = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch all distinct member classes
$stmtClasses = $conn->prepare("SELECT DISTINCT member_classS FROM tbl_member");
$stmtClasses->execute();
$classes = $stmtClasses->fetchAll(PDO::FETCH_COLUMN);


if(isset($_POST['clear_filter'])){
    
    header("Location: member.php");
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
    <h1>Member list <a href="FormAddMember.php" class="btn btn-info">+Add Member</a> </h1>
    <br>
    <form method="post" style="display: inline;">
    <label for="filter_class">Filter by category:</label>
    <select name="filter_class" id="filter_class">
    <button type="submit">Filter</button>
    <form method="post" style="display: inline;">
    <button type="submit" name="clear_filter">Clear Filter</button>
</form>
        <?php
        require_once 'connect.php';

        // Query to get distinct classes
        $stmt = $conn->prepare("SELECT DISTINCT class_name FROM member_class");
        $stmt->execute();

        // Loop through the result and create options
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $member_class = $row['class_name'];
            echo "<option value='$member_class'>$member_class</option>";
        }
        ?>
    </select>
    <form method="post"><button type="submit">Filter</button>   <button type="submit" name="clear_filter">Clear Filter</button></form>

</form>

    

    <table>
        <thead>
            <tr>
                
                <th width="15%">ID</th>
                <th width="7%">Class</th>
                <th width="15%">name</th>
                <th width="15%">sername</th>
                <th width="20%">Username</th>
                <th width="15%">Password</th>
                <th width="10%">Status</th>
                <th width="5%">Edit</th>
                <th width="5%">Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($filteredMembers as $member): ?>
                <tr>
                
                    <td><?= $member['member_id']; ?></td>
                    <td><?= $member['member_classS']; ?></td>
                    <td><?= $member['member_name']; ?></td>
                    <td><?= $member['member_sername']; ?></td>
                    <td><?= $member['username']; ?></td>
                    <td><?= $member['password'];?></td>
                    <td><?= $member['member_status'];?></td>
                    <td><a href="memberEdit.php?member_id=<?php echo $member['member_id'];?>">แก้ไข</a></td>
                    <td><a href="Delmember.php?member_id=<?php echo $member['member_id']; ?>" onclick="return confirm('คุณแน่ใจหรือไม่ที่จะลบข้อมูลนี้?')">ลบ</a></td>
                    </tr>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>


