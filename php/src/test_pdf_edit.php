<?php
session_start();
require 'vendor/autoload.php'; // Load Composer dependencies

use ddn\sapp\Sapp;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdf'])) {
    $uploadDir = 'uploads/';
    $uploadedFile = $uploadDir . basename($_FILES['pdf']['name']);

    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (move_uploaded_file($_FILES['pdf']['tmp_name'], $uploadedFile)) {
        $_SESSION['uploaded_pdf'] = $uploadedFile;
        header('Location: test_pdf_edit.php');
        exit;
    }
}

// Hardcoded user data
$userData = [
    'Allocation' => 'John Doe',
    'Fonction' => 'MASTER',
];

if (isset($_GET['generate'])) {
    if (!isset($_SESSION['uploaded_pdf'])) {
        die("No file uploaded.");
    }

    $pdfFile = $_SESSION['uploaded_pdf'];
    $sapp = new Sapp();
    $pdfText = $sapp->loadText($pdfFile);

    // Replace placeholders
    foreach ($userData as $key => $value) {
        $pdfText = str_replace("«$key»", $value, $pdfText); // If placeholders use Word-style «Name1»
    }

    $outputFile = 'uploads/modified_' . basename($pdfFile);
    $sapp->saveText($pdfText, $outputFile);

    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="modified.pdf"');
    readfile($outputFile);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload PDF</title>
</head>
<body>
    <h2>Upload a PDF</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="pdf" required>
        <button type="submit">Upload</button>
    </form>

    <?php if (isset($_SESSION['uploaded_pdf'])): ?>
        <h3>Generate Modified PDF</h3>
        <a href="?generate=1"><button>Download Modified PDF</button></a>
    <?php endif; ?>
</body>
</html>
