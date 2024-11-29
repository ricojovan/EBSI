<?php
require '../etms/authentication.php'; // Ensure this file has access to the database connection

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data)) {
    try {

        $stmt = $obj_admin->db->prepare("INSERT INTO upload_excel (emp_no, emp_name, date_rec, in_one, out_one) 
                VALUES (:emp_no, :emp_name, :date_rec, :in_one, :out_one)");


        foreach ($data as $row) {
            // Convert date_rec from mm/dd/yyyy to yyyy-mm-dd
            $date_parts = explode('/', $row['date']);
            $date_rec = count($date_parts) === 3 ? $date_parts[2] . '-' . $date_parts[0] . '-' . $date_parts[1] : null;

            $stmt->execute([
                ':emp_no' => $row['employee_no'],
                ':emp_name' => $row['name'],
                ':date_rec' => $date_rec,
                ':in_one' => $row['in1'] ?? null,
                ':out_one' => $row['out1'] ?? null,
            ]);            
        }

        echo json_encode(['message' => 'Data inserted successfully']);
    } catch (PDOException $e) {
        echo json_encode(['message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['message' => 'No data to insert']);
}
?> 