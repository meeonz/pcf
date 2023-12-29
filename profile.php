<?PHP
session_start();

include("database.php");
if( !verifyStudent($con) ) 
{
	header( "Location: index.php" );
	return false;
}
?>
<?PHP	
$act 	= (isset($_POST['act'])) ? trim($_POST['act']) : '';	

$name		= (isset($_POST['name'])) ? trim($_POST['name']) : '';
$matrix		= (isset($_POST['matrix'])) ? trim($_POST['matrix']) : '';
$programme	= (isset($_POST['programme'])) ? trim($_POST['programme']) : '';
$cur_semester= (isset($_POST['cur_semester'])) ? trim($_POST['cur_semester']) : '';
$semester	= (isset($_POST['semester'])) ? trim($_POST['semester']) : '0';
$faculty	= (isset($_POST['faculty'])) ? trim($_POST['faculty']) : '';
$noic		= (isset($_POST['noic'])) ? trim($_POST['noic']) : '';
$gender		= (isset($_POST['gender'])) ? trim($_POST['gender']) : '';
$religion	= (isset($_POST['religion'])) ? trim($_POST['religion']) : '';
$address	= (isset($_POST['address'])) ? trim($_POST['address']) : '';
$dob		= (isset($_POST['dob'])) ? trim($_POST['dob']) : '';
$nationality= (isset($_POST['nationality'])) ? trim($_POST['nationality']) : '';
$race		= (isset($_POST['race'])) ? trim($_POST['race']) : '';
$phone		= (isset($_POST['phone'])) ? trim($_POST['phone']) : '';
$email		= (isset($_POST['email'])) ? trim($_POST['email']) : '';
$username	= (isset($_POST['username'])) ? trim($_POST['username']) : '';
$password	= (isset($_POST['password'])) ? trim($_POST['password']) : '';

$name		=  mysqli_real_escape_string($con, $name);
$address	=  mysqli_real_escape_string($con, $address);

$success = "";

if($act == "edit")
{	
	$SQL_update = " UPDATE `student` SET 
						`name` = '$name',
						`matrix` = '$matrix',
						`programme` = '$programme',
						`cur_semester` = '$cur_semester',
						`semester` = '$semester',
						`faculty` = '$faculty',
						`noic` = '$noic',
						`gender` = '$gender',
						`religion` = '$religion',
						`address` = '$address',
						`dob` = '$dob',
						`nationality` = '$nationality',
						`race` = '$race',
						`phone` = '$phone',
						`email` = '$email',
						`username` = '$username',
						`password` = '$password'
					WHERE `username` =  '{$_SESSION['username']}'";	
										
	$result = mysqli_query($con, $SQL_update) or die("Error in query: ".$SQL_update."<br />".mysqli_error($con));
	
	$success = "Successfully Update";
	//print "<script>alert('Successfully Updated');</script>";
}


$SQL_view 	= " SELECT * FROM `student` WHERE `username` =  '{$_SESSION['username']}' ";
$result 	= mysqli_query($con, $SQL_view) or die("Error in query: ".$SQL_view."<br />".mysqli_error($con));
$data		= mysqli_fetch_array($result);
?>
<!DOCTYPE html>
<html>
<title>PCF</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<link href="css/table.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
<style>
a {
  text-decoration: none;
}

body,h1,h2,h3,h4,h5,h6 {font-family: "Raleway", sans-serif}

body, html {
  height: 100%;
  line-height: 1.8;
}

/* Full height image header */
.bgimg-1 {
  background-position: top;
  background-attachment: fixed;
  background-size: cover;
  background-image: url("images/banner.jpg");
  min-height: 100%;
  background-color: rgba(256, 256, 256, 0.8);
  background-blend-mode: overlay;
}

.w3-bar .w3-button {
  padding: 16px;
}
</style>

<body class="w3-pale-blue">

<?PHP include("menu-student.php"); ?>

<!--- Toast Notification -->
<?PHP 
if($success) { Notify("success", $success, "profile.php"); }
?>	

<div class="bgimg-1" >

	<div class="w3-padding-64"></div>
		
	
