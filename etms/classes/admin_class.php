<?php

class Admin_Class
{
	public $db; // Declare the property

	/* -------------------------set_database_connection_using_PDO---------------------- */

	public function __construct()
	{
		$host_name = 'localhost';
		$user_name = 'root';
		$password = '';
		$db_name = 'ebsi_db';

		try {
			$connection = new PDO("mysql:host={$host_name}; dbname={$db_name}", $user_name,  $password);
			$this->db = $connection; // connection established
		} catch (PDOException $message) {
			echo $message->getMessage();
		}
	}

	/* ---------------------- test_form_input_data ----------------------------------- */

	public function test_form_input_data($data)
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}


	/*----------------------- Fetch Leave Data ------------------------------------------ */
	public function fetch_leave_data()
	{
		try {
			$stmt = $this->db->prepare("SELECT * FROM tbl_leave");
			$stmt->execute();
			$leaveData = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if ($stmt->rowCount() > 0) {
				return $leaveData;
			} else {
				return 1;
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
			return [];
		}
	}

	/* ---------------------- Admin Login Check ----------------------------------- */

	public function admin_login_check($data)
	{

		$upass = $this->test_form_input_data(md5($data['admin_password']));
		$username = $this->test_form_input_data($data['username']);
		try {
			$stmt = $this->db->prepare("SELECT * FROM tbl_admin WHERE username=:uname AND password=:upass LIMIT 1");
			$stmt->execute(array(':uname' => $username, ':upass' => $upass));
			$userRow = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($stmt->rowCount() > 0) {
				session_start();
				$_SESSION['admin_id'] = $userRow['user_id'];
				$_SESSION['name'] = $userRow['fullname'];
				$_SESSION['security_key'] = 'rewsgf@%^&*nmghjjkh';
				$_SESSION['user_role'] = $userRow['user_role'];
				$_SESSION['temp_password'] = $userRow['temp_password'];
				$_SESSION['empDepartment'] = $userRow['em_department'];
				$_SESSION['empPosition'] = $userRow['em_position'];
				$_SESSION['empStatus'] = $userRow['em_status'];

				if ($userRow['temp_password'] == null) {
					header('Location: ../Interface/dashboard.php');
				} else {
					header('Location: ../Manage-Employee/change-password.php');
				}
			} else {
				$message = 'Invalid user name or Password';
				return $message;
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function change_password_for_employee($data)
	{
		$password  = $this->test_form_input_data($data['password']);
		$re_password = $this->test_form_input_data($data['re_password']);

		$user_id = $this->test_form_input_data($data['user_id']);
		$final_password = md5($password);
		$temp_password = '';

		if ($password == $re_password) {
			try {
				$update_user = $this->db->prepare("UPDATE tbl_admin SET password = :x, temp_password = :y WHERE user_id = :id ");

				$update_user->bindparam(':x', $final_password);
				$update_user->bindparam(':y', $temp_password);
				$update_user->bindparam(':id', $user_id);
				$update_user->execute();



				$stmt = $this->db->prepare("SELECT * FROM tbl_admin WHERE user_id=:id LIMIT 1");
				$stmt->execute(array(':id' => $user_id));
				$userRow = $stmt->fetch(PDO::FETCH_ASSOC);

				if ($stmt->rowCount() > 0) {
					session_start();
					$_SESSION['admin_id'] = $userRow['user_id'];
					$_SESSION['name'] = $userRow['fullname'];
					$_SESSION['security_key'] = 'rewsgf@%^&*nmghjjkh';
					$_SESSION['user_role'] = $userRow['user_role'];
					$_SESSION['temp_password'] = $userRow['temp_password'];
					header('Location: ../Manage-Attendance/attendance.php');
				}
			} catch (PDOException $e) {
				echo $e->getMessage();
			}
		} else {
			$message = 'Sorry !! Password Can not match';
			return $message;
		}
	}


	/* -------------------- Admin Logout ----------------------------------- */

	public function admin_logout()
	{

		session_start();
		unset($_SESSION['admin_id']);
		unset($_SESSION['admin_name']);
		unset($_SESSION['security_key']);
		unset($_SESSION['user_role']);
		header('Location: ../Interface/login.php');
	}

	/*----------- add_new_user--------------*/

	public function add_new_user($data)
	{

		// Retrieve Employee ID
		$user_id = $this->test_form_input_data($data['em_id']);

		// Combine the first, middle, and last names into a single fullname
		$user_fullname = $this->test_form_input_data(trim($data['em_firstname'] . ' ' . $data['em_middlename'] . ' ' . $data['em_lastname']));
		// Additional form data
		$user_username = $this->test_form_input_data($data['em_username']);
		$user_email = $this->test_form_input_data($data['em_email']);
		$department = $this->test_form_input_data($data['em_department']);
		$position = $this->test_form_input_data($data['em_position']);
		$status = $this->test_form_input_data($data['em_status']);
		$role = ($data['em_role'] == 'employee') ? 2 : 3; // Set user role based on selection
		$temp_password = rand(100000, 999999); // Generate a temporary password
		$user_password = md5($temp_password); // Hash the password

		// Handle file upload if provided
		$profile_pic = $_FILES['em_profile_pic']['name'];
		$target_dir = "../assets/images/author/"; // 
		$target_file = $target_dir . basename($profile_pic);


		if (!is_dir($target_dir)) {
			mkdir($target_dir, 0777, true);
		}

		if ($profile_pic && !move_uploaded_file($_FILES['em_profile_pic']['tmp_name'], $target_file)) {
			return "Failed to upload profile picture.";
		}

		try {
			// Check if email or username already exists
			$sqlEmail = "SELECT email FROM tbl_admin WHERE email = :email";
			$query_result_for_email = $this->db->prepare($sqlEmail);
			$query_result_for_email->execute([':email' => $user_email]);

			$sqlUsername = "SELECT username FROM tbl_admin WHERE username = :username";
			$query_result_for_username = $this->db->prepare($sqlUsername);
			$query_result_for_username->execute([':username' => $user_username]);

			if ($query_result_for_email->rowCount() > 0) {
				return "Email is already taken";
			} elseif ($query_result_for_username->rowCount() > 0) {
				return "Username is already taken";
			} else {
				// Prepare SQL query to insert user data
				$add_user = $this->db->prepare("INSERT INTO tbl_admin (user_id, fullname, username, email, password, temp_password, em_department, em_position, em_status, em_profile, user_role) 
					VALUES (:em_id, :fullname, :username, :email, :password, :temp_password, :department, :position, :status, :profile, :role)");

				// Bind parameters
				$add_user->bindParam(':em_id', $user_id);
				$add_user->bindParam(':fullname', $user_fullname);
				$add_user->bindParam(':username', $user_username);
				$add_user->bindParam(':email', $user_email);
				$add_user->bindParam(':password', $user_password);
				$add_user->bindParam(':temp_password', $temp_password);
				$add_user->bindParam(':department', $department);
				$add_user->bindParam(':position', $position);
				$add_user->bindParam(':status', $status);
				$add_user->bindParam(':profile', $target_file);
				$add_user->bindParam(':role', $role);

				// Execute the query
				$add_user->execute();
			}
		} catch (PDOException $e) {
			return "Error: " . $e->getMessage();
		}
	}

	/* ---------add_leave_data----------*/

	public function add_leave_data($data)
	{
		$emp_id = is_numeric($data['emp_id']) ? intval($data['emp_id']) : 0;
		$emp_name = $this->test_form_input_data($data['emp_name']);
		$emp_dept = $this->test_form_input_data($data['emp_dept']);
		$emp_w_pay = ($data['pay'] == 'With Pay') ? 1 : 0;
		$emp_status = $this->test_form_input_data($data['emp_status']);
		$emp_pos = $this->test_form_input_data($data['emp_pos']);
		$emp_lType = $this->test_form_input_data($data['emp_leaveType']);
		$emp_filed = $this->test_form_input_data($data['emp_DateFiled']);
		$emp_FromDate = $this->test_form_input_data($data['emp_DateFrom']);
		$emp_ToDate = $this->test_form_input_data($data['emp_DateTo']);
		$emp_Absences = is_numeric($data['emp_Abs']) ? intval($data['emp_Abs']) : 0;
		$emp_Reason = $this->test_form_input_data($data['emp_Reason']);

		try {
			$sqlemp_Id = "SELECT user_id FROM tbl_admin WHERE user_id = :emp_id";
			$query_result_for_emp_id = $this->db->prepare($sqlemp_Id);
			$query_result_for_emp_id->execute([':emp_id' => $emp_id]);

			if ($query_result_for_emp_id->rowCount() == 0) {
				return "The employee ID does not exist in the admin table.";
			}

			$sqlemp_Id_in_leave = "SELECT user_id FROM tbl_leave WHERE user_id = :emp_id AND status = 'Pending'";
			$query_result_for_leave = $this->db->prepare($sqlemp_Id_in_leave);
			$query_result_for_leave->execute([':emp_id' => $emp_id]);

			if ($query_result_for_leave->rowCount() > 0) {
				return "You have a pending request. Please resolve it before submitting another one.";
			} else {
				$add_leave = $this->db->prepare("
                INSERT INTO tbl_leave (
                    user_id, fullname, position, department, status, leave_type, w_pay, from_date, to_date, filed_date, days, reason
                ) VALUES (
                    :emp_id, :emp_name, :emp_pos, :emp_dept, :emp_status, :leave_type, :w_pay, :from_date, :to_date, :filed_date, :days, :reason
                )
            ");

				// Bind parameters for the query
				$add_leave->bindParam(':emp_id', $emp_id);
				$add_leave->bindParam(':emp_name', $emp_name);
				$add_leave->bindParam(':emp_pos', $emp_pos);
				$add_leave->bindParam(':emp_dept', $emp_dept);
				$add_leave->bindParam(':emp_status', $emp_status);
				$add_leave->bindParam(':leave_type', $emp_lType);
				$add_leave->bindParam(':w_pay', $emp_w_pay);
				$add_leave->bindParam(':from_date', $emp_FromDate);
				$add_leave->bindParam(':to_date', $emp_ToDate);
				$add_leave->bindParam(':filed_date', $emp_filed);
				$add_leave->bindParam(':days', $emp_Absences);
				$add_leave->bindParam(':reason', $emp_Reason);

				// Execute the query
				$add_leave->execute();
				return "Leave data added successfully!";
			}
		} catch (PDOException $e) {
			return "Error: " . $e->getMessage();
		}
	}





	/* ---------update_user_data----------*/

	public function update_user_data($data, $id)
	{
		$user_fullname  = $this->test_form_input_data($data['em_fullname']);
		$user_username = $this->test_form_input_data($data['em_username']);
		$user_email = $this->test_form_input_data($data['em_email']);
		try {
			$update_user = $this->db->prepare("UPDATE tbl_admin SET fullname = :x, username = :y, email = :z WHERE user_id = :id ");

			$update_user->bindparam(':x', $user_fullname);
			$update_user->bindparam(':y', $user_username);
			$update_user->bindparam(':z', $user_email);
			$update_user->bindparam(':id', $id);

			$update_user->execute();

			$_SESSION['update_user'] = 'update_user';

			header('Location: ../Manage-Admin/manage-user.php');
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}


	/* ------------update_admin_data-------------------- */

	public function update_admin_data($data, $id)
	{
		$user_fullname  = $this->test_form_input_data($data['em_fullname']);
		$user_username = $this->test_form_input_data($data['em_username']);
		$user_email = $this->test_form_input_data($data['em_email']);

		try {
			$update_user = $this->db->prepare("UPDATE tbl_admin SET fullname = :x, username = :y, email = :z WHERE user_id = :id ");

			$update_user->bindparam(':x', $user_fullname);
			$update_user->bindparam(':y', $user_username);
			$update_user->bindparam(':z', $user_email);
			$update_user->bindparam(':id', $id);

			$update_user->execute();

			header('Location: ../Manage-Admin/manage-admin.php');
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}


	/* ------update_user_password------------------*/

	public function update_user_password($data, $id)
	{
		$employee_password  = $this->test_form_input_data(md5($data['employee_password']));

		try {
			$update_user_password = $this->db->prepare("UPDATE tbl_admin SET password = :x WHERE user_id = :id ");

			$update_user_password->bindparam(':x', $employee_password);
			$update_user_password->bindparam(':id', $id);

			$update_user_password->execute();

			$_SESSION['update_user_pass'] = 'update_user_pass';

			header('Location: ../Manage-Admin/manage-user.php');
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}




	/* -------------admin_password_change------------*/

	public function admin_password_change($data, $id)
	{
		$admin_old_password  = $this->test_form_input_data(md5($data['admin_old_password']));
		$admin_new_password  = $this->test_form_input_data(md5($data['admin_new_password']));
		$admin_cnew_password  = $this->test_form_input_data(md5($data['admin_cnew_password']));
		$admin_raw_password = $this->test_form_input_data($data['admin_new_password']);

		try {

			// old password matching check 

			$sql = "SELECT * FROM tbl_admin WHERE user_id = '$id' AND password = '$admin_old_password' ";

			$query_result = $this->manage_all_info($sql);

			$total_row = $query_result->rowCount();
			$all_error = '';
			if ($total_row == 0) {
				$all_error = "Invalid old password";
			}


			if ($admin_new_password != $admin_cnew_password) {
				$all_error .= '<br>' . "New and Confirm New password do not match";
			}

			$password_length = strlen($admin_raw_password);

			if ($password_length < 6) {
				$all_error .= '<br>' . "Password length must be more then 6 character";
			}

			if (empty($all_error)) {
				$update_admin_password = $this->db->prepare("UPDATE tbl_admin SET password = :x WHERE user_id = :id ");

				$update_admin_password->bindparam(':x', $admin_new_password);
				$update_admin_password->bindparam(':id', $id);

				$update_admin_password->execute();

				$_SESSION['update_user_pass'] = 'update_user_pass';

				header('Location: ../Manage-Admin/manage-user.php');
			} else {
				return $all_error;
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}




	/* =================Task Related===================== */

	public function add_new_task($data)
	{
		// data insert   
		$task_title  = $this->test_form_input_data($data['task_title']);
		$task_description = $this->test_form_input_data($data['task_description']);
		$t_start_time = $this->test_form_input_data($data['t_start_time']);
		$t_end_time = $this->test_form_input_data($data['t_end_time']);
		$assign_to = $this->test_form_input_data($data['assign_to']);

		try {
			$add_task = $this->db->prepare("INSERT INTO task_info (t_title, t_description, t_start_time, 	t_end_time, t_user_id) VALUES (:x, :y, :z, :a, :b) ");

			$add_task->bindparam(':x', $task_title);
			$add_task->bindparam(':y', $task_description);
			$add_task->bindparam(':z', $t_start_time);
			$add_task->bindparam(':a', $t_end_time);
			$add_task->bindparam(':b', $assign_to);

			$add_task->execute();

			$_SESSION['Task_msg'] = 'Task Add Successfully';

			header('Location: ../task-info.php');
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}


	public function update_task_info($data, $task_id, $user_role)
	{
		$task_title  = $this->test_form_input_data($data['task_title']);
		$task_description = $this->test_form_input_data($data['task_description']);
		$t_start_time = $this->test_form_input_data($data['t_start_time']);
		$t_end_time = $this->test_form_input_data($data['t_end_time']);
		$status = $this->test_form_input_data($data['status']);

		if ($user_role == 1) {
			$assign_to = $this->test_form_input_data($data['assign_to']);
		} else {
			$sql = "SELECT * FROM task_info WHERE task_id='$task_id' ";
			$info = $this->manage_all_info($sql);
			$row = $info->fetch(PDO::FETCH_ASSOC);
			$assign_to = $row['t_user_id'];
		}

		try {
			$update_task = $this->db->prepare("UPDATE task_info SET t_title = :x, t_description = :y, t_start_time = :z, t_end_time = :a, t_user_id = :b, status = :c WHERE task_id = :id ");

			$update_task->bindparam(':x', $task_title);
			$update_task->bindparam(':y', $task_description);
			$update_task->bindparam(':z', $t_start_time);
			$update_task->bindparam(':a', $t_end_time);
			$update_task->bindparam(':b', $assign_to);
			$update_task->bindparam(':c', $status);
			$update_task->bindparam(':id', $task_id);

			$update_task->execute();

			$_SESSION['Task_msg'] = 'Task Update Successfully';

			header('Location: ../task-info.php');
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}


	/* =================Attendance Related===================== */
	public function add_punch_in($data)
	{
		$date = new DateTime('now', new DateTimeZone('Asia/Manila'));
		$user_id  = $this->test_form_input_data($data['user_id']);
		$punch_in_time = $date->format('Y-m-d H:i:s');

		try {
			// Set pause_duration to '00:00:00' when punching in
			$add_attendance = $this->db->prepare("INSERT INTO attendance_info (atn_user_id, in_time, pause_duration) VALUES ('$user_id', '$punch_in_time', '00:00:00')");
			$add_attendance->execute();

			header('Location: ../Manage-Attendance/attendance.php');
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function add_punch_out($data)
	{
		$date = new DateTime('now', new DateTimeZone('Asia/Manila'));
		$punch_out_time = $date->format('Y-m-d H:i:s');
		$punch_in_time  = $this->test_form_input_data($data['punch_in_time']);
		$attendance_id  = $this->test_form_input_data($data['aten_id']);

		// Get the total pause duration
		$query = $this->db->prepare("SELECT pause_duration FROM attendance_info WHERE aten_id = :id");
		$query->bindparam(':id', $attendance_id);
		$query->execute();
		$result = $query->fetch(PDO::FETCH_ASSOC);
		$pause_duration = $result['pause_duration'] ?? '00:00:00'; // default to 0 if not set

		// Calculate total duration
		$dteStart = new DateTime($punch_in_time);
		$dteEnd   = new DateTime($punch_out_time);
		$dteDiff  = $dteStart->diff($dteEnd);
		$total_duration_seconds = ($dteDiff->h * 3600) + ($dteDiff->i * 60) + $dteDiff->s;

		// Convert pause duration to seconds
		list($pause_hours, $pause_minutes, $pause_seconds) = explode(':', $pause_duration);
		$pause_duration_seconds = ($pause_hours * 3600) + ($pause_minutes * 60) + $pause_seconds;

		// Calculate final duration in seconds
		$final_duration_seconds = $total_duration_seconds - $pause_duration_seconds;

		// Ensure final duration is not negative
		$final_duration_seconds = max($final_duration_seconds, 0);

		// Convert back to H:i:s format
		$final_duration = sprintf(
			'%02d:%02d:%02d',
			floor($final_duration_seconds / 3600),
			floor(($final_duration_seconds % 3600) / 60),
			$final_duration_seconds % 60
		);

		try {
			$update_user = $this->db->prepare("UPDATE attendance_info SET out_time = :x, total_duration = :y WHERE aten_id = :id ");
			$update_user->bindparam(':x', $punch_out_time);
			$update_user->bindparam(':y', $final_duration);
			$update_user->bindparam(':id', $attendance_id);
			$update_user->execute();

			header('Location: ../Manage-Attendance/attendance.php');
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}






	public function pause_time($data)
	{
		$date = new DateTime('now', new DateTimeZone('Asia/Manila'));
		$pause_time = $date->format('Y-m-d H:i:s');
		$attendance_id  = $this->test_form_input_data($data['aten_id']);

		try {
			$update_pause = $this->db->prepare("UPDATE attendance_info SET pause_time = :pause_time WHERE aten_id = :id");
			$update_pause->bindparam(':pause_time', $pause_time);
			$update_pause->bindparam(':id', $attendance_id);
			$update_pause->execute();

			header('Location: ../Manage-Attendance/attendance.php');
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function resume_time($data)
	{
		$attendance_id  = $this->test_form_input_data($data['aten_id']);

		// Get the pause_time from the database
		$query = $this->db->prepare("SELECT pause_time, pause_duration FROM attendance_info WHERE aten_id = :id");
		$query->bindparam(':id', $attendance_id);
		$query->execute();
		$result = $query->fetch(PDO::FETCH_ASSOC);

		$pause_time = $result['pause_time'];
		$current_pause_duration = $result['pause_duration'];

		$date = new DateTime('now', new DateTimeZone('Asia/Manila'));
		$resume_time = $date->format('Y-m-d H:i:s');

		// Calculate how long the pause lasted
		$dtePauseStart = new DateTime($pause_time);
		$dtePauseEnd = new DateTime($resume_time);
		$pauseDiff = $dtePauseStart->diff($dtePauseEnd);

		// Add the new pause duration to the total pause duration
		$pauseSeconds = strtotime($pauseDiff->format("%H:%I:%S")) - strtotime('TODAY');
		$totalPauseDuration = date('H:i:s', strtotime($current_pause_duration) + $pauseSeconds);

		try {
			// Update the attendance info with the new total pause duration and reset pause_time
			$update_resume = $this->db->prepare("UPDATE attendance_info SET pause_duration = :pause_duration, pause_time = NULL WHERE aten_id = :id");
			$update_resume->bindparam(':pause_duration', $totalPauseDuration);
			$update_resume->bindparam(':id', $attendance_id);
			$update_resume->execute();

			header('Location: ../Manage-Attendance/attendance.php');
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}



	/* --------------------delete_data_by_this_method--------------*/

	public function delete_data_by_this_method($sql, $action_id, $sent_po)
	{
		try {
			$delete_data = $this->db->prepare($sql);

			$delete_data->bindparam(':id', $action_id);

			$delete_data->execute();

			header('Location: ' . $sent_po);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	/* ----------------------manage_all_info--------------------- */

	public function manage_all_info($sql)
	{
		try {
			$info = $this->db->prepare($sql);
			$info->execute();
			return $info;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	/* ----------------------scheduling--------------------- */
}
