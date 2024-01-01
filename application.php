<?php
session_start();
date_default_timezone_set('Asia/Kuala_Lumpur');

include("database.php");
if (!verifyStudent($con)) {
    header("Location: index.php");
    return false;
}
$id_student = $_SESSION["id_student"];
$matrix = $_SESSION["matrix"];
$act = (isset($_POST['act'])) ? trim($_POST['act']) : '';

$date = (isset($_POST['date'])) ? trim($_POST['date']) : '';
$purpose = (isset($_POST['purpose'])) ? trim($_POST['purpose']) : '';
$fund = (isset($_POST['fund'])) ? trim($_POST['fund']) : '';
$balance = (isset($_POST['balance'])) ? trim($_POST['balance']) : '';

$purpose = mysqli_real_escape_string($con, $purpose);
$currentdate = date('Y-m-d');
$success = "";

if ($act == "add") {
    $application_no = rand(1000, 9000);

    // File Upload
    if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($_FILES['file']['name']);

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
            // File is valid, and was successfully uploaded
            $fileName = $_FILES['file']['name'];

            // Insert into the database
            $SQL_update = " 
                INSERT INTO `application`(`id_application`, `id_student`, `application_no`, `date`, `purpose`, `fund`, `balance`, `application_date`, `status`, `file_name`) 
                VALUES (NULL, '$id_student', '$application_no', '$date', '$purpose', '$fund', '$balance', '$currentdate','Pending', '$fileName')
            ";

            $result = mysqli_query($con, $SQL_update) or die("Error in query: " . $SQL_update . "<br />" . mysqli_error($con));

            $success = "Successfully Updated";
        } else {
            echo 'Error uploading the file.';
        }
    } else {
        echo 'Error: ' . $_FILES['file']['error'];
    }
}

$SQL_view = " SELECT * FROM `student` WHERE `matrix` =  '{$_SESSION['matrix']}' ";
$result = mysqli_query($con, $SQL_view) or die("Error in query: " . $SQL_view . "<br />" . mysqli_error($con));
$data = mysqli_fetch_array($result);
$balance = $data["balance"];
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
if($success) { Notify("success", $success, "status.php"); }
?>	

<div class="bgimg-1" >

	<div class="w3-padding-64"></div>
		
	
<div class="w3-container w3-padding" id="contact">
    <div class="w3-content w3-container w3-white w3-round w3-card" style="max-width:600px">
		<div class="w3-padding">
		
			<form method="post" action=""  enctype="multipart/form-data">
				<h3>Application of Conference Fund</h3>
				<hr class="w3-clear">
				
				<div class="w3-section" >
					Matrik No *
					<input disabled class="w3-input w3-border w3-round" type="text" name="matrix" value="<?PHP echo $data["matrix"];?>" required>
				</div>
				
				<div class="w3-section" >
					Full Name *
					<input disabled class="w3-input w3-border w3-round" type="text" name="name" value="<?PHP echo $data["name"];?>" required>
				</div>
				
				<hr>
				
				<div class="w3-section" >
					Date Required *
					<input class="w3-input w3-border w3-round" type="date" name="date" value="" id=date required>
				</div>
				
				<div class="w3-section" >
					Balance (RM) *
					<input disabled class="w3-input w3-border w3-round" type="text" name="balancex" id="balancex" value="<?PHP echo $data["balance"];?>" required oninput="checkFieldValues()">
				</div>
				
				<div class="w3-section" >
					Fund Needed (RM) *
					<input class="w3-input w3-border w3-round" type="text" name="fund" value="" id="fund" required oninput="checkFieldValues()"  max="<?PHP echo $data["balance"];?>">
          <small class="form-text text-muted">Balance cannot exceed Fund.</small>

				</div>							
				
				<div class="w3-section" >
					Purpose *
					<textarea class="w3-input w3-border w3-round" name="purpose" required></textarea>
				</div>

				<div class="w3-section" >
					Receipt as proof *
					<!-- <textarea class="w3-input w3-border w3-round" name="purpose" required></textarea> -->
					<input  class="w3-input w3-border w3-round" type="file" name="file" id="file" required accept=".pdf">

				</div>
				
				<hr class="w3-clear">
				<input type="hidden" name="act" value="add" >
				<input type="hidden" name="balance" value="<?PHP echo $balance;?>" >
				<button type="submit" class="w3-button w3-block w3-padding-large w3-blue w3-margin-bottom w3-round">SUBMIT APPLICATION</button>

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
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const fundInput = document.querySelector('[name="fund"]');

    fundInput.addEventListener('input', function() {
        const balance = parseFloat(document.querySelector('[name="balancex"]').value);
        const fund = parseFloat(fundInput.value);

        if (fund > balance) {
            fundInput.style.borderColor = 'red';
        } else {
            fundInput.style.borderColor = ''; // Reset border color
        }
    });

    form.addEventListener('submit', function(event) {
        const balance = parseFloat(document.querySelector('[name="balancex"]').value);
        const fund = parseFloat(fundInput.value);

        if (fund > balance) {
            alert('Fund requested cannot exceed the available balance.');
            event.preventDefault(); // Prevent form submission
        }
    });
});
</script>

<script>
  // Function to check if Field 2 does not exceed Field 1
  function checkFieldValues() {
    var fund = document.getElementById('fund').value;
    var balancex = document.getElementById('balancex').value;

    if (parseInt(fund) > parseInt(balancex)) {
      alert("Field fund cannot exceed balance");
      // Reset the value of Field 2 or take other appropriate action
      document.getElementById('fund').value = balancex;
    }
  }
</script>

<script>
  // Set the minimum date to tomorrow
  var tomorrow = new Date();
  tomorrow.setDate(tomorrow.getDate() + 1);

  var formattedTomorrow = tomorrow.toISOString().split('T')[0];
  document.getElementById('date').setAttribute('min', formattedTomorrow);
</script>
</body>
</html>
