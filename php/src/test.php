<?php

ob_start();

require "functions.php";

// use Document\Parser\Word;



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


// shell tests
// echo "<h1>pdf converter test</h1><br />";
// // 
// echo shell_exec("whoami");
// echo "<br />";
// echo shell_exec("which libreoffice");
// echo "<br />";
// // 


function convertDocxToPdf($inputDocx, $outputPdf)
{
    $inputDocx = escapeshellarg($inputDocx);    // requires real path
    $outputPdf = escapeshellarg($outputPdf);    // ditto
    if (file_exists($outputPdf)){
        unlink($outputPdf);         // it can't overwrite exisiting files
    }
    // /var/www/html/ is from compose.yaml
    $command = "HOME=/tmp libreoffice --headless --convert-to pdf --outdir /var/www/html/uploads $inputDocx 2>&1";
    $output = shell_exec($command);

    // file_put_contents('/var/www/html/uploads/convert_log.txt', $output);    // logging file
    // echo "<pre>$output</pre>";  // visible on the webpage
    // echo "<br />";  // 

    return file_exists($outputPdf) ? $outputPdf : false;
}

$docxFile = "./uploads/output.docx";
$pdfFile = "./uploads/output.pdf";
// $docxFile = realpath("./uploads/output.docx");
// $pdfFile = realpath("./uploads/output.pdf");

convertDocxToPdf($docxFile, $pdfFile);


// if (convertDocxToPdf($docxFile, $pdfFile)) {
//     echo "Conversion successful: $pdfFile";
// } else {
//     echo "Conversion failed.";
// }
