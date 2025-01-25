<?php 
session_start();
// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: register.php"); // Redirect to login page if not logged in
    exit;
}

require "connection.php";

$limit = isset($_POST["limit-records"]) ? $_POST["limit-records"] : 5000;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Fetch records with error checking
$result = $conn->query("SELECT * FROM httnmagzine_httn_magazine.magcontent LIMIT $start, $limit");
if (!$result) {
    die("Query failed: " . $conn->error);
}
$customers = $result->fetch_all(MYSQLI_ASSOC);

// Fetch count with error checking
$result1 = $conn->query("SELECT count(productId) AS id FROM httnmagzine_httn_magazine.magcontent");
if (!$result1) {
    die("Query failed: " . $conn->error);
}
$custCount = $result1->fetch_all(MYSQLI_ASSOC);
if (isset($custCount[0])) {
    $total = $custCount[0]['id'];
} else {
    $total = 0;
}
$pages = ceil($total / $limit);

$Previous = $page - 1;
$Next = $page + 1;
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="img/logo/logo2.png" rel="icon">
  <title>DataTables</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="form_basics.php">
        <div class="sidebar-brand-icon">
          <img src="img/logo/logo2.png">
        </div>
        <div class="sidebar-brand-text mx-3"></div>
      </a>
      <hr class="sidebar-divider my-0">
   
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Features
      </div>
   
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseForm" aria-expanded="true"
          aria-controls="collapseForm">
          <i class="fab fa-fw fa-wpforms"></i>
          <span> UPLOAD CONTENT</span>
        </a>
        <div id="collapseForm" class="collapse" aria-labelledby="headingForm" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
 
            <a class="collapse-item" href="form_basics.php">Input Values</a>
            <!-- <a class="collapse-item" href="form_advanceds.php">Form Advanceds</a> -->
          </div>
        </div>
      </li>
      <li class="nav-item active">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTable" aria-expanded="true"
          aria-controls="collapseTable">
          <i class="fas fa-fw fa-table"></i>
          <span>VIEW REPORTS</span>
        </a>
        <div id="collapseTable" class="collapse show" aria-labelledby="headingTable" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
         
            <!-- <a class="collapse-item" href="simple-tables.php">Simple Tables</a> -->
            <a class="collapse-item active" href="datatables.php">DataTables</a>
          </div>
        </div>
      </li>
    
      <hr class="sidebar-divider">
     
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePage" aria-expanded="true"
          aria-controls="collapsePage">
          <i class="fas fa-fw fa-columns"></i>
          <span>LOGIN</span>
        </a>
        <div id="collapsePage" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
      
          <a class="collapse-item" href="register.php">Register/LogIn</a>
            <a class="collapse-item" href="logout.php">Logout</a>
           
          </div>
        </div>
      </li>
      
      <hr class="sidebar-divider">
      <div class="version" id="version-ruangadmin"></div>
    </ul>
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
          <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-1 small" placeholder="What do you want to look for?"
                      aria-label="Search" aria-describedby="basic-addon2" style="border-color: #3f51b5;">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>
         
              
              
            </li>
            
            <!-- <div class="topbar-divider d-none d-sm-block"></div> -->
            
              <!-- <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <img class="img-profile rounded-circle" src=  img/boy.png" style="max-width: 60px">
                <span class="ml-2 d-none d-lg-inline text-white small">    </span>
              </a> -->
              <!-- <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div> -->
            </li> 
          </ul>
        </nav>
        <!-- Topbar -->
        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">VIEW UPLOADED CONTENT</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item">Tables</li>
              <li class="breadcrumb-item active" aria-current="page">DataTables</li>
            </ol>
          </div>

          <!-- Row -->
          <div class="row">
            <!-- Datatables -->
            <!-- <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">DataTables</h6>
                </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush" id="dataTable">
                    <thead class="thead-light">
                      <tr>
                        <th>S/N</th>
                        <th>S/N PRODUCT</th>
                        <th>S/N LANGUAGE</th>
                        <th>CONTENT NAME</th>
                        <th>CONTENT DESCRIPTION</th>
                        <th>CONTENT URL 1</th>
                        <th>CONTENT URL 2</th>
                        <th>CONTENT URL 3</th>
                        <th>CONTENT URL 4</th>
                        <th>CONTENT URL 5</th>
                        <th>CONTENT URL 6</th>
                        <th>CONTENT URL 7</th>
                        <th>CONTENT URL 8</th>
                        <th>CONTENT URL 9</th>
                        <th>CONTENT TEXT</th>
                        <th>LANGUAGE</th>
                        <th>THUMBNAIL</th>
                        <th>CONENT IMAGE 1</th>
                        <th>CONTENT IMAGE 2</th>
                        <th>CONTENT IMAGE 3</th>
                        <th>KEYWORDS</th>
                        <th>CONTENT DATE</th>
                      </tr>
                    </thead>
                    
                    <tbody>
                    <?php foreach ($customers as $customer) : ?>
                        <tr>
                          <td><?= $customer['productId']; ?></td>
                            <td><?= $customer['product_category']; ?></td>
                            <td><?= $customer['language']; ?></td>
                            <td><?= $customer['content_name']; ?></td>
                            <td><?= $customer['content_description']; ?></td>
                            <td><?= $customer['content_url1']; ?></td>
                            <td><?= $customer['content_url2']; ?></td>
                            <td><?= $customer['content_url3']; ?></td>
                            <td><?= $customer['content_url4']; ?></td>
                            <td><?= $customer['content_url5']; ?></td>
                            <td><?= $customer['content_url6']; ?></td>
                            <td><?= $customer['content_url7']; ?></td>
                            <td><?= $customer['content_url8']; ?></td>
                            <td><?= $customer['content_url9']; ?></td>
                            <td><?= $customer['content_text']; ?></td>
                            <td><?= $customer['thumbnail']; ?></td>
                            <td><?= $customer['content_image']; ?></td>
                            <td><?= $customer['content_image1']; ?></td>
                            <td><?= $customer['content_image2']; ?></td>
                            <td><?= $customer['key_words']; ?></td>
                            <td><?= $customer['content_date']; ?></td>
                           <td><?= $customer['timestamp']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div> -->





            <!-- DataTable with Hover -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <!-- <h6 class="m-0 font-weight-bold text-primary">View Uploaded Content</h6> -->
                </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                  <thead class="thead-light">
                      <tr>
                        <th>Update</th> <!-- New column for Update button -->
                        <th>S/N</th>
                        <th>PRODUCT CATEGORY</th>
                        <th>LANGUAGE</th>
                        <th>CONTENT NAME</th>
                        <th>CONTENT DESCRIPTION</th>
                        <th>CONTENT URL 1</th>
                        <th>CONTENT URL 2</th>
                        <th>CONTENT URL 3</th>
                        <th>CONTENT URL 4</th>
                        <th>CONTENT URL 5</th>
                        <th>CONTENT URL 6</th>
                        <th>CONTENT URL 7</th>
                        <th>CONTENT URL 8</th>
                        <th>CONTENT URL 9</th>
                        <th>CONTENT TEXT</th>
                        <th>THUMBNAIL</th>
                        <th>CONENT IMAGE 1</th>
                        <th>CONTENT IMAGE 2</th>
                        <th>CONTENT IMAGE 3</th>
                        <th>KEYWORDS</th>
                        <th>CONTENT DATE</th>
                        <th>TIMESTAMP</th>
                      </tr>
                    </thead>

                  
