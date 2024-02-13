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


<?php include('menu_mem.php'); ?>

<?php
//เรียกใช้งานไฟล์เชื่อมต่อฐานข้อมูล
require_once 'connect.php';
//คิวรี่ข้อมูลหาผมรวมยอดขายโดยใช้ SQL SUM
$stmt = $conn->prepare("
    SELECT member_status, COUNT(*) as total
    FROM tbl_member
    GROUP BY member_status");
$stmt->execute();
$result = $stmt->fetchAll();

//นำข้อมูลที่ได้จากคิวรี่มากำหนดรูปแบบข้อมุลให้ถูกโครงสร้างของกราฟที่ใช้ *อ่าน docs เพิ่มเติม
$report_data = array();
foreach ($result as $rs) {
    //ทำข้อมูลให้ถูกโครงสร้างก่อนนำไปแสดงในกราฟ ศึกษาเพิ่มเติม https://www.amcharts.com/demos/pie-chart/
    $report_data[] = '{country:"' . $rs['member_status'] . '", value:' . $rs['total'] . '}';
}
//ตัด , ตัวสุดท้ายออก
$report_data = implode(",", $report_data);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PHP PDO Column Chart With Rotated Labels from amCharts devbanban.com 2021</title>
    <!--bootstrap5-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <!-- amcharts devbanban.com -->
    <title>Pie Chart from https://www.highcharts.com workshop by devbanban.com 2021</title>
    <!--bootstrap5-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <!-- css chart -->
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <!-- highcharts -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <!-- ionicon -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <!-- กำหนดขนาดของกราฟ -->
    <style>
        #chartdiv {
            width: 100%;
            height: 500px;
        }

        .highcharts-figure,
        .highcharts-data-table table {
            min-width: 320px;
            max-width: 800px;
            margin: 1em auto;
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #ebebeb;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }

        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }

        input[type="number"] {
            min-width: 50px;
        }

        col-md-10 {
            width: 50%
        }
    </style>

<body>
    </head>

    

                <?php
                //เรียกใช้งานไฟล์เชื่อมต่อฐานข้อมูล
                require_once 'connect.php';

                //คิวรี่ข้อมูลหาผมรวมยอดขายโดยใช้ SQL SUM
                $stmt = $conn->prepare("
    SELECT item_category, item_name, COUNT(*) as total
    FROM item
    GROUP BY item_category, item_name");


                $stmt->execute();
                $result = $stmt->fetchAll();

                //นำข้อมูลที่ได้จากคิวรี่มากำหนดรูปแบบข้อมุลให้ถูกโครงสร้างของกราฟที่ใช้
                $report_data = array();
                foreach ($result as $rs) {
                    //ทำข้อมูลให้ถูกโครงสร้างก่อนนำไปแสดงในกราฟ
                    $report_data[] = '{name:"' . $rs['item_category'] . ' - ' . $rs['item_name'] . '", y:' . $rs['total'] . '}';
                }
                //ตัด , ตัวสุดท้ายออก
                $report_data = implode(",", $report_data);
                ?>


                <div class="container">
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">

                            <figure class="highcharts-figure">
                                <div id="containerchart"></div>

                            </figure>
                            <script>
                                Highcharts.chart('containerchart', {
                                    chart: {
                                        plotBackgroundColor: null,
                                        plotBorderWidth: null,
                                        plotShadow: false,
                                        type: 'pie'
                                    },
                                    title: {
                                        text: 'จำนวนทรัพย์สินทั้งหมด'
                                    },
                                    tooltip: {
                                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                                    },
                                    accessibility: {
                                        point: {
                                            valueSuffix: '%'
                                        }
                                    },
                                    plotOptions: {
                                        pie: {
                                            allowPointSelect: true,
                                            cursor: 'pointer',
                                            dataLabels: {
                                                enabled: true,
                                                format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                                            }
                                        }
                                    },
                                    series: [{
                                        name: 'Brands',
                                        colorByPoint: true,
                                        data: [<?php echo $report_data; ?>]
                                    }]
                                });
                            </script>

                        </div>
                    </div>
                </div>

    </body>

</html>