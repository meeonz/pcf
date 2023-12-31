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
$SQL_view 	= " SELECT * FROM `admin` WHERE `username` =  '". $_SESSION["username"] ."'";
$result 	= mysqli_query($con, $SQL_view);
$data		= mysqli_fetch_array($result);

$tot_pending	= numRows($con, "SELECT * FROM `application` WHERE `status` = 'Pending' ");
$tot_application= numRows($con, "SELECT * FROM `application`");
$tot_student	= numRows($con, "SELECT * FROM `student`  ");
?>
<!DOCTYPE html>
<html>
<title>PCF</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Raleway", sans-serif}

body, html {
  height: 100%;
  line-height: 1.8;
}

/* Full height image header */
.bgimg-1 {
  background-position: top;
  background-size: cover;
  background-attachment: fixed;
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


<div class="bgimg-1" >

	<div class="w3-padding-32"></div>
	
	<div class=" w3-center w3-text-blank w3-padding-32">
		<span class="w3-xlarge"><b>DASHBOARD</b></span><br>
	</div>


	<!-- Page Container -->
	<div class="w3-container w3-content" style="max-width:900px;">    
	  <!-- The Grid -->
	  <div class="w3-row">
	  

		<div class="w3-padding w3-padding-16">
			<div class="w3-card w3-padding w3-round w3-white">
				<div class="w3-xlarge w3-padding-24 w3-padding" >
					<div class="w3-padding">Welcome, Admin</div>
				</div>
				
				<div class="w3-row w3-padding-24">
					<div class="w3-col m4 w3-container">
						<div class=" w3-card w3-blue w3-round w3-padding-16">
							<div class="w3-container w3-large">
								New Application <i class="fa fa-inbox fa-lg w3-right"></i> 
								<hr style="border-top: 1px dashed; margin: 1px 0 15px !important;">
								<h2 class="w3-center"><?PHP echo $tot_pending;?></h2>
							</div>
						</div>
					</div>
					
					<div class="w3-col m4 w3-container">
						<div class=" w3-card w3-blue w3-round w3-padding-16">
							<div class="w3-container w3-large">
								All Application <i class="fa fa-inbox fa-lg w3-right"></i> 
								<hr style="border-top: 1px dashed; margin: 1px 0 15px !important;">
								<h2 class="w3-center"><?PHP echo $tot_application;?></h2>
							</div>
						</div>
					</div>
		
					
					<div class="w3-col m4 w3-container">
						<div class=" w3-card w3-blue w3-round w3-padding-16">
							<div class="w3-container w3-large">
								Student<i class="fa fa-user-tie fa-lg w3-right"></i> 
								<hr style="border-top: 1px dashed; margin: 1px 0 15px !important;">
								<h2 class="w3-center"><?PHP echo $tot_student;?></h2>
							</div>
						</div>
					</div>
					

						
			</div>
		  </div>
		</div>
			  

		
	  <!-- End Grid -->
	  </div>
	  
	<!-- End Page Container -->
	</div>
	
	<div class="w3-padding-24"></div>
	
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
