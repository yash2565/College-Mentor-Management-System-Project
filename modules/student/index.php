<?php


session_start();
if(isset($_SESSION['id']) && isset($_SESSION['username'])){
include("../../config/database.php");
$id = $_SESSION['id'];
$sid = $_SESSION['username'];
$sql = "SELECT * FROM students WHERE sid = '$sid'";
$result = mysqli_query($conn, $sql);
$resultcheck = mysqli_num_rows($result);
if($row = mysqli_fetch_assoc($result)){
	$fname= ucfirst($row['fname']);
	$lname = ucfirst($row['lname']);
	$center = $row['center'];
	$course = $row['course'];
	$batch = $row['batch'];
	$status = $row['status'];
}
if($status == 'yes' || $status == 'Yes') {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Students-SCOE</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
    <h2 align="center" style="color: blue"><?php echo ucfirst($center) . ' (' . strtoupper($course) . ')' ?></h2>
    <div class="header">

        <span style="font-size:30px;cursor:pointer" class="logo" onclick="openNav()">&#9776; Menu </span>

        <div class="header-right">
            <a href="profile.php">
                <?php echo $fname . " " . $lname . " (" . strtoupper($sid) . ")" ?></a>
        </div>
    </div>
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="index.php" class="logo"><span style="color:red;font-size:25px">Sanjivani College Of Engineering</span></a>
        <a href="profile.php"><?php echo $fname . " " . $lname . " (" . strtoupper($sid) . ")" ?></a>
        <a href="index.php">Home</a>

        <a href="timetable.php">TimeTable</a>
        <a href="marks.php">Marks</a>
      
        <a href="../../logout.php">Logout</a>
    </div>
    <div style="padding-left:20px; float: left;border-left: 6px solid red;background-color: lightgrey;width: 50%">
        <h1 align="center">Time Table</h1>
        <p align="center"><?php echo date("d-m-Y") . '<br>(' . date("l") . ')' ?></p>
        <table border="2" align="center" cellpadding="5px">
            <tr>
                <th>S.No</th>
                <th>Timing</th>
                <th>Subject name</th>
                <th>Subject Teacher</th>
                <th>Teacher ID(EID)</th>
            </tr>

            <?php
            $day = date("l");
            $sql_time = "SELECT * FROM timetable WHERE center = '$center' AND batch = '$batch' AND course = '$course' AND day ='$day'";
            $sql_time_result = mysqli_query($conn, $sql_time);
            $sql_time_result_check = mysqli_num_rows($sql_time_result);
            $j = 0;
            while ($rown = mysqli_fetch_assoc($sql_time_result)){
            $j++;
            $time = $rown['timing'];
            $subject = $rown['subject'];
            $eid = $rown['eid'];

            $sql_teacher1 = "SELECT * FROM teachers WHERE eid = '$eid'";
            $sql_result1 = mysqli_query($conn, $sql_teacher1);
            $sql_result_teacher1 = mysqli_num_rows($sql_result1);
            while ($rowsn1 = mysqli_fetch_assoc($sql_result1)) {
                $teacherfname1 = $rowsn1['fname'];
                $teacherlname1 = $rowsn1['lname'];

            }

            ?>
            <tr>
                <td><?php echo $j; ?></td>
                <td><?php echo $time; ?></td>
                <td><?php echo $subject ?></td>
                <td><?php echo $teacherfname1 . ' ' . $teacherlname1 ?></td>
                <td><?php echo $eid ?></td>

                <?php } ?>

        </table>
    </div>
    
    <script>
        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
        }
    </script>
    </body>
    </html>
    <?php
}else{
    ?>
    <h1>Your account is deactivated by admin due to some reasons. kindly contact Admin for further.</h1>
<?php
}
}else{
    header("Location: ../../index.php");
}

?>