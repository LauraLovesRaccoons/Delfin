<?php

ob_start();

require "functions.php";

use Document\Parser\Word;



include 'header.html';






// testdocx.docx




// Define the template file and output file
$templateFile = './uploads/testdocx.docx'; // Make sure this file exists in the same directory
$outputFile = './uploads/output.docx';

$myName = "SUPER";

// Define the replacements
$replacements = [
    '«Allocation»' => 'Madame',
    '«Nom»' => $myName,
    '«Nom2»' => 'Laura',
    '«Fonction»' => '',
    '«Adresse1»' => 'Place JFK',
    '«Adresse2»' => 'Pétange',
    '«Allocation_Spéciale»' => 'Prinzessin',
    '«ERRORRRORRRRR»' => 'AA<AAAAASHBSJBU989965S',
];

// Create an instance of the Word class
$word = new Word();
$word->findAndReplace($templateFile, $outputFile, $replacements);

echo "Document generated successfully: <a href='$outputFile'>Download Here</a>";


// 
echo "<h1>pdf converter test</h1><br />";
// 
echo shell_exec("whoami");
echo "<br />";
echo shell_exec("which libreoffice");
echo "<br />";
// 


function convertDocxToPdf($inputDocx, $outputPdf)
{
    // Ensure file paths are absolute and writable
    $inputDocx = escapeshellarg($inputDocx);
    $outputPdf = escapeshellarg($outputPdf);

    // // Use LibreOffice to convert DOCX to PDF
    // $command = '"C:\Program Files\LibreOffice\program\soffice.exe" --headless --convert-to pdf ' . $inputDocx . ' --outdir ' . dirname($outputPdf);
    // // $command = "libreoffice --headless --convert-to pdf:writer_pdf_Export $inputDocx --outdir " . dirname($outputPdf) . " 2>&1";
    // // $output = shell_exec($command);
    // // file_put_contents('uploads/convert_log.txt', $output);
    // shell_exec($command);

    // $command = "/usr/bin/libreoffice --headless --convert-to pdf $inputDocx --outdir " . dirname($outputPdf) . " 2>&1";
    // $command = "HOME=/tmp libreoffice --headless --convert-to pdf $inputDocx --outdir " . dirname($outputPdf) . " 2>&1";
    // $command = "HOME=/tmp libreoffice --headless --convert-to pdf $inputDocx --outdir /var/www/html/uploads 2>&1";
    // $output = shell_exec($command);
    // file_put_contents('uploads/convert_log.txt', $output);
    // echo "<pre>$output</pre>"; // Display error output
    if (file_exists($outputPdf)){
        unlink($outputPdf);
    }
    $command = "HOME=/tmp libreoffice --headless --convert-to pdf --outdir /var/www/html/uploads $inputDocx 2>&1";
    $output = shell_exec($command);
    file_put_contents('/var/www/html/uploads/convert_log.txt', $output);
    echo "<pre>$output</pre>"; // Show any errors

    return file_exists($outputPdf) ? $outputPdf : false;
}

// Example usage
// $docxFile = "./uploads/testdocx.docx";
// $pdfFile = "./uploads/output.pdf";
$docxFile = realpath("./uploads/output.docx");
$pdfFile = realpath("./uploads/output.pdf");

if (convertDocxToPdf($docxFile, $pdfFile)) {
    echo "Conversion successful: $pdfFile";
} else {
    echo "Conversion failed.";
}
