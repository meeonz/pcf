<?PHP
session_start();

include("database.php");
if( !verifyAdmin($con) ) 
{
	header( "Location: index.php" );
	return false;
}
?>
<?PHP
$id_student	= (isset($_REQUEST['id_student'])) ? trim($_REQUEST['id_student']) : '0';
$act 		= (isset($_REQUEST['act'])) ? trim($_REQUEST['act']) : '';	

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

if($act == "add")
{	
	$SQL_insert = " 
	INSERT INTO `student`(`id_student`, `name`, `matrix`, `programme`, `cur_semester`, `semester`, `faculty`, 
				`noic`, `gender`, `religion`, `address`, `dob`, `nationality`, `race`, `phone`, `email`, `username`, `password`,
				`balance`, `acc_no`, `bank`) 
			VALUES (NULL, '$name', '$matrix', '$programme', '$cur_semester', '$semester', '$faculty', 
				'$noic', '$gender', '$religion', '$address', '$dob', '$nationality', '$race', '$phone', '$email', '$username', '$password',
				'1000', '', '')	
	";		
										
	$result = mysqli_query($con, $SQL_insert);
	
	$success = "Successfully Registered";
	
	//print "<script>self.location='a-package.php';</script>";
}
if($act == "edit")
{	
	$SQL_update = " UPDATE
						`student`
					SET
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
					WHERE `id_student` =  '$id_student'";	
										
	$result = mysqli_query($con, $SQL_update) or die("Error in query: ".$SQL_update."<br />".mysqli_error($con));
	
	$success = "Successfully Update";
	//print "<script>alert('Successfully Update'); self.location='a-student.php';</script>";
}

if($act == "del")
{
	$SQL_delete = " DELETE FROM `student` WHERE `id_student` =  '$id_student' ";
	$result = mysqli_query($con, $SQL_delete);
	
	$success = "Succe";
	//print "<script>self.location='a-student.php';</script>";
}
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
a { text-decoration : none ;}

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

<?PHP include("menu-admin.php"); ?>

<!--- Toast Notification -->
<?PHP 
if($success) { Notify("success", $success, "a-student.php"); }
?>	

