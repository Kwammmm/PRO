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
<?php include('testmenu.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Viewer</title>
    <style>
        .pdf-container {
            width: 100%;
            max-width: 800px; 
            margin: 0 auto;
        }
        .pdf-file {
            margin-bottom: 20px;
        }
       
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
            margin-left: 40%;
            margin-top: 5%;
            
        }

        form {
            padding: 15px;
            margin-left: 35%;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Click to Download PDF</h1><br>
    <div class="pdf-container"style="margin-left: 40%; margin-top: 1%;" >
        <?php
        $pdfDirectory = 'pdfs/';

        
        $pdfFiles = glob($pdfDirectory . '*.pdf');

        
        if ($pdfFiles !== false && count($pdfFiles) > 0) {
            
            foreach ($pdfFiles as $pdfFile) {
                
                $fileName = basename($pdfFile);
                echo '<div class="pdf-file">';
                echo "<p><a href='$pdfFile' download='$fileName'>$fileName</a></p>"; 
                echo '</div>';
            }
        } else {
            echo '<p>No PDF files found.</p>';
        }
        ?>
    </div>
</body>
</html>
