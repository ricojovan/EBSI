<?php
require '../etms/authentication.php'; // Ensure this file has access to the database connection

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data)) {
    try {
        $stmt = $obj_admin->db->prepare("INSERT INTO upload_record (emp_no, emp_name, date_rec, in_one, out_one, in_two, out_two, in_three, out_three) 
            VALUES (:emp_no, :emp_name, :date_rec, :in_one, :out_one, :in_two, :out_two, :in_three, :out_three)");

        foreach ($data as $row) {
            // Convert date_rec from mm/dd/yyyy to yyyy-mm-dd
            $date_parts = explode('/', $row['date_rec']);
            if (count($date_parts) === 3) {
                $date_rec = $date_parts[2] . '-' . $date_parts[0] . '-' . $date_parts[1];
            } else {
                $date_rec = null; // Handle invalid date format
            }

            $stmt->execute([
                ':emp_no' => $row['emp_no'],
                ':emp_name' => $row['emp_name'],
                ':date_rec' => $date_rec,
                ':in_one' => empty($row['in_one']) ? null : $row['in_one'],
                ':out_one' => empty($row['out_one']) ? null : $row['out_one'],
                ':in_two' => empty($row['in_two']) ? null : $row['in_two'],
                ':out_two' => empty($row['out_two']) ? null : $row['out_two'],
                ':in_three' => empty($row['in_three']) ? null : $row['in_three'],
                ':out_three' => empty($row['out_three']) ? null : $row['out_three']
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