<div class="bgimg-1" >

	<div class="w3-padding-32"></div>
	
	<div class=" w3-center w3-text-blank w3-padding-32">
		<span class="w3-xlarge"><b>STUDENT LIST</b></span><br>
	</div>


	<!-- Page Container -->
	<div class="w3-container w3-content" style="max-width:1400px;">    
	  <!-- The Grid -->
	  <div class="w3-row w3-white w3-card w3-padding">
	  
		<a onclick="document.getElementById('add01').style.display='block'; " class="w3-margin-bottom w3-right w3-button w3-blue w3-round "><i class="fa fa-fw fa-lg fa-plus"></i> ADD NEW</a>
		
		<div class="w3-row w3-margin ">
		<div class="table-responsive">
		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			<thead>
				<tr>
					<th>#</th>
					<th>Student Name</th>
					<th>Matrix No</th>
					<th>Programme</th>
					<th>Faculty</th>
					<th>Current Semester</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?PHP
			$bil = 0;
			$SQL_list = "SELECT * FROM `student` ";
			$result = mysqli_query($con, $SQL_list) ;
			while ( $data	= mysqli_fetch_array($result) )
			{
				$bil++;
			?>			
			<tr>
				<td><?PHP echo $bil ;?></td>

				<td><?PHP echo $data["name"] ;?></td>
				<td><?PHP echo $data["matrix"] ;?></td>
				<td><?PHP echo $data["programme"] ;?></td>
				<td><?PHP echo $data["faculty"] ;?></td>
				<td><?PHP echo $data["cur_semester"] ;?></td>
				<td>
				<a href="#" onclick="document.getElementById('idEdit<?PHP echo $bil;?>').style.display='block'" class=""><i class="fa fa-fw fa-edit fa-lg"></i></a>
				
				<a href="#" onclick="document.getElementById('idDelete<?PHP echo $bil;?>').style.display='block'" class="w3-text-red"><i class="fa fa-fw fa-trash-alt fa-lg"></i></a>
				</td>
			</tr>
			
<div id="idEdit<?PHP echo $bil; ?>" class="w3-modal" style="z-index:10;">
	<div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:600px">
      <header class="w3-container "> 
        <span onclick="document.getElementById('idEdit<?PHP echo $bil; ?>').style.display='none'" 
        class="w3-button w3-large w3-circle w3-display-topright "><i class="fa fa-fw fa-times"></i></span>
      </header>

		<div class="w3-container w3-padding">
		
		<form action="" method="post" >
			<div class="w3-padding"></div>
			<b class="w3-large">Update Student</b>
			<hr>
				
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
			  
			<hr class="w3-clear">
			<input type="hidden" name="id_student" value="<?PHP echo $data["id_student"];?>" >
			<input type="hidden" name="act" value="edit" >
			<button type="submit" class="w3-button w3-blue w3-text-white w3-margin-bottom w3-round">SAVE CHANGES</button>

		</form>
		</div>
	</div>
	<div class="w3-padding-24"></div>
</div>

<div id="idDelete<?PHP echo $bil; ?>" class="w3-modal" style="z-index:10;">
	<div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:500px">
      <header class="w3-container "> 
        <span onclick="document.getElementById('idDelete<?PHP echo $bil; ?>').style.display='none'" 
        class="w3-button w3-large w3-circle w3-display-topright "><i class="fa fa-fw fa-times"></i></span>
      </header>

		<div class="w3-container w3-padding">
		
		<form action="" method="post">
			<div class="w3-padding"></div>
			<b class="w3-large">Delete Confirmation</b>
			  
			<hr class="w3-clear">		
			Are you sure to delete this record?
			<div class="w3-padding-16"></div>
			
			<input type="hidden" name="id_student" value="<?PHP echo $data["id_student"];?>" >
			<input type="hidden" name="act" value="del" >
			<button type="button" onclick="document.getElementById('idDelete<?PHP echo $bil; ?>').style.display='none'"  class="w3-button w3-gray w3-text-white w3-margin-bottom w3-round">CANCEL</button>
			
			<button type="submit" class="w3-right w3-button w3-red w3-text-white w3-margin-bottom w3-round">YES, DELETE</button>
		</form>
		</div>
	</div>
</div>				
			<?PHP } ?>
			</tbody>
		</table>
		</div>
		</div>

		
	  <!-- End Grid -->
	  </div>
	  
	<!-- End Page Container -->
	</div>
	
	<div class="w3-padding-24"></div>
	
</div>



