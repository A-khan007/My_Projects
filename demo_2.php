<?php
error_reporting(0);
$hostname = "localhost";
$username = "root";
$password = "";
$dbname   = "wscube";

// Connect to database
$conn = mysqli_connect($hostname, $username, $password, $dbname);
if (!$conn) {
    die("Connection error: " . mysqli_connect_error());
}

// Create table query
$sql = "
CREATE TABLE IF NOT EXISTS ws_students (
    st_id INT NOT NULL AUTO_INCREMENT,
    st_fname VARCHAR(50) NOT NULL,
    st_lname VARCHAR(50) NOT NULL,
    st_contact VARCHAR(50) NOT NULL,
    st_email VARCHAR(50) NOT NULL,
    course_name VARCHAR(50),
    photo VARCHAR(100),
    st_regdate TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (st_id)
)";
if (!mysqli_query($conn, $sql)) {
    echo "Table creation failed: " . mysqli_error($conn);
} else {
    echo "Table created successfully.";
}

// Search filters
$where = "";
if (isset($_POST['search'])) {
    $cname = mysqli_real_escape_string($conn, $_POST['cname']);
    if (!empty($cname)) {
        $where .= " AND course_name = '$cname'";
    }

    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    if (!empty($fname)) {
        $where .= " AND st_fname LIKE '%$fname%'";
    }
}

//Delete Query
echo $id=$_GET['stid'];
if($id!==""){
    $del="DELETE FROM ws_students where st_id='$id'";
    mysqli_query($conn, $del);
}

//Multiple Delete
//Method-1

 // $id=$_POST['del'];
 // print_r($id);
 // $totalid=count($id);

 // for($i=0; $i<$totalid;$i++){
 //    $delid= $id[$i];
 //     $del="DELETE FROM ws_students where st_id='$delid'";
 //    mysqli_query($conn, $del);
 // }

//Method-2
if(isset($_POST['Delete'])){

 $id=$_POST['del'];
 $ids=implode(",", $id);
 echo $del="DELETE FROM ws_students where st_id IN($ids)";
 mysqli_query($conn, $del);
}
 


?>

<!-- Right Portion Starts -->
<div class="col-md-10 col-sm-10 right_menu">
    <div class="container-fluid">
        <div class="container" style="width: 90%;">
            <div class="row">
                <h5 id="title" class="col-md-12 col-sm-12 text-center">View Course:</h5>
                <div class="col-md-12 col-sm-12">
                    <form method="post">
                        <center>
                            <label for="fname">First Name:</label>
                            <input type="text" name="fname" class="form-control" style="width: 200px; display: inline-block; margin: 0 10px;">

                            <label for="cname">Course Name:</label>
                            <select name="cname" class="form-control" style="width: 200px; display: inline-block; margin: 0 10px;">
                                <option value="">Select Course</option>
                                <option value="PHP">PHP</option>
                                <option value="Java">Java</option>
                                <option value="C">C</option>
                            </select>

                            <input type="submit" name="search" value="Search" class="btn btn-info" />
                        </center>
                    </form>

                    <form method="post">

                    <table class="table table-bordered table-striped mt-3">
                        <thead>
                            <tr>
                                <th><input type="submit" value="Delete" name="Delete"/></th>
                                <th>Sr. No</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Contact</th>
                                <th>Email</th>
                                <th>Course Name</th>
                                <th>Photo</th>
                                <th>Reg Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sel = "SELECT * FROM ws_students WHERE 1=1 $where";
                            $exe = mysqli_query($conn, $sel);
                            $sr_no = 1;

                            while ($fetch = mysqli_fetch_assoc($exe)) {
                            ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" value="<?php echo $fetch['st_id']; ?>" name="del[]"/>
                                    </td>
                                    <td><?php echo $fetch['st_id']; ?></td>
                                    <!--<td><?php echo $sr_no++; ?></td>-->
                                    <td><?php echo htmlspecialchars($fetch['st_fname']); ?></td>
                                    <td><?php echo htmlspecialchars($fetch['st_lname']); ?></td>
                                    <td><?php echo htmlspecialchars($fetch['st_contact']); ?></td>
                                    <td><?php echo htmlspecialchars($fetch['st_email']); ?></td>
                                    <td><?php echo htmlspecialchars($fetch['course_name']); ?></td>
                                    <td>
                                        <img src="upload/<?php echo htmlspecialchars($fetch['photo']); ?>" width="50" height="50" alt="Photo">
                                    </td>
                                    <td><?php echo $fetch['st_regdate']; ?></td>
                                    <td><button class="btn btn-success btn-sm">Active</button></td>
                                    <td>
                                        <a href="demo_2.php?stid=<?php echo $fetch['st_id'];?>">
                                        <button class="btn btn-danger btn-sm">Delete</button></a>
                                        <a href="demo_2.php?editid=<?php echo $fetch['st_id'];?>">
                                        <button class="btn btn-primary btn-sm">Edit</button></a>
                                    </td>
                                </tr>
                            <?php } ?>
                            <?php if (mysqli_num_rows($exe) == 0): ?>
                                <tr>
                                    <td colspan="10" class="text-center">No records found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Right Portion Ends -->

<!-- <?php // include("footer.php"); ?> -->
