<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    /* Add your styles here */

    /* Example style for the active link */
    .active {
      background-color: #4CAF50; /* Green color, you can change this */
      color: white;
    }
  </style>
</head>
<body>

<!-- Navbar (sit on top) -->
<div class="w3-top" style="z-index=0">
  <div class="w3-bar w3-white w3-card" id="myNavbar">
    &nbsp;<a href="main.php"><img src="images/logo.png" height="55"></a>
    <!-- Right-sided navbar links -->
    <div class="w3-right w3-hide-small">
      <!-- Use PHP to add a class to the active page -->
      <a href="main.php" class="w3-bar-item1 w3-button <?php echo isActive('main.php'); ?>">HOME</a>
      <a href="application.php" class="w3-bar-item1 w3-button <?php echo isActive('application.php'); ?>"> APPLICATION</a>
      <a href="status.php" class="w3-bar-item1 w3-button <?php echo isActive('status.php'); ?>"> APPLICATION STATUS</a>
      <a href="activity.php" class="w3-bar-item1 w3-button <?php echo isActive('activity.php'); ?>"> ACTIVITIES</a>
      <a href="finance.php" class="w3-bar-item1 w3-button <?php echo isActive('finance.php'); ?>"> FINANCE</a>
      <a href="profile.php" class="w3-bar-item1 w3-button <?php echo isActive('profile.php'); ?>"> PROFILE</a>
      <a href="logout.php" class="w3-bar-item1 w3-button"><i class="fa fa-fw fa-sign-out-alt"></i> LOGOUT</a>
    </div>
    <!-- Hide right-floated links on small screens and replace them with a menu icon -->
    <a href="javascript:void(0)" class="w3-bar-item w3-button w3-right w3-hide-large w3-hide-medium" onclick="w3_open()">
      <i class="fa fa-bars"></i>
    </a>
  </div>
</div>

<!-- Sidebar on small screens when clicking the menu icon -->
<nav class="w3-sidebar w3-bar-block w3-indigo w3-card w3-animate-left w3-hide-medium w3-hide-large" style="display:none" id="mySidebar">
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-bar-item w3-button w3-large w3-padding-16">Close ×</a>

  <a href="main.php" onclick="w3_close()" class="w3-bar-item w3-button <?php echo isActive('main.php'); ?>">HOME</a>
  <a href="application.php" onclick="w3_close()" class="w3-bar-item w3-button <?php echo isActive('application.php'); ?>">APPLICATION</a>
  <a href="status.php" onclick="w3_close()" class="w3-bar-item w3-button <?php echo isActive('status.php'); ?>">STATUS</a>
  <a href="activity.php" onclick="w3_close()" class="w3-bar-item w3-button <?php echo isActive('activity.php'); ?>">ACTIVITIES</a>
  <a href="finance.php" onclick="w3_close()" class="w3-bar-item w3-button <?php echo isActive('finance.php'); ?>">FINANCE</a>
  <a href="profile.php" onclick="w3_close()" class="w3-bar-item w3-button <?php echo isActive('profile.php'); ?>">PROFILE</a>
  <a href="logout.php" onclick="w3_close()" class="w3-bar-item w3-button">LOGOUT</a>
</nav>

<?php
// Function to check if the current page matches the given page and return 'active' if true
function isActive($page)
{
    $currentFile = $_SERVER["PHP_SELF"];
    $currentPage = basename($currentFile);

    if ($currentPage == $page) {
        return 'active';
    } else {
        return '';
    }
}
?>

<!-- Your content goes here -->


</body>
</html>
