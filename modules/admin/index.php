<?php
/**
 * Created by PhpStorm.
 * User: Bharat
 * Date: 7/6/2018
 * Time: 8:15 PM
 */

session_start();
if(isset($_SESSION['id']) && isset($_SESSION['username'])){
    include("../../config/database.php");
    $id = $_SESSION['id'];
    $eid = $_SESSION['username'];
    $sql = "SELECT * FROM teachers WHERE eid = '$eid'";
    $result = mysqli_query($conn, $sql);
    $resultcheck = mysqli_num_rows($result);
    if($row = mysqli_fetch_assoc($result)){
        $fname= ucfirst($row['fname']);
        $lname = ucfirst($row['lname']);
        $center = $row['center'];
        $course = $row['course'];
        $status = $row['status'];
    }
    if($status == 'yes' || $status == 'Yes') {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Admin-SCOE</title>
            <link rel="stylesheet" type="text/css" href="css/style.css">
        </head>
        <body>
        <h2 align="center" style="color:black ">ADMIN</h2>
        <div class="header">

            <span style="color:white;font-size:30px;cursor:pointer" class="logo" onclick="openNav()">&#9776; Menu </span>

            <div class="header-right" style="color:white">
                </div>
        </div>
        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <a href="index.php" class="logo"><span style="color:white;font-size:70px">SCOE</span></a>
            <a href="profile.php"><?php echo $fname . " " . $lname . " (" . strtoupper($eid) . ")" ?></a>
            <a href="index.php">Home</a>
            <a href="student.php">Student</a>
            <a href="teachers.php">Teachers</a>
            <a href="add.php">Add TimeTable/batch</a>
            <a href="update_password.php">Update Password</a>
            <a href="../../logout.php">Logout</a>
        </div>
        
        <div align="center">
            <table cellpadding="10px">
                <tr>
                    <?php
                    $sql_find_batch = "SELECT count(batch) AS total_batch FROM batches WHERE center='$center' AND course='$course'";
                    $sql_find_batch_get=mysqli_query($conn,$sql_find_batch);
                    $sql_find_batch_total = mysqli_fetch_assoc($sql_find_batch_get);
                    ?>
                    <th><div style="background-color: #8e198e; color: white; padding-left:20px;padding-right: 20px;padding-bottom: 1px;padding-top: 1px;"><h3>Total Batches</h3><p><?php echo $sql_find_batch_total['total_batch'];?></p></div></th>

                    <?php
                    $sql_find_sid = "SELECT count(sid) AS total_sid FROM students WHERE center='$center' AND course='$course'";
                    $sql_find_sid_get=mysqli_query($conn,$sql_find_sid);
                    $sql_find_sid_total = mysqli_fetch_assoc($sql_find_sid_get);
                    ?>
                    <th><div style="background-color: #8e198e; color:white; padding-left:20px;padding-right: 20px;padding-bottom: 1px;padding-top: 1px;"><h3>Total Students</h3><p><?php echo $sql_find_sid_total['total_sid'];?></p></div></th>

                    <?php
                    $sql_find_mentor = "SELECT count(eid) AS total_mentor FROM teachers WHERE center='$center' AND course='$course' AND position='mentor'";
                    $sql_find_mentor_get=mysqli_query($conn,$sql_find_mentor);
                    $sql_find_mentor_total = mysqli_fetch_assoc($sql_find_mentor_get);
                    ?>
                    <th><div style="background-color: #8e198e; color: white; padding-left:20px;padding-right: 20px;padding-bottom: 1px;padding-top: 1px;"><h3>Total Mentors</h3><p><?php echo $sql_find_mentor_total['total_mentor']; ?></p></div></th>
                    <?php
                    $sql_find_hod = "SELECT count(eid) AS total_hod FROM teachers WHERE center='$center' AND course='$course' AND position='hod'";
                    $sql_find_hod_get=mysqli_query($conn,$sql_find_hod);
                    $sql_find_hod_total = mysqli_fetch_assoc($sql_find_hod_get);
                    ?>
                    <th><div style="background-color: #8e198e; color: white; padding-left:20px;padding-right: 20px;padding-bottom: 1px;padding-top: 1px;"><h3>Total HOD's</h3><p><?php echo $sql_find_hod_total['total_hod']?></p></div></th>
                    <?php
                    $sql_find_teacher = "SELECT count(eid) AS total_teacher FROM teachers WHERE center='$center' AND course='$course' AND position='teacher'";
                    $sql_find_teacher_get=mysqli_query($conn,$sql_find_teacher);
                    $sql_find_teacher_total = mysqli_fetch_assoc($sql_find_teacher_get);
                    ?>
                    <th><div style="background-color: #8e198e; color: white; padding-left:20px;padding-right: 20px;padding-bottom: 1px;padding-top: 1px;"><h3>Total Teachers</h3><p><?php echo $sql_find_teacher_total['total_teacher']?></p></div></th>

                </tr>
            </table>
        </div>

        <div align="center" style="background-color: lightgray; padding: 10px;">
            <h3 style="color: black">Batch And Batch Mentors</h3>
            <table border="1" cellpadding="10px">
                <tr>
                    <th width="250px">Batches</th>
                    <th width="250px">Mentor Id</th>
                </tr>
                <?php
                    $get_batch_information = "SELECT * FROM batches where course='$course' AND center='$center'";
                    $get_batch_information_query = mysqli_query($conn,$get_batch_information);
                    while($rwo = mysqli_fetch_assoc($get_batch_information_query)){
                ?>
                        <tr>
                            <th><?php echo $rwo['batch']?></th>
                            <th><?php echo $rwo['mentor']?></th>
                        </tr>
                      <?php }  ?>
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