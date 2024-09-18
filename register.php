<!doctype html>
<html class="no-js" lang="en">
    <head>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    </head>

            <?php
            include 'db_connection.php'; // Include database connection script

            // Check if form is submitted
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Retrieve form data
                $first_name = $_POST['first_name'];
                $last_name = $_POST['last_name'];
                $full_name = $first_name . ' ' . $last_name; // Combine first and last name

                $username = $_POST['username'];
                $e_password = $_POST['e_password'];
                $position = $_POST['position'];
                $group = $_POST['group'];
                $phone = $_POST['phone'];
                $date_hire = $_POST['date_hire'];
                $age = $_POST['age'];

                // Generate a 4-digit random number for emp_id
                $emp_id = mt_rand(1000, 9999); // Generate a random number between 1000 and 9999

                // SQL query to insert data into employees table
                $sql = "INSERT INTO employees (emp_id, full_name, position, `group`, username, age, start_date, phone, e_password)
                    VALUES ('$emp_id', '$full_name', '$position', '$group', '$username', '$age', '$date_hire', '$phone', '$e_password')";


                if ($conn->query($sql) === TRUE) {
                    echo '<script>alert("New record created successfully!");</script>';
                    echo '<script>window.location.href = "register.php";</script>';
                    // Redirect to a success page or perform other actions
                    // Example: header("Location: success.php");
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }

            // Fetch data from employees table
            $sql_fetch_employees = "SELECT emp_id, full_name, position, `group`, username, age, start_date, phone FROM employees";
            $result = $conn->query($sql_fetch_employees);
            ?>
