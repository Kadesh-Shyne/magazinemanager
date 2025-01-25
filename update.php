<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: register.php");
    exit;
}


// Ensure database connection
require "connection.php";

if (isset($_GET['productId'])) {
    $productId = $_GET['productId'];

    // Fetch current data for the given productId
    $stmt = $conn->prepare("SELECT * FROM httnmagzine_httn_magazine.magcontent WHERE productId = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $customer = $result->fetch_assoc();

    if (!$customer) {
        die("Record not found.");
    }
} else {
    die("Invalid request.");
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
<title>Form Basics</title>
<link href="css/ruang-admin.min.css" rel="stylesheet">
<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>

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
                    <a class="collapse-item active" href="form_basics.php">Input Values</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTable"
               aria-expanded="true" aria-controls="collapseTable">
                <i class="fas fa-fw fa-table"></i>
                <span>VIEW REPORTS</span>
            </a>
            <div id="collapseTable" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="datatables.php">DataTables</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePage"
               aria-expanded="true" aria-controls="collapsePage">
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
                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-search fa-fw"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                             aria-labelledby="searchDropdown">
                            <form class="navbar-search">
                                <div class="input-group">
                                    <input type="text" class="form-control bg-light border-1 small"
                                           placeholder="What do you want to look for?"
                                           aria-label="Search" aria-describedby="basic-addon2"
                                           style="border-color: #3f51b5;">
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
                    <h1 class="h3 mb-0 text-gray-800">Form Basics</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="./">Home</a></li>
                        <li class="breadcrumb-item">Forms</li>
                        <li class="breadcrumb-item active" aria-current="page">Form Basics</li>
                    </ol>
                </div>

                <div class="col-lg-12">
                    <!-- General Element -->
                    <div class="card mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Upload Magazine Content</h6>
                        </div>
                        <div class="card-body">
                            <h2>Update Content</h2>
                            <form action="process_update.php" method="post">
                                <div class="form-group">
                                    <label for="productsId">Product Category</label>
                                    <select class="form-control" id="productsId">
                                        <!-- Options will be populated by JavaScript -->
                                    </select>
                                    <input type="hidden" name="product_category" id="product_category" value="<?= htmlspecialchars($customer['product_category']); ?>">
                                    <input type="hidden" name="productId" value="<?= htmlspecialchars($customer['productId']); ?>">
                                </div>



                             
                                <div class="form-group">
                                    <label for="language">Select Language:</label>
                                    <select id="language" name="language" class="form-control">
                                        <!-- Options for languages will be dynamically added here -->
                                    </select>
                                    <input type="hidden" id="languageId" name="languageId" value="<?= htmlspecialchars($customer['languageId']); ?>">
                                    <input type="hidden" id="languageName" name="languageName" value="<?= htmlspecialchars($customer['languageName']); ?>">
                                </div>



                                <div class="form-group">
                                    <label for="contentName">Content Name</label>
                                    <input type="text" class="form-control" id="contentName" name="contentName"
                                           value="<?= htmlspecialchars($customer['content_name']); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="contentDescription">Content Description</label>
                                    <textarea class="form-control" id="contentDescription"
                                              name="contentDescription"><?= htmlspecialchars($customer['content_description']); ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="contentURL1">Content URL 1</label>
                                    <input type="text" class="form-control" id="contentURL1" name="contentURL1"
                                           value="<?= htmlspecialchars($customer['content_url1']); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="contentURL2">Content URL 2</label>
                                    <input type="text" class="form-control" id="contentURL2" name="contentURL2"
                                           value="<?= htmlspecialchars($customer['content_url2']); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="contentURL3">Content URL 3</label>
                                    <input type="text" class="form-control" id="contentURL3" name="contentURL3"
                                           value="<?= htmlspecialchars($customer['content_url3']); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="contentURL4">Content URL 4</label>
                                    <input type="text" class="form-control" id="contentURL4" name="contentURL4"
                                           value="<?= htmlspecialchars($customer['content_url4']); ?>">
                                </div>
                                <div class="form-group">
                                  <label for="contentURL5">Content URL 5</label>
                                  <input type="text" class="form-control" id="contentURL5" name="contentURL5" value="<?= $customer['content_url5']; ?>">
                                </div>
                                <div class="form-group">
                                  <label for="contentURL6">Content URL 6</label>
                                  <input type="text" class="form-control" id="contentURL6" name="contentURL6" value="<?= $customer['content_url6']; ?>">
                                </div>
                                <div class="form-group">
                                  <label for="contentURL7">Content URL 7</label>
                                  <input type="text" class="form-control" id="contentURL7" name="contentURL7" value="<?= $customer['content_url7']; ?>">
                                </div>
                                <div class="form-group">
                                  <label for="contentURL8">Content URL 8</label>
                                  <input type="text" class="form-control" id="contentURL8" name="contentURL8" value="<?= $customer['content_url8']; ?>">
                                </div>
                                <div class="form-group">
                                  <label for="contentURL9">Content URL 9</label>
                                  <input type="text" class="form-control" id="contentURL9" name="contentURL9" value="<?= $customer['content_url9']; ?>">
                                </div>
                                <div class="form-group">
                                  <label for="contentText">Content Text</label>
                                  <textarea class="form-control" id="contentText" name="contentText"><?= $customer['content_text']; ?></textarea>
                                </div>
                                <div class="form-group">
                                  <label for="thumbnail">Thumbnail</label>
                                  <input type="text" class="form-control" id="thumbnail" name="thumbnail" value="<?= $customer['thumbnail']; ?>">
                                </div>
                                <div class="form-group">
                                  <label for="contentImage1">Content Image 1</label>
                                  <input type="text" class="form-control" id="contentImage1" name="contentImage1" value="<?= $customer['content_image']; ?>">
                                </div>
                                <div class="form-group">
                                  <label for="contentImage2">Content Image 2</label>
                                  <input type="text" class="form-control" id="contentImage2" name="contentImage2" value="<?= $customer['content_image1']; ?>">
                                </div>
                                <div class="form-group">
                                  <label for="contentImage3">Content Image 3</label>
                                  <input type="text" class="form-control" id="contentImage3" name="contentImage3" value="<?= $customer['content_image2']; ?>">
                                </div>
                                <div class="form-group">
                                  <label for="key_words">Key Words</label>
                                  <input type="text" class="form-control" id="key_words" name="key_words" value="<?= $customer['key_words']; ?>">
                                </div>
                                <div class="form-group">
                                  <label for="content_date">Content Date</label>
                                  <input type="date" class="form-control" id="content_date" name="content_date" value="<?= $customer['content_date']; ?>">
                                </div>
                                <!-- <div class="form-group col-md-12">
                                  <label for="datetime">Timestamp:</label>
                                  <input type="datetime-local" id="datetime" name="datetime" class="form-control" required>
                                </div> -->
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container Fluid-->
        </div>
        <!---Container Fluid-->
    </div>
</div>

<!-- Scroll to top -->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>
 <!-- CKEditor Script -->
 <script src="https://cdn.ckeditor.com/ckeditor5/37.0.0/classic/ckeditor.js"></script>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="js/ruang-admin.min.js"></script>
<script src="vendor/select2/dist/js/select2.min.js"></script>
<script src="vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script>
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

                // Set the dropdown to the current product category
                const currentProductCategory = productCategoryInput.value;
                for (let i = 0; i < productsDropdown.options.length; i++) {
                    if (productsDropdown.options[i].text === currentProductCategory) {
                        productsDropdown.selectedIndex = i;
                        break;
                    }
                }
            })
            .catch(error => console.error('Error loading products:', error));

        // Update hidden input with the selected product name
        productsDropdown.addEventListener('change', function() {
            const selectedOption = productsDropdown.options[productsDropdown.selectedIndex];
            productCategoryInput.value = selectedOption.text; // Set the hidden input value to the product name
        });

        // Initialize CKEditor
        ClassicEditor
            .create(document.querySelector('#contentText'))
            .catch(error => {
                console.error(error);
            });
    });



   




  document.addEventListener("DOMContentLoaded", function() {
        var preselectedLanguage = "<?= htmlspecialchars($customer['language']); ?>";
        var languageDropdown = document.getElementById("language");
        
        fetch('languages.json')
            .then(response => response.json())
            .then(languages => {
                languages.forEach(language => {
                    var option = document.createElement("option");
                    option.text = language.language; // Displaying the language name
                    option.value = language.language; // Using language name as the value
                    languageDropdown.add(option);
                });

                // Loop through options and select the preselected language
                for (var i = 0; i < languageDropdown.options.length; i++) {
                    if (languageDropdown.options[i].value === preselectedLanguage) {
                        languageDropdown.selectedIndex = i;
                        break;
                    }
                }
            })
            .catch(error => console.error('Error fetching languages:', error));
    });
</script>



</body>
</html>
With these corrections, your language dropdown should exhibit behavior similar to the product dropdown. Make sure to adjust the paths and IDs as necessary based on your file structure and requirements.












</body>
</html>
