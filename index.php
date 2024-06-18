<?php 
    require 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registration | Login Page</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="./public/style/style.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body id="login-body">
        <!-- Login -->
        <section id="login">
            <div class="container">
                <a class="ms-2 ms-lg-5 fs-1 mt-5"></a>
                <div class="row justify-content-center my-2 mt-lg-0 mt-xxl-5 my-lg-0 my-xxl-5">
                    <div class="col-10 shadow" id="login-box">
                        <div class="row flex-column flex-md-row flex-lg-row" id="login-box2">
                            <div class="col-12 col-lg-6 d-flex justify-content-center align-items-center" id="login-left">
                                <img id="isu-icon" src="./public/img/isu-icon.png" alt="isu icon">
                            </div>
                            <div class="col-12 col-lg-6 text-center" id="login-right">
                               
                                <h2 id="login-as">Login As</h2>
                                <div class="d-flex flex-column my-5 my-lg-0 mt-lg-5 gap-xxl-5 gap-lg-4 gap-4 align-items-center">
                                    <a href="admin.view.php" class="login-button">Admin</a>
                                     <!-- Register Student Button Modal -->
                                    <button class="btn btn-primary mt-5" data-bs-toggle="modal" data-bs-target="#register-student">Register Student</button>
                                </div>
                                <!--<img id="question-mark" src="./public/img/question-mark.png" alt="question mark">-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Register Student Button Modal -->
            <div class="modal fade" id="register-student" tabindex="-1" aria-labelledby="register-student" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <h1 class="modal-title fs-5" id="register-student">Register Student</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="registerStudent" method="post">

                                <!-- First Name -->
                                <div class="mb-3">
                                    <div>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-person"></i>
                                            </span>
                                            <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name" autocomplete="off">
                                        </div>
                                    </div>
                                    <div id="fname-error" class="text-danger"></div>
                                </div>

                                <!-- Last Name -->
                                <div class="mb-3">
                                    <div>                        
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-person"></i>
                                            </span>
                                            <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name" autocomplete="off">
                                        </div>
                                    </div>
                                    <div id="lname-error" class="text-danger"></div>
                                </div>

                                
                                <!-- Date of Birth -->
                                <div class="mb-3">
                                    <div>                        
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-calendar"></i>
                                            </span>
                                            <input type="text" class="form-control" id="dbirth" name="dbirth" placeholder="Date of Birth" autocomplete="off">
                                        </div>
                                    </div>
                                    <div id="dbirth-error" class="text-danger"></div>
                                </div>

                                <!-- Username -->
                                <div class="mb-3">
                                    <div>           
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-person-circle"></i>
                                            </span>
                                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" autocomplete="off">
                                        </div>
                                    </div>
                                    <div id="username-error" class="text-danger"></div>
                                </div>

                                <!-- Password -->
                                <div class="mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-lock"></i>
                                        </span>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off">                                                                    
                                        <span class="input-group-text password-toggle-icon">
                                            <i class="bi bi-eye" id="togglePassword"></i>
                                        </span>
                                    </div>
                                    <div id="password-error" class="text-danger"></div>
                                </div>


                                <div class="text-center">
                                    <button type="submit" name="submit" value="Register" class="btn btn-primary my-5 px-5">Register</button>
                                </div>
                            </form>
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
        </script>
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="./public/javascript/script.js"></script>
        <script src="./public/javascript/instructor-validation.js"></script>
        <script src="./public/javascript/student-validation.js"></script>
        <script src="./public/javascript/delete-instructor.js"></script>
    </body>
</html>