<body>
    <?php include 'nav-and-footer/header-nav.php';?>
    <!-- No gutters start -->
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <div class="header-title">User Account</div>
                <div class="row no-gutters">
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body" > 
<!-- INFORMATION CARD START -->  
<div class="flex justify-center">                          
<div
  class="profile-card w-[300px] rounded-md shadow-xl overflow-hidden z-[100] relative cursor-pointer snap-start shrink-0 bg-white flex flex-col items-center justify-center gap-3 transition-all duration-300 group">
  <div
    class="avatar w-full pt-5 flex items-center justify-center flex-col gap-1">
    <div class="img_container w-full flex items-center justify-center relative z-40 after:absolute after:h-[6px] after:w-full after:bg-[#58b0e0] after:top-4 after:group-hover:size-[1%] after:delay-300 after:group-hover:delay-0 after:group-hover:transition-all after:group-hover:duration-300 after:transition-all after:duration-300 before:absolute before:h-[6px] before:w-full before:bg-[#58b0e0] before:bottom-4 before:group-hover:size-[1%] before:delay-300 before:group-hover:delay-0 before:group-hover:transition-all before:group-hover:duration-300 before:transition-all before:duration-300">
      <svg
        class="size-36 z-40 border-4 border-white rounded-full group-hover:border-8 group-hover:transition-all group-hover:duration-300 transition-all duration-300"
        id="avatar"
        viewBox="0 0 61.8 61.8"
        xmlns="http://www.w3.org/2000/svg"
      >
        <g data-name="Layer 2">
          <g data-name="—ÎÓÈ 1">
            <path
              d="M31.129 8.432c21.281 0 12.987 35.266 0 35.266-12.266 0-21.281-35.266 0-35.266z"
              fill-rule="evenodd"
              fill="#ffe8be"
            ></path>
            <circle fill="#58b0e0" r="30.9" cy="30.9" cx="30.9"></circle>
            <path
              d="M45.487 19.987l-29.173.175s1.048 16.148-2.619 21.21h35.701c-.92-1.35-3.353-1.785-3.909-21.385z"
              fill-rule="evenodd"
              fill="#60350a"
            ></path>
            <path
              d="M18.135 45.599l7.206-3.187 11.55-.3 7.42 3.897-5.357 11.215-7.613 4.088-7.875-4.35-5.331-11.363z"
              fill-rule="evenodd"
              fill="#d5e1ed"
            ></path>
            <path
              d="M24.744 38.68l12.931.084v8.949l-12.931-.085V38.68z"
              fill-rule="evenodd"
              fill="#f9dca4"
            ></path>
            <path
              opacity=".11"
              d="M37.677 38.778v3.58a9.168 9.168 0 0 1-.04 1.226 6.898 6.898 0 0 1-.313 1.327c-4.37 4.165-11.379.78-12.49-6.333z"
              fill-rule="evenodd"
            ></path>
            <path
              d="M52.797 52.701a30.896 30.896 0 0 1-44.08-.293l1.221-3.098 9.103-4.122c3.262 5.98 6.81 11.524 12.317 15.455A45.397 45.397 0 0 0 43.2 45.483l8.144 3.853z"
              fill-rule="evenodd"
              fill="#434955"
            ></path>
            <path
              d="M19.11 24.183c-2.958 1.29-.442 7.41 1.42 7.383a30.842 30.842 0 01-1.42-7.383zM43.507 24.182c2.96 1.292.443 7.411-1.419 7.384a30.832 30.832 0 001.419-7.384z"
              fill-rule="evenodd"
              fill="#f9dca4"
            ></path>
            <path
              d="M31.114 8.666c8.722 0 12.377 6.2 12.601 13.367.307 9.81-5.675 21.43-12.6 21.43-6.56 0-12.706-12.018-12.333-21.928.26-6.953 3.814-12.869 12.332-12.869z"
              fill-rule="evenodd"
              fill="#ffe8be"
            ></path>
            <path
              d="M33.399 24.983a7.536 7.536 0 0 1 5.223-.993h.005c5.154.63 5.234 2.232 4.733 2.601a2.885 2.885 0 0 0-.785 1.022 6.566 6.566 0 0 1-1.052 2.922 5.175 5.175 0 0 1-3.464 2.312c-.168.027-.34.048-.516.058a4.345 4.345 0 0 1-3.65-1.554 8.33 8.33 0 0 1-1.478-2.53v.003s-.797-1.636-2.072-.114a8.446 8.446 0 0 1-1.52 2.64 4.347 4.347 0 0 1-3.651 1.555 5.242 5.242 0 0 1-.516-.058 5.176 5.176 0 0 1-3.464-2.312 6.568 6.568 0 0 1-1.052-2.921 2.75 2.75 0 0 0-.77-1.023c-.5-.37-.425-1.973 4.729-2.603h.002a7.545 7.545 0 0 1 5.24 1.01l-.001-.001.003.002.215.131a3.93 3.93 0 0 0 3.842-.148l-.001.001zm-4.672.638a6.638 6.638 0 0 0-6.157-.253c-1.511.686-1.972 1.17-1.386 3.163a5.617 5.617 0 0 0 .712 1.532 4.204 4.204 0 0 0 3.326 1.995 3.536 3.536 0 0 0 2.966-1.272 7.597 7.597 0 0 0 1.36-2.37c.679-1.78.862-1.863-.82-2.795zm10.947-.45a6.727 6.727 0 0 0-5.886.565c-1.538.911-1.258 1.063-.578 2.79a7.476 7.476 0 0 0 1.316 2.26 3.536 3.536 0 0 0 2.967 1.272 4.228 4.228 0 0 0 .43-.048 4.34 4.34 0 0 0 2.896-1.947 5.593 5.593 0 0 0 .684-1.44c.702-2.25.076-2.751-1.828-3.451z"
              fill-rule="evenodd"
              fill="#464449"
            ></path>
            <path
              d="M17.89 25.608c0-.638.984-.886 1.598 2.943a22.164 22.164 0 0 0 .956-4.813c1.162.225 2.278 2.848 1.927 5.148 3.166-.777 11.303-5.687 13.949-12.324 6.772 3.901 6.735 12.094 6.735 12.094s.358-1.9.558-3.516c.066-.538.293-.733.798-.213C48.073 17.343 42.3 5.75 31.297 5.57c-15.108-.246-17.03 16.114-13.406 20.039z"
              fill-rule="evenodd"
              fill="#8a5c42"
            ></path>
            <path
              d="M24.765 42.431a14.125 14.125 0 0 0 6.463 5.236l-4.208 6.144-5.917-9.78z"
              fill-rule="evenodd"
              fill="#fff"
            ></path>
            <path
              d="M37.682 42.431a14.126 14.126 0 0 1-6.463 5.236l4.209 6.144 5.953-9.668z"
              fill-rule="evenodd"
              fill="#fff"
            ></path>
            <circle fill="#434955" r=".839" cy="52.562" cx="31.223"></circle>
            <circle fill="#434955" r=".839" cy="56.291" cx="31.223"></circle>
            <path
              d="M41.997 24.737c1.784.712 1.719 1.581 1.367 1.841a2.886 2.886 0 0 0-.785 1.022 6.618 6.618 0 0 1-.582 2.086v-4.949zm-21.469 4.479a6.619 6.619 0 0 1-.384-1.615 2.748 2.748 0 0 0-.77-1.023c-.337-.249-.413-1.06 1.154-1.754z"
              fill-rule="evenodd"
              fill="#464449"
            ></path>
          </g>
        </g>
      </svg>
      <div
        class="absolute bg-[#58b0e0] z-10 size-[60%] w-full group-hover:size-[1%] group-hover:transition-all group-hover:duration-300 transition-all duration-300 delay-700 group-hover:delay-0"
      ></div>
    </div>
  </div>

  
  <div class="headings *:text-center *:leading-4 f-name">
    <p class="text-xl font-serif font-semibold text-[#434955]">FIRST NAME LAST NAME</p>
    <p class="text-sm font-semibold text-[#434955]">POSITION</p>
  </div>
  <div class="w-full items-center justify-center flex">
    <ul
      class="flex flex-col items-start gap-2 has-[:last]:border-b-0 *:inline-flex *:gap-2 *:items-center *:justify-center *:border-b-[1.5px] *:border-b-stone-700 *:border-dotted *:text-xs *:font-semibold *:text-[#434955] pb-3"
    >
      <li>
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
</svg>
        <p>+123-458-784</p>
      </li>
      <li>
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
</svg>
        <p>Username</p>
      </li>
      <li>
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
</svg>
        <p>Group A</p>
      </li>
      <li>
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
</svg>
        <p>DATE HIRED: MM/DD/YYYY</p>
      </li>
    </ul>
  </div>
  <hr class="w-full group-hover:h-5 h-3 bg-[#58b0e0] group-hover:transition-all group-hover:duration-300 transition-all duration-300"/>