<div class="w3-container w3-padding" id="contact">
    <div class="w3-content w3-container w3-white w3-round w3-card" style="max-width:900px">
		<div class="w3-padding">
		
			<form method="post" action="" >
				<h3>Your Profile</h3>
				<hr class="w3-clear">
				
				<div class="w3-row">
					<div class="w3-col m6 w3-padding">
						<div class="w3-section" >
							Matrik No *
							<input class="w3-input w3-border w3-round" type="text" name="matrix" value="<?PHP echo $data["matrix"];?>" required>
						</div>
						
						<div class="w3-section" >
							Full Name *
							<input class="w3-input w3-border w3-round" type="text" name="name" value="<?PHP echo $data["name"];?>" required>
						</div>
						
						<div class="w3-section" >
							Programme *
							<input class="w3-input w3-border w3-round" type="text" name="programme" value="<?PHP echo $data["programme"];?>" required>
						</div>
						
						<div class="w3-section" >
							IC Number / Passport *
							<input class="w3-input w3-border w3-round" type="text" name="noic" value="<?PHP echo $data["noic"];?>" required>
						</div>
						
						<div class="w3-section" >
							Mobile Phone *
							<input class="w3-input w3-border w3-round" type="text" name="phone" value="<?PHP echo $data["phone"];?>" required>
						</div>
						
						<div class="w3-section" >
							Email *
							<input class="w3-input w3-border w3-round" type="email" name="email" value="<?PHP echo $data["email"];?>" required>
						</div>
						
						<div class="w3-section " >
							Current Semester *
							<select class="w3-select w3-border w3-round w3-padding" name="cur_semester" >
								<option value="">- Choose Semester -</option>
								<option value="1" <?PHP if($data["cur_semester"] == "1") echo "selected";?>>1</option>
								<option value="2" <?PHP if($data["cur_semester"] == "2") echo "selected";?>>2</option>
							</select>
						</div>
						
						<div class="w3-section " >
							Semester No *
							<select class="w3-select w3-border w3-round w3-padding" name="semester" >
								<option value="">- Choose Semester -</option>
								<option value="1" <?PHP if($data["semester"] == "1") echo "selected";?>>1</option>
								<option value="2" <?PHP if($data["semester"] == "2") echo "selected";?>>2</option>
								<option value="3" <?PHP if($data["semester"] == "3") echo "selected";?>>3</option>
								<option value="4" <?PHP if($data["semester"] == "4") echo "selected";?>>4</option>
								<option value="5" <?PHP if($data["semester"] == "5") echo "selected";?>>5</option>
								<option value="6" <?PHP if($data["semester"] == "6") echo "selected";?>>6</option>
								<option value="7" <?PHP if($data["semester"] == "7") echo "selected";?> >7</option>
								<option value="8" <?PHP if($data["semester"] == "8") echo "selected";?>>8</option>
							</select>
						</div>
						
						<div class="w3-section " >
							Faculty *
							<select class="w3-select w3-border w3-round w3-padding" name="faculty" >
								<option value="">- Select Faculty -</option>
								<option value="Faculty of Quranic & Sunnah Studies" <?PHP if($data["faculty"] == "Faculty of Quranic & Sunnah Studies") echo "selected";?>>Faculty of Quranic & Sunnah Studies</option>
								<option value="Faculty of Leadership & Management" <?PHP if($data["faculty"] == "Faculty of Leadership & Management") echo "selected";?>>Faculty of Leadership & Management</option>
								<option value="Faculty of Syariah & Law" <?PHP if($data["faculty"] == "Faculty of Syariah & Law") echo "selected";?>>Faculty of Syariah & Law</option>
								<option value="Faculty of Economics & Muamalat" <?PHP if($data["faculty"] == "Faculty of Economics & Muamalat") echo "selected";?>>Faculty of Economics & Muamalat</option>
								<option value="Faculty of Science & Technology" <?PHP if($data["faculty"] == "Faculty of Science & Technology") echo "selected";?>>Faculty of Science & Technology</option>
								<option value="Faculty of Medicine & Health Science" <?PHP if($data["faculty"] == "Faculty of Medicine & Health Science") echo "selected";?>>Faculty of Medicine & Health Science</option>
								<option value="Faculty of Major Language Studies" <?PHP if($data["faculty"] == "Faculty of Major Language Studies") echo "selected";?>>Faculty of Major Language Studies</option>
								<option value="Faculty of Dentistry" <?PHP if($data["faculty"] == "Faculty of Dentistry") echo "selected";?>>Faculty of Dentistry</option>
								<option value="Faculty of Engineering & Built Enviroment" <?PHP if($data["faculty"] == "Faculty of Engineering & Built Enviroment") echo "selected";?>>Faculty of Engineering & Built Enviroment</option>						
							</select>
						</div>
						
					</div>
				
					<div class="w3-col m6 w3-padding">
						<div class="w3-section " >
							Gender *
							<select class="w3-select w3-border w3-round w3-padding" name="gender" >
								<option value="">- Select Gender -</option>
								<option value="Male" <?PHP if($data["gender"] == "Male") echo "selected";?>>Male</option>
								<option value="Female" <?PHP if($data["gender"] == "Female") echo "selected";?> >Female</option>
							</select>
						</div>
						
						<div class="w3-section" >
							Religion *
							<input class="w3-input w3-border w3-round" type="text" name="religion" value="<?PHP echo $data["religion"];?>" required>
						</div>
						
						<div class="w3-section" >
							Race *
							<input class="w3-input w3-border w3-round" type="text" name="race" value="<?PHP echo $data["race"];?>" required>
						</div>
						
						<div class="w3-section" >
							Nationality *
							<input class="w3-input w3-border w3-round" type="text" name="nationality" value="<?PHP echo $data["nationality"];?>" required>
						</div>
						
						
						<div class="w3-section" >
							Address *
							<textarea class="w3-input w3-border w3-round" name="address" required><?PHP echo $data["address"];?></textarea>
						</div>
						
						
						<div class="w3-section" >
							Date of Birth *
							<input class="w3-input w3-border w3-round" type="date" name="dob" value="<?PHP echo $data["dob"];?>" required>
						</div>
						
						<div class="w3-section" >
							Username *
							<input class="w3-input w3-border w3-round" type="text" name="username" value="<?PHP echo $data["username"];?>" required>
						</div>
						
						<div class="w3-section">
							Password *
							<input class="w3-input w3-border w3-round cpwdx" type="password" name="password" id="password2" placeholder="Password must at least be 6 characters" value="<?PHP echo $data["password"];?>" required>					
							<div class=""><input type="checkbox" onclick="myFunction()"> Show Password</div>
						</div>
					</div>
				</div>
				
				<hr class="w3-clear">
				<input type="hidden" name="act" value="edit" >
				<button type="submit" class="w3-button w3-padding-large w3-blue w3-margin-bottom w3-round">SAVE CHANGES</button>

			</form>
		</div>
    </div>
</div>


<div class="w3-padding-16"></div>
	
</div>




<script>

// Toggle between showing and hiding the sidebar when clicking the menu icon
var mySidebar = document.getElementById("mySidebar");

function w3_open() {
  if (mySidebar.style.display === 'block') {
    mySidebar.style.display = 'none';
  } else {
    mySidebar.style.display = 'block';
  }
}

// Close the sidebar with the close button
function w3_close() {
    mySidebar.style.display = "none";
}
</script>

</body>
</html>