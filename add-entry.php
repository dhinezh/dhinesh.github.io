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
    <title>Dashboard | Fast value inspection</title>
</head>

<body class="dashboard">
    <aside class="side-menu-wrapper">
        <a class="navbar-brand" href="#">
            <img src="./assets/images/logo.png" alt="Company Logo" class="logo">
        </a>
        <ul class="menu-list">
            <li>
                <a href="./dashboard.php" class="menu-option active">Dashboard</a>
            </li>
            <li>
                <a href="./view-details.php" class="menu-option">View vehicle details</a>
            </li>
            <li>
                <a href="./add-edit-user.php" class="menu-option">Add/Edit users</a>
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
                    <h2 class="d-none d-lg-block m-0">Dashboard</h2>
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
                        <form id="vehicle-entry-form" name="vehicle-entry-form" action='' method="post">
                            <div id="four-wheeler-entry-form" class="form-register">
                                <!-- SECTION 1 -->
                                <h3><span class="step-icon">01</span></h3>
                                <section>
                                    <h2 class="mb-3">Vehicle Details</h2>
                                    <div class="row button-wrapper">
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="repId" name="repId">
                                                <label for="repId">Rep ID</label>
                                                <span class="helper-text" id='vehicle-entry-form_repId_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="datepicker" id="inspectionData" name="inspectionData">
                                                <label for="inspectionData">Inspection date</label>
                                                <span class="helper-text" id='vehicle-entry-form_inspectionData_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="loanNo" name="loanNo">
                                                <label for="loanNo">Loan No</label>
                                                <span class="helper-text" id='vehicle-entry-form_loanNo_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="location" name="location">
                                                <label for="location">Location</label>
                                                <span class="helper-text" id='vehicle-entry-form_location_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="vehicleMake" name="vehicleMake">
                                                <label for="vehicleMake">Make</label>
                                                <span class="helper-text" id='vehicle-entry-form_vehicleMake_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="datepicker" id="vehicleModel" name="vehicleModel">
                                                <label for="vehicleModel">Model</label>
                                                <span class="helper-text" id='vehicle-entry-form_vehicleModel_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="vehicleVariant" name="vehicleVariant">
                                                <label for="vehicleVariant">Variant</label>
                                                <span class="helper-text" id='vehicle-entry-form_vehicleVariant_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="vehicleRegNo" name="vehicleRegNo">
                                                <label for="vehicleRegNo">Registration No</label>
                                                <span class="helper-text" id='vehicle-entry-form_vehicleRegNo_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="datepicker" id="vehicleRegDate" name="vehicleRegDate">
                                                <label for="vehicleRegDate">Registration date</label>
                                                <span class="helper-text" id='vehicle-entry-form_vehicleRegDate_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="ownerName" name="ownerName">
                                                <label for="ownerName">Owner Name</label>
                                                <span class="helper-text" id='vehicle-entry-form_ownerName_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="rcType" id="rcType">
                                                    <option value="available" selected>Available</option>
                                                    <option value="notAvailable">Not Available</option>
                                                </select>
                                                <label for="rcType">RC Status</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="manufacturedYear" name="manufacturedYear">
                                                <label for="manufacturedYear">Manufactured Year</label>
                                                <span class="helper-text" id='vehicle-entry-form_manufacturedYear_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="insuranceStatus" id="insuranceStatus">
                                                    <option value="available" selected>Available</option>
                                                    <option value="notAvailable">Not Available</option>
                                                </select>
                                                <label for="insuranceStatus">Insurance Status</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="datepicker" id="vehicleInsuranceDate" name="vehicleInsuranceDate">
                                                <label for="vehicleInsuranceDate">Insurance Date</label>
                                                <span class="helper-text" id='vehicle-entry-form_vehicleInsuranceDate_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="odometerReading" name="odometerReading">
                                                <label for="odometerReading">Odometer Reading</label>
                                                <span class="helper-text" id='vehicle-entry-form_odometerReading_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="vehicleOwnership" id="vehicleOwnership">
                                                    <option value="1" selected>1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                                <label for="vehicleOwnership">Vehicle Ownership</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="reportType" id="reportType">
                                                    <option value="retail" selected>Retail</option>
                                                    <option value="rpo">RPO</option>
                                                </select>
                                                <label for="reportType">Report Type</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="hpaStatus" name="hpaStatus">
                                                <label for="hpaStatus">HPA Status</label>
                                                <span class="helper-text" id='vehicle-entry-form_hpaStatus_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="hpaBank" name="hpaBank">
                                                <label for="hpaBank">HPA Bank</label>
                                                <span class="helper-text" id='vehicle-entry-form_hpaBank_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="transmissionType" id="transmissionType">
                                                    <option value="manual" selected>Manual</option>
                                                    <option value="automatic">Automatic</option>
                                                </select>
                                                <label for="transmissionType">Transmission Type</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="fuelType" id="fuelType">
                                                    <option value="diesel" selected>Diesel</option>
                                                    <option value="petrol">Petrol</option>
                                                    <option value="lpg">LPG</option>
                                                    <option value="cng">CNG</option>
                                                </select>
                                                <label for="fuelType">Fuel Type</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="vehicleColor" name="vehicleColor">
                                                <label for="vehicleColor">Color</label>
                                                <span class="helper-text" id='vehicle-entry-form_vehicleColor_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="engineCondition" id="engineCondition">
                                                    <option value="starts" selected>Starts</option>
                                                    <option value="doesntstart">Does not start</option>
                                                </select>
                                                <label for="engineCondition">Engine Condition</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="vehicleCondition" id="vehicleCondition">
                                                    <option value="running" selected>Running Condition</option>
                                                    <option value="towing">Towing Condition</option>
                                                </select>
                                                <label for="vehicleCondition">Vehicle Condition</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="structuralCondition" id="structuralCondition">
                                                    <option value="good" selected>Good</option>
                                                    <option value="average">Average</option>
                                                </select>
                                                <label for="structuralCondition">Structural Condition</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="ownerSerial" id="ownerSerial">
                                                    <option value="1" selected>1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                                <label for="ownerSerial">Owner Serial</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="vehicleKey" id="vehicleKey">
                                                    <option value="available" selected>Available</option>
                                                    <option value="notAvailable">Not Available</option>
                                                </select>
                                                <label for="vehicleKey">Vehicle Key</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="batteryStatus" id="batteryStatus">
                                                    <option value="available" selected>Available</option>
                                                    <option value="notAvailable">Not Available</option>
                                                </select>
                                                <label for="batteryStatus">Battery</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="tyreCondition" id="tyreCondition">
                                                    <option value="5" selected>Very Good</option>
                                                    <option value="4">Good</option>
                                                    <option value="3">Average</option>
                                                    <option value="2">Bad</option>
                                                    <option value="1">Not Available</option>
                                                </select>
                                                <label for="tyreCondition">Tyre Condition</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="reportRequestedBy" name="reportRequestedBy">
                                                <label for="reportRequestedBy">Report Requested By</label>
                                                <span class="helper-text" id='vehicle-entry-form_reportRequestedBy_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="valuationPrice" name="valuationPrice">
                                                <label for="valuationPrice">Valuation Price</label>
                                                <span class="helper-text" id='vehicle-entry-form_valuationPrice_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="input-field">
                                                <textarea id="remarks" class="materialize-textarea"></textarea>
                                                <label for="remarks">Remarks</label>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                <!-- SECTION 2 -->
                                <h3><span class="step-icon">02</span></h3>
                                <section>
                                    <h2 class="mb-3">Personal Information</h2>
                                    <div class="row button-wrapper">
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="fname" name="fname">
                                                <label for="fname">last name</label>
                                                <span class="helper-text" id='addUser_fname_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="fname" name="fname">
                                                <label for="fname">last name</label>
                                                <span class="helper-text" id='addUser_fname_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="fname" name="fname">
                                                <label for="fname">last name</label>
                                                <span class="helper-text" id='addUser_fname_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="fname" name="fname">
                                                <label for="fname">last name</label>
                                                <span class="helper-text" id='addUser_fname_errorloc'></span>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <footer class="p-3 text-center">Copyrights &copy; Fast value India Pvt.Ltd. All rights reserved</footer>
    </main>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="./assets/lib/core/materialize.min.js"></script>
    <script type="text/javascript" src="./assets/lib/plugins/jquery.steps.min.js"></script>
    <script type="text/javascript" src="./assets/js/entryScript.js"></script>
    <script>
        $(document).ready(function() {
            $('.datepicker').datepicker();
            $('select').formSelect();
            $('.sidenav-trigger').on('click', function(e) {
                $('.side-menu-wrapper').addClass("show");
                $('.sidenav-overlay').on('click', function(e) {
                    $('.side-menu-wrapper').removeClass("show");
                });
                e.preventDefault();
            });
        });
    </script>
</body>

</html>