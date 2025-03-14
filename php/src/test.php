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

// function here



