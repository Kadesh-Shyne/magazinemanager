<?php 
require "connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['productId'];
    $product_category = $_POST['product_category'];
    $language = $_POST['language'];
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

    // Update the database with the new values
    $stmt = $conn->prepare("UPDATE httnmagzine_httn_magazine.magcontent SET 
        product_category = ?, 
        language = ?, 
        content_name = ?, 
        content_description = ?, 
        content_url1 = ?, 
        content_url2 = ?, 
        content_url3 = ?, 
        content_url4 = ?, 
        content_url5 = ?, 
        content_url6 = ?, 
        content_url7 = ?, 
        content_url8 = ?, 
        content_url9 = ?, 
        content_text = ?, 
        thumbnail = ?, 
        content_image = ?, 
        content_image1 = ?, 
        content_image2 = ?, 
        key_words = ?, 
        content_date = ?
        WHERE productId = ?");

    $stmt->bind_param("ssssssssssssssssssssi", 
        $product_category, 
        $language, 
        $contentName, 
        $contentDescription, 
        $contentURL1, 
        $contentURL2, 
        $contentURL3, 
        $contentURL4, 
        $contentURL5, 
        $contentURL6, 
        $contentURL7, 
        $contentURL8, 
        $contentURL9, 
        $contentText, 
        $thumbnail, 
        $contentImage1, 
        $contentImage2, 
        $contentImage3, 
        $key_words, 
        $content_date,
        $productId);

    if ($stmt->execute()) {
        echo "Record updated successfully.";
        // Optionally, redirect to the DataTable page or another page
        header("Location: datatables.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>
