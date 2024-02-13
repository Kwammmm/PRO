<?php include('menu_mem.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barcode Scanner</title>
</head>

<body>
<style>
        body {
            font-family: 'Tahoma', Arial, sans-serif;
        }
        table {
            width: 1100px;
            margin-left: 0%;
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
            margin-left: 0%;
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
    <div style="width: 1217px; height: 60px; background: #6D7BC8; border-radius: 4px ; margin-left: 19%;">
        <div style="color: black; font-size: 20px; font-family: Inter; font-weight: 600; word-wrap: break-word ;">
            <h1>Barcode Scanner</h1>

            <div style="width: 1217px; height: auto; background: #FFFFFF; border: 1px solid black; border-radius: 4px;">
                <form method="post">
                    <input type="text" id="barcodeInput" placeholder="Scan barcode...">
                    <button onclick="updateStatus()">Update Status</button>

                    <script>
                        function updateStatus() {
                            var barcode = document.getElementById('barcodeInput').value;


                            var xhr = new XMLHttpRequest();
                            xhr.onreadystatechange = function() {
                                if (xhr.readyState === 4 && xhr.status === 200) {
                                    alert(xhr.responseText);
                                    document.getElementById('barcodeInput').value = '';
                                }
                            };
                            xhr.open('POST', 'update_status.php', true);
                            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                            xhr.send('barcode=' + barcode);
                        }
                    </script>
                
            </div>
        </form>
        </div>
</body>

</html>