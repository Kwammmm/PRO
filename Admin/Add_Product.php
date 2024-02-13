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
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Property management system</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
</head>

<body>
    <style>
        .col-sm-12 {
            width: 100%;
            padding-top: 50px;
            padding-left: 250px;
        }

        row {
            margin-left: 50px;
            height: 100%;
        }

        #password-toggle {
            margin-left: 10px;
            cursor: pointer;
        }

        .form-horizontal .form-group {
            margin-right: -15px;
            margin-left: -15px;

        }

        .col-sm-12 {
            width: 100%;
            padding-top: 50px;
            padding-left: 0;
            /* ลองปรับเป็น 0 หรือลบบรรทัดนี้ไปดู */
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6"> <br />
                <h4 align="center"> Add Product </h4>
                <hr />

                <form name="addproduct" action="Add_Product_DB.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
                    <div class="form-group">
                        <div class="col-sm-9">
                            <p> Name</p>
                            <input type="text" name="item_name" class="form-control" required placeholder="product name" />
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-9">
                            <p>Detail</p>
                            <textarea name="item_detail" class="form-control" rows="2" required placeholder="Detail"></textarea>
                        </div>
                    </div>





                    <form name="addproduct" action="Add_Product_DB.php" method="POST" enctype="multipart/form-data" class="form-horizontal form-inline">
                        <div class="form-group">
                            <div class="col-sm-5">
                                <p>category:</p>
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
                                    $currentYear = date('Y');
                                    for ($year = 2000; $year <= $currentYear; $year++) {
                                        echo "<option value='$year'>$year</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-sm-5">
                                <p>Serialnumber </p>
                                <input type="text" name="item_serial" id="item_serial" class="form-control" readonly placeholder="Serialnumber" />
                            </div>


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

                            <div class="form-group">
                                <div class="col-sm-3">
                                    <p>Status:</p>
                                    <select name="item_status" class="form-control" required>
                                        <option value="มีให้ยืม">มีให้ยืม</option>
                                    </select>
                                </div>
                            </div>



                            <div class="form-group">
                                <div class="col-sm-5">
                                    <button type="submit" class="btn btn-primary" name="btnadd">เพิ่มข้อมูล</button>
                                </div>
                            </div>
                            </div>

                    </form>
                </form>
            </div>
        </div>
    
    </div>
    </form>
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

                        var formattedSerial = ('000' + (lastSerialNumber + 1)).slice(-3);

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
</body>

</html>