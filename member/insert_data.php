  <?php
  require_once 'connect.php';


  $re_studentid = $_POST['re_studentid'];
  $re_studentname = $_POST['re_studentname'];
  $re_serial = $_POST['re_serial'];
  $re_borrow = $_POST['re_borrow'];
  $re_return = $_POST['re_return'];
  $re_status = $_POST['re_status'];

  // Insert data into the database
  $stmt = $conn->prepare("INSERT INTO report (re_studentid, re_studentname, re_serial, re_borrow, re_return, re_status) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->execute([$re_studentid, $re_studentname, $re_serial, $re_borrow, $re_return, $re_status]);

  // Provide a response (you can customize it as per your requirement)
  echo "Data inserted successfully";

  ?>