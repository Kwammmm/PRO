<?php include('menu_mem.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <title>Update information</title>

</head>

<body>

    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            var item_serial = <?php echo json_encode($_POST['item_serial']); ?>;
            var item_status = <?php echo json_encode($_POST['item_status']); ?>;
            const serialInput = document.getElementById('item_serial');
            const statusInput = document.querySelector('#re_status');

            // Set the value of the input field
            serialInput.value = item_serial;
            //statusInput.value = item_status;

            if (item_status == 'มีให้ยืม') {
                statusInput.value = 'มีให้ยืม'
                console.log(item_status);
            } else if (item_status == 'ยืม') {
                statusInput.value = 'ยืม'
                console.log(item_status);
            } else if (item_status == 'เกินกำหนด') {
                statusInput.value = 'เกินกำหนด'
                console.log(item_status);
            }

            console.log(item_serial);

        });
    </script>




    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6"> <br />

                <h4>ฟอร์มแก้ไขข้อมูล</h4>

                <form name="addproduct" method="post" enctype="multipart/form-data" class="form-horizontal">
                    <div class="form-group">
                        <div class="mb-1">
                            <p>รหัสนักศึกษา :</p>
                            <div class="col-sm-10">
                                <input type="text" id="re_studentid" class="form-control" required placeholder="รหัสนักศึกษา" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="mb-1">
                            <p>ชื่อนักศึกษา :</p>
                            <div class="col-sm-10">
                                <input type="text" id="re_studentname" class="form-control" required placeholder="ชื่อนักศึกษา" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="mb-1">
                            <p>serialnumber :</p>
                            <div class="col-sm-10">
                                <input type="text" id="item_serial" class="form-control" required readonly value="<?= isset($row['item_serial']) ? $row['item_serial'] : ''; ?>" minlength="3">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="mb-1">
                            <p>วันที่ยืม :</p>
                            <div class="col-sm-10">
                                <input type="date" id="re_borrow" class="form-control" required placeholder="วันที่ยืม" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="mb-1">
                            <p>วันที่คืน :</p>
                            <div class="col-sm-10">
                                <input type="date" id="re_return" class="form-control" required placeholder="วันที่คืน" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="mb-1">
                            <p>Status :</p>
                            <div class="col-sm-10">
                                <select id="re_status" class="form-control" >
                                    <option value='มีให้ยืม'>มีให้ยืม</option>
                                    <option value='ยืม'>ยืม</option>
                                    <option value='เกินกำหนด'>เกินกำหนด</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-sm-12">
                            <button class="btn btn-primary edit">แก้ไขข้อมูล</button>
                        </div>
                    </div>
                    <script type="text/javascript">
                        document.addEventListener("DOMContentLoaded", function() {
                            const editButtons = document.querySelectorAll('.edit');

                            editButtons.forEach(function(button) {
                                button.addEventListener("click", function(event) {
                                    const studentIDInput = document.getElementById('re_studentid').value;
                                    const studentnameInput = document.getElementById('re_studentname').value;
                                    const itemserialInput = document.getElementById('item_serial').value;
                                    const borrowInput = document.getElementById('re_borrow').value;
                                    const returnnput = document.getElementById('re_return').value;
                                    const statusInput = document.querySelector('#re_status').value;

                                    const xhr = new XMLHttpRequest();
                                    const xhr2 = new XMLHttpRequest();

                                    xhr.open('POST', 'insert_data.php', true);
                                    xhr2.open('POST', 'update_status.php', true);

                                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                                    xhr2.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

                                   
                                        xhr.onload = function() {
                                            if (xhr.status == 200) {
                                                console.log(xhr.responseText);
                                                xhr2.onload = function() {
                                                    if (xhr2.status == 200) {
                                                        console.log(xhr2.responseText);
                                                        window.location = 'product_mem.php';
                                                    }
                                                };
                                                xhr2.send('re_serial=' + itemserialInput + '&re_status=' + statusInput);
                                            }
                                        };

                                        xhr.onerror = function() {
                                            console.log('Error submitting data.');
                                        };
                                        xhr2.onerror = function() {
                                            console.log('Error updating status.');
                                        };

                                        xhr.send('re_studentid=' + studentIDInput + '&re_studentname=' + studentnameInput + '&re_serial=' + itemserialInput + '&re_borrow=' + borrowInput + '&re_return=' + returnnput + '&re_status=' + statusInput);
                                  
                                    event.preventDefault();
                                });
                            });
                        });
                    </script>

                </form>

            </div>
        </div>
    </div>