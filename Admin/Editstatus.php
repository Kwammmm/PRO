<?php include('testmenu.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editcategory</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6"> <br />

        <h4>ฟอร์มแก้ไขข้อมูล</h4>

        <form enctype="multipart/form-data" class="form-horizontal" action="Editstatus_db.php" method="POST">
          <div class="form-group">
            <div class="mb-1">
              <p>เลขหมวดหมู่ :</p>
              <div class="col-sm-10">
                <input type="text" id="status_name" class="form-control" required minlength="3">
              </div>
            </div>
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-primary edit">แก้ไขข้อมูล</button>
            <div class="col-sm-12">
            </div>
          </div>
        </form>

        <script type="text/javascript">
          document.addEventListener("DOMContentLoaded", function() {
            <?php
            if (isset($_GET['status_name'])) {
              require_once 'connect.php';
              $stmt = $conn->prepare("SELECT * FROM tbl_statusmember WHERE status_name=?");
              $stmt->execute([$_GET['status_name']]);

              if ($stmt->rowCount() < 1) {
                header('Location: statusmember.php');
                exit();
              }

              $row = $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
              header('Location: main.php');
              exit();
            }
            ?>

            var status_name = <?php echo json_encode($row['status_name']); ?>;
            const statusnameInput = document.getElementById('status_name');
            const editButton = document.querySelector('.edit');

            statusnameInput.value = status_name;

            editButton.addEventListener("click", function(event) {
              event.preventDefault(); 
              const formData = new FormData();
              formData.append('newstatus_name', statusnameInput.value);
              formData.append('status_name', status_name);

              const xhr = new XMLHttpRequest();
              xhr.open('POST', 'Editstatus_db.php', true);
              xhr.onload = function() {
                if (xhr.status === 200) {
                  alert("แก้ไขข้อมูลสำเร็จ");
                  window.location = "statusmember.php";
                }
              };

              xhr.onerror = function() {
                console.error('Error submitting data.');
              };

              xhr.send(formData);
            });
          });
        </script>
      </div>
    </div>
  </div>
</body>

</html>
