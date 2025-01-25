<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: register.php"); // Redirect to login page if not logged in
    exit;
}

require "connection.php";
// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['productId'])) {

    // Check if the required fields are set
    $products =  $_POST['productId'];
    $product_category = $_POST['product_category']; 
    $language = $_POST['languageName'];
    $languageId = $_POST['languageId'];
    $contentName = $_POST['contentName'];
    $contentDescription = $_POST['contentDescription'];
    $contentURL1 = $_POST['contentURL1'];
    $contentURL2 = $_POST['contentURL2'];
    $contentURL3 = $_POST['contentURL3'];
    $contentURL4 = $_POST['contentURL4'];
    $contentURL5 = $_POST['contentURL5'];
    $contentURL6 = $_POST['contentURL6'];
    $contentURL7 = $_POST['contentURL7'];
    $contentURL8 = $_POST['contentURL8'];
    $contentURL9 = $_POST['contentURL9'];
    $contentText = $_POST['contentText'];
    $thumbnail = $_POST['thumbnail'];
    $contentImage1 = $_POST['contentImage1'];
    $contentImage2 = $_POST['contentImage2'];
    $contentImage3 = $_POST['contentImage3'];
    $key_words = $_POST['key_words'];
    $content_date = $_POST['content_date'];


    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO magcontent (
        productId, product_category, language,  content_name,
        content_description, content_url1, content_url2, content_url3,
        content_url4, content_url5, content_url6, content_url7,
        content_url8, content_url9, content_text, thumbnail,
        content_image, content_image1, content_image2,
        key_words, content_date
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Check if prepare() failed
    if ($stmt === false) {
        die('Error preparing statement: ' . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("issssssssssssssssssss",
        $products, $product_category, $language,  $contentName,
        $contentDescription, $contentURL1, $contentURL2, $contentURL3,
        $contentURL4, $contentURL5, $contentURL6, $contentURL7,
        $contentURL8, $contentURL9, $contentText, $thumbnail,
        $contentImage1, $contentImage2, $contentImage3, $key_words, $content_date
    );
    if ($stmt->execute()) {
      echo "<script>
              window.onload = function() {
                  var modal = document.createElement('div');
                  modal.innerHTML = '<div id=\"successModal\" style=\"position: fixed; top: 0; left: 50%; transform: translateX(-50%); width: 80%; max-width: 400px; background-color: black; z-index: 9999; text-align: center; padding: 20px;\">Data Inserted Successfully</div>';
                  document.body.appendChild(modal);
                  setTimeout(function() {
                      var successModal = document.getElementById('successModal');
                      if (successModal) {
                          successModal.parentNode.removeChild(successModal);
                      }
                  }, 3000); // 3000 milliseconds (3 seconds)
              };
            </script>";
    } else {
      echo "<script>alert('Data Not Inserted Successfully');</script>";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} 
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
  <title>Upload Magazine Content</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />
  <link href="css/ruang-admin.min.css" rel="stylesheet">
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

      <li class="nav-item active">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseForm"
        aria-expanded="true" aria-controls="collapseForm">
          <i class="fab fa-fw fa-wpforms"></i>
          
          <span>UPLOAD CONTENT</span>
        </a>
        <div id="collapseForm" class="collapse show" aria-labelledby="headingForm"
          data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
      
            <a class="collapse-item  active" href="form_basics.php">Input Values</a>            
            <!-- <a class="collapse-item" href="form_advanceds.php">Form Advanceds</a> -->
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTable" aria-expanded="true"
          aria-controls="collapseTable">
          <i class="fas fa-fw fa-table"></i>
          <span>VIEW REPORTS</span>
        </a>
        <div id="collapseTable" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
         
            <!-- <a class="collapse-item" href="simple-tables.php">Simple Tables</a> -->
            <a class="collapse-item" href="datatables.php">DataTables</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePage" aria-expanded="true"
          aria-controls="collapsePage">
          <i class="fas fa-fw fa-columns"></i>
          <span>LOGIN</span>
        </a>
        <div id="collapsePage" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">

             <a class="collapse-item" href="register.php">Register</a> 
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
            

            <div class="topbar-divider d-none d-sm-block"></div>
            
          </ul>
        </nav>
        <!-- Topbar -->

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h3 mb-0 text-gray-800">UPLOAD MAGAZINE CONTENT</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item">Forms</li>
              <li class="breadcrumb-item active" aria-current="page">Upload Magazine Content</li>
            </ol>
          </div>

            <div class="col-lg-12">
              <!-- General Element -->
        <div class="card mb-4">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <!-- <h6 class="m-0 font-weight-bold text-primary">Upload Magazine Content</h6> -->
              </div>

              
            <div class="card-body">


                  <form method="post" id="productForm" action="" enctype="multipart/form-data">
                  <div class="form-group">
                  <label for="products">Select Products:</label>
                  <select name="productId" id="productsId" class="form-control">
                      <!-- Options for products will be dynamically added here -->
                  </select>
                  <input type="hidden" id="product_category" name="product_category" required>
                </div>



            <div class="form-group">
            <select id="language" name="language" class="form-control" onchange="captureLanguageName()">
            </select>
              <input type="hidden" id="languageId" name="languageId">
              <input type="hidden" id="languageName" name="languageName" required>
            </div>

            <div class="form-group">
                <label for="contentName">Content Name:</label>
                <input type="text" id="contentName" name="contentName" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="contentDescription">Content Description:</label>
                <textarea id="contentDescription" name="contentDescription" class="form-control" required></textarea>
            </div>

           <!-- Content URLs -->
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="contentURL1">Content URL 1:</label>
            <input type="text" id="contentURL1" name="contentURL1" class="form-control" required>
        </div>
        <div class="form-group col-md-4">
            <label for="contentURL2">Content URL 2:</label>
            <input type="text" id="contentURL2" name="contentURL2" class="form-control">
        </div>
        <div class="form-group col-md-4">
            <label for="contentURL3">Content URL 3:</label>
            <input type="text" id="contentURL3" name="contentURL3" class="form-control">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="contentURL4">Content URL 4:</label>
            <input type="text" id="contentURL4" name="contentURL4" class="form-control">
        </div>
        <div class="form-group col-md-4">
            <label for="contentURL5">Content URL 5:</label>
            <input type="text" id="contentURL5" name="contentURL5" class="form-control">
        </div>
        <div class="form-group col-md-4">
            <label for="contentURL6">Content URL 6:</label>
            <input type="text" id="contentURL6" name="contentURL6" class="form-control">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="contentURL7">Content URL 7:</label>
            <input type="text" id="contentURL7" name="contentURL7" class="form-control">
        </div>
        <div class="form-group col-md-4">
            <label for="contentURL8">Content URL 8:</label>
            <input type="text" id="contentURL8" name="contentURL8" class="form-control">
        </div>
        <div class="form-group col-md-4">
            <label for="contentURL9">Content URL 9:</label>
            <input type="text" id="contentURL9" name="contentURL9" class="form-control">
        </div>
    </div>

            <div class="form-group">
                <label for="contentText">Content Text (maximum 300 characters):</label>
                <textarea id="contentText" name="contentText" class="form-control" required maxlength="300"></textarea>
            </div>

            <!-- Dropdown for selecting language -->


            <div class="form-group">
                <label for="thumbnail">Thumbnail URL:</label>
                <input type="url" id="thumbnail" name="thumbnail" class="form-control" required>
            </div>

            <!-- Content Images -->
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="contentImage1">Content Image 1 URL:</label>
                    <input type="url" id="contentImage1" name="contentImage1" class="form-control" required>
                </div>

                <div class="form-group col-md-4">
                    <label for="contentImage2">Content Image 2 URL:</label>
                    <input type="url" id="contentImage2" name="contentImage2" class="form-control" required>
                </div>
             
                <div class="form-group col-md-4">
                    <label for="contentImage3">Content Image 3 URL:</label>
                    <input type="url" id="contentImage3" name="contentImage3" class="form-control" required>
                </div>

                <div class="form-group  col-md-6">
                      <label for="key_words">Keywords:</label>
                      <input type="text" id="key_words" name="key_words" placeholder="seperate keywords with comma" class="form-control large-width" required>
                </div>

                <div class="form-group  col-md-6 ">
                      <label for="content_date">Content Date:</label>
                      <input type="date" id="content_date" name="content_date" class="form-control" required>
                </div>

                <div class="form-group col-md-6">
                      <input type="submit" value="Submit" class="btn btn-primary">
                </div>

        </form>
         </div>
         </div>
            </div>
          </div>
        </div>
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    fetch('languages.json')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            const languageDropdown = $('#language');
            // Clear existing options
            languageDropdown.empty();
            // Populate the dropdown with fetched languages
            data.forEach(language => {
                const option = $('<option>').val(language.languageId).text(language.language);
                languageDropdown.append(option);
            });

            // Initialize select2 and add change event listener
            languageDropdown.select2().on('change', function() {
                const selectedLanguage = $(this).find('option:selected').text();
                const selectedLanguageId = $(this).val();
                $('#languageName').val(selectedLanguage);
                $('#languageId').val(selectedLanguageId);
            });
        })
        .catch(error => console.error('Error loading languages:', error));
});

document.addEventListener('DOMContentLoaded', function() {
    const productsDropdown = document.getElementById('productsId');
    const productCategoryInput = document.getElementById('product_category');

    fetch('products.json')
        .then(response => response.json())
        .then(data => {
            data.forEach(product => {
                const option = document.createElement('option');
                option.value = product.productId; // Set product ID as the value
                option.text = product.product_name;
                productsDropdown.appendChild(option);
            });
        })
        .catch(error => console.error('Error loading products:', error));

    // Update hidden input with the selected product name
    productsDropdown.addEventListener('change', function() {
        const selectedOption = productsDropdown.options[productsDropdown.selectedIndex];
        productCategoryInput.value = selectedOption.text; // Set the hidden input value to the product name
    });
});
// Truncate content text to maximum of 300 characters
document.getElementById('productForm').addEventListener('submit', function(event) {
    var contentText = document.getElementById('contentText').value;
    if (contentText.length > 300) {
        document.getElementById('contentText').value = contentText.substring(0, 300);
    }
});
</script>
</body>
</html>

