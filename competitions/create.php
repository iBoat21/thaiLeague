<?php
  include "../config/connect.php";
  include "../function/myFunction.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Admin Dashboard</title>

  <!-- Open Sans Font -->
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@100;200;300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">

  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
  <div class="grid-container">

    <!-- Header -->
    <header class="header">
      <div class="menu-icon" onclick="openSidebar()">
        <span class="material-icons-outlined">menu</span>
      </div>
      <div class="header-left">
        <span class="material-icons-outlined">search</span>
      </div>
      <div class="header-right">
        <span class="material-icons-outlined">notifications</span>
        <span class="material-icons-outlined">email</span>
        <span class="material-icons-outlined">account_circle</span>
      </div>
    </header>
    <!-- End Header -->

    <!-- Sidebar -->
    <aside id="sidebar">
      <div class="sidebar-title">
        <div class="sidebar-brand">
          <span class="material-icons-outlined">mood</span> LOGO
        </div>
        <span class="material-icons-outlined" onclick="closeSidebar()">close</span>
      </div>

      <ul class="sidebar-list">
        <li class="sidebar-list-item">
          <a href="#">
            <span class="material-icons-outlined">leaderboard</span> Competition
          </a>
        </li>
        <li class="sidebar-list-item">
          <a href="#">
            <span class="material-icons-outlined">dashboard</span> Add Competition
          </a>
        </li>
        <li class="sidebar-list-item">
          <a href="#">
            <span class="material-icons-outlined">dashboard</span> Add Team
          </a>
        </li>
      </ul>
    </aside>
    <!-- End Sidebar -->

    <!-- Main -->
    <main class="main-container">
      <div class="main-title">
        <h2>DASHBOARD</h2>
      </div>
      <!-- SECTION INSERT -->
      <div class="main-cards">
        <i action="../function/action.php" method="post" enctype="multipart/form-data">
          <label for="name">Competition Name: </label>
          <input type="text" name="name" id="name" required>
          <label for="name">Max Teams: </label>
          <input type="number" name="team" id="team" required>
          <label for="name">Select Competition Banner: </label>
          <input type="file" name="banner" id="banner" required>
          <br>
          <label for="provinces">Provinces: </label>
          
        </form>
      </div>
      <!-- SECTION INSERT -->

    </main>


    <!-- End Main -->



  </div>

  <!-- Scripts -->
  <!-- Custom JS -->
  <script src="js/scripts.js"></script>
</body>

</html>