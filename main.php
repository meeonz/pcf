<?php
session_start();
include("database.php");

if (!verifyStudent($con)) {
    header("Location: index.php");
	return false; // Ensure that no further code is executed after the redirect
}

$currentDateTime = date('Y-m-d H:i:s'); // Format: Year-Month-Day Hour:Minute:Second
echo "Current Date and Time in Malaysia: $currentDateTime";

$SQL_view 	= " SELECT * FROM `student` WHERE `matrix` =  '" . $_SESSION["matrix"] . "'";
$result 	= mysqli_query($con, $SQL_view);
$data		= mysqli_fetch_array($result);
$name		= $data["name"];
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

<?PHP include("menu-student.php"); ?>


<div class="bgimg-1" >

	<div class="w3-padding-32"></div>
	
	<div class=" w3-center w3-text-blank w3-padding-32">
		<span class="w3-xlarge"><b>DASHBOARD</b></span><br>
	</div>


	<!-- Page Container -->
	<div class="w3-container w3-content" style="max-width:1200px;">    
	  <!-- The Grid -->
	  <div class="w3-row">
	  

		<div class="w3-padding w3-padding-16">
			<div class="w3-card w3-padding w3-round w3-white">
				<div class="w3-xlarge w3-padding-24 w3-padding" >
					<div class="w3-padding">Welcome, <?PHP echo $name;?></div>
				</div>
				
				<div class="w3-row w3-padding-24">
					<div class="w3-col m3 w3-container">
						<div class=" w3-card w3-blue w3-round w3-padding-16">
							<div class="w3-container w3-large">
								Application <i class="fa fa-plus-circle fa-lg w3-right"></i> 
								<hr style="border-top: 1px dashed; margin: 1px 0 15px !important;">
								<a href="application.php" class="w3-button w3-round w3-indigo w3-block">Apply New</a>
							</div>
						</div>
					</div>
		
					
					<div class="w3-col m3 w3-container">
						<div class=" w3-card w3-blue w3-round w3-padding-16">
							<div class="w3-container w3-large">
								Activities<i class="fa fa-inbox fa-lg w3-right"></i> 
								<hr style="border-top: 1px dashed; margin: 1px 0 15px !important;">
								<a href="activity.php" class="w3-button w3-round w3-indigo w3-block">View</a>
							</div>
						</div>
					</div>
					
					<div class="w3-col m3 w3-container">
						<div class=" w3-card w3-blue w3-round w3-padding-16">
							<div class="w3-container w3-large">
								Finance<i class="fa fa-money-bill fa-lg w3-right"></i> 
								<hr style="border-top: 1px dashed; margin: 1px 0 15px !important;">
								<a href="finance.php" class="w3-button w3-round w3-indigo w3-block">View</a>
							</div>
						</div>
					</div>
					
					<div class="w3-col m3 w3-container">
						<div class=" w3-card w3-blue w3-round w3-padding-16">
							<div class="w3-container w3-large">
								Profile<i class="fa fa-user-circle fa-lg w3-right"></i> 
								<hr style="border-top: 1px dashed; margin: 1px 0 15px !important;">
								<a href="profile.php" class="w3-button w3-round w3-indigo w3-block">Update</a>
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
