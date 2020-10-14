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
    $repId = $_GET['repId'];
    $vehicleType = $_GET['vehicleType'];
    $detailsResponse = $main->getVehicleDetails($repId, $vehicleType);
    $rating = array('', 'Not Available', 'Bad', 'Average', 'Good', 'Very Good');
}
function moneyFormatIndia($num)
{
    $explrestunits = "";
    if (strlen($num) > 3) {
        $lastthree = substr($num, strlen($num) - 3, strlen($num));
        $restunits = substr($num, 0, strlen($num) - 3); // extracts the last three digits
        $restunits = (strlen($restunits) % 2 == 1) ? "0" . $restunits : $restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
        $expunit = str_split($restunits, 2);
        for ($i = 0; $i < sizeof($expunit); $i++) {
            // creates each of the 2's group and adds a comma to the end
            if ($i == 0) {
                $explrestunits .= (int)$expunit[$i] . ","; // if is first value , convert into integer
            } else {
                $explrestunits .= $expunit[$i] . ",";
            }
        }
        $thecash = $explrestunits . $lastthree;
    } else {
        $thecash = $num;
    }
    return $thecash; // writes the final format where $currency is the currency symbol.
}
?>
<!DOCTYPE html>
<html lang="en" class="report">

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
    <title>Report | Fast value inspection</title>
</head>