<tbody>
  <?php foreach ($customers as $customer) : ?>
    <tr>
      <td>
      <form action="update.php" method="get">
          <input type="hidden" name="productId" value="<?= $customer['productId']; ?>">
          <button type="submit" class="btn btn-primary">Update</button>
        </form>
      </td>
      <td><?= $customer['productId']; ?></td>
      <td><?= $customer['product_category']; ?></td>
      <td><?= $customer['language']; ?></td>
      <td><?= $customer['content_name']; ?></td>
      <td><?= $customer['content_description']; ?></td>
      <td><?= $customer['content_url1']; ?></td>
      <td><?= $customer['content_url2']; ?></td>
      <td><?= $customer['content_url3']; ?></td>
      <td><?= $customer['content_url4']; ?></td>
      <td><?= $customer['content_url5']; ?></td>
      <td><?= $customer['content_url6']; ?></td>
      <td><?= $customer['content_url7']; ?></td>
      <td><?= $customer['content_url8']; ?></td>
      <td><?= $customer['content_url9']; ?></td>
      <td><?= $customer['content_text']; ?></td>
      <td><?= $customer['thumbnail']; ?></td>
      <td><?= $customer['content_image']; ?></td>
      <td><?= $customer['content_image1']; ?></td>
      <td><?= $customer['content_image2']; ?></td>
      <td><?= $customer['key_words']; ?></td>
      <td><?= $customer['content_date']; ?></td>
      <td><?= $customer['timestamp']; ?></td>
    </tr>
  <?php endforeach; ?>
</tbody>

                  </table>
                </div>
              </div>
            </div>
          </div>
          <!--Row-->

          

          <!-- Modal Logout -->
          <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>Are you sure you want to logout?</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                  <a href="login.php" class="btn btn-primary">Logout</a>
                </div>
              </div>
            </div>
          </div>

        </div>
        <!---Container Fluid-->
      </div>

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; <script> document.write(new Date().getFullYear()); </script> - Developed by
            <b><a href="https://enterthehealingschool.org" target="_blank">Healing School</a></b>
            </span>
          </div>
        </div>
      </footer>
      <!-- Footer -->
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script>
    $(document).ready(function () {
      $('#dataTable').DataTable(); // ID From dataTable 
      $('#dataTableHover').DataTable(); // ID From dataTable with Hover
    });
  </script>

</body>

</html>