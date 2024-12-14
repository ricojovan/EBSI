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
	public function pending_leave_data()
	{
		try {
			$stmt = $this->db->prepare("SELECT * FROM tbl_pending_leave");
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
	
	public function pending_leave_data_by_id($userId)
	{
		try {
			$stmt = $this->db->prepare("SELECT * FROM tbl_pending_leave where user_id = :userId");
			$stmt->bindParam(':userId', $userId);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function cancel_pending_request($pendingId)
	{
		$stmt = $this->db->prepare("DELETE FROM tbl_pending_leave WHERE pending_id = :pendingId");
		$stmt->bindParam(":pendingId", $pendingId);
		return $stmt->execute();
	}

	public function fetch_leave_data_by_id($userId)
	{
		try {
			$stmt = $this->db->prepare("SELECT * FROM tbl_leave where user_id = :userId");
			$stmt->bindParam(':userId', $userId);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
	public function fetch_leave_data_by_ids($userId)
	{
		try {
			$stmt = $this->db->prepare("SELECT * FROM tbl_pending_leave where user_id = :userId");
			$stmt->bindParam(':userId', $userId);
			$stmt->execute();
			return $stmt->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function update_leave_data($userId) {}

	/* ---------------------- Admin Login Check ----------------------------------- */

	public function admin_login_check($data)
	{
		$username = $this->test_form_input_data($data['username']);
		$password = $this->test_form_input_data(md5($data['admin_password']));

		try {
			$stmt = $this->db->prepare("SELECT * FROM tbl_admin WHERE username = :username AND password = :password LIMIT 1");
			$stmt->execute(array(':username' => $username, ':password' => $password));
			$adminRow = $stmt->fetch(PDO::FETCH_ASSOC);

			if ($adminRow) {
				session_start();
				$_SESSION['admin_id'] = $adminRow['user_id'];
				$_SESSION['name'] = $adminRow['fullname'];
				$_SESSION['security_key'] = 'rewsgf@%^&*nmghjjkh';
				$_SESSION['user_role'] = 1;

				header('Location: Interface/dashboard.php');
				exit;
			}

			$stmt = $this->db->prepare("SELECT * FROM employees WHERE username = :username AND password = :password LIMIT 1");
			$stmt->execute([':username' => $username, ':password' => $password]);
			$employeeRow = $stmt->fetch(PDO::FETCH_ASSOC);

			if ($employeeRow) {
				session_start();
				$_SESSION['admin_id'] = $employeeRow['emp_id'];
				$_SESSION['name'] = $employeeRow['emp_name'];
				$_SESSION['security_key'] = 'rewsgf@%^&*nmghjjkh';
				$_SESSION['user_role'] = 2;
				$_SESSION['empDepartment'] = $employeeRow['emp_dept'];
				$_SESSION['empPosition'] = $employeeRow['job_title'];
				$_SESSION['empStatus'] = $employeeRow['employee_type'];
				$_SESSION['temp_password'] = $adminRow['temp_password'];

				if ($employeeRow['temp_password'] == null) {
					header('Location: Interface/dashboard.php');
				} else {
					header('Location: Manage-Employee/change-password.php');
				}
				exit;
			}
			return 'Invalid username or password';
		} catch (PDOException $e) {
			return 'Database error: ' . $e->getMessage();
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
				$update_user = $this->db->prepare("UPDATE employees SET password = :x, temp_password = :y WHERE emp_id = :id ");

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
		header('Location: ../index.php');
	}

	/*----------- add_new_user--------------*/

	public function add_new_user($data)
	{
		$em_username = $this->test_form_input_data($data['em_username']);
		$temp_password = rand(100000, 999999);
		$password = md5($temp_password);

		$em_id = $this->test_form_input_data($data['em_id']);
		$em_lastname = $this->test_form_input_data($data['em_lastname']);
		$em_firstname = $this->test_form_input_data($data['em_firstname']);
		$em_middlename = $this->test_form_input_data($data['em_middlename']);
		$em_fullname = $this->test_form_input_data(trim($data['em_firstname'] . ' ' . $data['em_middlename'] . ' ' . $data['em_lastname']));
		$em_gender = $this->test_form_input_data($data['em_gender']);
		$em_dob = $this->test_form_input_data($data['em_dob']);
		$em_civ_stat = $this->test_form_input_data($data['em_civ_stat']);
		$em_email = $this->test_form_input_data($data['em_email']);
		$em_mobile = $this->test_form_input_data($data['em_mobile']);

		$em_home_addr = $this->test_form_input_data($data['em_home_addr']);
		$em_curr_addr = $this->test_form_input_data($data['em_curr_addr']);

		$em_hire_date = $this->test_form_input_data($data['em_hire_date']);
		$em_dept = $this->test_form_input_data($data['em_dept']);
		$em_pos = $this->test_form_input_data($data['em_pos']);
		$em_type = $this->test_form_input_data($data['em_type']);
		$em_pType = $this->test_form_input_data($data['em_pType']);
		$em_taxStat = $this->test_form_input_data($data['em_taxStat']);
		$em_basic_sal = $this->test_form_input_data($data['em_basic_sal']);
		$em_mRate = $this->test_form_input_data($data['em_mRate']);
		$em_dRate = $this->test_form_input_data($data['em_dRate']);

		$em_sss_no = $this->test_form_input_data($data['em_sss_no']);
		$em_phealth_no = $this->test_form_input_data($data['em_phealth_no']);
		$em_pagibig_no = $this->test_form_input_data($data['em_pagibig_no']);
		$em_tin_no = $this->test_form_input_data($data['em_tin_no']);

		$profile_pic = $_FILES['em_prof_pic']['name'];
		$target_dir = "../assets/images/author/";
		$target_file = $target_dir . basename($profile_pic);

		if (!is_dir($target_dir)) {
			mkdir($target_dir, 0777, true);
		}

		if ($profile_pic && !move_uploaded_file($_FILES['em_prof_pic']['tmp_name'], $target_file)) {
			return "Failed to upload profile picture.";
		}

		try {
			// Check if email or username already exists
			$sqlEmail = "SELECT emp_email_addr FROM employees WHERE emp_email_addr = :email";
			$query_result_for_email = $this->db->prepare($sqlEmail);
			$query_result_for_email->execute([':email' => $em_email]);

			$sqlUsername = "SELECT username FROM employees WHERE username = :username";
			$query_result_for_username = $this->db->prepare($sqlUsername);
			$query_result_for_username->execute([':username' => $em_username]);

			if ($query_result_for_email->rowCount() > 0) {
				return "Email is already taken";
			} elseif ($query_result_for_username->rowCount() > 0) {
				return "Username is already taken";
			} else {

				$add_user = $this->db->prepare(
					"INSERT INTO employees (
					emp_id, emp_name, emp_lname, emp_fname, emp_mname, hire_date, sss_number, p_health_num, p_ibig_num, tin_num, 
					birth_date, department, job_title, employee_type, pay_type, b_salary, m_rate, d_rate, tax_stat, emp_civ_stat,
					emp_home_addr, emp_curr_addr, gender, emp_email_addr, mobile_num, username, password, temp_password, emp_profile
					) 
					VALUES (
					:em_id, :em_name, :em_lname, :em_fname, :em_mname, :hire_date, :sss_number, :p_health_num, :p_ibig_num, :tin_num,
					:birth_date, :department, :job_title, :employee_type, :pay_type, :b_salary, :m_rate, :d_rate, :tax_stat, :emp_civ_stat,
                    :emp_home_addr, :emp_curr_addr, :gender, :emp_email_addr, :mobile_num, :username, :password, :temp_password, :emp_profile
					)"
				);

				$add_user->bindParam(':em_id', $em_id);
				$add_user->bindParam(':em_name', $em_fullname);
				$add_user->bindParam(':em_lname', $em_lastname);
				$add_user->bindParam(':em_fname', $em_firstname);
				$add_user->bindParam(':em_mname', $em_middlename);
				$add_user->bindParam(':hire_date', $em_hire_date);
				$add_user->bindParam(':sss_number', $em_sss_no);
				$add_user->bindParam(':p_health_num', $em_phealth_no);
				$add_user->bindParam(':p_ibig_num', $em_pagibig_no);
				$add_user->bindParam(':tin_num', $em_tin_no);
				$add_user->bindParam(':birth_date', $em_dob);
				$add_user->bindParam(':department', $em_dept);
				$add_user->bindParam(':job_title', $em_pos);
				$add_user->bindParam(':employee_type', $em_type);
				$add_user->bindParam('pay_type', $em_pType);
				$add_user->bindParam(':b_salary', $em_basic_sal);
				$add_user->bindParam(':m_rate', $em_mRate);
				$add_user->bindParam('d_rate', $em_dRate);
				$add_user->bindParam(':tax_stat', $em_taxStat);
				$add_user->bindParam(':emp_civ_stat', $em_civ_stat);
				$add_user->bindParam(':emp_home_addr', $em_home_addr);
				$add_user->bindParam(':emp_curr_addr', $em_curr_addr);
				$add_user->bindParam(':gender', $em_gender);
				$add_user->bindParam(':emp_email_addr', $em_email);
				$add_user->bindParam(':mobile_num', $em_mobile);
				$add_user->bindParam(':username', $em_username);
				$add_user->bindParam(':password', $password);
				$add_user->bindParam(':temp_password', $temp_password);
				$add_user->bindParam(':emp_profile', $target_file);

				$add_user->execute();
			}
		} catch (PDOException $e) {
			return "Error: " . $e->getMessage();
		}
	}

	/* ---------add_leave_data----------*/

	public function add_pending_data($data)
	{
		$emp_id = $this->test_form_input_data($data['emp_id']);
		$emp_name = $this->test_form_input_data($data['emp_name']);
		$emp_dept = $this->test_form_input_data($data['emp_dept']);
		$emp_w_pay = ($data['pay'] === 'With Pay') ? 1 : 0;
		$emp_status = $this->test_form_input_data($data['emp_status']);
		$emp_pos = $this->test_form_input_data($data['emp_pos']);
		$emp_lType = $this->test_form_input_data($data['emp_leaveType']);
		$emp_filed = $this->test_form_input_data($data['emp_DateFiled']);
		$emp_FromDate = $this->test_form_input_data($data['emp_DateFrom']);
		$emp_ToDate = $this->test_form_input_data($data['emp_DateTo']);
		$emp_Reason = $this->test_form_input_data($data['emp_Reason']);

		$date1 = new DateTime($emp_FromDate);
		$date2 = new DateTime($emp_ToDate);
		$emp_Absences = $date2->diff($date1)->days + 1;

		try {

			$stmt = $this->db->prepare("SELECT emp_id FROM employees WHERE emp_id = :emp_id");
			$stmt->execute([':emp_id' => $emp_id]);

			if ($stmt->rowCount() === 0) {
				return "The provided Employee ID does not exist.";
			}

			$stmt = $this->db->prepare("SELECT user_id FROM tbl_pending_leave WHERE user_id = :emp_id");
			$stmt->execute([':emp_id' => $emp_id]);

			if ($stmt->rowCount() > 0) {
				return "You have a pending request. Please resolve it before submitting another one.";
			}

			$stmt = $this->db->prepare("
            INSERT INTO tbl_pending_leave (
                user_id, fullname, position, department, status, leave_type, w_pay, from_date, to_date, filed_date, days, reason
            ) VALUES (
                :emp_id, :emp_name, :emp_pos, :emp_dept, :emp_status, :leave_type, :w_pay, :from_date, :to_date, :filed_date, :days, :reason
            )
        ");

			if ($stmt->execute([
				':emp_id' => $emp_id,
				':emp_name' => $emp_name,
				':emp_pos' => $emp_pos,
				':emp_dept' => $emp_dept,
				':emp_status' => $emp_status,
				':leave_type' => $emp_lType,
				':w_pay' => $emp_w_pay,
				':from_date' => $emp_FromDate,
				':to_date' => $emp_ToDate,
				':filed_date' => $emp_filed,
				':days' => $emp_Absences,
				':reason' => $emp_Reason
			])) {
				$_SESSION['toast_message'] = "Leave data added successfully!";
				header('Location: ../Manage-Attendance/leave-data.php');
				exit();
			} else {
				$_SESSION['error_message'] = "Failed to add leave data. Please try again.";
			}
		} catch (PDOException $e) {
			error_log("Error adding leave data: " . $e->getMessage());
			$_SESSION['error_message'] = "There was an error adding the leave data. Please try again.";
		}
	}


	public function add_leave_data($data)
	{
		$emp_id = $this->test_form_input_data($data['emp_id']);
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
		$ver_by = $this->test_form_input_data($data['ver_by']);
		$req_by = $this->test_form_input_data($data['req_by']);
		$leave_bal = $this->test_form_input_data($data['leave_bal']);
		$leave_req = $this->test_form_input_data($data['leave_req']);
		$new_bal = $this->test_form_input_data($data['new_bal']);
		$isApproved = $this->test_form_input_data($data['approval'] == 'Approved' ? 1 : 0);
		$hr_name = $this->test_form_input_data($data['rec_by']);

		try {
			$sqlemp_Id = "SELECT emp_id FROM employees WHERE emp_id = :emp_id";
			$query_result_for_emp_id = $this->db->prepare($sqlemp_Id);
			$query_result_for_emp_id->execute([':emp_id' => $emp_id]);

			if ($query_result_for_emp_id->rowCount() == 0) {
				return "The employee ID does not exist in the admin table.";
			}

			// Prepare the insert statement
			$add_leave = $this->db->prepare("
            INSERT INTO tbl_leave (
                user_id, fullname, position, department, status, leave_type, w_pay, from_date, to_date, filed_date, days, reason, leave_bal, leave_req, new_bal, ver_by, req_by, isApproved, hr_name
            ) VALUES (
                :emp_id, :emp_name, :emp_pos, :emp_dept, :emp_status, :leave_type, :w_pay, :from_date, :to_date, :filed_date, :days, :reason, :leave_bal, :leave_req, :new_bal, :ver_by, :req_by, :isApproved, :hr_name
            )
        ");

			// Bind parameters
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
			$add_leave->bindParam(':leave_bal', $leave_bal);
			$add_leave->bindParam(':leave_req', $leave_req);
			$add_leave->bindParam(':new_bal', $new_bal);
			$add_leave->bindParam(':ver_by', $ver_by);
			$add_leave->bindParam(':req_by', $req_by);
			$add_leave->bindParam(':isApproved', $isApproved);
			$add_leave->bindParam(':hr_name', $hr_name);

			// Execute the query
			$add_leave->execute();

			// Perform the delete operation after insertion
			$delete_old_request = $this->db->prepare("
			 DELETE FROM tbl_pending_leave WHERE user_id = :emp_id
		 ");
			$delete_old_request->bindParam(':emp_id', $emp_id);
			$delete_old_request->execute();

			$_SESSION['message'] = "Leave Data Reviewed!";
			header('Location: ../Manage-Attendance/leave-report.php');
			exit();
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
			$update_user = $this->db->prepare("UPDATE employees SET emp_name = :x, username = :y, emp_email_addr = :z WHERE emp_id = :id ");

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
			$update_user_password = $this->db->prepare("UPDATE employees SET password = :x WHERE emp_id = :id ");

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
