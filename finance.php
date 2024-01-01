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

$acc_no		= (isset($_POST['acc_no'])) ? trim($_POST['acc_no']) : '';
$bank		= (isset($_POST['bank'])) ? trim($_POST['bank']) : '';

$acc_no		=  mysqli_real_escape_string($con, $acc_no);
$bank	=  mysqli_real_escape_string($con, $bank);

$success = "";

if($act == "edit")
{	
	$SQL_update = " UPDATE `student` SET 
						`acc_no` = '$acc_no',
						`bank` = '$bank'
					WHERE `matrix` =  '{$_SESSION['matrix']}'";	
										
	$result = mysqli_query($con, $SQL_update) or die("Error in query: ".$SQL_update."<br />".mysqli_error($con));
	
	$success = "Successfully Update";
	//print "<script>alert('Successfully Updated');</script>";
}


$SQL_view 	= " SELECT * FROM `student` WHERE `matrix` =  '{$_SESSION['matrix']}' ";
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
if($success) { Notify("success", $success, "finance.php"); }
?>	

<div class="bgimg-1" >

	<div class="w3-padding-64"></div>
		
	
<div class="w3-container w3-padding" id="contact">
    <div class="w3-content w3-container w3-white w3-round w3-card" style="max-width:600px">
		<div class="w3-padding">
		
			<form method="post" action="" >
				<h3>Finance Info</h3>
				<hr class="w3-clear">
				
				<div class="w3-section" >
					Matrik No *
					<input disabled class="w3-input w3-border w3-round" type="text" name="matrix" value="<?PHP echo $data["matrix"];?>" required>
				</div>
				
				<div class="w3-section" >
					Full Name *
					<input disabled class="w3-input w3-border w3-round" type="text" name="name" value="<?PHP echo $data["name"];?>" required>
				</div>
				
				<div class="w3-section" >
					Programme *
					<input disabled class="w3-input w3-border w3-round" type="text" name="programme" value="<?PHP echo $data["programme"];?>" required>
				</div>
	
				<hr>
				
				<div class="w3-section" >
					Balance (RM) *
					<input disabled class="w3-input w3-border w3-round" type="text" name="balance" value="<?PHP echo $data["balance"];?>" required>
				</div>
				
				<div class="w3-section" >
					Acc No *
					<input class="w3-input w3-border w3-round" type="text" name="acc_no" value="<?PHP echo $data["acc_no"];?>" required>
				</div>
				
				<div class="w3-section" >
					Bank *
					<input class="w3-input w3-border w3-round" type="text" name="bank" value="<?PHP echo $data["bank"];?>" required>
				</div>
				
				<hr class="w3-clear">
				<input type="hidden" name="act" value="edit" >
				<button type="submit" class="w3-button w3-block w3-padding-large w3-blue w3-margin-bottom w3-round">SAVE CHANGES</button>

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