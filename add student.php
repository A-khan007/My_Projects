<?php
error_reporting(0);

include("connection.php");

//include("header.php");

// Insert Query
$id=$_GET['editid'];
if($id==""){

if(isset($_POST['save'])){
	$fname=$_POST['fname'];
	$lname=$_POST['lastname'];
	$Contact=$_POST['Contact'];
	$email=$_POST['email'];
	$cname=$_POST['cname'];
	$ins="INSERT INTO ws_students set st_fname='$fname',st_lname='$lname', st_email='$email', st_contact='$Contact', course_name='$cname'";

	if(!mysqli_query($conn,$ins)){
		echo "Insert Error".mysqli_error($conn);
	}
	echo "Data inserted.....";
}
}else{
// Update Query

$sel="Select * From ws_students where st_id='$id'";
$exe=mysqli_query($conn,$sel);
$fetchdata=mysqli_fetch_assoc($exe);
if(isset($_POST['save'])){
	$fname=$_POST['fname'];
	$lname=$_POST['lastname'];
	$Contact=$_POST['Contact'];
	$email=$_POST['email'];
	$cname=$_POST['cname'];
	
$upd="update ws_students set st_fname='$fname',st_lname='$lname', st_email='$email', st_contact='$Contact', course_name='$cname' where st_id='$id'";
if(!mysqli_query($conn,$upd)){
		echo "Update Error".mysqli_error($conn);
	}
	echo "Data Updated.....";
}
}
?>

<!--Right Portion Starts-->
<div class="col-md-10 col-sm-10 right_menu">
    <div class="container-fluid">
        <div class="container" style="width: 90%;">
            <div class="row">
                <h5 id="title" class="col-md-12 col-sm-12 text-center">Add Student</h5>
                <!--Query form-->
                <div class="col-md-12 col-sm-12">
                	<form action="" method="post" id="insert_form">
                		<div class="<col-md-6 form-group">
                			<label for="name">First Name:</label>
                			<input type="text" class="form-control" name="fname" value="<?php echo $fetchdata['st_fname'];?>" required />
                		</div>
                		</<div><br><br>
                		<div class="row">
                			<div class="<col-md-6 form-group">
                			<label for="name">Last Name:</label>
                			<input type="text" class="form-control" name="lastname"value="<?php echo $fetchdata['st_lname'];?>" required />
                		</div>
                	</div><br><br>
                	<div class="row">
                			<div class="<col-md-6 form-group">
                			<label for="name">Contact:</label>
                			<input type="text" value="<?php echo $fetchdata['st_contact'];?>"class="form-control" name="Contact"/>
                		</div>
                	</div><br><br>
                	<div class="row">
                			<div class="<col-md-6 form-group">
                			<label for="name">Email:</label>
                			<input type="email" value="<?php echo $fetchdata['st_fname'];?>"class="form-control" name="email"/>
                		</div>
                	</div><br><br>
                	<div class="row">
                			<div class="<col-md-6 form-group">
                			<label for="name">Course Name:</label>
                			<select name="cname" class="form-control">
                				<option>Select Course</option>
                					<option value="PHP" <?php if($fetchdata['course_name']=="PHP"){echo "selected";} ?>>PHP</option>
                					<option value="Java"<?php if($fetchdata['course_name']=="Java"){echo "selected";} ?>>Java</option>
                					<option value="C"<?php if($fetchdata['course_name']=="C"){echo "selected";} ?>>C</option>
                			</select>
                		</div>
                	</div><br><br>
                			<div class="<col-md-6 form-group">
                			<label for="name">Photo:</label>
                			<input type="file" class="form-control" name="images"/>
                		</div>
                	</div><br><br>
                	<div class="row">
                		<input type="submit" name="save" class="col-md-2 btn btn-primary"/>
                	</div>
                </div>
                			
               </form>

