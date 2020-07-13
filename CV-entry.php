<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/php-scripts/main.php';
$main = new Main();
$user = $main->loginCheck();
if (!$user) {
    header("location:index.php");
} else {
    $username = $_SESSION['user']['username'];
    $usertype = $_SESSION['user']['usertype'];
}
$loading = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $loading = true;
    $registrationResponse = $main->registerCV();
    $loading = empty($registrationResponse["status"]);
}
?>
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
    <title>CV Entry | Fast value inspection</title>
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
            <?php
            if (isset($usertype) && $usertype == 'admin') {
            ?>
                <li>
                    <a href="./add-edit-user.php" class="menu-option">Add/Edit users</a>
                </li>
            <?php
            }
            ?>
            <?php
            if (isset($usertype) && $usertype == 'admin') {
            ?>
                <li>
                    <a href="./view-users.php" class="menu-option">View users</a>
                </li>
            <?php
            }
            ?>
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
                    <h2 class="d-none d-lg-block m-0">CV Entry</h2>
                    <div class="d-flex align-items-center">
                        <p class="m-0 mr-3">Welcome <?php
                                                    if (isset($username)) {
                                                    ?>
                                <?php echo $username; ?>
                            <?php
                                                    }
                            ?></p>
                        <a href="./logout.php" class="btn-floating btn-medium waves-effect waves-light">
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
                        <?php
                        if ($loading) {
                        ?>
                            <div class="loading-overlay">
                                <div class="preloader-wrapper big active">
                                    <div class="spinner-layer spinner-blue-only">
                                        <div class="circle-clipper left">
                                            <div class="circle"></div>
                                        </div>
                                        <div class="gap-patch">
                                            <div class="circle"></div>
                                        </div>
                                        <div class="circle-clipper right">
                                            <div class="circle"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        <?php
                        if (!empty($registrationResponse["status"])) {
                        ?>
                            <?php
                            if ($registrationResponse["status"] == "error") {
                            ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?php echo $registrationResponse["message"]; ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php
                            } else if ($registrationResponse["status"] == "success") {
                            ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <?php echo $registrationResponse["message"]; ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php
                            }
                            ?>
                        <?php
                        }
                        ?>
                        <form id="CV-entry-form" name="CV-entry-form" action='' method="post" enctype="multipart/form-data">
                            <div class="form-register">
                                <!-- SECTION 1 -->
                                <h3><span class="step-icon">01</span></h3>
                                <section>
                                    <h2 class="mb-3">Vehicle Details</h2>
                                    <div class="row button-wrapper">
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate required" id="repId" name="repId">
                                                <label for="repId">Rep ID</label>
                                                <span class="helper-text" id='CV-entry-form_repId_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="datepicker" id="inspectionDate" name="inspectionDate">
                                                <label for="inspectionDate">Inspection date</label>
                                                <span class="helper-text" id='CV-entry-form_inspectionDate_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate required" id="loanNo" name="loanNo">
                                                <label for="loanNo">Loan No</label>
                                                <span class="helper-text" id='CV-entry-form_loanNo_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="location" name="location">
                                                <label for="location">Location</label>
                                                <span class="helper-text" id='CV-entry-form_location_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate required" id="vehicleMake" name="vehicleMake">
                                                <label for="vehicleMake">Make</label>
                                                <span class="helper-text" id='CV-entry-form_vehicleMake_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate required" id="vehicleModel" name="vehicleModel">
                                                <label for="vehicleModel">Model</label>
                                                <span class="helper-text" id='CV-entry-form_vehicleModel_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate required" id="vehicleVariant" name="vehicleVariant">
                                                <label for="vehicleVariant">Variant</label>
                                                <span class="helper-text" id='CV-entry-form_vehicleVariant_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="vehicleRegNo" name="vehicleRegNo">
                                                <label for="vehicleRegNo">Registration No</label>
                                                <span class="helper-text" id='CV-entry-form_vehicleRegNo_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="datepicker" id="vehicleRegDate" name="vehicleRegDate">
                                                <label for="vehicleRegDate">Registration date</label>
                                                <span class="helper-text" id='CV-entry-form_vehicleRegDate_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="ownerName" name="ownerName">
                                                <label for="ownerName">Owner Name</label>
                                                <span class="helper-text" id='CV-entry-form_ownerName_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="rcType" id="rcType">
                                                    <option value="Available" selected>Available</option>
                                                    <option value="Not Available">Not Available</option>
                                                </select>
                                                <label for="rcType">RC Status</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="manufacturedYear" name="manufacturedYear">
                                                <label for="manufacturedYear">Manufactured Year</label>
                                                <span class="helper-text" id='CV-entry-form_manufacturedYear_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="insuranceStatus" id="insuranceStatus">
                                                    <option value="Available" selected>Available</option>
                                                    <option value="Not Available">Not Available</option>
                                                </select>
                                                <label for="insuranceStatus">Insurance Status</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="datepicker" id="vehicleInsuranceDate" name="vehicleInsuranceDate">
                                                <label for="vehicleInsuranceDate">Insurance Date</label>
                                                <span class="helper-text" id='CV-entry-form_vehicleInsuranceDate_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="odometerReading" name="odometerReading">
                                                <label for="odometerReading">Odometer Reading</label>
                                                <span class="helper-text" id='CV-entry-form_odometerReading_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="vehicleOwnership" id="vehicleOwnership">
                                                    <option value=1 selected>1</option>
                                                    <option value=2>2</option>
                                                    <option value=3>3</option>
                                                    <option value=4>4</option>
                                                    <option value=5>5</option>
                                                </select>
                                                <label for="vehicleOwnership">Vehicle Ownership</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="reportType" id="reportType">
                                                    <option value="Retail" selected>Retail</option>
                                                    <option value="RPO">RPO</option>
                                                </select>
                                                <label for="reportType">Report Type</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="hpaStatus" name="hpaStatus">
                                                <label for="hpaStatus">HPA Status</label>
                                                <span class="helper-text" id='CV-entry-form_hpaStatus_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="hpaBank" name="hpaBank">
                                                <label for="hpaBank">HPA Bank</label>
                                                <span class="helper-text" id='CV-entry-form_hpaBank_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="transmissionType" id="transmissionType">
                                                    <option value="Manual" selected>Manual</option>
                                                    <option value="Automatic">Automatic</option>
                                                </select>
                                                <label for="transmissionType">Transmission Type</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="fuelType" id="fuelType">
                                                    <option value="Diesel" selected>Diesel</option>
                                                    <option value="Petrol">Petrol</option>
                                                    <option value="LPG">LPG</option>
                                                    <option value="CNG">CNG</option>
                                                </select>
                                                <label for="fuelType">Fuel Type</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="vehicleColor" name="vehicleColor">
                                                <label for="vehicleColor">Color</label>
                                                <span class="helper-text" id='CV-entry-form_vehicleColor_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="engineCondition" id="engineCondition">
                                                    <option value="Starts" selected>Starts</option>
                                                    <option value="Does not start">Does not start</option>
                                                </select>
                                                <label for="engineCondition">Engine Condition</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="vehicleCondition" id="vehicleCondition">
                                                    <option value="Running Condition" selected>Running Condition</option>
                                                    <option value="Towing Condition">Towing Condition</option>
                                                </select>
                                                <label for="vehicleCondition">Vehicle Condition</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="structuralCondition" id="structuralCondition">
                                                    <option value="Good" selected>Good</option>
                                                    <option value="Average">Average</option>
                                                </select>
                                                <label for="structuralCondition">Structural Condition</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="ownerSerial" id="ownerSerial">
                                                    <option value=1 selected>1</option>
                                                    <option value=2>2</option>
                                                    <option value=3>3</option>
                                                    <option value=4>4</option>
                                                    <option value=5>5</option>
                                                </select>
                                                <label for="ownerSerial">Owner Serial</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="vehicleKey" id="vehicleKey">
                                                    <option value="Available" selected>Available</option>
                                                    <option value="Not Available">Not Available</option>
                                                </select>
                                                <label for="vehicleKey">Vehicle Key</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="batteryStatus" id="batteryStatus">
                                                    <option value="Available" selected>Available</option>
                                                    <option value="Not Available">Not Available</option>
                                                </select>
                                                <label for="batteryStatus">Battery</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="tyreCondition" id="tyreCondition">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="tyreCondition">Tyre Condition</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="reportRequestedBy" name="reportRequestedBy">
                                                <label for="reportRequestedBy">Report Requested By</label>
                                                <span class="helper-text" id='CV-entry-form_reportRequestedBy_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="valuationPrice" name="valuationPrice">
                                                <label for="valuationPrice">Valuation Price</label>
                                                <span class="helper-text" id='CV-entry-form_valuationPrice_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="input-field">
                                                <textarea id="remarks" name="remarks" class="materialize-textarea"></textarea>
                                                <label for="remarks">Remarks</label>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <!-- SECTION 2 -->
                                <h3><span class="step-icon">02</span></h3>
                                <section>
                                    <h2 class="mb-3">Parivahan Details</h2>
                                    <div class="row button-wrapper">
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="parivahanOwnerName" name="parivahanOwnerName">
                                                <label for="parivahanOwnerName">Owner Name</label>
                                                <span class="helper-text" id='CV-entry-form_parivahanOwnerName_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="parivahanMaker" name="parivahanMaker">
                                                <label for="parivahanMaker">Maker</label>
                                                <span class="helper-text" id='CV-entry-form_parivahanMaker_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="parivahanModel" name="parivahanModel">
                                                <label for="parivahanModel">Model</label>
                                                <span class="helper-text" id='CV-entry-form_parivahanModel_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="parivahanManufacturedYear" name="parivahanManufacturedYear">
                                                <label for="parivahanManufacturedYear">Manufactured Year</label>
                                                <span class="helper-text" id='CV-entry-form_parivahanManufacturedYear_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="datepicker" id="parivahanRegDate" name="parivahanRegDate">
                                                <label for="parivahanRegDate">Registration date</label>
                                                <span class="helper-text" id='CV-entry-form_parivahanRegDate_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="vehicleCategory" name="vehicleCategory">
                                                <label for="vehicleCategory">Vehicle Category</label>
                                                <span class="helper-text" id='CV-entry-form_vehicleCategory_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="engineNumber" name="engineNumber">
                                                <label for="engineNumber">Engine Number</label>
                                                <span class="helper-text" id='CV-entry-form_engineNumber_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="chassisNumber" name="chassisNumber">
                                                <label for="chassisNumber">Chassis Number</label>
                                                <span class="helper-text" id='CV-entry-form_chassisNumber_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="bodyType" name="bodyType">
                                                <label for="bodyType">Body Type</label>
                                                <span class="helper-text" id='CV-entry-form_bodyType_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="ladenWeight" name="ladenWeight">
                                                <label for="ladenWeight">Laden Weight</label>
                                                <span class="helper-text" id='CV-entry-form_ladenWeight_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="unladenWeight" name="unladenWeight">
                                                <label for="unladenWeight">Unladen Weight</label>
                                                <span class="helper-text" id='CV-entry-form_unladenWeight_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="sleeperCapacity" name="sleeperCapacity">
                                                <label for="sleeperCapacity">Sleeper Capacity</label>
                                                <span class="helper-text" id='CV-entry-form_sleeperCapacity_errorloc'></span>
                                            </div>
                                        </div>
                                        <h2 class="col-12">Insurance Details</h2>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="insuranceType" name="insuranceType">
                                                <label for="insuranceType">Insurance Type</label>
                                                <span class="helper-text" id='CV-entry-form_insuranceType_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="insuranceCompany" name="insuranceCompany">
                                                <label for="insuranceCompany">Insurance Company</label>
                                                <span class="helper-text" id='CV-entry-form_insuranceCompany_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="datepicker" id="insuranceFrom" name="insuranceFrom">
                                                <label for="insuranceFrom">Insurance From</label>
                                                <span class="helper-text" id='CV-entry-form_insuranceFrom_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="datepicker" id="InsuranceUpTo" name="InsuranceUpTo">
                                                <label for="InsuranceUpTo">Insurance UpTo</label>
                                                <span class="helper-text" id='CV-entry-form_InsuranceUpTo_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="insuranceValue" name="insuranceValue">
                                                <label for="insuranceValue">Insurance Declared Value</label>
                                                <span class="helper-text" id='CV-entry-form_insuranceValue_errorloc'></span>
                                            </div>
                                        </div>
                                        <h2 class="col-12">Tax Details</h2>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="taxAmount" name="taxAmount">
                                                <label for="taxAmount">Tax Amount</label>
                                                <span class="helper-text" id='CV-entry-form_taxAmount_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="datepicker" id="taxRecipientDate" name="taxRecipientDate">
                                                <label for="taxRecipientDate">Tax Receipient Date</label>
                                                <span class="helper-text" id='CV-entry-form_taxRecipientDate_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="taxUpTo" name="taxUpTo">
                                                <label for="taxUpTo">Tax UpTo</label>
                                                <span class="helper-text" id='CV-entry-form_taxUpTo_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="taxClearUpTo" name="taxClearUpTo">
                                                <label for="taxClearUpTo">Tax Clear Upto</label>
                                                <span class="helper-text" id='CV-entry-form_taxClearUpTo_errorloc'></span>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <!-- SECTION 3 -->
                                <h3><span class="step-icon">03</span></h3>
                                <section>
                                    <div class="row button-wrapper">
                                        <h2 class="col-12">Test Drive Results</h2>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TDEngineCondition" id="TDEngineCondition">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="TDEngineCondition">Engine Condition</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TDClutch" id="TDClutch">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="TDClutch">Clutch Condition</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TDAccelerator" id="TDAccelerator">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="TDAccelerator">Accelerator</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TDGearShiftRatios" id="TDGearShiftRatios">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="TDGearShiftRatios">Gear shift ratios</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TDStearing" id="TDStearing">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="TDStearing">Stearing Condition</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TDBreaking" id="TDBreaking">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="TDBreaking">Breaking Condition</label>
                                            </div>
                                        </div>
                                        <!-- up until here both are same -->
                                        <h2 class="col-12">Cabin Condition</h2>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="CabinFrontBumper" id="CabinFrontBumper">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="CabinFrontBumper">Front Bumper</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="CabinRearBumper" id="CabinRearBumper">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="CabinRearBumper">Rear Bumper</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="CabinRightDoor" id="CabinRightDoor">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="CabinRightDoor">Right Door</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="CabinLeftDoor" id="CabinLeftDoor">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="CabinLeftDoor">Left Door</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="CabinDashboardCondition" id="CabinDashboardCondition">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="CabinDashboardCondition">Dashboard Condition</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="CabinDriverSeat" id="CabinDriverSeat">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="CabinDriverSeat">Driver Seat Condition</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="CabinCoDriverSeat" id="CabinCoDriverSeat">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="CabinCoDriverSeat">Co-Driver Seat Condition</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="CabinThirdRow" id="CabinThirdRow">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="CabinThirdRow">Third Row Seat Condition</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="CabinABS" id="CabinABS">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="CabinABS">ABS Condition</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="CabinRadiator" id="CabinRadiator">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="CabinRadiator">Radiator Condition</label>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <!-- SECTION 4 -->
                                <h3><span class="step-icon">04</span></h3>
                                <section>
                                    <div class="row button-wrapper">
                                        <h2 class="col-12">Vehicle Body Details</h2>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="LBType" id="LBType">
                                                    <option value="Company body" selected>Company body</option>
                                                    <option value="Normal body">Normal body</option>
                                                    <option value="Local body">Local body</option>
                                                </select>
                                                <label for="LBType">Load body type</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="LBBuild" id="LBBuild">
                                                    <option value="High side deck" selected>High side deck</option>
                                                    <option value="Fixed side deck">Fixed side deck</option>
                                                    <option value="Drop side deck">Drop side deck</option>
                                                    <option value="Half deck load">Half deck load</option>
                                                    <option value="Flat deck trailer">Flat deck trailer</option>
                                                    <option value="Cabin chassis deck">Cabin chassis deck</option>
                                                    <option value="Fully built">Fully built</option>
                                                </select>
                                                <label for="LBBuild">Load Body Build</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="LBLeftSideGate" id="LBLeftSideGate">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="LBLeftSideGate">Left Side Gate</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="LBRightSideGate" id="LBRightSideGate">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="LBRightSideGate">Right Side Gate</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="LBLoadFloor" id="LBLoadFloor">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="LBLoadFloor">Load Floor</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="LBOverallLoadBody" id="LBOverallLoadBody">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="LBOverallLoadBody">Overall Load Body</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="LBBodyPaint" id="LBBodyPaint">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="LBBodyPaint">Body Paint</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="LBFuelTank" id="LBFuelTank">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="LBFuelTank">Fuel Tank</label>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <!-- SECTION 5 -->
                                <h3><span class="step-icon">05</span></h3>
                                <section>
                                    <div class="row button-wrapper">
                                        <h2 class="col-12">Exterior Conditions</h2>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="ExCHeadLight" id="ExCHeadLight">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="ExCHeadLight">Head Light</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="ExCRearTailLight" id="ExCRearTailLight">
                                                    <option value="Working" selected>Working</option>
                                                    <option value="Not Working">Not Working</option>
                                                </select>
                                                <label for="ExCRearTailLight">Rear Tail Light</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="ExCHood" id="ExCHood">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="ExCHood">Hood</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="ExCLeftFender" id="ExCLeftFender">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="ExCLeftFender">Left Fender</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="ExCRightFender" id="ExCRightFender">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="ExCRightFender">Right Fender</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="ExCWindshield" id="ExCWindshield">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="ExCWindshield">Windshield</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="ExCChassisCondition" id="ExCChassisCondition">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="ExCChassisCondition">Chassis Condition</label>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <!-- SECTION 6 -->
                                <h3><span class="step-icon">06</span></h3>
                                <section>
                                    <div class="row button-wrapper">
                                        <h2 class="col-12">Electrical Functions</h2>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="ECEletricalCondition" id="ECEletricalCondition">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="ECEletricalCondition">Electrical Condition</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="ECBatteryCondition" id="ECBatteryCondition">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="ECBatteryCondition">Battery Condition</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="ECACCooling" id="ECACCooling">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="ECACCooling">A/C Cooling</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="ECPowerWindow" id="ECPowerWindow">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="ECPowerWindow">Power Window Condition</label>
                                            </div>
                                        </div>
                                        <h2 class="col-12">HVAC/Cooling</h2>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="ECACRefrigrationUnit" id="ECACRefrigrationUnit">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="ECACRefrigrationUnit">Refrigration Unit Fitted In Load Vehicle</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="ECACHvacCooling" id="ECACHvacCooling">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="ECACHvacCooling">HVAC Cooling</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="ECACHeaterBlowerFan" id="ECACHeaterBlowerFan">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="ECACHeaterBlowerFan">A/C / Heater / Blower Fan</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="ECElectricCoolingFan" id="ECElectricCoolingFan">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="ECElectricCoolingFan">Electric Cooling Fan</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="ECCoolingSystemRadiator" id="ECCoolingSystemRadiator">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="ECCoolingSystemRadiator">Cooling System / Radiator</label>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <!-- SECTION 7 -->
                                <h3><span class="step-icon">07</span></h3>
                                <section>
                                    <div class="row button-wrapper">
                                        <h2 class="col-12">Stearing Conditions</h2>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="SCSteeringPlay" id="SCSteeringPlay">
                                                    <option value="Yes" selected>Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                                <label for="SCSteeringPlay">Stearing Play</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="SCPowerSteering" id="SCPowerSteering">
                                                    <option value="Working" selected>Working</option>
                                                    <option value="Not Working">Not Working</option>
                                                </select>
                                                <label for="SCPowerSteering">Power Steering</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="SCStearing" id="SCStearing">
                                                    <option value="Power" selected>Power</option>
                                                    <option value="Manual">Manual</option>
                                                </select>
                                                <label for="SCStearing">Steering</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="SCSteeringCondition" id="SCSteeringCondition">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="SCSteeringCondition">Stearing Conditons</label>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <!-- SECTION 8 -->
                                <h3><span class="step-icon">08</span></h3>
                                <section>
                                    <div class="row button-wrapper">
                                        <h2 class="col-12">Mechanical Conditions</h2>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="MCEngineCondition" id="MCEngineCondition">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="MCEngineCondition">Engine Condition</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="MCEngineRunning" id="MCEngineRunning">
                                                    <option value="Yes" selected>Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                                <label for="MCEngineRunning">Engine Running</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="MCEngineOilLevel" id="MCEngineOilLevel">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="MCEngineOilLevel">Engine Oil Level</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="MCEngineOilFunction" id="MCEngineOilFunction">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="MCEngineOilFunction">Engine Oil Functions</label>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <!-- SECTION 9 -->
                                <h3><span class="step-icon">09</span></h3>
                                <section>
                                    <div class="row button-wrapper">
                                        <h2 class="col-12">Transmission Conditions</h2>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TCTransmissionCondition" id="TCTransmissionCondition">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="TCTransmissionCondition">Transmission / Gear Box Condition</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TCTransmissionWorking" id="TCTransmissionWorking">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="TCTransmissionWorking">Transmission Working </label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TCFrontSuspension" id="TCFrontSuspension">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="TCFrontSuspension">Front Suspension</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TCRearSuspension" id="TCRearSuspension">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="TCRearSuspension">Rear Suspension</label>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <!-- SECTION 10 -->
                                <h3><span class="step-icon">10</span></h3>
                                <section>
                                    <div class="row button-wrapper">
                                        <h2 class="col-12">Tyre Conditions</h2>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate required" id="TCNofTyres" name="TCNofTyres">
                                                <label for="TCNofTyres">No of Tyres</label>
                                                <span class="helper-text" id='CV-entry-form_TCNofTyres_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TCFrontLeftTyresCondition" id="TCFrontLeftTyresCondition">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="TCFrontLeftTyresCondition">Front Left Tyres Condition</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TCFrontRightTyresCondition" id="TCFrontRightTyresCondition">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="TCFrontRightTyresCondition">Front Right Tyres Condition</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TCRearLeftTyresCondition" id="TCRearLeftTyresCondition">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="TCRearLeftTyresCondition">Rear Left Tyres Condition</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TCRearRightTyresCondition" id="TCRearRightTyresCondition">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="TCRearRightTyresCondition">Rear Right Tyres Condition</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TCSpareTyresCondition" id="TCSpareTyresCondition">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="TCSpareTyresCondition">Spare Tyres Condition</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TCTyre5Condition" id="TCTyre5Condition">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="TCTyre5Condition">Tyre 5 Condition</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TCTyre6Condition" id="TCTyre6Condition">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="TCTyre6Condition">Tyre 6 Condition</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TCTyre7Condition" id="TCTyre7Condition">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="TCTyre7Condition">Tyre 7 Condition</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TCTyre8Condition" id="TCTyre8Condition">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="TCTyre8Condition">Tyre 8 Condition</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TCTyre9Condition" id="TCTyre9Condition">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="TCTyre9Condition">Tyre 9 Condition</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TCTyre10Condition" id="TCTyre10Condition">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="TCTyre10Condition">Tyre 10 Condition</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TCFrontLeftWheelLife" id="TCFrontLeftWheelLife">
                                                    <option value="10" selected>10</option>
                                                    <option value="20">20</option>
                                                    <option value="30">30</option>
                                                    <option value="40">40</option>
                                                    <option value="50">50</option>
                                                    <option value="60">60</option>
                                                    <option value="70">70</option>
                                                    <option value="80">80</option>
                                                    <option value="90">90</option>
                                                    <option value="Available">Available</option>
                                                    <option value="Not Available">Not Available</option>
                                                </select>
                                                <label for="TCFrontLeftWheelLife">Front Left Tyre Life</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TCFrontRightWheelLife" id="TCFrontRightWheelLife">
                                                    <option value="10" selected>10</option>
                                                    <option value="20">20</option>
                                                    <option value="30">30</option>
                                                    <option value="40">40</option>
                                                    <option value="50">50</option>
                                                    <option value="60">60</option>
                                                    <option value="70">70</option>
                                                    <option value="80">80</option>
                                                    <option value="90">90</option>
                                                    <option value="Available">Available</option>
                                                    <option value="Not Available">Not Available</option>
                                                </select>
                                                <label for="TCFrontRightWheelLife">Front Right Tyre Life</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TCRearLeftWheelLife" id="TCRearLeftWheelLife">
                                                    <option value="10" selected>10</option>
                                                    <option value="20">20</option>
                                                    <option value="30">30</option>
                                                    <option value="40">40</option>
                                                    <option value="50">50</option>
                                                    <option value="60">60</option>
                                                    <option value="70">70</option>
                                                    <option value="80">80</option>
                                                    <option value="90">90</option>
                                                    <option value="Available">Available</option>
                                                    <option value="Not Available">Not Available</option>
                                                </select>
                                                <label for="TCRearLeftWheelLife">Rear Left Tyre Life</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TCRearRightWheelLife" id="TCRearRightWheelLife">
                                                    <option value="10" selected>10</option>
                                                    <option value="20">20</option>
                                                    <option value="30">30</option>
                                                    <option value="40">40</option>
                                                    <option value="50">50</option>
                                                    <option value="60">60</option>
                                                    <option value="70">70</option>
                                                    <option value="80">80</option>
                                                    <option value="90">90</option>
                                                    <option value="Available">Available</option>
                                                    <option value="Not Available">Not Available</option>
                                                </select>
                                                <label for="TCRearRightWheelLife">Rear Right Tyre Life</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TCSpareWheelLife" id="TCSpareWheelLife">
                                                    <option value="10" selected>10</option>
                                                    <option value="20">20</option>
                                                    <option value="30">30</option>
                                                    <option value="40">40</option>
                                                    <option value="50">50</option>
                                                    <option value="60">60</option>
                                                    <option value="70">70</option>
                                                    <option value="80">80</option>
                                                    <option value="90">90</option>
                                                    <option value="Available">Available</option>
                                                    <option value="Not Available">Not Available</option>
                                                </select>
                                                <label for="TCSpareWheelLife">Spare Wheel Life</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TCTyre5Life" id="TCTyre5Life">
                                                    <option value="10" selected>10</option>
                                                    <option value="20">20</option>
                                                    <option value="30">30</option>
                                                    <option value="40">40</option>
                                                    <option value="50">50</option>
                                                    <option value="60">60</option>
                                                    <option value="70">70</option>
                                                    <option value="80">80</option>
                                                    <option value="90">90</option>
                                                    <option value="Available">Available</option>
                                                    <option value="Not Available">Not Available</option>
                                                </select>
                                                <label for="TCTyre5Life">Tyre 5 Life</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TCTyre6Life" id="TCTyre6Life">
                                                    <option value="10" selected>10</option>
                                                    <option value="20">20</option>
                                                    <option value="30">30</option>
                                                    <option value="40">40</option>
                                                    <option value="50">50</option>
                                                    <option value="60">60</option>
                                                    <option value="70">70</option>
                                                    <option value="80">80</option>
                                                    <option value="90">90</option>
                                                    <option value="Available">Available</option>
                                                    <option value="Not Available">Not Available</option>
                                                </select>
                                                <label for="TCTyre6Life">Tyre 6 Life</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TCTyre7Life" id="TCTyre7Life">
                                                    <option value="10" selected>10</option>
                                                    <option value="20">20</option>
                                                    <option value="30">30</option>
                                                    <option value="40">40</option>
                                                    <option value="50">50</option>
                                                    <option value="60">60</option>
                                                    <option value="70">70</option>
                                                    <option value="80">80</option>
                                                    <option value="90">90</option>
                                                    <option value="Available">Available</option>
                                                    <option value="Not Available">Not Available</option>
                                                </select>
                                                <label for="TCTyre7Life">Tyre 7 Life</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TCTyre8Life" id="TCTyre8Life">
                                                    <option value="10" selected>10</option>
                                                    <option value="20">20</option>
                                                    <option value="30">30</option>
                                                    <option value="40">40</option>
                                                    <option value="50">50</option>
                                                    <option value="60">60</option>
                                                    <option value="70">70</option>
                                                    <option value="80">80</option>
                                                    <option value="90">90</option>
                                                    <option value="Available">Available</option>
                                                    <option value="Not Available">Not Available</option>
                                                </select>
                                                <label for="TCTyre8Life">Tyre 8 Life</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TCTyre9Life" id="TCTyre9Life">
                                                    <option value="10" selected>10</option>
                                                    <option value="20">20</option>
                                                    <option value="30">30</option>
                                                    <option value="40">40</option>
                                                    <option value="50">50</option>
                                                    <option value="60">60</option>
                                                    <option value="70">70</option>
                                                    <option value="80">80</option>
                                                    <option value="90">90</option>
                                                    <option value="Available">Available</option>
                                                    <option value="Not Available">Not Available</option>
                                                </select>
                                                <label for="TCTyre9Life">Tyre 9 Life</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TCTyre10Life" id="TCTyre10Life">
                                                    <option value="10" selected>10</option>
                                                    <option value="20">20</option>
                                                    <option value="30">30</option>
                                                    <option value="40">40</option>
                                                    <option value="50">50</option>
                                                    <option value="60">60</option>
                                                    <option value="70">70</option>
                                                    <option value="80">80</option>
                                                    <option value="90">90</option>
                                                    <option value="Available">Available</option>
                                                    <option value="Not Available">Not Available</option>
                                                </select>
                                                <label for="TCTyre10Life">Tyre 10 Life</label>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <!-- SECTION 11 -->
                                <h3><span class="step-icon">11</span></h3>
                                <section>
                                    <div class="row button-wrapper">
                                        <h2 class="col-12">Images Upload</h2>
                                        <p class="col-12">
                                            Note: The image file size should not exceeed 5 mb. If the size is bigger go to this <a href="https://tinypng.com/">Link</a> to compress the image.
                                        </p>
                                        <div class="col-12">
                                            <div class="file-field input-field">
                                                <div class="btn">
                                                    <span>Upload</span>
                                                    <input type="file" name="CVAvatarImage">
                                                </div>
                                                <div class="file-path-wrapper">
                                                    <input class="file-path validate" type="text" placeholder="CV Avatar">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="file-field input-field">
                                                <div class="btn">
                                                    <span>Upload</span>
                                                    <input type="file" name="chassisImprintImage">
                                                </div>
                                                <div class="file-path-wrapper">
                                                    <input class="file-path validate" type="text" placeholder="Chassis Imprint">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="file-field input-field">
                                                <div class="btn">
                                                    <span>Upload</span>
                                                    <input type="file" name="CVFrontImage">
                                                </div>
                                                <div class="file-path-wrapper">
                                                    <input class="file-path validate" type="text" placeholder="Vehicle Front View">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="file-field input-field">
                                                <div class="btn">
                                                    <span>Upload</span>
                                                    <input type="file" name="CVRightImage">
                                                </div>
                                                <div class="file-path-wrapper">
                                                    <input class="file-path validate" type="text" placeholder="Vehicle Right View">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="file-field input-field">
                                                <div class="btn">
                                                    <span>Upload</span>
                                                    <input type="file" name="CVRearImage">
                                                </div>
                                                <div class="file-path-wrapper">
                                                    <input class="file-path validate" type="text" placeholder="Vehicle Rear View">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="file-field input-field">
                                                <div class="btn">
                                                    <span>Upload</span>
                                                    <input type="file" name="CVLeftImage">
                                                </div>
                                                <div class="file-path-wrapper">
                                                    <input class="file-path validate" type="text" placeholder="Vehicle Left View">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="file-field input-field">
                                                <div class="btn">
                                                    <span>Upload</span>
                                                    <input type="file" name="dashboardImage">
                                                </div>
                                                <div class="file-path-wrapper">
                                                    <input class="file-path validate" type="text" placeholder="Dashboard">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="file-field input-field">
                                                <div class="btn">
                                                    <span>Upload</span>
                                                    <input type="file" name="odometerImage">
                                                </div>
                                                <div class="file-path-wrapper">
                                                    <input class="file-path validate" type="text" placeholder="Odometer">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="file-field input-field">
                                                <div class="btn">
                                                    <span>Upload</span>
                                                    <input type="file" name="insideCabinImage">
                                                </div>
                                                <div class="file-path-wrapper">
                                                    <input class="file-path validate" type="text" placeholder="Inside Cabin">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="file-field input-field">
                                                <div class="btn">
                                                    <span>Upload</span>
                                                    <input type="file" name="engineRoomImage">
                                                </div>
                                                <div class="file-path-wrapper">
                                                    <input class="file-path validate" type="text" placeholder="Engine Room">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="file-field input-field">
                                                <div class="btn">
                                                    <span>Upload</span>
                                                    <input type="file" name="regPlateImage">
                                                </div>
                                                <div class="file-path-wrapper">
                                                    <input class="file-path validate" type="text" placeholder="Registration Plate">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="file-field input-field">
                                                <div class="btn">
                                                    <span>Upload</span>
                                                    <input type="file" name="chassisNoImage">
                                                </div>
                                                <div class="file-path-wrapper">
                                                    <input class="file-path validate" type="text" placeholder="Chassis No">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="file-field input-field">
                                                <div class="btn">
                                                    <span>Upload</span>
                                                    <input type="file" name="rcFrontImage">
                                                </div>
                                                <div class="file-path-wrapper">
                                                    <input class="file-path validate" type="text" placeholder="RC Front">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="file-field input-field">
                                                <div class="btn">
                                                    <span>Upload</span>
                                                    <input type="file" name="rcBackImage">
                                                </div>
                                                <div class="file-path-wrapper">
                                                    <input class="file-path validate" type="text" placeholder="RC Back">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="file-field input-field">
                                                <div class="btn">
                                                    <span>Upload</span>
                                                    <input type="file" name="tyre1Image">
                                                </div>
                                                <div class="file-path-wrapper">
                                                    <input class="file-path validate" type="text" placeholder="Tyre 1">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="file-field input-field">
                                                <div class="btn">
                                                    <span>Upload</span>
                                                    <input type="file" name="tyre2Image">
                                                </div>
                                                <div class="file-path-wrapper">
                                                    <input class="file-path validate" type="text" placeholder="Tyre 2">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="file-field input-field">
                                                <div class="btn">
                                                    <span>Upload</span>
                                                    <input type="file" name="tyre3Image">
                                                </div>
                                                <div class="file-path-wrapper">
                                                    <input class="file-path validate" type="text" placeholder="Tyre 3">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="file-field input-field">
                                                <div class="btn">
                                                    <span>Upload</span>
                                                    <input type="file" name="tyre4Image">
                                                </div>
                                                <div class="file-path-wrapper">
                                                    <input class="file-path validate" type="text" placeholder="Tyre 4">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="file-field input-field">
                                                <div class="btn">
                                                    <span>Upload</span>
                                                    <input type="file" name="tyre5Image">
                                                </div>
                                                <div class="file-path-wrapper">
                                                    <input class="file-path validate" type="text" placeholder="Tyre 5">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="file-field input-field">
                                                <div class="btn">
                                                    <span>Upload</span>
                                                    <input type="file" name="tyre6Image">
                                                </div>
                                                <div class="file-path-wrapper">
                                                    <input class="file-path validate" type="text" placeholder="Tyre 6">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="file-field input-field">
                                                <div class="btn">
                                                    <span>Upload</span>
                                                    <input type="file" name="tyre7Image">
                                                </div>
                                                <div class="file-path-wrapper">
                                                    <input class="file-path validate" type="text" placeholder="Tyre 7">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="file-field input-field">
                                                <div class="btn">
                                                    <span>Upload</span>
                                                    <input type="file" name="tyre8Image">
                                                </div>
                                                <div class="file-path-wrapper">
                                                    <input class="file-path validate" type="text" placeholder="Tyre 8">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="file-field input-field">
                                                <div class="btn">
                                                    <span>Upload</span>
                                                    <input type="file" name="tyre9Image">
                                                </div>
                                                <div class="file-path-wrapper">
                                                    <input class="file-path validate" type="text" placeholder="Tyre 9">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="file-field input-field">
                                                <div class="btn">
                                                    <span>Upload</span>
                                                    <input type="file" name="tyre10Image">
                                                </div>
                                                <div class="file-path-wrapper">
                                                    <input class="file-path validate" type="text" placeholder="Tyre 10">
                                                </div>
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <script type="text/javascript" src="./assets/lib/plugins/jquery.steps.min.js"></script>
    <script type="text/javascript" src="./assets/js/CVEntry.js"></script>
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
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>

</html>