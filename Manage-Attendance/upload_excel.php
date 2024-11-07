<?php
require 'vendor/autoload.php'; // Adjust the path if necessary

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_FILES['file']['name']) {
    $file = $_FILES['file']['tmp_name'];
    $spreadsheet = IOFactory::load($file);
    $worksheet = $spreadsheet->getActiveSheet();
    $data = [];

    foreach ($worksheet->getRowIterator() as $rowIndex => $row) {
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(false); // Loop through all cells

        $rowData = [];
        foreach ($cellIterator as $cell) {
            $rowData[] = $cell->getValue(); // Fetch cell value
        }

        // Skip header row if present, otherwise store the row data
        if ($rowIndex > 1) { // Assuming first row is header, adjust if needed
            $data[] = [
                'employee_no' => $rowData[0],
                'name' => $rowData[1],
                'date' => $rowData[2],
                'in1' => $rowData[3],
                'out1' => $rowData[4],
                'in2' => $rowData[5],
                'out2' => $rowData[6],
                'in3' => $rowData[7],
                'out3' => $rowData[8],
            ];
        }
    }

    header('Content-Type: application/json');
    echo json_encode($data);
}
?>
