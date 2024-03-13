<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $uploadedFile = $_FILES['file'];
        $uploadDirectory = 'uploads/';
        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true);
        }
        $filePath = $uploadDirectory . $uploadedFile['name'];
        move_uploaded_file($uploadedFile['tmp_name'], $filePath);
        displayExcelData($filePath);
    } else {
        echo 'Error uploading file.';
    }
}
function displayExcelData($filePath){
    $spreadsheet = IOFactory::load($filePath);
    $sheet = $spreadsheet->getActiveSheet();
    $highestRow = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();
    $data = $sheet->rangeToArray('A31:' . $highestColumn . $highestRow, null, true, true, true);
    // echo '<pre>'; print_r($data); exit;
    $excelData =[$data];
    // $excelData =[];
    // foreach($data as $row) {
    //     $rowData = [];
    //     foreach ($row as $cell) {
    //         $rowData[] = $cell;
    //     }
    //     $excelData[] = $rowData;
    // }
    echo json_encode($excelData); 
}
?>
