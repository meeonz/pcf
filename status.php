<?php
session_start();
date_default_timezone_set('Asia/Kuala_Lumpur');

include("database.php");
if (!verifyStudent($con)) {
    header("Location: index.php");
    return false;
}

$id_student = $_SESSION["id_student"];
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
    $SQL_update = "
    INSERT INTO `application`(`id_application`, `id_student`, `application_no`, `date`, `purpose`, `fund`, `balance`, `application_date`, `status`, `file_name`) 
    VALUES (NULL, '$id_student', '$application_no', '$date', '$purpose', '$fund', '$balance', '$currentdate','Pending', '')
    ";

    $result = mysqli_query($con, $SQL_update) or die("Error in query: " . $SQL_update . "<br />" . mysqli_error($con));

    $success = "Successfully Update";
}

$SQL_view = " SELECT * FROM `student` WHERE `username` =  '{$_SESSION['username']}' ";
$result = mysqli_query($con, $SQL_view) or die("Error in query: " . $SQL_view . "<br />" . mysqli_error($con));
$data = mysqli_fetch_array($result);
$balance = $data["balance"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
          integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <link href="css/table.css" rel="stylesheet"/>
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet"/>
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />

          crossorigin="anonymous"/>

    <style>
        a {
            text-decoration: none;
        }

        body, h1, h2, h3, h4, h5, h6 {
            font-family: "Raleway", sans-serif
        }

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
</head>
<body class="w3-pale-blue">

<?php include("menu-student.php"); ?>

<div class="bgimg-1">

    <div class="w3-padding-32"></div>

    <div class="w3-center w3-text-blank w3-padding-32">
        <span class="w3-xlarge"><b>APPLICATION LIST</b></span><br>
    </div>

    <div class="w3-container w3-content" style="max-width:1400px;">
        <div class="w3-row w3-white w3-card w3-padding">
            <div class="w3-row w3-margin">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Purpose</th>
                            <th>Date</th>
                            <th>Fund Request (RM)</th>
                            <th>Balance (RM)</th>
                            <th>Approval</th>                            
                            <th>Proof</th> <!-- Add this column for images -->
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $bil = 0;
                        $SQL_list = "SELECT * FROM `application` WHERE `id_student` = $id_student";
                        $result = mysqli_query($con, $SQL_list);
                        while ($data = mysqli_fetch_array($result)) {
                            $bil++;
                            $status = $data["status"];
                            $color = "";
                            if ($status == "Yes") $color = "w3-text-green";
                            if ($status == "No") $color = "w3-text-red";
                        ?>
                            <tr>
                                <td><?php echo $bil; ?></td>
                                <td><?php echo $data["purpose"]; ?></td>
                                <td><?php echo $data["date"]; ?></td>
                                <td><?php echo $data["fund"]; ?></td>
                                <td><?php echo $data["balance"]; ?></td>
                                <td><div class="<?php echo $color; ?>"><b><?php echo $status; ?></b></div></td>
                                <td>
                                    <?php
                                    if (!empty($data["file_name"])) {
                                        $imagePath = "uploads/" . $data["file_name"];
                                        // <td><a href="uploads/<?php echo $data['file_name']; 
                                        // " target="_blank"><img src="path/to/custom.png" alt="Custom Icon" width="20" height="20"></a></td>


                                        echo '<a href="' . $imagePath . '" target="_blank"><p>' . basename($imagePath) . '</p></a>';
                                    } else {
                                        echo 'No Document';
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="w3-padding-24"></div>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>


<script>
    $(document).ready(function () {
        $('#dataTable').DataTable({
            paging: true,
            searching: true
        });
    });
</script>

<script>
    var mySidebar = document.getElementById("mySidebar");

    function w3_open() {
        if (mySidebar.style.display === 'block') {
            mySidebar.style.display = 'none';
        } else {
            mySidebar.style.display = 'block';
        }
    }

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
