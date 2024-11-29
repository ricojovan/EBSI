<?php
require 'vendor/autoload.php'; // Adjust the path if necessary

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_FILES['file']['name']) {
    $file = $_FILES['file']['tmp_name'];
    $spreadsheet = IOFactory::load($file);
    $worksheet = $spreadsheet->getActiveSheet();
    $data = [];

    $last_employee_no = null; // Store the last non-empty employee_no
    $last_name = null;        // Store the last non-empty name

    foreach ($worksheet->getRowIterator() as $rowIndex => $row) {
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(false); // Loop through all cells

        $rowData = [];
        foreach ($cellIterator as $cell) {
            $rowData[] = $cell->getValue(); // Fetch cell value
        }

        // Process rows starting from row 7 (adjust based on your file structure)
        if ($rowIndex >= 7) { 
            $employee_no = $rowData[0] ?? null; // Column A
            $name = $rowData[1] ?? null;        // Column B
            $date = $rowData[2] ?? null;        // Column C

            // If "employee_no" or "name" is empty, use the last known value
            if (empty($employee_no)) {
                $employee_no = $last_employee_no;
            } else {
                $last_employee_no = $employee_no; // Update last known value
            }

            if (empty($name)) {
                $name = $last_name;
            } else {
                $last_name = $name; // Update last known value
            }

            // Stop processing if the "date" column is empty
            if (empty($date)) {
                continue;
            }

            // Map IN and OUT columns based on your structure
            $in1 = $rowData[3] ?? null; // First IN
            $out1 = $rowData[4] ?? null; // First OUT
            $in2 = $rowData[5] ?? null; // Second IN
            $out2 = $rowData[6] ?? null; // Second OUT
            $in3 = $rowData[7] ?? null; // Third IN
            $out3 = $rowData[8] ?? null; // Third OUT

            // Determine the earliest IN and latest OUT
            $in_times = array_filter([$in1, $in2, $in3]); // Filter out empty values
            $out_times = array_filter([$out1, $out2, $out3]); // Filter out empty values

            $first_in = !empty($in_times) ? min($in_times) : null; // Earliest IN time
            $last_out = !empty($out_times) ? max($out_times) : null; // Latest OUT time

            $data[] = [
                'employee_no' => $employee_no,
                'name' => $name,
                'date' => $date,
                'in1' => $first_in,
                'out1' => $last_out,
            ];
        }
    }

    // Return JSON data for frontend
    header('Content-Type: application/json');
    echo json_encode($data);
}
?>