</div>
</div>
</div></div></div>
<!-- INFORMATION CARD END -->
      <div class="col-sm-8">
        <div class="col-12">
          <div class="card mt-5">
            <div class="card-body">
              <h4 class="header-title">Register Account</h4>
                <!-- Registration form -->
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="needs-validation" novalidate="" >
                                    <div class="col-md-3 mb-3">
                                                <label for="validationCustom04">Emp ID</label>
                                                <input type="number" class="form-control" name="emp_id" id="validationCustom04" placeholder="0000" required="" style="width: 60px" id="disabledTextInput" disabled>
                                            </div>
                                    
                                    <div class="form-row">

                                            <div class="col-md-4 mb-3">
                                                <label for="validationCustom01">First name</label>
                                                <input type="text" class="form-control" name="first_name" id="validationCustom01" placeholder="First name" required="">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="validationCustom02">Last name</label>
                                                <input type="text" class="form-control" name="last_name" id="validationCustom02" placeholder="Last name" required="">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="validationCustomUsername">Username</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="username" id="validationCustomUsername" placeholder="Username" aria-describedby="inputGroupPrepend" required="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-3">
                                                <label for="validationCustom03">Password</label>
                                                <input type="password" class="form-control" name="e_password" id="validationCustom03" placeholder="Password" required="">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="validationCustom08">Cellphone Number</label>
                                                <input type="tel" class="form-control" name="phone" id="validationCustom08" placeholder="+63**********" required="">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="date-input">Date Hire</label>
                                                <input class="form-control" type="date" name="date_hire" id="validationCustom05" placeholder="2024-04-09" required="">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-3">
                                                <label class="col-form-label">Position</label>
                                                <select class="form-control" name="position" style="height: 45px;">
                                                <option value="" disabled selected>Select</option>
                                                    <option>Employee</option>
                                                    <option>Admin</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="example-number-input" class="col-form-label">Age</label>
                                                <input class="form-control" type="number" name="age" placeholder="##" id="example-number-input" required="">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-3">
                                                <label class="col-form-label">Select Group</label>
                                                <select class="form-control" name="group" style="height: 45px;">
                                                <option value="" disabled selected>Select</option>
                                                    <option>A</option>
                                                    <option>B</option>
                                                    <option>C</option>
                                                    <option>D</option>
                                                    <option>E</option>
                                                    <option>F</option>
                                                    <option>G</option>
                                                    <option>H</option>
                                                </select>
                                            </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Upload</span>
                                            </div>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="photo" id="inputGroupFile01" required="">
                                                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                            </div>
                                        </div>
                                        <button  class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">Submit form</button>

                                        <!-- Modal -->
                                        
                                <!-- <div class="modal fade" id="exampleModalCenter">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Message</h5>
                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Please ensure that all input fields are filled before submitting.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary" type="submit" >Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->

                                    </form>
                                    <!-- End of registration form -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap Grid start -->
    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <!-- Start 12 column grid system -->
                                <div class="row">
                                    <div class="col-12">
                                        <!-- Dark table start -->
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Data Table Dark</h4>
                                <div class="data-tables datatable-dark">
                                    <table id="dataTable3" class="text-center">
                                        <thead class="text-capitalize">
                                            <tr>
                                                <th>EMP ID</th>
                                                <th>Name</th>
                                                <th>Position</th>
                                                <th>Group</th>
                                                <th>Username</th>
                                                <th>Age</th>
                                                <th>Start Date</th>
                                                <th>Phone</th>
                                                <th scope="col">action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo "<tr>";
                                                        echo "<td>" . htmlspecialchars($row["emp_id"]) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row["full_name"]) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row["position"]) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row["group"]) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row["age"]) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row["start_date"]) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row["phone"]) . "</td>";

                                                        echo "<td>
                                                                <ul class='d-flex justify-content-center'>
                                                                
                                                                <li class='mr-3'><a href='#' class='text-secondary edit-btn' 
                                                                data-name='" . htmlspecialchars($row["full_name"]) . "' 
                                                                data-position='" . htmlspecialchars($row["position"]) . "' 
                                                                data-username='" . htmlspecialchars($row["username"]) . "' 
                                                                data-age='" . htmlspecialchars($row["age"]) . "' 
                                                                data-start-date='" . htmlspecialchars($row["start_date"]) . "' 
                                                                data-phone='" . htmlspecialchars($row["phone"]) . "'>
                                                                <i class='fa fa-edit'></i></a></li>

                                                                    <li><a href='#' class='text-danger delete-btn' data-name='" . $row["full_name"] . "'><i class='ti-trash'></i></a></li>
                                                                </ul>
                                                            </td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='7'>No employees found</td></tr>";
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Dark table end -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Bootstrap Grid end -->
        <!-- main content area end -->
    <br><br>
    <?php include 'nav-and-footer/footer-area.php';?>  

    <script src="https://cdn.tailwindcss.com"></script>
    
</body>
</html>
