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
<?php

use Mpdf\Mpdf;
use Picqer\Barcode\BarcodeGeneratorPNG;

require_once __DIR__ . '/../vendor/autoload.php';
include('connect.php');

if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_items = "SELECT * FROM item";
$stmt_items = $conn->query($sql_items);

if (isset($_POST['generate_pdf'])) {
   
    if (isset($_POST['selected_serial']) && is_array($_POST['selected_serial'])) {
        $generator = new BarcodeGeneratorPNG();
        
        // Check the number of selected items
        $num_selected_items = count($_POST['selected_serial']);
        
        // Initialize mPDF instance
        $mpdf = new Mpdf();
        $date = new DateTime();
        foreach ($_POST['selected_serial'] as $selected_serial) {
          
            $sql = "SELECT * FROM item WHERE item_serial = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$selected_serial]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

           
            if ($row) {
                $barcode_data = $row['item_serial'];
                $barcode_image = $generator->getBarcode($barcode_data, $generator::TYPE_CODE_128, 2, 50);
               
                $html_content = ''; // Initialize HTML content for each item
                $html_content .= '<img src="data:image/png;base64,' . base64_encode($barcode_image) . '" alt="Barcode Image"><br>';
                $html_content .= "Serial: $selected_serial <br>";
                
                if ($num_selected_items == 1) {
                    // Generate separate PDF for each selected item
                    $pdf_filename = "pdfs/{$selected_serial} {$date->format('Y-m-d H-i-s')}.pdf";
                    $mpdf->WriteHTML($html_content);
                    $mpdf->Output($pdf_filename, 'F');
                    
                    echo "PDF for serial $selected_serial generated successfully.<br>";
                } else {
                    // Append content for each item when generating a combined PDF
                    $mpdf->WriteHTML($html_content);
                }
            } else {
                echo "Item with serial $selected_serial not found.<br>";
            }
        }
        
        if ($num_selected_items > 1) {
            // Generate a combined PDF when more than one item is selected
            $combined_pdf_filename = "pdfs/combined_items {$date->format('Y-m-d H-i-s')}.pdf";
            $mpdf->Output($combined_pdf_filename, 'F');
            echo "Combined PDF generated successfully.<br>";
        }
        
    } else {
        echo "No items selected.<br>";
    }
}
?>
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
            margin-left: 15%;
            margin-top: 5%;
        }

        form {
            padding: 15px;
            margin-left: 30%;
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
<form method="post">
<h1>Printer Barcode</h1>
    <?php
    // Display checkboxes for each item
    while ($row_item = $stmt_items->fetch(PDO::FETCH_ASSOC)) :
        $item_serial = $row_item['item_serial'];
        $item_name = $row_item['item_name'];
        
    ?>
        <input type="checkbox" name="selected_serial[]" value="<?php echo htmlspecialchars($item_serial); ?>">
        <?php echo "$item_serial - $item_name "; ?><br>
    <?php endwhile; ?>

    <input type="submit" name="generate_pdf" value="Generate PDF">
    <a href="downloadpdf.php" class="btn btn-info">Download PDF</a>
</form>
