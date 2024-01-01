<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Add your styles or include external stylesheets here -->
  <!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->
  <!-- <link rel="stylesheet" href="path/to/your/font-awesome/css/all.min.css"> -->
  <style>
    /* Add your styles here */
    .active {
      background-color: #4CAF50; /* Change this to your desired color */
      color: white ; /* !important to override other styles */
    }
  </style>
</head>
<body>

<!-- Navbar (sit on top) -->
<div class="w3-top" style="z-index=0">
  <div class="w3-bar w3-white w3-card" id="myNavbar">
    &nbsp;<a href=""><img src="images/logo.png" height="55"></a>
    <!-- Right-sided navbar links -->
    <div class="w3-right w3-hide-small">
      <a href="a-main.php" class="w3-bar-item1 w3-button">HOME</a>
      <a href="a-application.php" class="w3-bar-item1 w3-button">APPLICATION</a>
      <a href="a-activity.php" class="w3-bar-item1 w3-button">STUDENT ACTIVITIES</a>
      <a href="a-student.php" class="w3-bar-item1 w3-button">STUDENT</a>
      <a href="a-profile.php" class="w3-bar-item1 w3-button">PROFILE</a>
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
  <a href="a-main.php" onclick="w3_close()" class="w3-bar-item w3-button">HOME</a>
  <a href="a-application.php" onclick="w3_close()" class="w3-bar-item w3-button">APPLICATION</a>
  <a href="a-activity.php" onclick="w3_close()" class="w3-bar-item w3-button">STUDENT ACTIVITIES</a>
  <a href="a-student.php" onclick="w3_close()" class="w3-bar-item w3-button">STUDENT</a>
  <a href="a-profile.php" onclick="w3_close()" class="w3-bar-item w3-button">PROFILE</a>
  <a href="logout.php" onclick="w3_close()" class="w3-bar-item w3-button">LOGOUT</a>
</nav>

<!-- Your existing JavaScript and any additional scripts -->
<script>
  // Function to set the current page as active
  function setActivePage() {
    var currentPage = window.location.pathname.split('/').pop();

    // Remove existing 'active' class from all links
    var links = document.querySelectorAll('.w3-bar-item1');
    links.forEach(function(link) {
      link.classList.remove('active');
    });

    // Add 'active' class to the current page link
    var currentLink = document.querySelector('[href="' + currentPage + '"]');
    if (currentLink) {
      currentLink.classList.add('active');
    }
  }

  // Call the function when the page loads
  window.onload = setActivePage;
</script>

</body>
</html>
