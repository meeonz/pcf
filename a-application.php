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
$id_application	= (isset($_REQUEST['id_application'])) ? trim($_REQUEST['id_application']) : '0';
$id_student	= (isset($_POST['id_student'])) ? trim($_POST['id_student']) : '0';
$fund		= (isset($_POST['fund'])) ? trim($_POST['fund']) : '0';

$act 		= (isset($_REQUEST['act'])) ? trim($_REQUEST['act']) : '';	

$status		= (isset($_POST['status'])) ? trim($_POST['status']) : '';


$success = "";

if ($act == "yes") {
    // Assuming $id_application, $id_student, $fund are defined elsewhere in your code

    // Check if balance is not equal to or less than zero
    $checkBalanceQuery = "SELECT balance FROM `student` WHERE `id_student` = '$id_student'";
    $balanceResult = mysqli_query($con, $checkBalanceQuery);
    
    if ($balanceResult) {
        $row = mysqli_fetch_assoc($balanceResult);
        $currentBalance = $row['balance'];

        if ($currentBalance <= 0) {
            $error = "Balance is not equal to or less than zero";
        } elseif ($fund > $currentBalance) {
            $error = "Fund exceeds the current balance";
        } else {
            // Update application status to 'Yes'
            $updateApplicationQuery = "UPDATE `application` SET `status` = 'Yes' WHERE `id_application` = '$id_application'";
            $resultApplication = mysqli_query($con, $updateApplicationQuery) or die("Error in query: ".$updateApplicationQuery."<br />".mysqli_error($con));

            // Deduct fund from balance
            $updateBalanceQuery = "UPDATE `student` SET `balance` = balance - $fund WHERE `id_student` = '$id_student'";
            $resultBalance = mysqli_query($con, $updateBalanceQuery);

            if ($resultApplication && $resultBalance) {
                $success = "Successfully Update";
            } else {
                $error = "Error updating application or balance";
            }
        }
    } else {
        $error = "Error fetching balance";
    }
}



