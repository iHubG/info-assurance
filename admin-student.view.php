<?php
    session_start();

    require 'db.php';

    // Check if the user is logged in
    if (!isset($_SESSION['admin_id'])) {
        header('Location: admin.view.php');
        exit();
    }

    // Get the username from the session
    $username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Admin';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Students</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="./public/style/style.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body id="login-body">
        <section id="admin-dash">
            <div class="row g-0">
                <!-- Sidebar -->
                <div class="col-0 d-none d-sm-block d-sm-none d-md-block d-md-none d-lg-block col-lg-2 d-flex p-3 p-xxl-4 px-2 flex-column" id="admin-sidebar">                   
                    <h2 class="h4 text-center">Admin</h2>
                    <nav id="dash-nav">
                        <hr> 
                        <a href="admin-student.view.php" class="text-decoration-none text-white">
                            <div class="dash-nav d-flex gap-2 my-1 p-2 rounded" id="student-link">
                                <i class="bi bi-backpack2"></i>
                                <h5>Students</h5>           
                            </div>
                        </a> 
                        <div class="logout-box rounded position-absolute bottom-0 start-0 d-flex justify-content-center align-items-center flex-column p-3 p-xxl-4 px-2">
                            <hr class="bottom-rule">
                            <a href="admin-logout.php" class="text-decoration-none text-white">
                                <div class="logout-nav d-flex justify-content-center gap-2 p-2">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <h5>Log out</h5>
                                </div> 
                            </a>                        
                        </div>
                    </nav>
                </div>

                <!-- OffCanvas -->
                <div class="offcanvas offcanvas-start w-50" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title text-center m-auto" id="offcanvasScrollingLabel">Admin</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="p-3 p-xxl-4 px-2">
                        <hr>
                    </div>
                    <div class="offcanvas-body">
                        <nav id="dash-nav">
                            <a href="/crms-project/admin-student" class="text-decoration-none text-white">
                                <div class="dash-nav d-flex gap-2 my-1 p-2 rounded" id="student-link">
                                    <i class="bi bi-backpack2"></i>
                                    <h5>Students</h5>           
                                </div>
                            </a>   
                            <div class="logout-box rounded position-absolute bottom-0 start-0 d-flex justify-content-center align-items-center flex-column p-3 p-xxl-4 px-2">
                                <hr class="bottom-rule">
                                <a href="admin-logout" class="text-decoration-none text-white">
                                    <div class="logout-nav d-flex justify-content-center gap-2 p-2">
                                        <i class="bi bi-box-arrow-right"></i>
                                        <h5>Log out</h5>
                                    </div> 
                                </a>                        
                            </div>
                        </nav>
                    </div>
                </div>
               
                <!-- Main Content -->
                <div class="col-12 col-lg-10 offset-lg-2" id="admin-main-content">
                    <nav class="bg-success-subtle p-3 mb-3">
                        <div class="container text-center">
                            <h2>Students</h2>
                        </div>
                    </nav>
                    <?php 
                        // Prepare SQL query to retrieve all students
                        $sql_students = "SELECT id, first_name, last_name, date_of_birth, username, password FROM student";

                        // Prepare and execute the statement to retrieve all students
                        $stmt_students = $pdo->query($sql_students);

                        // Fetch all students
                        $students = $stmt_students->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <div class="main-content-info">
                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-striped">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Date of Birth</th>
                                                <th>Username</th>
                                                <th>Password</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="searchResults">
                                            <?php
                                            $rowNumber = 1;
                                            foreach ($students as $student) {
                                                echo "<tr id='row_$rowNumber'>"; // Add unique identifier to each row
                                                echo "<td>" . $rowNumber . "</td>"; 
                                                echo "<form action='admin-update-student.php' method='post'>";           
                                                echo "<td><input type='text' class='form-control' name='firstName' value='" . (isset($student['first_name']) ? htmlspecialchars($student['first_name']) : '') . "' readonly autocomplete='off'></td>";
                                                echo "<td><input type='text' class='form-control' name='lastName' value='" . (isset($student['last_name']) ? htmlspecialchars($student['last_name']) : '') . "' readonly autocomplete='off'></td>";
                                                echo "<td><input type='text' class='form-control' name='dbirth' value='" . (isset($student['date_of_birth']) ? htmlspecialchars($student['date_of_birth']) : '') . "' readonly autocomplete='off'></td>";
                                                echo "<td><input type='text' class='form-control' name='username' value='" . (isset($student['username']) ? htmlspecialchars($student['username']) : '') . "' readonly autocomplete='off'></td>";                                                
                                                echo "<td><input type='text' class='form-control' name='password' value='" . (isset($student['password']) ? htmlspecialchars($student['password']) : '') . "' readonly autocomplete='off'></td>";                                                
                                                echo "<td>";
                                               
                                                // Update button with success color
                                                echo "<input type='hidden' name='id_update' id='studentIdInput' value='" . htmlspecialchars($student['id']) . "''>
                                                    <button type='submit' name='update' class='btn btn-success mx-1 my-1'>Update</button>";
                                                // Delete button with danger color
                                                echo "</form>";

                                                 // Edit button with primary color
                                                 echo "<button class='btn btn-primary mx-1 my-1 edit-button' onclick='enableEditing($rowNumber)'>Edit</button>"; // Add onclick event
                                                
                                                echo "<form action='admin-student-delete.php' method='post'>
                                                        <input type='hidden' name='id_delete' id='studentIdInput' value='" . htmlspecialchars($student['id']) . "''>
                                                        <button type='submit' name='delete' class='btn btn-danger mx-1 my-1'>Delete</button>
                                                    </form>";
                                                echo "</td>";
                                                echo "</tr>";
                                                $rowNumber++;
                                            }
                                            ?>

                                            <script>
                                                 // Delegate event handling for "Edit" buttons
                                                 document.addEventListener("click", function(event) {
                                                    var target = event.target;
                                                    if (target.classList.contains("edit-button")) {
                                                        var rowNumber = target.dataset.row; // Get the row number from data attribute
                                                        enableEditing(rowNumber);
                                                    }
                                                });

                                                // Function to enable editing for a specific row
                                                function enableEditing(rowNumber) {
                                                    // Get the row element
                                                    var row = document.getElementById('row_' + rowNumber);
                                                    if (row) { // Check if the row element exists
                                                        // Find all input fields within the row using querySelectorAll
                                                        var inputs = row.querySelectorAll('input[type="text"]');
                                                        // Toggle the readonly attribute for each input field
                                                        inputs.forEach(function(input) {
                                                            input.readOnly = !input.readOnly;
                                                        });
                                                    }
                                                }

                                            </script>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>               
                    </div>
                </div>
            </div>
        </section>
        <script>
             // Hide content until everything is loaded
             document.documentElement.style.visibility = "hidden";

            function showContent() {
                document.documentElement.style.visibility = "visible";
            }

            // Only apply delay if the page is initially loading
            if (document.readyState === "loading") {
                // Introduce a delay of 0.5 seconds before showing content
                setTimeout(showContent, 500); // Delay of 0.5 seconds (500 milliseconds)
            } else {
                // If the page is already loaded, immediately show the content
                showContent();
            }

            function showProfilePicture() {
                document.getElementById('profilePicture').classList.remove('d-none');
                document.getElementById('placeholderContainer').classList.add('d-none');
            }

        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="./public/javascript/script.js"></script>
        <script src="./public/javascript/instructor-validation.js"></script>
        <script src="./public/javascript/student-validation.js"></script>
        <script src="./public/javascript/delete-instructor.js"></script>
    </body>
</html>