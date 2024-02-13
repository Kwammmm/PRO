<?php include('testmenu.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
  <title>Basic CRUD PHP PDO by devbanban.com 2021</title>
</head>

<body>



  <div class="container">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6"> <br />

        <h4>ฟอร์มแก้ไขข้อมูล</h4>

        <form enctype="multipart/form-data" class="form-horizontal">
          <div class="form-group">
            <div class="mb-2">
              <label for="name" class="col-sm-2 col-form-label"> รหัสประจำตัว : </label>
              <div class="col-sm-10">
                <input type="text" id="member_id" class="form-control" readonly minlength="3">
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="mb-2">
              <label for="name" class="col-sm-2 col-form-label"> ชื่อ : </label>
              <div class="col-sm-10">
                <input type="text" id="member_name" class="form-control" required minlength="3">
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="mb-1">
              <label for="surname" class="col-sm-2 col-form-label"> นามสกุล : </label>
              <div class="col-sm-10">
                <input type="text" id="member_sername" class="form-control" required minlength="3">
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-8">
              <p>ชั้นปี:</p>
              <select name="member_classS" id="member_classS" class="form-control" required>
                <?php
                require_once 'connect.php';

                $stmt = $conn->prepare("SELECT class_name FROM member_class");
                $stmt->execute();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  $class_name = $row['class_name'];
                  echo "<option value='$class_name'>$class_name</option>";
                }
                ?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <div class="mb-1">
              <label for="username" class="col-sm-2 col-form-label"> ชื่อผู้ใช้ : </label>
              <div class="col-sm-10">
                <input type="text" id="username" class="form-control" readonly minlength="3">
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-8">
              <p> Password </p>
              <div class="input-group">
                <input type="password" name="password" id="password" class="form-control" required placeholder="password" />
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility()">Show/Hide Password</button>
                  <button class="btn btn-outline-secondary" type="button" onclick="generatePassword()">Generate Password</button>
                </div>
              </div>
            </div>
          </div>


          <div class="form-group">
            <div class="col-sm-8">
              <p>หมวดหมู่:</p>
              <select name="member_status" id="member_status" class="form-control" required>
                <?php
                require_once 'connect.php';

                $stmt = $conn->prepare("SELECT status_name FROM tbl_statusmember");
                $stmt->execute();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  $status_name = $row['status_name'];
                  echo "<option value='$status_name'>$status_name</option>";
                }
                ?>
              </select>
            </div>
          </div>
          <br>
          <div class="form-group">
            <button class="btn btn-primary edit">แก้ไขข้อมูล</button>
            <div class="col-sm-12">
            </div>
          </div>
          <footer>
            <br><br>
          </footer>
          <script>
            function generatePassword() {
              var length = 8; // กำหนดความยาวของรหัสผ่าน
              var charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"; // ตัวอักษรที่ใช้ในการสร้างรหัสผ่าน
              var password = "";
              for (var i = 0; i < length; i++) {
                var charIndex = Math.floor(Math.random() * charset.length); // เลือกตัวอักษรสุ่ม
                password += charset.charAt(charIndex);
              }
              document.getElementById('password').value = password; // แสดงรหัสผ่านในช่อง input
            }
          </script>


          <script>
            function togglePasswordVisibility() {
              var passwordInput = document.getElementById('password');
              if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
              } else {
                passwordInput.type = 'password';
              }
            }
          </script>
          <script type="text/javascript">
            <?php
            if (isset($_GET['member_id'])) {
              require_once 'connect.php';
              $stmt = $conn->prepare("SELECT * FROM tbl_member WHERE member_id=?");
              $stmt->execute([$_GET['member_id']]);

              if ($stmt->rowCount() < 1) {
                header('Location: Member.php');
                exit();
              }

              $row = $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
              header('Location: main.php');
              exit();
            }
            ?>
            document.addEventListener("DOMContentLoaded", function() {
              var member_id = <?php echo json_encode($row['member_id']); ?>;
              var username = <?php echo json_encode($row['username']); ?>;
              var member_name = <?php echo json_encode($row['member_name']); ?>;
              var member_sername = <?php echo json_encode($row['member_sername']); ?>;
              var member_classS = <?php echo json_encode($row['member_classS']); ?>;
              var member_status = <?php echo json_encode($row['member_status']); ?>;
              var password = <?php echo json_encode($row['password']); ?>;

              const memberidInput = document.getElementById('member_id');
              const usernameInput = document.getElementById('username');
              const membernameInput = document.getElementById('member_name');
              const membersernameInput = document.getElementById('member_sername');
              const member_classSInput = document.getElementById('member_classS');
              const member_statusInput = document.getElementById('member_status');
              const passwordInput = document.getElementById('password');
              const editButtons = document.querySelectorAll('.edit');

              memberidInput.value = member_id;
              usernameInput.value = username;
              membernameInput.value = member_name;
              membersernameInput.value = member_sername;
              member_classSInput.value = member_classS;
              member_statusInput.value = member_status;
              passwordInput.value = password;

              editButtons.forEach(function(button) {
                button.addEventListener("click", function(event) {
                  const xhr = new XMLHttpRequest();
                  const formData = new FormData();

                  formData.append('member_id', member_id);
                  formData.append('member_name', membernameInput.value);
                  formData.append('member_sername', membersernameInput.value);
                  formData.append('member_classS', member_classSInput.value);
                  formData.append('username', usernameInput.value);
                  formData.append('password', passwordInput.value);
                  formData.append('member_status', member_statusInput.value);

                  xhr.open('POST', 'memberEdit._DB.php', true);

                  xhr.onload = function() {
                    if (xhr.status == 200) {
                      alert("แก้ไขข้อมูลสำเร็จ");
                      window.location = "Member.php";
                    }
                  };

                  xhr.onerror = function() {
                    console.log('Error submitting data.');
                  };

                  xhr.send(formData);

                  event.preventDefault();
                });
              });
            });
          </script>



        </form>
      </div>
    </div>
  </div>