<?php session_start();?>
 <!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <title>Property management system</title>
  </head>
  
  <body>
    <style>
      col-md-8{
        border: 1px solid black;
      }
      h4{
        margin-top: 25%;
        margin-left: 26%;
        padding: 10px;
      }
      .form-control {
    display: block;
    width: 60%;
    margin-left: 18%;
      }
      btn-primary{
        display: block;
    width: 60%;
    margin-left: 18%;
      }
      .btn{
        display: block;
    width: 60%;
    margin-left: 18%;
      }
    </style>
    <div class="container">
      <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-8"> <br> 
          <h4>USER LOGIN</h4>
          <form action="" method="post">
                <div class="mb-2">
                <div class="col-sm-9">
                  <input type="text" name="username" class="form-control" required minlength="3" placeholder="username">
                </div>
                </div>
                <div class="mb-3">
                <div class="col-sm-9">
                  <input type="password" name="password" class="form-control" required minlength="3" placeholder="password">
                </div>
                </div>
                <div class="d-grid gap-2 col-sm-9 mb-3">
                <button type="submit" class="btn btn-primary">Login</button>
              </div>
              <div class="text" style="margin-left:17%; color:black;">
                    <a>You're not an user, right?</a>
                    <a href="/member/login.php">member</a> or
                    <a href="/admin/login.php">admin</a>
              </form>
            </div>
          </div>
        </div>
      </body>
    </html>  


    <?php

  //print_r($_POST); //ตรวจสอบมี input อะไรบ้าง และส่งอะไรมาบ้าง 
 //ถ้ามีค่าส่งมาจากฟอร์ม
 if(isset($_POST['username']) && isset($_POST['password'])){
  // Include SweetAlert
  echo '
  <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
  ';

  // Include database connection
  require_once 'connect.php';

  // Get values from the form
  $username = $_POST['username'];
  $password = $_POST['password']; 

  // Check username & password
  $stmt = $conn->prepare("SELECT member_id, member_name, member_sername,member_status FROM tbl_member WHERE username = :username AND password = :password");
  $stmt->bindParam(':username', $username, PDO::PARAM_STR);
  $stmt->bindParam(':password', $password, PDO::PARAM_STR);
  $stmt->execute();

  // If username & password are correct
  if($stmt->rowCount() == 1){
      // Fetch to get column values
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // Create session variables
      $_SESSION['member_id'] = $row['member_id'];
      $_SESSION['member_name'] = $row['member_name'];
      $_SESSION['member_sername'] = $row['member_sername'];
      $_SESSION['member_status'] = $row['member_status'];

      
      header("Location: main.php");
      

      }else{ //ถ้า username or password ไม่ถูกต้อง

         echo '<script>
                       setTimeout(function() {
                        swal({
                            title: "เกิดข้อผิดพลาด",
                             text: "Username หรือ Password ไม่ถูกต้อง ลองใหม่อีกครั้ง",
                            type: "warning"
                        }, function() {
                            window.location = "login.php"; //หน้าที่ต้องการให้กระโดดไป
                        });
                      }, 1000);
                  </script>';
              $conn = null; //close connect db
            } //else
    } //isset 
    //devbanban.com
    ?>