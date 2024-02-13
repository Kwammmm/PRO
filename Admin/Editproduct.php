<?php include('testmenu.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editproperty</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
<body>

<?php
if(isset($_GET['item_id'])){
    require_once 'connect.php';
    $stmt = $conn->prepare("SELECT * FROM item WHERE item_id=?");
    $stmt->execute([$_GET['item_id']]);
    // Check if item exists
    if($stmt->rowCount() < 1){
        header('Location: product.php');
        exit();
    }
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    header('Location: main.php');
    exit();
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <br />
            <h4>ฟอร์มแก้ไขข้อมูล</h4>
            <form name="edit" action="Editproduct_DB.php" method="post" enctype="multipart/form-data" class="form-horizontal" >
                <div class="form-group">
                    <p>เลขหมวดหมู่ :</p>
                    <div class="col-sm-10">
                        <input type="text" name="item_id" class="form-control" required value="<?= isset($row['item_id']) ? $row['item_id'] : ''; ?>" minlength="3">
                    </div>
                </div>
                <div class="form-group">
                    <p>ชื่อหมวดหมู๋ :</p>
                    <div class="col-sm-10">
                        <input type="text" name="item_name" class="form-control" required value="<?= isset($row['item_name']) ? $row['item_name'] : ''; ?>" minlength="3">
                    </div>
                </div>
                <div class="form-group">
                    <p>รายละเอียด :</p>
                    <div class="col-sm-10">
                        <textarea name="item_detail" class="form-control" required minlength="3"><?= isset($row['item_detail']) ? $row['item_detail'] : ''; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
    <div class="col-sm-4">
        <p>Category:</p>
        <select name="item_category" id="item_category" class="form-control" required>
            <?php
            require_once 'connect.php';  
            $stmt = $conn->prepare("SELECT Cate_id, Cate_status FROM category");
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $categoryId = $row['Cate_id'];
                $category = $row['Cate_status'];
                echo "<option value='$categoryId'>$category</option>";
            }
            ?>
        </select>
    </div>
    <div class="col-sm-3">
        <p>Received Year:</p>
        <select name="received_year" id="received_year" class="form-control" required>
            <?php
            // Generate ตัวเลือกปี (ตั้งแต่ปี 2000 ถึงปีปัจจุบัน)
            $currentYear = date('Y');
            for ($year = 2000; $year <= $currentYear; $year++) {
                echo "<option value='$year'>$year</option>";
            }
            ?>
        </select>
    </div>
    <div class="col-sm-3">
        <p>In-use Year:</p>
        <select name="in_use_year" id="in_use_year" class="form-control" required>
            <?php
            // Generate ตัวเลือกปี (ตั้งแต่ปี 2000 ถึงปีปัจจุบัน)
            $currentYear = date('Y');
            for ($year = 2000; $year <= $currentYear; $year++) {
                echo "<option value='$year'>$year</option>";
            }
            ?>
        </select>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-10">
        <p>Serialnumber </p>
        <input type="text" name="item_serial" id="item_serial" class="form-control" readonly placeholder="Serialnumber" value="<?php echo isset($row['item_serial']) ? $row['item_serial'] : ''; ?>" />
        <?php
// เชื่อมต่อฐานข้อมูล
require_once 'connect.php';

// ตรวจสอบว่ามีการส่งค่า item_category, received_year และ in_use_year ผ่านเมธอด POST หรือไม่
if(isset($_POST['item_category']) && isset($_POST['received_year']) && isset($_POST['in_use_year'])) {
    // ดึงค่าข้อมูลจาก POST
    $item_category = $_POST['item_category'];
    $received_year = $_POST['received_year'];
    $in_use_year = $_POST['in_use_year'];

    // ทำการ query เพื่อดึงข้อมูล item_serial จากฐานข้อมูล
    $stmt = $conn->prepare("SELECT item_serial FROM your_table_name WHERE item_category = :item_category AND received_year = :received_year AND in_use_year = :in_use_year");
    $stmt->bindParam(':item_category', $item_category);
    $stmt->bindParam(':received_year', $received_year);
    $stmt->bindParam(':in_use_year', $in_use_year);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $item_serial = $row['item_serial'];

    // ส่งค่า item_serial ไปยังสคริปต์ JavaScript เพื่อแสดงผล
    echo "<script>";
    echo "document.getElementById('item_serial').value = '" . $item_serial . "';";
    echo "</script>";
}
?>


<script>
// ใส่ค่าของ item_serial ที่ดึงมาจาก PHP ลงใน input field
document.getElementById('item_serial').value = "<?php echo $item_serial; ?>";
</script>

    </div>
</div>

                <div class="form-group">
                    <div class="col-sm-5">
                    <p>Owner:</p>
                    <select name="item_owner" class="form-control" required>
                <?php
                    require_once 'connect.php';  
                    $stmt = $conn->prepare("SELECT owner_name FROM owner");
                    $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $ownername = $row['owner_name'];
                    echo "<option value='$ownername'>$ownername</option>";
            }
            ?>
        </select>
    </div>
    <div class="col-sm-5">
        <p>Status:</p>
        <select name="item_status" class="form-control" required>
            <option value="มีให้ยืม">มีให้ยืม</option>
            <option value='ยืม'>ยืม</option>
        </select>
    </div>
</div>

                <br>
                <div class="form-group">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary" onclick="return confirmEdit()">แก้ไขข้อมูล</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function confirmEdit() {
        // สร้าง confirm dialog เพื่อให้ผู้ใช้ยืนยันการแก้ไขข้อมูล
        var confirmation = confirm('แก้ไขข้อมูลทั้งหมดแล้วใช่ไหม?');
        
        if (confirmation) {
            // หากผู้ใช้กด "ตกลง" ให้ส่งค่าเป็น true และทำการแก้ไข
            return true;
        } else {
            // หากผู้ใช้กด "ยกเลิก" ให้ส่งค่าเป็น false และไม่ทำการแก้ไข
            alert('ไม่มีการเปลี่ยนแปลงข้อมูล');
            return false;
        }
    }
</script>

</body>
</html>

<script>
        document.getElementById('item_category').addEventListener('change', function() {
    generateSerialNumber();
});

document.getElementById('received_year').addEventListener('change', function() {
    generateSerialNumber();
});

document.getElementById('in_use_year').addEventListener('change', function() {
    generateSerialNumber();
});

function generateSerialNumber() {
    var selectedCategoryId = document.getElementById('item_category').value;
    var receivedYear = document.getElementById('received_year').value;
    var inUseYear = document.getElementById('in_use_year').value;

    if (selectedCategoryId !== '' && receivedYear !== '' && inUseYear !== '') {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var lastSerial = xhr.responseText;

                var lastSerialNumber = parseInt(lastSerial);

                // ให้ newSerial เป็นตัวเลข
                var newSerial = parseInt('000' + (lastSerialNumber + 1));

                // เปลี่ยนที่นี่เพื่อให้ลำดับเริ่มต้นที่ 001
                var formattedSerial = ('000' + newSerial).slice(-3);

                var serialValue = selectedCategoryId + '-' + receivedYear + '-' + inUseYear + '-' + formattedSerial;

                document.getElementById('item_serial').value = serialValue;
            }
        };
        xhr.open('GET', 'get_last_serial.php?cate_id=' + selectedCategoryId, true);
        xhr.send();
    } else {
        document.getElementById('item_serial').value = '';
    }
}
    </script>