<body>
    <?php
    if (!empty($detailsResponse["status"])) {
    ?>
        <?php
        if ($detailsResponse["status"] == "error") {
        ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $detailsResponse["message"]; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php
        } else if ($detailsResponse["status"] == "success") {
            $columns = $detailsResponse["message"];
            // $img = file_get_contents('./assets/images/logo.png');
            // $logo = base64_encode($img);
        ?>
            <div class="watermark">
                <img src="./assets/images/logo.png" />
            </div>
            <div class="page">
                <div class="subpage">
                    <!-- <img src="data:image/png;base64,<?php echo $logo; ?>" class="watermark" alt="logo" /> -->
                    <div class="row align-items-center justify-content-between mb-4">
                        <div class="col-3">
                            <img src="./assets/images/logo.png" />
                        </div>
                        <div class="col-9">
                            <div class="row align-items-center mb-0">
                                <div class="col-6">
                                    <div class="colorContainer">
                                        <p class="m-0">ENG: <span style="color: #2196F3"><?php echo $columns["engineNumber"]; ?></span></p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="colorContainer">
                                        <p class="m-0">CHS: <span style="color: #2196F3"><?php echo $columns["chassisNumber"]; ?></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between topGrayContainer">
                        <p>Rep ID: <span style="font-weight: 500"><?php echo $repId; ?></span></p>
                        <p>Insp. Dt: <span style="font-weight: 500"><?php echo $columns["inspectionDate"]; ?></span></p>
                        <p>Loan No: <span style="font-weight: 500"><?php echo $columns["loanNo"]; ?></span></p>
                        <p>Location: <span style="font-weight: 500"><?php echo $columns["location"]; ?></span></p>
                    </div>
                    <div class="d-flex align-items-center justify-content-between px-2 py-3 border-bottom mb-4 mt-3" style="font-weight: 500; font-size: 1.125rem; color: #053677">
                        <span style="font-size: 0.9375rem">Vehicle Description</span>
                        <span>Your Fastvalue Inspection Report</span>
                    </div>
                    <div class="row mb-4">
                        <div class="col-4 text-center">
                            <p style="font-weight: 500; color: #053677">Overall rating</p>
                            <p style="font-weight: 500; font-size: 2.5rem"><?php echo $columns["mainRating"]; ?> / 5</p>
                            <p style="font-size: 0.75rem">Rating is consistent with age and kms</p>
                        </div>
                        <div class="col-4">
                            <div class="mainBlueContainer">
                                <p>Valuation Price: </p>
                                <p style="font-size: 1.875rem; font-weight: 500">Rs. <?php echo moneyFormatIndia($columns["valuationPrice"]); ?></p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mainBlueContainer">
                                <p>Report requested by: </p>
                                <p style="font-size: 1.125rem; font-weight: 500;"><?php echo $columns["reportRequestedBy"]; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-6">
                            <p style="color: #2196F3; font-size: 1.125rem; font-weight: 500">
                                <span><?php echo $columns["vehicleMake"]; ?></span>&nbsp;
                                <span><?php echo $columns["vehicleModel"]; ?></span>&nbsp;
                                <span><?php echo $columns["vehicleVariant"]; ?></span>
                            </p>
                            <p class="mb-3" style="color: #2196F3; font-size: 1.125rem; font-weight: 500">
                                <span><?php echo $columns["vehicleRegNo"]; ?></span>&nbsp;
                                <span><?php echo $columns["vehicleRegDate"]; ?></span>
                            </p>
                            <table class="details-table with-bottom-border with-cellborder">
                                <tr>
                                    <td>Registration No</td>
                                    <td><?php echo $columns["vehicleRegNo"]; ?></td>
                                </tr>
                                <tr>
                                    <td>Registration Date</td>
                                    <td><?php echo $columns["vehicleRegDate"]; ?></td>
                                </tr>
                                <tr>
                                    <td>RC Status</td>
                                    <td><?php echo $columns["rcType"]; ?></td>
                                </tr>
                                <tr>
                                    <td>Manufactured Year</td>
                                    <td><?php echo $columns["manufacturedYear"]; ?></td>
                                </tr>
                                <tr>
                                    <td>Insurance Date</td>
                                    <td><?php echo $columns["vehicleInsuranceDate"]; ?></td>
                                </tr>
                                <tr>
                                    <td>Odometer Reading</td>
                                    <td><?php echo $columns["odometerReading"]; ?></td>
                                </tr>
                                <tr>
                                    <td>Vehicle Ownership</td>
                                    <td><?php echo $columns["vehicleOwnership"]; ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-6">
                            <p class="mb-3" style="color: #2196F3; font-size: 1.125rem; font-weight: 500">
                                <span>Report Type:</span>&nbsp;
                                <span style="color: #333"><?php echo $columns["reportType"]; ?></span>
                            </p>
                            <img src="./php-scripts/uploadedImages/<?php echo $columns["avatarImage"]; ?>" class="main-avatar" alt="avatar" />
                        </div>
                    </div>
                    <h2 style="color: #053677; font-size: 1.25rem;" class="mb-3 border-bottom pb-3">Inspection Report Summary</h2>
                    <div class="row mb-0 text-center vehicle-details">
                        <div class="col-2">
                            <div class="position-relative">
                                <i class="material-icons">directions_car</i>
                                <?php
                                if ($columns["vehicleCondition"] == "Running Condition" || $columns["vehicleCondition"] == "Running Conditio") {
                                ?>
                                    <div class="abs-position">
                                        <i class="material-icons">check</i>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                            <p class="vehicle-info">Running condition</p>
                        </div>
                        <div class="col-2">
                            <div class="position-relative">
                                <i class="material-icons">build_circle</i>
                                <?php
                                if ($columns["engineCondition"] == "Starts") {
                                ?>
                                    <div class="abs-position">
                                        <i class="material-icons">check</i>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                            <p class="vehicle-info">Engine start</p>
                        </div>
                        <div class="col-2">
                            <div class="position-relative">
                                <i class="material-icons">commute</i>
                                <?php
                                if ($columns["structuralCondition"] == "Good") {
                                ?>
                                    <div class="abs-position">
                                        <i class="material-icons">check</i>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                            <p class="vehicle-info">Structural condition</p>
                        </div>
                        <div class="col-2">
                            <i class="material-icons">person</i>
                            <p class="vehicle-info"><?php echo $columns["vehicleOwnership"]; ?> Owner(s)</p>
                        </div>
                        <div class="col-2">
                            <i class="material-icons">local_gas_station</i>
                            <p class="vehicle-info"><?php echo $columns["fuelType"]; ?></p>
                        </div>
                        <div class="col-2">
                            <i class="material-icons">miscellaneous_services</i>
                            <p class="vehicle-info">Transmission: <span style="font-weight: bold"><?php echo $columns["transmissionType"]; ?></span></p>
                        </div>
                        <div class="col-2">
                            <i class="material-icons">vpn_key</i>
                            <p class="vehicle-info">Key: <span style="font-weight: bold"><?php echo $columns["vehicleKey"]; ?></span></p>
                        </div>
                        <div class="col-2">
                            <i class="material-icons">assignment</i>
                            <p class="vehicle-info">RC: <span style="font-weight: bold"><?php echo $columns["rcType"]; ?></span></p>
                        </div>
                        <div class="col-2">
                            <i class="material-icons">verified_user</i>
                            <p class="vehicle-info">Insurance: <span style="font-weight: bold"><?php echo $columns["insuranceStatus"]; ?></span></p>
                        </div>
                        <div class="col-2">
                            <i class="material-icons">trip_origin</i>
                            <p class="vehicle-info">Tyre Condition: <span style="font-weight: bold"><?php echo $rating[$columns["tyreCondition"]]; ?></span></p>
                        </div>
                        <div class="col-2">
                            <i class="material-icons">battery_unknown</i>
                            <p class="vehicle-info">Battery Condition: <span style="font-weight: bold"><?php echo $columns["batteryStatus"]; ?></span></p>
                        </div>
                        <div class="col-2">
                            <i class="material-icons">format_paint</i>
                            <p class="vehicle-info">Color: <span style="font-weight: bold"><?php echo $columns["vehicleColor"]; ?></span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page">
                <div class="subpage">
                    <div class="header-container">
                        <h2 class="table-heading">Parivahan Details</h2>
                    </div>
                    <div style="border: 1px solid rgba(0, 0, 0, 0.12);">
                        <div class="row">
                            <div class="col-6">
                                <table class="details-table" style="border: 0">
                                    <tr>
                                        <td>Owner name</td>
                                        <td><?php echo $columns["parivahanOwnerName"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Maker</td>
                                        <td><?php echo $columns["parivahanMaker"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Model</td>
                                        <td><?php echo $columns["parivahanModel"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Manufactured Year</td>
                                        <td><?php echo $columns["parivahanManufacturedYear"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Registration date</td>
                                        <td><?php echo $columns["parivahanRegDate"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Vehicle Category</td>
                                        <td><?php echo $columns["vehicleCategory"]; ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-6">
                                <table class="details-table" style="border: 0">
                                    <tr>
                                        <td>Engine Number</td>
                                        <td><?php echo $columns["engineNumber"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Chassis Number</td>
                                        <td><?php echo $columns["chassisNumber"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Body Type</td>
                                        <td><?php echo $columns["bodyType"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Laden Weight</td>
                                        <td><?php echo $columns["ladenWeight"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Unladen Weight</td>
                                        <td><?php echo $columns["unladenWeight"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Sleeper Capacity</td>
                                        <td><?php echo $columns["sleeperCapacity"]; ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="header-container mt-4">
                        <h2 class="table-heading">Insurance Details</h2>
                    </div>
                    <div style="border: 1px solid rgba(0, 0, 0, 0.12);">
                        <div class="row">
                            <div class="col-6">
                                <table class="details-table" style="border: 0">
                                    <tr>
                                        <td>Insurance Type</td>
                                        <td><?php echo $columns["insuranceType"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Insurance Company</td>
                                        <td><?php echo $columns["insuranceCompany"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Insurance From</td>
                                        <td><?php echo $columns["insuranceFrom"]; ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-6">
                                <table class="details-table" style="border: 0">
                                    <tr>
                                        <td>Insurance UpTo</td>
                                        <td><?php echo $columns["InsuranceUpTo"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Insurance Declared Value</td>
                                        <td>Rs. <?php echo moneyFormatIndia($columns["insuranceValue"]); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="header-container mt-4">
                        <h2 class="table-heading">Tax Details</h2>
                    </div>
                    <div style="border: 1px solid rgba(0, 0, 0, 0.12);">
                        <div class="row">
                            <div class="col-6">
                                <table class="details-table" style="border: 0">
                                    <tr>
                                        <td>Tax Amount</td>
                                        <td>Rs. <?php echo moneyFormatIndia($columns["taxAmount"]); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tax Receipient Date</td>
                                        <td><?php echo $columns["taxRecipientDate"]; ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-6">
                                <table class="details-table" style="border: 0">
                                    <tr>
                                        <td>Tax UpTo</td>
                                        <td>Rs. <?php echo moneyFormatIndia($columns["taxUpTo"]); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tax Clear Upto</td>
                                        <td>Rs. <?php echo moneyFormatIndia($columns["taxClearUpTo"]); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <h2 class="sub-table-heading">Test Drive Results</h2>
                            <table class="details-table with-bottom-border">
                                <tr>
                                    <td>Engine Condition</td>
                                    <td><?php echo $rating[$columns["TDEngineCondition"]]; ?></td>
                                </tr>
                                <tr>
                                    <td>Clutch Condition</td>
                                    <td><?php echo $rating[$columns["TDClutch"]]; ?></td>
                                </tr>
                                <tr>
                                    <td>Accelerator</td>
                                    <td><?php echo $rating[$columns["TDAccelerator"]]; ?></td>
                                </tr>
                                <tr>
                                    <td>Gear shift ratios</td>
                                    <td><?php echo $rating[$columns["TDGearShiftRatios"]]; ?></td>
                                </tr>
                                <tr>
                                    <td>Stearing Condition</td>
                                    <td><?php echo $rating[$columns["TDStearing"]]; ?></td>
                                </tr>
                                <tr>
                                    <td>Breaking Condition</td>
                                    <td><?php echo $rating[$columns["TDBreaking"]]; ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-6">
                            <h2 class="sub-table-heading">Mechanical Conditions</h2>
                            <table class="details-table with-bottom-border">
                                <tr>
                                    <td>Engine Condition</td>
                                    <td><?php echo $rating[$columns["MCEngineCondition"]]; ?></td>
                                </tr>
                                <tr>
                                    <td>Engine Running</td>
                                    <td><?php echo $columns["MCEngineRunning"]; ?></td>
                                </tr>
                                <tr>
                                    <td>Engine Oil Level</td>
                                    <td><?php echo $rating[$columns["MCEngineOilLevel"]]; ?></td>
                                </tr>
                                <tr>
                                    <td>Engine Oil Functions</td>
                                    <td><?php echo $rating[$columns["MCEngineOilFunction"]]; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page">
                <div class="subpage">
                    <div class="row">
                        <div class="col-6">
                            <h2 class="sub-table-heading">Stearing Conditions</h2>
                            <table class="details-table with-bottom-border">
                                <tr>
                                    <td>Stearing Play</td>
                                    <td><?php echo $columns["SCSteeringPlay"]; ?></td>
                                </tr>
                                <tr>
                                    <td>Power Steering</td>
                                    <td><?php echo $columns["SCPowerSteering"]; ?></td>
                                </tr>
                                <tr>
                                    <td>Steering</td>
                                    <td><?php echo $columns["SCStearing"]; ?></td>
                                </tr>
                                <tr>
                                    <td>Stearing Conditons</td>
                                    <td><?php echo $rating[$columns["SCSteeringCondition"]]; ?></td>
                                </tr>
                            </table>
                            <h2 class="sub-table-heading">Exterior Conditions</h2>
                            <table class="details-table with-bottom-border">
                                <tr>
                                    <td>Head Light</td>
                                    <td><?php echo $rating[$columns["ExCHeadLight"]]; ?></td>
                                </tr>
                                <tr>
                                    <td>Rear Tail Light</td>
                                    <td><?php echo $columns["ExCRearTailLight"]; ?></td>
                                </tr>
                                <tr>
                                    <td>Hood</td>
                                    <td><?php echo $rating[$columns["ExCHood"]]; ?></td>
                                </tr>
                                <tr>
                                    <td>Left Fender</td>
                                    <td><?php echo $rating[$columns["ExCLeftFender"]]; ?></td>
                                </tr>
                                <tr>
                                    <td>Right Fender</td>
                                    <td><?php echo $rating[$columns["ExCRightFender"]]; ?></td>
                                </tr>
                                <?php
                                if ($vehicleType == "CV") {
                                ?>
                                    <tr>
                                        <td>Windshield</td>
                                        <td><?php echo $rating[$columns["ExCWindshield"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Chassis Condition</td>
                                        <td><?php echo $rating[$columns["ExCChassisCondition"]]; ?></td>
                                    </tr>
                                <?php
                                } else {
                                ?>
                                    <tr>
                                        <td>Grill</td>
                                        <td><?php echo $rating[$columns["ExCGrill"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Front Bumper</td>
                                        <td><?php echo $rating[$columns["ExCFrontBumper"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Left Quarter</td>
                                        <td><?php echo $rating[$columns["ExCLeftQuarter"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Right Quarter</td>
                                        <td><?php echo $rating[$columns["ExCRightQuarter"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Front Windshield</td>
                                        <td><?php echo $columns["ExCFrontWindshield"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Right Front Door</td>
                                        <td><?php echo $rating[$columns["ExCRightFrontDoor"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Left Front Door</td>
                                        <td><?php echo $rating[$columns["ExCLeftFrontDoor"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Left Rear Door</td>
                                        <td><?php echo $rating[$columns["ExCLeftRearDoor"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Right Rear Door</td>
                                        <td><?php echo $rating[$columns["ExCRightRearDoor"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Roof</td>
                                        <td><?php echo $rating[$columns["ExCRoof"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Rear Windshield</td>
                                        <td><?php echo $columns["ExCRearWindShield"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Rear Tail Light</td>
                                        <td><?php echo $columns["ExCRearTailLight"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Rear Bumper</td>
                                        <td><?php echo $rating[$columns["ExCRearBumper"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Body Paint</td>
                                        <td><?php echo $rating[$columns["ExCBodyPaint"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Deck LID</td>
                                        <td><?php echo $rating[$columns["ExCDeckLid"]]; ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </table>
                        </div>
                        <div class="col-6">
                            <?php
                            if ($vehicleType == "CV") {
                            ?>
                                <h2 class="sub-table-heading">Vehicle Body Details</h2>
                                <table class="details-table with-bottom-border">
                                    <tr>
                                        <td>Load body type</td>
                                        <td><?php echo $columns["LBType"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Load body Build</td>
                                        <td><?php echo $columns["LBBuild"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Left Side Gate</td>
                                        <td><?php echo $rating[$columns["LBLeftSideGate"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Right Side Gate</td>
                                        <td><?php echo $rating[$columns["LBRightSideGate"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Load Floor</td>
                                        <td><?php echo $rating[$columns["LBLoadFloor"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Overall Load Body</td>
                                        <td><?php echo $rating[$columns["LBOverallLoadBody"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Body Paint</td>
                                        <td><?php echo $rating[$columns["LBBodyPaint"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Fuel Tank</td>
                                        <td><?php echo $rating[$columns["LBFuelTank"]]; ?></td>
                                    </tr>
                                </table>
                                <h2 class="sub-table-heading">Cabin Condition</h2>
                                <table class="details-table with-bottom-border">
                                    <tr>
                                        <td>Front Bumper</td>
                                        <td><?php echo $rating[$columns["CabinFrontBumper"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Rear Bumper</td>
                                        <td><?php echo $rating[$columns["CabinRearBumper"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Right Door</td>
                                        <td><?php echo $rating[$columns["CabinRightDoor"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Left Door</td>
                                        <td><?php echo $rating[$columns["CabinLeftDoor"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Dashboard Condition</td>
                                        <td><?php echo $rating[$columns["CabinDashboardCondition"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Driver Seat Condition</td>
                                        <td><?php echo $rating[$columns["CabinDriverSeat"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Co-Driver Seat Condition</td>
                                        <td><?php echo $rating[$columns["CabinCoDriverSeat"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Third Row Seat Condition</td>
                                        <td><?php echo $rating[$columns["CabinThirdRow"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>ABS Condition</td>
                                        <td><?php echo $rating[$columns["CabinABS"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Radiator Condition</td>
                                        <td><?php echo $rating[$columns["CabinRadiator"]]; ?></td>
                                    </tr>
                                </table>
                            <?php
                            } else {
                            ?>
                                <h2 class="sub-table-heading">Vehicle Condition</h2>
                                <table class="details-table with-bottom-border">
                                    <tr>
                                        <td>Running Condition</td>
                                        <td><?php echo $rating[$columns["VCRunningCondition"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Engine Start</td>
                                        <td><?php echo $columns["VCEngineStart"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Transmission / Gear Box Condition</td>
                                        <td><?php echo $rating[$columns["VCTransmissionCondition"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Transmission Working</td>
                                        <td><?php echo $rating[$columns["VCTransmissionWorking"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Gear Shift</td>
                                        <td><?php echo $rating[$columns["VCGearShift"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Front Suspension</td>
                                        <td><?php echo $rating[$columns["VCFrontSuspension"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Rear Suspension</td>
                                        <td><?php echo $rating[$columns["VCRearSuspension"]]; ?></td>
                                    </tr>
                                </table>
                                <h2 class="sub-table-heading">Interior Condition</h2>
                                <table class="details-table with-bottom-border">
                                    <tr>
                                        <td>Dashboard Condition</td>
                                        <td><?php echo $rating[$columns["InTDashboardCondition"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Front Left Seat</td>
                                        <td><?php echo $rating[$columns["InTFrontLeftSeat"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Front Right Seat</td>
                                        <td><?php echo $rating[$columns["InTFrontRightSeat"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Rear Left Seat</td>
                                        <td><?php echo $rating[$columns["InTRearLeftSeat"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Rear Right Seat</td>
                                        <td><?php echo $rating[$columns["InTRearRightSeat"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Third Row Seat Condition</td>
                                        <td><?php echo $rating[$columns["InTThirdRowSeatCondition"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Trunk Cargo Condition</td>
                                        <td><?php echo $rating[$columns["InTTrunkCargo"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Cruise Control</td>
                                        <td><?php echo $columns["InTCruiseControl"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Air Bag</td>
                                        <td><?php echo $columns["InTAirbags"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Power Window</td>
                                        <td><?php echo $columns["InTPowerWindow"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Carpet & Floor mats</td>
                                        <td><?php echo $rating[$columns["InTCarpetNFloorMat"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Odometer Condition</td>
                                        <td><?php echo $rating[$columns["IntOdometerCondition"]]; ?></td>
                                    </tr>
                                </table>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page">
                <div class="subpage">
                    <div class="row">
                        <div class="col-6">
                            <?php
                            if ($vehicleType == "CV") {
                            ?>
                                <h2 class="sub-table-heading">Transmission Conditions</h2>
                                <table class="details-table with-bottom-border">
                                    <tr>
                                        <td>Transmission / Gear Box Condition</td>
                                        <td><?php echo $rating[$columns["TCTransmissionCondition"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Transmission Working</td>
                                        <td><?php echo $rating[$columns["TCTransmissionWorking"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Front Suspension</td>
                                        <td><?php echo $rating[$columns["TCFrontSuspension"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Rear Suspension</td>
                                        <td><?php echo $rating[$columns["TCRearSuspension"]]; ?></td>
                                    </tr>
                                </table>
                                <h2 class="sub-table-heading">Electrical Functions</h2>
                                <table class="details-table with-bottom-border">
                                    <tr>
                                        <td>Electrical Condition</td>
                                        <td><?php echo $rating[$columns["ECEletricalCondition"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Battery Condition</td>
                                        <td><?php echo $rating[$columns["ECBatteryCondition"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>A/C Cooling</td>
                                        <td><?php echo $rating[$columns["ECACCooling"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Power Window Condition</td>
                                        <td><?php echo $rating[$columns["ECPowerWindow"]]; ?></td>
                                    </tr>
                                </table>
                                <h2 class="sub-table-heading">HVAC/Cooling</h2>
                                <table class="details-table with-bottom-border">
                                    <tr>
                                        <td>Refrigration Unit Fitted In Load Vehicle</td>
                                        <td><?php echo $rating[$columns["ECACRefrigrationUnit"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>HVAC Cooling</td>
                                        <td><?php echo $rating[$columns["ECACHvacCooling"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>A/C / Heater / Blower Fan</td>
                                        <td><?php echo $rating[$columns["ECACHeaterBlowerFan"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Electric Cooling Fan</td>
                                        <td><?php echo $rating[$columns["ECElectricCoolingFan"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Cooling System / Radiator</td>
                                        <td><?php echo $rating[$columns["ECCoolingSystemRadiator"]]; ?></td>
                                    </tr>
                                </table>
                            <?php
                            } else {
                            ?>
                                <h2 class="sub-table-heading">Electrical Functions</h2>
                                <table class="details-table with-bottom-border">
                                    <tr>
                                        <td>Electrical Condition</td>
                                        <td><?php echo $rating[$columns["ECEletricalCondition"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Battery Condition</td>
                                        <td><?php echo $rating[$columns["ECBatteryCondition"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>A/C Cooling</td>
                                        <td><?php echo $rating[$columns["ECACCooling"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Power Window Condition</td>
                                        <td><?php echo $rating[$columns["ECPowerWindow"]]; ?></td>
                                    </tr>
                                </table>
                                <h2 class="sub-table-heading">HVAC/Cooling</h2>
                                <table class="details-table with-bottom-border">
                                    <tr>
                                        <td>A/C / Heater / Blower Fan</td>
                                        <td><?php echo $rating[$columns["ECACHeaterBlowerFan"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Electric Cooling Fan</td>
                                        <td><?php echo $rating[$columns["ECElectricCoolingFan"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Cooling System / Radiator</td>
                                        <td><?php echo $rating[$columns["ECCoolingSystemRadiator"]]; ?></td>
                                    </tr>
                                </table>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="col-6">
                            <?php
                            if ($vehicleType == "CV") {
                            ?>
                                <h2 class="sub-table-heading">Tyre Conditions</h2>
                                <table class="details-table with-bottom-border">
                                    <tr>
                                        <td>No of Tyres</td>
                                        <td><?php echo $columns["TCNofTyres"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Front Left Tyres Condition</td>
                                        <td><?php echo $rating[$columns["TCFrontLeftTyresCondition"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Front Right Tyres Condition</td>
                                        <td><?php echo $rating[$columns["TCFrontRightTyresCondition"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Rear Left Tyres Condition</td>
                                        <td><?php echo $rating[$columns["TCRearLeftTyresCondition"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Rear Right Tyres Condition</td>
                                        <td><?php echo $rating[$columns["TCRearRightTyresCondition"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Spare Tyres Condition</td>
                                        <td><?php echo $rating[$columns["TCSpareTyresCondition"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tyre 5 Condition</td>
                                        <td><?php echo $rating[$columns["TCTyre5Condition"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tyre 6 Condition</td>
                                        <td><?php echo $rating[$columns["TCTyre6Condition"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tyre 7 Condition</td>
                                        <td><?php echo $rating[$columns["TCTyre7Condition"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tyre 8 Condition</td>
                                        <td><?php echo $rating[$columns["TCTyre8Condition"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tyre 9 Condition</td>
                                        <td><?php echo $rating[$columns["TCTyre9Condition"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tyre 10 Condition</td>
                                        <td><?php echo $rating[$columns["TCTyre10Condition"]]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Front Left Tyre Life</td>
                                        <td><?php echo $columns["TCFrontLeftWheelLife"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Front Right Tyre Life</td>
                                        <td><?php echo $columns["TCFrontRightWheelLife"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Rear Left Tyre Life</td>
                                        <td><?php echo $columns["TCRearLeftWheelLife"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Rear Right Tyre Life</td>
                                        <td><?php echo $columns["TCRearRightWheelLife"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Spare Wheel Life</td>
                                        <td><?php echo $columns["TCSpareWheelLife"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tyre 5 Life</td>
                                        <td><?php echo $columns["TCTyre5Life"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tyre 6 Life</td>
                                        <td><?php echo $columns["TCTyre6Life"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tyre 7 Life</td>
                                        <td><?php echo $columns["TCTyre7Life"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tyre 8 Life</td>
                                        <td><?php echo $columns["TCTyre8Life"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tyre 9 Life</td>
                                        <td><?php echo $columns["TCTyre9Life"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tyre 10 Life</td>
                                        <td><?php echo $columns["TCTyre10Life"]; ?></td>
                                    </tr>
                                </table>
                            <?php
                            } else {
                            ?>
                                <h2 class="sub-table-heading">Tyre Conditions</h2>
                                <table class="details-table with-bottom-border">
                                    <tr>
                                        <td>No of Tyres</td>
                                        <td><?php echo $columns["TCNoOfTyres"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Front Right Wheel Type</td>
                                        <td><?php echo $columns["TCFrontRightWheelType"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Front Left Wheel Type</td>
                                        <td><?php echo $columns["TCFrontLeftWheelType"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Rear Right Wheel Type</td>
                                        <td><?php echo $columns["TCRearRightWheelType"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Rear Left Wheel Type</td>
                                        <td><?php echo $columns["TCRearLeftWheelType"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Spare Wheel Type</td>
                                        <td><?php echo $columns["TCSpareWheelType"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Front Left Tyre</td>
                                        <td><?php echo $columns["TCFrontLeftWheel"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Front Right Tyre</td>
                                        <td><?php echo $columns["TCFrontRightWheel"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Rear Left Tyre</td>
                                        <td><?php echo $columns["TCRearLeftWheel"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Rear Right Tyre</td>
                                        <td><?php echo $columns["TCRearRightWheel"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Spare Wheel</td>
                                        <td><?php echo $columns["TCSpareWheel"]; ?></td>
                                    </tr>
                                </table>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page">
                <div class="subpage">
                    <h2 class="m-0 mt-3 mb-4" style="font-size: 1.25rem">Remarks:</h2>
                    <div class="remarksBox mb-4">
                        <?php echo $columns["remarks"]; ?>
                    </div>
                    <h2 class="m-0 mt-3 mb-3 text-center" style="font-size: 1.25rem">Disclaimer</h2>
                    <div class="remarksBox mb-3" style="font-size: 0.75rem;">
                        <p class="mb-2">The inspection is VISIBLE and non-TECHNICAL report only and FAST VALUE DIGITAL VEHICLE INSPECTION will not be responsible for any defects that are latent discovered which were not possibly visible during the inspection.
                            The inspection will asses the vehicle’s exterior, interior, engine compartment, tyres and wheels, brakes and under body where possible. The inspection will precisely not pinpoint all defects within the vehicle.
                            You must take in account of age and condition of the vehicle at the time of inspection and any Report should be reviewed in this context.
                            This inspection report of FAST VALUE DIGITAL VEHICLE INSPECTION generated on (current date) is not responsible for representation regarding the nature, reliability, accuracy of price or completeness of any information contained in the Report or the fitness of the information contained in the Report for any purpose intended by you that are not identified or identifiable with an inspection of this kind.
                        </p>
                        <p class="mb-2"><span style="color: #ff0000">*</span>The odometer reading might vary in real , the mentioned reading was observed during inspection.</p>
                        <p>A vehicle is rated to be accidental if it has under gone a crash of any type and have impact on Chassis , structural panels with body dimensions changed and thus effecting the safety & functioning of a vehicle.</p>
                    </div>
                    <p class="mb-5" style="font-weight: 500;">Approved by</p>
                    <p></p>
                    <div class="header-container mt-4">
                        <h2 class="table-heading">Images</h2>
                    </div>
                    <div class="row image-section">
                        <div class="col-12">
                            <img src="./php-scripts/uploadedImages/<?php echo $columns["chassisImprintImage"]; ?>" alt="chassis imprint" />
                            <h3 class="image-caption">Chassis imprint</h3>
                        </div>
                        <?php
                        if ($vehicleType == "CV") {
                        ?>
                            <div class="col-4">
                                <img src="./php-scripts/uploadedImages/<?php echo $columns["CVFrontImage"]; ?>" alt="chassis imprint" />
                                <h3 class="image-caption">Vehicle Front View</h3>
                            </div>
                            <div class="col-4">
                                <img src="./php-scripts/uploadedImages/<?php echo $columns["CVRightImage"]; ?>" alt="chassis imprint" />
                                <h3 class="image-caption">Vehicle Right View</h3>
                            </div>
                            <div class="col-4">
                                <img src="./php-scripts/uploadedImages/<?php echo $columns["CVRearImage"]; ?>" alt="chassis imprint" />
                                <h3 class="image-caption">Vehicle Rear View</h3>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="col-4">
                                <img src="./php-scripts/uploadedImages/<?php echo $columns["carFrontImage"]; ?>" alt="chassis imprint" />
                                <h3 class="image-caption">Car Front</h3>
                            </div>
                            <div class="col-4">
                                <img src="./php-scripts/uploadedImages/<?php echo $columns["carRightImage"]; ?>" alt="chassis imprint" />
                                <h3 class="image-caption">Car Right</h3>
                            </div>
                            <div class="col-4">
                                <img src="./php-scripts/uploadedImages/<?php echo $columns["carRearImage"]; ?>" alt="chassis imprint" />
                                <h3 class="image-caption">Car Rear</h3>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="page">
                <div class="subpage">
                    <div class="row image-section">
                        <?php
                        if ($vehicleType == "CV") {
                        ?>
                            <div class="col-4">
                                <img src="./php-scripts/uploadedImages/<?php echo $columns["CVLeftImage"]; ?>" alt="chassis imprint" />
                                <h3 class="image-caption">Vehicle Left View</h3>
                            </div>
                            <div class="col-4">
                                <img src="./php-scripts/uploadedImages/<?php echo $columns["dashboardImage"]; ?>" alt="chassis imprint" />
                                <h3 class="image-caption">Dashboard</h3>
                            </div>
                            <div class="col-4">
                                <img src="./php-scripts/uploadedImages/<?php echo $columns["odometerImage"]; ?>" alt="chassis imprint" />
                                <h3 class="image-caption">Odometer</h3>
                            </div>
                            <div class="col-4">
                                <img src="./php-scripts/uploadedImages/<?php echo $columns["insideCabinImage"]; ?>" alt="chassis imprint" />
                                <h3 class="image-caption">Inside Cabin</h3>
                            </div>
                            <div class="col-4">
                                <img src="./php-scripts/uploadedImages/<?php echo $columns["engineRoomImage"]; ?>" alt="chassis imprint" />
                                <h3 class="image-caption">Engine Room</h3>
                            </div>
                            <div class="col-4">
                                <img src="./php-scripts/uploadedImages/<?php echo $columns["regPlateImage"]; ?>" alt="chassis imprint" />
                                <h3 class="image-caption">Registration Plate</h3>
                            </div>
                            <div class="col-4">
                                <img src="./php-scripts/uploadedImages/<?php echo $columns["chassisNoImage"]; ?>" alt="chassis imprint" />
                                <h3 class="image-caption">Chassis No</h3>
                            </div>
                            <div class="col-4">
                                <img src="./php-scripts/uploadedImages/<?php echo $columns["rcFrontImage"]; ?>" alt="chassis imprint" />
                                <h3 class="image-caption">RC Front</h3>
                            </div>
                            <div class="col-4">
                                <img src="./php-scripts/uploadedImages/<?php echo $columns["rcBackImage"]; ?>" alt="chassis imprint" />
                                <h3 class="image-caption">RC Back</h3>
                            </div>
                            <div class="col-4">
                                <img src="./php-scripts/uploadedImages/<?php echo $columns["tyre1Image"]; ?>" alt="chassis imprint" />
                                <h3 class="image-caption">Tyre 1</h3>
                            </div>
                            <div class="col-4">
                                <img src="./php-scripts/uploadedImages/<?php echo $columns["tyre2Image"]; ?>" alt="chassis imprint" />
                                <h3 class="image-caption">Tyre 2</h3>
                            </div>
                            <div class="col-4">
                                <img src="./php-scripts/uploadedImages/<?php echo $columns["tyre3Image"]; ?>" alt="chassis imprint" />
                                <h3 class="image-caption">Tyre 3</h3>
                            </div>
                            <div class="col-4">
                                <img src="./php-scripts/uploadedImages/<?php echo $columns["tyre4Image"]; ?>" alt="chassis imprint" />
                                <h3 class="image-caption">Tyre 4</h3>
                            </div>
                            <div class="col-4">
                                <img src="./php-scripts/uploadedImages/<?php echo $columns["tyre5Image"]; ?>" alt="chassis imprint" />
                                <h3 class="image-caption">Tyre 5</h3>
                            </div>
                            <div class="col-4">
                                <img src="./php-scripts/uploadedImages/<?php echo $columns["tyre6Image"]; ?>" alt="chassis imprint" />
                                <h3 class="image-caption">Tyre 6</h3>
                            </div>
                            <div class="col-4">
                                <img src="./php-scripts/uploadedImages/<?php echo $columns["tyre7Image"]; ?>" alt="chassis imprint" />
                                <h3 class="image-caption">Tyre 7</h3>
                            </div>
                            <div class="col-4">
                                <img src="./php-scripts/uploadedImages/<?php echo $columns["tyre8Image"]; ?>" alt="chassis imprint" />
                                <h3 class="image-caption">Tyre 8</h3>
                            </div>
                            <div class="col-4">
                                <img src="./php-scripts/uploadedImages/<?php echo $columns["tyre9Image"]; ?>" alt="chassis imprint" />
                                <h3 class="image-caption">Tyre 9</h3>
                            </div>
                            <div class="col-4">
                                <img src="./php-scripts/uploadedImages/<?php echo $columns["tyre10Image"]; ?>" alt="chassis imprint" />
                                <h3 class="image-caption">Tyre 10</h3>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="col-4">
                                <img src="./php-scripts/uploadedImages/<?php echo $columns["carLeftImage"]; ?>" alt="chassis imprint" />
                                <h3 class="image-caption">Car Left</h3>
                            </div>
                            <div class="col-4">
                                <img src="./php-scripts/uploadedImages/<?php echo $columns["dashboardImage"]; ?>" alt="chassis imprint" />
                                <h3 class="image-caption">Dashboard</h3>
                            </div>
                            <div class="col-4">
                                <img src="./php-scripts/uploadedImages/<?php echo $columns["gearAndSeatImage"]; ?>" alt="chassis imprint" />
                                <h3 class="image-caption">Gear and Seat</h3>
                            </div>
                            <div class="col-4">
                                <img src="./php-scripts/uploadedImages/<?php echo $columns["odometerImage"]; ?>" alt="chassis imprint" />
                                <h3 class="image-caption">Odometer</h3>
                            </div>
                            <div class="col-4">
                                <img src="./php-scripts/uploadedImages/<?php echo $columns["engineRoomImage"]; ?>" alt="chassis imprint" />
                                <h3 class="image-caption">Engine Room</h3>
                            </div>
                            <div class="col-4">
                                <img src="./php-scripts/uploadedImages/<?php echo $columns["regPlateImage"]; ?>" alt="chassis imprint" />
                                <h3 class="image-caption">Registration Plate</h3>
                            </div>
                            <div class="col-4">
                                <img src="./php-scripts/uploadedImages/<?php echo $columns["chassisNoImage"]; ?>" alt="chassis imprint" />
                                <h3 class="image-caption">Chassis No</h3>
                            </div>
                            <div class="col-4">
                                <img src="./php-scripts/uploadedImages/<?php echo $columns["rcFrontImage"]; ?>" alt="chassis imprint" />
                                <h3 class="image-caption">RC Front</h3>
                            </div>
                            <div class="col-4">
                                <img src="./php-scripts/uploadedImages/<?php echo $columns["rcBackImage"]; ?>" alt="chassis imprint" />
                                <h3 class="image-caption">RC Back</h3>
                            </div>
                            <div class="col-4">
                                <img src="./php-scripts/uploadedImages/<?php echo $columns["tyre1Image"]; ?>" alt="chassis imprint" />
                                <h3 class="image-caption">Tyre 1</h3>
                            </div>
                            <div class="col-4">
                                <img src="./php-scripts/uploadedImages/<?php echo $columns["tyre2Image"]; ?>" alt="chassis imprint" />
                                <h3 class="image-caption">Tyre 2</h3>
                            </div>
                            <div class="col-4">
                                <img src="./php-scripts/uploadedImages/<?php echo $columns["tyre3Image"]; ?>" alt="chassis imprint" />
                                <h3 class="image-caption">Tyre 3</h3>
                            </div>
                            <div class="col-4">
                                <img src="./php-scripts/uploadedImages/<?php echo $columns["tyre4Image"]; ?>" alt="chassis imprint" />
                                <h3 class="image-caption">Tyre 4</h3>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <button type="button" class="btn-floating waves-effect waves-light btn-large printBtn" onclick="window.print()"><i class="material-icons">get_app</i></button>
        <?php
        }
        ?>
    <?php
    }
    ?>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>

</html>