<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/php-scripts/main.php';
$main = new Main();
$user = $main->loginCheck();
if (!$user) {
    header("location:index.php");
    die();
} else {
    $username = $_SESSION['user']['username'];
    $usertype = $_SESSION['user']['usertype'];
}
$upload = 'err';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $registrationResponse = $main->registerFourwheeler();
        if (!empty($registrationResponse["status"])) {
            if ($registrationResponse["status"] == "success") {
                $upload = 'ok';
            } else {
                $upload = $registrationResponse["message"];
            }
        }
    } catch (Exception $e) {
        $upload = $e->getMessage();
    }
    echo $upload;
    exit;
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
    <title>Four wheeler entry | Fast value inspection</title>
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
                    <h2 class="d-none d-lg-block m-0">Four wheeler entry</h2>
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
                        <div class="loading-overlay">
                            <div class="text-center w-100" style="padding: 0 10rem;">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%">
                                    </div>
                                </div>
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
                        </div>
                        <div id="error" class="alert alert-danger alert-dismissible fade show" role="alert">
                            <span id="error-msg"></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div id="success" class="alert alert-success alert-dismissible fade show" role="alert">
                            <span id="success-msg"></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="four-wheeler-entry-form" name="four-wheeler-entry-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
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
                                                <span class="helper-text" id='four-wheeler-entry-form_repId_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="datepicker" id="inspectionDate" name="inspectionDate">
                                                <label for="inspectionDate">Inspection date</label>
                                                <span class="helper-text" id='four-wheeler-entry-form_inspectionDate_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate required" id="loanNo" name="loanNo">
                                                <label for="loanNo">Loan No</label>
                                                <span class="helper-text" id='four-wheeler-entry-form_loanNo_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="location" name="location">
                                                <label for="location">Location</label>
                                                <span class="helper-text" id='four-wheeler-entry-form_location_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate required" id="vehicleMake" name="vehicleMake">
                                                <label for="vehicleMake">Make</label>
                                                <span class="helper-text" id='four-wheeler-entry-form_vehicleMake_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate required" id="vehicleModel" name="vehicleModel">
                                                <label for="vehicleModel">Model</label>
                                                <span class="helper-text" id='four-wheeler-entry-form_vehicleModel_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate required" id="vehicleVariant" name="vehicleVariant">
                                                <label for="vehicleVariant">Variant</label>
                                                <span class="helper-text" id='four-wheeler-entry-form_vehicleVariant_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="vehicleRegNo" name="vehicleRegNo">
                                                <label for="vehicleRegNo">Registration No</label>
                                                <span class="helper-text" id='four-wheeler-entry-form_vehicleRegNo_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="datepicker" id="vehicleRegDate" name="vehicleRegDate">
                                                <label for="vehicleRegDate">Registration date</label>
                                                <span class="helper-text" id='four-wheeler-entry-form_vehicleRegDate_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="ownerName" name="ownerName">
                                                <label for="ownerName">Owner Name</label>
                                                <span class="helper-text" id='four-wheeler-entry-form_ownerName_errorloc'></span>
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
                                                <span class="helper-text" id='four-wheeler-entry-form_manufacturedYear_errorloc'></span>
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
                                                <span class="helper-text" id='four-wheeler-entry-form_vehicleInsuranceDate_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="odometerReading" name="odometerReading">
                                                <label for="odometerReading">Odometer Reading</label>
                                                <span class="helper-text" id='four-wheeler-entry-form_odometerReading_errorloc'></span>
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
                                                <span class="helper-text" id='four-wheeler-entry-form_hpaStatus_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="hpaBank" name="hpaBank">
                                                <label for="hpaBank">HPA Bank</label>
                                                <span class="helper-text" id='four-wheeler-entry-form_hpaBank_errorloc'></span>
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
                                                <span class="helper-text" id='four-wheeler-entry-form_vehicleColor_errorloc'></span>
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
                                                <span class="helper-text" id='four-wheeler-entry-form_reportRequestedBy_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="valuationPrice" name="valuationPrice">
                                                <label for="valuationPrice">Valuation Price</label>
                                                <span class="helper-text" id='four-wheeler-entry-form_valuationPrice_errorloc'></span>
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
                                                <span class="helper-text" id='four-wheeler-entry-form_parivahanOwnerName_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="parivahanMaker" name="parivahanMaker">
                                                <label for="parivahanMaker">Maker</label>
                                                <span class="helper-text" id='four-wheeler-entry-form_parivahanMaker_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="parivahanModel" name="parivahanModel">
                                                <label for="parivahanModel">Model</label>
                                                <span class="helper-text" id='four-wheeler-entry-form_parivahanModel_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="parivahanManufacturedYear" name="parivahanManufacturedYear">
                                                <label for="parivahanManufacturedYear">Manufactured Year</label>
                                                <span class="helper-text" id='four-wheeler-entry-form_parivahanManufacturedYear_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="datepicker" id="parivahanRegDate" name="parivahanRegDate">
                                                <label for="parivahanRegDate">Registration date</label>
                                                <span class="helper-text" id='four-wheeler-entry-form_parivahanRegDate_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="vehicleCategory" name="vehicleCategory">
                                                <label for="vehicleCategory">Vehicle Category</label>
                                                <span class="helper-text" id='four-wheeler-entry-form_vehicleCategory_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="engineNumber" name="engineNumber">
                                                <label for="engineNumber">Engine Number</label>
                                                <span class="helper-text" id='four-wheeler-entry-form_engineNumber_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="chassisNumber" name="chassisNumber">
                                                <label for="chassisNumber">Chassis Number</label>
                                                <span class="helper-text" id='four-wheeler-entry-form_chassisNumber_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="bodyType" name="bodyType">
                                                <label for="bodyType">Body Type</label>
                                                <span class="helper-text" id='four-wheeler-entry-form_bodyType_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="ladenWeight" name="ladenWeight">
                                                <label for="ladenWeight">Laden Weight</label>
                                                <span class="helper-text" id='four-wheeler-entry-form_ladenWeight_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="unladenWeight" name="unladenWeight">
                                                <label for="unladenWeight">Unladen Weight</label>
                                                <span class="helper-text" id='four-wheeler-entry-form_unladenWeight_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="sleeperCapacity" name="sleeperCapacity">
                                                <label for="sleeperCapacity">Sleeper Capacity</label>
                                                <span class="helper-text" id='four-wheeler-entry-form_sleeperCapacity_errorloc'></span>
                                            </div>
                                        </div>
                                        <h2 class="col-12">Insurance Details</h2>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="insuranceType" name="insuranceType">
                                                <label for="insuranceType">Insurance Type</label>
                                                <span class="helper-text" id='four-wheeler-entry-form_insuranceType_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="insuranceCompany" name="insuranceCompany">
                                                <label for="insuranceCompany">Insurance Company</label>
                                                <span class="helper-text" id='four-wheeler-entry-form_insuranceCompany_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="datepicker" id="insuranceFrom" name="insuranceFrom">
                                                <label for="insuranceFrom">Insurance From</label>
                                                <span class="helper-text" id='four-wheeler-entry-form_insuranceFrom_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="datepicker" id="InsuranceUpTo" name="InsuranceUpTo">
                                                <label for="InsuranceUpTo">Insurance UpTo</label>
                                                <span class="helper-text" id='four-wheeler-entry-form_InsuranceUpTo_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="insuranceValue" name="insuranceValue">
                                                <label for="insuranceValue">Insurance Declared Value</label>
                                                <span class="helper-text" id='four-wheeler-entry-form_insuranceValue_errorloc'></span>
                                            </div>
                                        </div>
                                        <h2 class="col-12">Tax Details</h2>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="taxAmount" name="taxAmount">
                                                <label for="taxAmount">Tax Amount</label>
                                                <span class="helper-text" id='four-wheeler-entry-form_taxAmount_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="datepicker" id="taxRecipientDate" name="taxRecipientDate">
                                                <label for="taxRecipientDate">Tax Receipient Date</label>
                                                <span class="helper-text" id='four-wheeler-entry-form_taxRecipientDate_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="taxUpTo" name="taxUpTo">
                                                <label for="taxUpTo">Tax UpTo</label>
                                                <span class="helper-text" id='four-wheeler-entry-form_taxUpTo_errorloc'></span>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <input type="text" class="validate" id="taxClearUpTo" name="taxClearUpTo">
                                                <label for="taxClearUpTo">Tax Clear Upto</label>
                                                <span class="helper-text" id='four-wheeler-entry-form_taxClearUpTo_errorloc'></span>
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
                                    </div>
                                </section>
                                <!-- up until here both are same -->
                                <!-- SECTION 4 -->
                                <h3><span class="step-icon">04</span></h3>
                                <section>
                                    <div class="row button-wrapper">
                                        <h2 class="col-12">Exterior Conditions</h2>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="ExCGrill" id="ExCGrill">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="ExCGrill">Grill</label>
                                            </div>
                                        </div>
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
                                                <select name="ExCFrontBumper" id="ExCFrontBumper">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="ExCFrontBumper">Front Bumper</label>
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
                                                <select name="ExCLeftQuarter" id="ExCLeftQuarter">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="ExCLeftQuarter">Left Quarter</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="ExCRightQuarter" id="ExCRightQuarter">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="ExCRightQuarter">Right Quarter</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="ExCFrontWindshield" id="ExCFrontWindshield">
                                                    <option value="Original" selected>Original</option>
                                                    <option value="Duplicate">Duplicate</option>
                                                </select>
                                                <label for="ExCFrontWindshield">Front Windshield</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="ExCRightFrontDoor" id="ExCRightFrontDoor">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="ExCRightFrontDoor">Right Front Door</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="ExCLeftFrontDoor" id="ExCLeftFrontDoor">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="ExCLeftFrontDoor">Left Front Door</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="ExCRightRearDoor" id="ExCRightRearDoor">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="ExCRightRearDoor">Right Rear Door</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="ExCLeftRearDoor" id="ExCLeftRearDoor">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="ExCLeftRearDoor">Left Rear Door</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="ExCRoof" id="ExCRoof">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="ExCRoof">Roof</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="ExCRearWindShield" id="ExCRearWindShield">
                                                    <option value="Original" selected>Original</option>
                                                    <option value="Duplicate">Duplicate</option>
                                                </select>
                                                <label for="ExCRearWindShield">Rear Windshield</label>
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
                                                <select name="ExCRearBumper" id="ExCRearBumper">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="ExCRearBumper">Rear Bumper</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="ExCBodyPaint" id="ExCBodyPaint">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="ExCBodyPaint">Body Paint</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="ExCDeckLid" id="ExCDeckLid">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="ExCDeckLid">Deck LID</label>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <!-- SECTION 5 -->
                                <h3><span class="step-icon">05</span></h3>
                                <section>
                                    <div class="row button-wrapper">
                                        <h2 class="col-12">Interior Conditions</h2>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="InTDashboardCondition" id="InTDashboardCondition">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="InTDashboardCondition">Dashboard Condition</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="InTFrontLeftSeat" id="InTFrontLeftSeat">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="InTFrontLeftSeat">Front Left Seat</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="InTFrontRightSeat" id="InTFrontRightSeat">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="InTFrontRightSeat">Front Right Seat</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="InTRearLeftSeat" id="InTRearLeftSeat">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="InTRearLeftSeat">Rear Left Seat</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="InTRearRightSeat" id="InTRearRightSeat">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="InTRearRightSeat">Rear Right Seat</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="InTThirdRowSeatCondition" id="InTThirdRowSeatCondition">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="InTThirdRowSeatCondition">Third Row Seat Condition</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="InTTrunkCargo" id="InTTrunkCargo">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="InTTrunkCargo">Trunk Cargo Condition</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="InTCruiseControl" id="InTCruiseControl">
                                                    <option value="Available" selected>Available</option>
                                                    <option value="Not Available">Not Available</option>
                                                </select>
                                                <label for="InTCruiseControl">Cruise Control</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="InTAirbags" id="InTAirbags">
                                                    <option value="Available" selected>Available</option>
                                                    <option value="Not Available">Not Available</option>
                                                </select>
                                                <label for="InTAirbags">Air Bag</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="InTPowerWindow" id="InTPowerWindow">
                                                    <option value="Available" selected>Available</option>
                                                    <option value="Not Available">Not Available</option>
                                                </select>
                                                <label for="InTPowerWindow">Power Window</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="InTCarpetNFloorMat" id="InTCarpetNFloorMat">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="InTCarpetNFloorMat">Carpet & Floor mats</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="IntOdometerCondition" id="IntOdometerCondition">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="IntOdometerCondition">Odometer Condition</label>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <!-- SECTION 6 -->
                                <h3><span class="step-icon">06</span></h3>
                                <section>
                                    <div class="row button-wrapper">
                                        <h2 class="col-12">Vehicle Condition</h2>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="VCRunningCondition" id="VCRunningCondition">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="VCRunningCondition">Running Condition</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="VCEngineStart" id="VCEngineStart">
                                                    <option value="Starts" selected>Starts</option>
                                                    <option value="Does not start">Does not start</option>
                                                </select>
                                                <label for="VCEngineStart">Engine Start</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="VCTransmissionCondition" id="VCTransmissionCondition">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="VCTransmissionCondition">Transmission / Gear Box Condition</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="VCTransmissionWorking" id="VCTransmissionWorking">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="VCTransmissionWorking">Transmission Working </label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="VCGearShift" id="VCGearShift">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="VCGearShift">Gear Shift</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="VCFrontSuspension" id="VCFrontSuspension">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="VCFrontSuspension">Front Suspension</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="VCRearSuspension" id="VCRearSuspension">
                                                    <option value=5 selected>Very Good</option>
                                                    <option value=4>Good</option>
                                                    <option value=3>Average</option>
                                                    <option value=2>Bad</option>
                                                    <option value=1>Not Available</option>
                                                </select>
                                                <label for="VCRearSuspension">Rear Suspension</label>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <!-- SECTION 7 -->
                                <h3><span class="step-icon">07</span></h3>
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
                                <!-- SECTION 8 -->
                                <h3><span class="step-icon">08</span></h3>
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
                                <!-- SECTION 9 -->
                                <h3><span class="step-icon">09</span></h3>
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
                                <!-- SECTION 10 -->
                                <h3><span class="step-icon">10</span></h3>
                                <section>
                                    <div class="row button-wrapper">
                                        <h2 class="col-12">Tyre Conditions</h2>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TCNoOfTyres" id="TCNoOfTyres">
                                                    <option value=5 selected>5</option>
                                                    <option value=4>4</option>
                                                    <option value=3>3</option>
                                                    <option value=2>2</option>
                                                    <option value=1>1</option>
                                                </select>
                                                <label for="TCNoOfTyres">No Of Tyres</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TCFrontRightWheelType" id="TCFrontRightWheelType">
                                                    <option value="Rim" selected>Rim</option>
                                                    <option value="Alloy">Alloy</option>
                                                </select>
                                                <label for="TCFrontRightWheelType">Front Right Wheel Type</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TCFrontLeftWheelType" id="TCFrontLeftWheelType">
                                                    <option value="Rim" selected>Rim</option>
                                                    <option value="Alloy">Alloy</option>
                                                </select>
                                                <label for="TCFrontLeftWheelType">Front Left Wheel Type</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TCRearRightWheelType" id="TCRearRightWheelType">
                                                    <option value="Rim" selected>Rim</option>
                                                    <option value="Alloy">Alloy</option>
                                                </select>
                                                <label for="TCRearRightWheelType">Rear Right Wheel Type</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TCRearLeftWheelType" id="TCRearLeftWheelType">
                                                    <option value="Rim" selected>Rim</option>
                                                    <option value="Alloy">Alloy</option>
                                                </select>
                                                <label for="TCRearLeftWheelType">Rear Left Wheel Type</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TCSpareWheelType" id="TCSpareWheelType">
                                                    <option value="Rim" selected>Rim</option>
                                                    <option value="Alloy">Alloy</option>
                                                </select>
                                                <label for="TCSpareWheelType">Spare Wheel Type</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TCFrontLeftWheel" id="TCFrontLeftWheel">
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
                                                <label for="TCFrontLeftWheel">Front Left Tyre</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TCFrontRightWheel" id="TCFrontRightWheel">
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
                                                <label for="TCFrontRightWheel">Front Right Tyre</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TCRearLeftWheel" id="TCRearLeftWheel">
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
                                                <label for="TCRearLeftWheel">Rear Left Tyre</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TCRearRightWheel" id="TCRearRightWheel">
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
                                                <label for="TCRearRightWheel">Rear Right Tyre</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="input-field">
                                                <select name="TCSpareWheel" id="TCSpareWheel">
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
                                                <label for="TCSpareWheel">Spare Wheel</label>
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
                                                    <input type="file" name="carAvatarImage">
                                                </div>
                                                <div class="file-path-wrapper">
                                                    <input class="file-path validate" type="text" placeholder="Car Avatar">
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
                                                    <input type="file" name="carFrontImage">
                                                </div>
                                                <div class="file-path-wrapper">
                                                    <input class="file-path validate" type="text" placeholder="Car Front">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="file-field input-field">
                                                <div class="btn">
                                                    <span>Upload</span>
                                                    <input type="file" name="carRightImage">
                                                </div>
                                                <div class="file-path-wrapper">
                                                    <input class="file-path validate" type="text" placeholder="Car Right">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="file-field input-field">
                                                <div class="btn">
                                                    <span>Upload</span>
                                                    <input type="file" name="carRearImage">
                                                </div>
                                                <div class="file-path-wrapper">
                                                    <input class="file-path validate" type="text" placeholder="Car Rear">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-xl-3">
                                            <div class="file-field input-field">
                                                <div class="btn">
                                                    <span>Upload</span>
                                                    <input type="file" name="carLeftImage">
                                                </div>
                                                <div class="file-path-wrapper">
                                                    <input class="file-path validate" type="text" placeholder="Car Left">
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
                                                    <input type="file" name="gearAndSeatImage">
                                                </div>
                                                <div class="file-path-wrapper">
                                                    <input class="file-path validate" type="text" placeholder="Gear and Seat">
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
                                                    <input type="file" id="tyre4Image" name="tyre4Image">
                                                </div>
                                                <div class="file-path-wrapper">
                                                    <input class="file-path validate" type="text" placeholder="Tyre 4">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="targetLayer"></div>
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
    <script type="text/javascript" src="./assets/js/fourWheelerEntry.js"></script>
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
            $('.loading-overlay').hide();
            $('#error').hide();
            $('#success').hide();
            $("#four-wheeler-entry-form").on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = ((evt.loaded / evt.total) * 100);
                                var value = Math.round(percentComplete);
                                $(".progress-bar").css("width", `${value}%`);
                                $(".progress-bar").html(value + '%');
                            }
                        }, false);
                        return xhr;
                    },
                    type: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $(".progress-bar").css("width", '0%');
                        $('.loading-overlay').show();
                    },
                    error: function(resp) {
                        $('#error').show();
                        $('.loading-overlay').hide();
                        $('#error-msg').html(`<p style="color:#EA4335;">${resp}</p>`);
                    },
                    success: function(resp) {
                        if (resp == 'ok') {
                            $('.loading-overlay').hide();
                            $('#success').show();
                            $('#success-msg').html('<p>Four wheeler registered registered successfully.</p>');
                        } else {
                            $('#error').show();
                            $('.loading-overlay').hide();
                            $('#error-msg').html(`<p style="color:#EA4335;">${resp}</p>`);
                        }
                    }
                });
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