if($act == "no")
{	
	$SQL_update = " UPDATE `application` SET `status` = 'No' WHERE `id_application` =  '$id_application'";	
	$result = mysqli_query($con, $SQL_update) or die("Error in query: ".$SQL_update."<br />".mysqli_error($con));
	
	$success = "Successfully Update";
	//print "<script>alert('Successfully Update'); self.location='a-application.php';</script>";
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
if($success) { Notify("success", $success, "a-application.php"); }
?>	

<div class="bgimg-1" >

	<div class="w3-padding-32"></div>
	
	<div class=" w3-center w3-text-blank w3-padding-32">
		<span class="w3-xlarge"><b>APPLICATION LIST</b></span><br>
	</div>


	<!-- Page Container -->
	<div class="w3-container w3-content" style="max-width:1400px;">    
	  <!-- The Grid -->
	  <div class="w3-row w3-white w3-card w3-padding">
	  
		<div class="w3-row w3-margin ">
		<div class="table-responsive">
		<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
			<thead>
				<tr>
					<th>#</th>
					<th>Student Name</th>
					<th>Matrix No</th>
					<th>Purpose</th>
					<th>Date</th>					
					<th>Balance (RM)</th>
					<th>Fund Needed (RM)</th>
					<th>Status</th>
					<th>Application Date</th>
					<th>Approval</th>

				</tr>
			</thead>
			<tbody>
			<?PHP
			$bil = 0;
			$SQL_list = "SELECT *, application.balance as bal FROM `application`,`student` WHERE  application.id_student = student.id_student";
			$result = mysqli_query($con, $SQL_list) ;
			while ( $data	= mysqli_fetch_array($result) )
			{
				$bil++;
			?>			
			<tr>
				<td><?PHP echo $bil ;?></td>
				<td><?PHP echo $data["name"] ;?></td>
				<td><?PHP echo $data["matrix"] ;?></td>
				<td><?PHP echo $data["purpose"] ;?></td>
				<td><?PHP echo $data["date"] ;?></td>
				<td><?PHP echo $data["bal"] ;?></td>
				<td><b><?PHP echo $data["fund"] ;?></b></td>
				<td><?PHP echo $data["status"] ;?></td>
				<td><?PHP echo $data["application_date"] ;?></td>
				<td>
				<?PHP if($data["status"] == "Pending") { ?>
				<a href="#" onclick="document.getElementById('idYes<?PHP echo $bil;?>').style.display='block'" class="w3-button w3-round w3-green">YES</a>				
				<a href="#" onclick="document.getElementById('idNo<?PHP echo $bil;?>').style.display='block'" class="w3-button w3-round w3-red">NO</a>
				<?PHP } ?>
				</td>
			</tr>
			
<div id="idYes<?PHP echo $bil; ?>" class="w3-modal" style="z-index:10;">
	<div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:500px">
      <header class="w3-container "> 
        <span onclick="document.getElementById('idYes<?PHP echo $bil; ?>').style.display='none'" 
        class="w3-button w3-large w3-circle w3-display-topright "><i class="fa fa-fw fa-times"></i></span>
      </header>

		<div class="w3-container w3-padding">
		
		<form action="" method="post">
			<div class="w3-padding"></div>
			<b class="w3-large">Approval Confirmation</b>
			  
			<hr class="w3-clear">		
			Are you sure to approve this application?<br>
			Balance will be automatically deducted.
			<div class="w3-padding-16"></div>
			
			<input type="hidden" name="id_student" value="<?PHP echo $data["id_student"];?>" >
			<input type="hidden" name="fund" value="<?PHP echo $data["fund"];?>" >
			<input type="hidden" name="id_application" value="<?PHP echo $data["id_application"];?>" >
			<input type="hidden" name="act" value="yes" >
			<button type="button" onclick="document.getElementById('idYes<?PHP echo $bil; ?>').style.display='none'"  class="w3-button w3-gray w3-text-white w3-margin-bottom w3-round">CANCEL</button>
			
			<button type="submit" class="w3-right w3-button w3-red w3-text-white w3-margin-bottom w3-round">YES</button>
		</form>
		</div>
	</div>
</div>	

<div id="idNo<?PHP echo $bil; ?>" class="w3-modal" style="z-index:10;">
	<div class="w3-modal-content w3-round-large w3-card-4 w3-animate-zoom" style="max-width:500px">
      <header class="w3-container "> 
        <span onclick="document.getElementById('idNo<?PHP echo $bil; ?>').style.display='none'" 
        class="w3-button w3-large w3-circle w3-display-topright "><i class="fa fa-fw fa-times"></i></span>
      </header>

		<div class="w3-container w3-padding">
		
		<form action="" method="post">
			<div class="w3-padding"></div>
			<b class="w3-large">Approval Confirmation</b>
			  
			<hr class="w3-clear">		
			Are you sure to reject this application?
			<div class="w3-padding-16"></div>
			
			<input type="hidden" name="id_application" value="<?PHP echo $data["id_application"];?>" >
			<input type="hidden" name="act" value="no" >
			<button type="button" onclick="document.getElementById('idNo<?PHP echo $bil; ?>').style.display='none'"  class="w3-button w3-gray w3-text-white w3-margin-bottom w3-round">CANCEL</button>
			
			<button type="submit" class="w3-right w3-button w3-red w3-text-white w3-margin-bottom w3-round">YES</button>
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


<script>
    // Destroy existing DataTable instance
// if ($.fn.DataTable.isDataTable('#dataTable')) {
//     $('#dataTable').DataTable().destroy();
// }

$(document).ready(function() {
    // Destroy existing DataTable instance
    if ($.fn.DataTable.isDataTable('#dataTable')) {
        $('#dataTable').DataTable().destroy();
    }

    // Reinitialize DataTable
    $('#dataTable').DataTable({
        paging: true,
        searching: true,
        language: {
            searchPlaceholder: 'Enter your search term...',
        }
    });
});
</script>
</body>
</html>
