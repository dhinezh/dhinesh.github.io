<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="apple-touch-icon" sizes="114x114" href="./favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./favicons/favicon-16x16.png">
    <link rel="manifest" href="./favicons/site.webmanifest">
    <link rel="mask-icon" href="./favicons/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="./assets/styles/core/materialize.min.css" media="screen,projection" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet/less" type="text/css" href="./assets/styles/styles.less" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/3.9.0/less.min.js"></script>
    <script type='text/javascript' src='./assets/lib/plugins/gen_validatorv31.js'></script>
    <title>Add/Edit Users | Fast value inspection</title>
</head>

<body class="dashboard">
    <aside class="side-menu-wrapper">
        <a class="navbar-brand" href="#">
            <img src="./assets/images/logo.png" alt="Company Logo" class="logo">
        </a>
        <ul class="menu-list">
            <li>
                <a href="./dashboard.php" class="menu-option">Dashboard</a>
            </li>
            <li>
                <a href="./view-details.php" class="menu-option">View vehicle details</a>
            </li>
            <li>
                <a href="#" class="menu-option active">Add/Edit users</a>
            </li>
        </ul>
    </aside>
    <div class="sidenav-overlay"></div>
    <main class="main-wrapper">
        <header>
            <section class="header">
                <a class="sidenav-trigger btn-sidenav-toggle btn-floating btn-medium waves-effect waves-light hide-on-large-only" href="#" data-target="slide-out">
                    <i class="material-icons">menu</i>
                </a>
                <div class="d-flex align-items-center flex-grow-1 justify-content-end justify-content-lg-between">
                    <h2 class="d-none d-lg-block m-0">Add/Edit users</h2>
                    <div class="d-flex align-items-center">
                        <p class="m-0 mr-3">Welcome Saravanan</p>
                        <a href="./index.html" class="btn-floating btn-medium waves-effect waves-light">
                            <i class="material-icons">input</i>
                        </a>
                    </div>
                </div>
            </section>
        </header>
        <div class="flex-grow-1">
            <div class="content-wrapper-before"></div>
            <div class="container pt-5">
                <div class="card">
                    <div class="card-content">
                        <form id="addUser" name="addUser" action='' method="post" onsubmit="return loginValidation()">
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="input-field">
                                        <input type="text" class="validate" id="fname" name="fname">
                                        <label for="fname">First name</label>
                                        <span class="helper-text" id='addUser_fname_errorloc'></span>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="input-field">
                                        <input type="text" class="validate" id="lname" name="lname">
                                        <label for="lname">Last name</label>
                                        <span class="helper-text" id='addUser_lname_errorloc'></span>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="input-field">
                                        <input type="text" class="validate" id="username" name="username">
                                        <label for="username">Username</label>
                                        <span class="helper-text" id='addUser_username_errorloc'></span>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="input-field">
                                        <select name="usertype">
                                            <option value="none" disabled selected>Choose user type</option>
                                            <option value="admin">Admin</option>
                                            <option value="user">Normal user</option>
                                        </select>
                                        <label>User type</label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="input-field">
                                        <input type="password" class="validate" id="password" name="password">
                                        <label for="password">Password</label>
                                        <span class="helper-text" id='addUser_password_errorloc'></span>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="input-field">
                                        <input type="password" class="validate" id="confpassword" name="confpassword">
                                        <label for="confpassword">Confirm Password</label>
                                        <span class="helper-text" id='addUser_confpassword_errorloc'></span>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="input-field">
                                        <input type="number" class="validate" id="mobile" name="mobile">
                                        <label for="mobile">Mobile number</label>
                                        <span class="helper-text" id='addUser_mobile_errorloc'></span>
                                    </div>
                                </div>
                            </div>
                            <button type='submit' name='Submit' class="btn btn-primary mt-3 waves-effect waves-light float-right">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <footer class="p-3 text-center">Copyrights &copy; Fast value India Pvt.Ltd. All rights reserved</footer>
    </main>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="./assets/lib/core/materialize.min.js"></script>
    <script>
        $(document).ready(function() {
            $('select').formSelect();
            var frmvalidator = new Validator("addUser");
            frmvalidator.EnableOnPageErrorDisplay();
            frmvalidator.EnableMsgsTogether();

            frmvalidator.addValidation("username", "req", "Please provide your username");
            frmvalidator.addValidation("password", "req", "Please provide the password");
            frmvalidator.addValidation("mobile", "req", "Please provide the Mobile number");
            frmvalidator.addValidation("usertype", "dontselect=none", "Please select a user type");
            frmvalidator.addValidation("password", "neelmnt=username", "The password should not be same as username");
            frmvalidator.addValidation("confpassword", "eqelmnt=password", "The confirmed password is not same as password");


            $('.sidenav-trigger').on('click', function(e) {
                $('.side-menu-wrapper').addClass("show");
                $('.sidenav-overlay').on('click', function(e) {
                    $('.side-menu-wrapper').removeClass("show");
                });
                e.preventDefault();
            });
            $('#addUser').on('submit', function(e) {
                var valid = true;
                var Password = $('#password').val();
                var confpassword = $('#confpassword').val();
                if (Password !== confpassword) {
                    e.preventDefault();
                    valid = false;
                    $('#addUser_confpassword_errorloc').text('The confirmed password is not same as password');
                }
                return valid;
            });
        });
    </script>
</body>

</html>