<div id="add01" class="w3-modal" >
    <div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:600px">
		<header class="w3-container "> 
			<span onclick="document.getElementById('add01').style.display='none'" class="w3-button w3-large w3-circle w3-display-topright "><i class="fa fa-fw fa-times"></i></span>
		</header>

		<div class="w3-container w3-padding">	
		<form action="" method="post" class="w3-padding">
			<div class="w3-padding"></div>
			<b class="w3-large">Add Student</b>
			<hr>

				<div class="w3-section" >
					Matrik No *
					<input class="w3-input w3-border w3-round" type="text" name="matrix"  required>
				</div>
				
				<div class="w3-section" >
					Full Name *
					<input class="w3-input w3-border w3-round" type="text" name="name" value="" required>
				</div>
				
				<div class="w3-section" >
					Programme *
					<input class="w3-input w3-border w3-round" type="text" name="programme" value="" required>
				</div>
				
				<div class="w3-section" >
					IC Number / Passport *
					<input class="w3-input w3-border w3-round" type="text" name="noic" value="" required>
				</div>
				
				<div class="w3-section" >
					Mobile Phone *
					<input class="w3-input w3-border w3-round" type="text" name="phone" value="" required>
				</div>
				
				<div class="w3-section" >
					Email *
					<input class="w3-input w3-border w3-round" type="email" name="email" value="" required>
				</div>
				
				<div class="w3-section " >
					Current Semester *
					<select class="w3-select w3-border w3-round w3-padding" name="cur_semester" >
						<option value="">- Choose Semester -</option>
						<option value="1" >1</option>
						<option value="2" >2</option>
					</select>
				</div>
				
				<div class="w3-section " >
					Semester No *
					<select class="w3-select w3-border w3-round w3-padding" name="semester" >
						<option value="">- Choose Semester -</option>
						<option value="1" >1</option>
						<option value="2" >2</option>
						<option value="3" >3</option>
						<option value="4" >4</option>
						<option value="5" >5</option>
						<option value="6" >6</option>
						<option value="7" >7</option>
						<option value="8" >8</option>
					</select>
				</div>
				
				<div class="w3-section " >
					Faculty *
					<select class="w3-select w3-border w3-round w3-padding" name="faculty" >
						<option value="">- Select Faculty -</option>
						<option value="Faculty of Quranic & Sunnah Studies" >Faculty of Quranic & Sunnah Studies</option>
						<option value="Faculty of Leadership & Management" >Faculty of Leadership & Management</option>
						<option value="Faculty of Syariah & Law" >Faculty of Syariah & Law</option>
						<option value="Faculty of Economics & Muamalat" >Faculty of Economics & Muamalat</option>
						<option value="Faculty of Science & Technology" >Faculty of Science & Technology</option>
						<option value="Faculty of Medicine & Health Science" >Faculty of Medicine & Health Science</option>
						<option value="Faculty of Major Language Studies" >Faculty of Major Language Studies</option>
						<option value="Faculty of Dentistry" >Faculty of Dentistry</option>
						<option value="Faculty of Engineering & Built Enviroment" >Faculty of Engineering & Built Enviroment</option>						
					</select>
				</div>
				
				<div class="w3-section " >
					Gender *
					<select class="w3-select w3-border w3-round w3-padding" name="gender" >
						<option value="">- Select Gender -</option>
						<option value="Male" >Male</option>
						<option value="Female" >Female</option>
					</select>
				</div>
				
				<div class="w3-section" >
					Religion *
					<input class="w3-input w3-border w3-round" type="text" name="religion" value="" required>
				</div>
				
				<div class="w3-section" >
					Race *
					<input class="w3-input w3-border w3-round" type="text" name="race" value="" required>
				</div>
				
				<div class="w3-section" >
					Nationality *
					<input class="w3-input w3-border w3-round" type="text" name="nationality" value="" required>
				</div>
				
				
				<div class="w3-section" >
					Address *
					<textarea class="w3-input w3-border w3-round" name="address" required></textarea>
				</div>
				
				
				<div class="w3-section" >
					Date of Birth *
					<input class="w3-input w3-border w3-round" type="date" name="dob" value="" required>
				</div>
				
				<div class="w3-section" >
					Username *
					<input class="w3-input w3-border w3-round" type="text" name="username" value="" required>
				</div>
				
				<div class="w3-section">
					Password *
					<input class="w3-input w3-border w3-round cpwdx" type="password" name="password" id="password" placeholder="Password must at least be 6 characters" required>					
					<div class=""><input type="checkbox" onclick="myFunction()"> Show Password</div>
				</div>
				  
				<script>
				function myFunction() {
				  var x = document.getElementById("password");
				  var y = document.getElementById("password2");
				  if (x.type === "password") {
					x.type = "text";
					y.type = "text";
				  } else {
					x.type = "password";
					y.type = "password";
				  }
				}
				</script>
				
				<hr class="w3-clear">

				<div class="w3-section" >
					<input name="act" type="hidden" value="add">
					<button type="submit" class="w3-button w3-blue w3-text-white w3-margin-bottom w3-round">SUBMIT</button>
				</div>
		</form> 
		</div>   
    </div>
	<div class="w3-padding-24"></div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
<!--<script src="assets/demo/datatables-demo.js"></script>-->


<script>
$(document).ready(function() {

  
	$('#dataTable').DataTable( {
		paging: true,
		
		searching: true
	} );
		
	
});
</script>

 
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
