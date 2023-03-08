<?php
// Define your API key
$apiKey = 'MnglassAPPad2f2s2glassAP';
$allowed_types = array('jpg', 'jpeg', 'png', 'gif', 'pdf');


// Check if the API key is valid
if (!isset($_SERVER['HTTP_X_API_KEY']) || $_SERVER['HTTP_X_API_KEY'] !== $apiKey) {
    header('HTTP/1.1 401 Unauthorized');
    exit('Unauthorized');
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 405 Method Not Allowed');
    exit('Method Not Allowed');
}

// Check if image data was provided
if (!isset($_FILES['image'])) {
    header('HTTP/1.1 400 Bad Request');
    exit('Image data not provided');
}

// Check if the uploaded file is an image.
if (!isset($_FILES['image']) || !in_array(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION), $allowed_types)) {
    header('HTTP/1.1 400 Bad Request');
    exit('Invalid file type. Only JPG, PNG, GIF, and PDF files are allowed.');
}

// Get the image file and upload it to a folder
$imageFile = $_FILES['image']['tmp_name'];
$uploadDir = dirname(__FILE__) . '/images/';
$uploadPath = $uploadDir . time() . basename($_FILES['image']['name']);

if (!move_uploaded_file($imageFile, $uploadPath)) {
    header('HTTP/1.1 500 Internal Server Error');
    exit('Failed to upload image');
}

// Return a success message
header('HTTP/1.1 200 OK');
echo 'Image uploaded successfully';