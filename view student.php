<?php
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

                    <table class="table table-bordered table-striped mt-3">
                        <thead>
                            <tr>
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
                                    <td><?php echo $sr_no++; ?></td>
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
                                        <button class="btn btn-danger btn-sm">Delete</button>
                                        <button class="btn btn-primary btn-sm">Edit</button>
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
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Right Portion Ends -->

<!-- <?php // include("footer.php"); ?> -->
