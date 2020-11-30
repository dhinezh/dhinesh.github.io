<?php

class Main
{
    /** @var object $pdo Copy of PDO connection */
    private $pdo;
    /** @var object of the logged in user */
    private $user;
    /** @var string error msg */
    private $msg;
    /** @var array number of permitted wrong login attemps */
    private $columns = array();

    function __construct($file = 'database.ini')
    {
        define('SITE_ROOT', realpath(dirname(__FILE__)));
        if (!$settings = parse_ini_file($file, TRUE)) throw new exception('Unable to open ' . $file . '.');

        $dns = $settings['database']['driver'] .
            ':host=' . $settings['database']['host'] .
            ((!empty($settings['database']['port'])) ? (';port=' . $settings['database']['port']) : '') .
            ';dbname=' . $settings['database']['schema'];
        $this->dbConnect($dns, $settings['database']['username'], $settings['database']['password']);
        date_default_timezone_set('Asia/Kolkata');
    }

    /**
     * Connection init function
     * @param string $conString DB connection string.
     * @param string $user DB user.
     * @param string $pass DB password.
     *
     * @return bool Returns connection success.
     */
    public function dbConnect($conString, $user, $pass)
    {
        try {
            $pdo = new PDO($conString, $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
            return $this->success("connection success");
        } catch (PDOException $e) {
            return $this->error('Connection did not work out!');
        }
    }
    /**
     * Register a new user account function
     * @param string $username User email.
     * @param string $mobile User mobile.
     * @param string $usertype User type either admin or user.
     * @param string $pass User password.
     * @return array with either success or error
     */
    public function registration($username, $pass, $mobile, $usertype)
    {
        $pdo = $this->pdo;
        if (!(isset($username) && isset($pass) && isset($mobile) && isset($usertype))) {
            return $this->error('Insert all valid required fields.');
        }
        if ($this->checkForExistingMobile($mobile)) {
            return $this->editUser($username, $pass, $mobile, $usertype);
        }

        $pass = $this->hashPass($pass);
        $stmt = $pdo->prepare('INSERT INTO registered_users (username, password, usertype, mobile) VALUES (?, ?, ?, ?)');
        if ($stmt->execute([$username, $pass, $usertype, $mobile])) {
            return $this->success("User registered successfully.");
        } else {
            return $this->error('User creation failed');
        }
    }

    /**
     * Check if mobile is already used function
     * @param int $mobile User mobile number.
     * @return boolean of success.
     */
    private function checkForExistingMobile($mobile)
    {
        $pdo = $this->pdo;
        $stmt = $pdo->prepare('SELECT username FROM registered_users WHERE mobile = ? limit 1');
        $stmt->execute([$mobile]);
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function success($msg)
    {
        return array("status" => "success", "message" => $msg);
    }

    public function error($msg)
    {
        return array("status" => "error", "message" => $msg);
    }


    /**
     * Return the logged in user.
     * @return user array data
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Login function
     * @param string $email User email.
     * @param string $password User password.
     *
     * @return bool Returns login success.
     */
    public function login($mobile, $password)
    {
        if (is_null($this->pdo)) {
            $this->msg = 'Connection did not work out!';
            return false;
        } else {
            $pdo = $this->pdo;
            $stmt = $pdo->prepare('SELECT * FROM registered_users WHERE mobile = ?');
            $stmt->execute([$mobile]);
            $user = $stmt->fetch();
            $passwordFromDb = $user['password'];
            if (password_verify($password, $passwordFromDb)) {
                session_start();
                $_SESSION['user']['username'] = $user['username'];
                $_SESSION['user']['usertype'] = $user['usertype'];
                $url = "./dashboard.php";
                header("Location: $url");
                exit();
            } else {
                return $this->error('Login failed. Please enter valid Mobile/Password.');
            }
        }
    }
    /**
     * Check if the user is logged in or not.
     *
     * @return true if the user session is available
     */

    public function loginCheck()
    {
        if (isset($_SESSION['user']['username'])) return true;
        else return false;
    }

    /**
     * Logout the user and remove it from the session.
     *
     * @return true
     */
    public function logout()
    {
        $_SESSION['user'] = null;
        return true;
    }

    /**
     * insert data in to fourwheeler
     * contains nearly 140 entries
     */

    public function registerFourwheeler()
    {
        $repId = $_POST["repId"];
        $regNo = $_POST["vehicleRegNo"];
        if ($this->checkforExistingRepId($repId)) {
            return $this->error("RepId already exists.");
        }
        if ($this->checkforExistingRegno($regNo)) {
            return $this->error("Vehicle with register number already exists.");
        }
        set_time_limit(180);
        $functionsCalled =
            $this->uploadFourwheelerImages() and
            $this->registerCommonFields("four-wheeler") and
            $this->registerFourwheelerExteriorConditions() and
            $this->registerFourwheelerInteriorConditions() and
            $this->registerFourwheelerVehicleCondition() and
            $this->registerFourwheelerElectricalFunctions() and
            $this->registerFourwheelerTyreConditions();
        if ($functionsCalled) {
            return $this->success("Four wheeler registered registered successfully.");
        } else {
            return $this->error($this->msg);
        }
    }

    public function registerCV()
    {
        $repId = $_POST["repId"];
        $regNo = $_POST["vehicleRegNo"];
        if ($this->checkforExistingRepId($repId)) {
            return $this->error("RepId already exists.");
        }
        if ($this->checkforExistingRegno($regNo)) {
            return $this->error("CV with register number already exists.");
        }
        set_time_limit(180);
        $functionsCalled =
            $this->uploadCVImages() and
            $this->registerCommonFields("CV") and
            $this->registerCVCabinConditions() and
            $this->registerCVExteriorConditions() and
            $this->registerCVElectricalFunctions() and
            $this->registerCVTransmissionCondition() and
            $this->registerCVVehicleBodyDetails() and
            $this->registerCVTyreConditions();
        if ($functionsCalled) {
            return $this->success("CV registered registered successfully.");
        } else {
            return $this->error($this->msg);
        }
    }

    public function registerCommonFields($vehicleType)
    {
        $functionsCalled =
            $this->registerVehicleDetails($vehicleType) and
            $this->registerParivahanDetails() and
            $this->registerInsuranceDetails() and
            $this->registerTaxDetails() and
            $this->registerTestDriveResults() and
            $this->registerStearingConditions() and
            $this->registerMechanicalConditions();
        if ($functionsCalled) {
            return true;
        } else {
            return false;
        }
    }

    public function registerVehicleDetails($vehicleType)
    {
        $pdo = $this->pdo;
        foreach ($_POST as $key => $value) {
            if (isset($$key)) continue;
            $$key = $value;
        }
        $createdBy =  $_SESSION['user']['username'];
        // $createdOn = date('m/d/Y h:i:s a', time());
        $createdOn = date('Y-m-d H:i:s');
        $success = '';

        try {
            $stmt = $pdo->prepare('INSERT INTO vehicle_details 
            (repId, inspectionDate, loanNo, location, vehicleMake, 
            vehicleModel, vehicleVariant, vehicleRegNo, vehicleRegDate, ownerName, 
            rcType, manufacturedYear, insuranceStatus, vehicleInsuranceDate, odometerReading, 
            vehicleOwnership, reportType, hpaStatus, hpaBank, transmissionType, 
            fuelType, vehicleColor, engineCondition, vehicleCondition, structuralCondition, 
            ownerSerial, vehicleKey, batteryStatus, tyreCondition, reportRequestedBy, 
            valuationPrice, remarks, createdBy, createdOn, vehicleType) VALUES (
                ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?
            )');
            $executeArray = array(
                $repId, $inspectionDate, $loanNo, $location, $vehicleMake,
                $vehicleModel, $vehicleVariant, $vehicleRegNo, $vehicleRegDate, $ownerName,
                $rcType, $manufacturedYear, $insuranceStatus, $vehicleInsuranceDate, $odometerReading,
                $vehicleOwnership, $reportType, $hpaStatus, $hpaBank, $transmissionType,
                $fuelType, $vehicleColor, $engineCondition, $vehicleCondition, $structuralCondition,
                $ownerSerial, $vehicleKey, $batteryStatus, $tyreCondition, $reportRequestedBy,
                $valuationPrice, $remarks, $createdBy, $createdOn, $vehicleType
            );
            $stmt->execute($executeArray);
            //success
            $success = 'done';
        } catch (PDOException $e) {
            //error
            $this->msg = 'Vehicle data insertion failed: ' . $e->getMessage();
        }
        if ($success == 'done') return true;
        else return false;
    }

    public function registerParivahanDetails()
    {
        $pdo = $this->pdo;
        foreach ($_POST as $key => $value) {
            if (isset($$key)) continue;
            $$key = $value;
        }
        $success = '';

        try {
            $stmt = $pdo->prepare('INSERT INTO parivahan_details 
            (repId, parivahanOwnerName, parivahanMaker, parivahanModel, parivahanManufacturedYear, parivahanRegDate, 
            vehicleCategory, engineNumber, chassisNumber, bodyType, ladenWeight, 
            unladenWeight, sleeperCapacity) VALUES (
                ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?,
                ?, ?, ?
            )');
            $executeArray = array(
                $repId, $parivahanOwnerName, $parivahanMaker, $parivahanModel, $parivahanManufacturedYear, $parivahanRegDate,
                $vehicleCategory, $engineNumber, $chassisNumber, $bodyType, $ladenWeight,
                $unladenWeight, $sleeperCapacity
            );
            $stmt->execute($executeArray);
            //success
            $success = 'done';
        } catch (PDOException $e) {
            //error
            $this->msg = 'Parivahan data insertion failed: ' . $e->getMessage();
        }
        if ($success == 'done') return true;
        else return false;
    }

    public function registerInsuranceDetails()
    {
        $pdo = $this->pdo;
        foreach ($_POST as $key => $value) {
            if (isset($$key)) continue;
            $$key = $value;
        }
        $success = '';

        try {
            $stmt = $pdo->prepare('INSERT INTO insurance_details 
            (repId, insuranceType, insuranceCompany, insuranceFrom, InsuranceUpTo, insuranceValue) VALUES (
                ?, ?, ?, ?, ?,
                ?
            )');
            $executeArray = array(
                $repId, $insuranceType, $insuranceCompany, $insuranceFrom, $InsuranceUpTo, $insuranceValue
            );
            $stmt->execute($executeArray);
            //success
            $success = 'done';
        } catch (PDOException $e) {
            //error
            $this->msg = 'Insurance data insertion failed: ' . $e->getMessage();
        }
        if ($success == 'done') return true;
        else return false;
    }

    public function registerTaxDetails()
    {
        $pdo = $this->pdo;
        foreach ($_POST as $key => $value) {
            if (isset($$key)) continue;
            $$key = $value;
        }
        $success = '';

        try {
            $stmt = $pdo->prepare('INSERT INTO tax_details 
            (repId, taxAmount, taxRecipientDate, taxUpTo, taxClearUpTo) VALUES (
                ?, ?, ?, ?, ?
            )');
            $executeArray = array(
                $repId, $taxAmount, $taxRecipientDate, $taxUpTo, $taxClearUpTo
            );
            $stmt->execute($executeArray);
            //success
            $success = 'done';
        } catch (PDOException $e) {
            //error
            $this->msg = 'Tax data insertion failed: ' . $e->getMessage();
        }
        if ($success == 'done') return true;
        else return false;
    }

    public function registerTestDriveResults()
    {
        $pdo = $this->pdo;
        foreach ($_POST as $key => $value) {
            if (isset($$key)) continue;
            $$key = $value;
        }
        $success = '';

        try {
            $stmt = $pdo->prepare('INSERT INTO testdrive_results 
            (repId, TDEngineCondition, TDClutch, TDAccelerator, TDGearShiftRatios, TDStearing, TDBreaking) VALUES (
                ?, ?, ?, ?, ?, ?, ?
            )');
            $executeArray = array(
                $repId, $TDEngineCondition, $TDClutch, $TDAccelerator, $TDGearShiftRatios, $TDStearing, $TDBreaking
            );
            $stmt->execute($executeArray);
            //success
            $success = 'done';
        } catch (PDOException $e) {
            //error
            $this->msg = 'Test drive results data insertion failed: ' . $e->getMessage();
        }
        if ($success == 'done') return true;
        else return false;
    }

    public function registerStearingConditions()
    {
        $pdo = $this->pdo;
        foreach ($_POST as $key => $value) {
            if (isset($$key)) continue;
            $$key = $value;
        }
        $success = '';

        try {
            $stmt = $pdo->prepare('INSERT INTO stearing_conditions 
            (repId, SCSteeringPlay, SCPowerSteering, SCStearing, SCSteeringCondition) VALUES (
                ?, ?, ?, ?, ?
            )');
            $executeArray = array(
                $repId, $SCSteeringPlay, $SCPowerSteering, $SCStearing, $SCSteeringCondition
            );
            $stmt->execute($executeArray);
            //success
            $success = 'done';
        } catch (PDOException $e) {
            //error
            $this->msg = 'Stearing conditions data insertion failed: ' . $e->getMessage();
        }
        if ($success == 'done') return true;
        else return false;
    }

    public function registerMechanicalConditions()
    {
        $pdo = $this->pdo;
        foreach ($_POST as $key => $value) {
            if (isset($$key)) continue;
            $$key = $value;
        }
        $success = '';

        try {
            $stmt = $pdo->prepare('INSERT INTO mechanical_conditions 
            (repId, MCEngineCondition, MCEngineRunning, MCEngineOilLevel, MCEngineOilFunction) VALUES (
                ?, ?, ?, ?, ?
            )');
            $executeArray = array(
                $repId, $MCEngineCondition, $MCEngineRunning, $MCEngineOilLevel, $MCEngineOilFunction
            );
            $stmt->execute($executeArray);
            //success
            $success = 'done';
        } catch (PDOException $e) {
            //error
            $this->msg = 'Mechanical conditions data insertion failed: ' . $e->getMessage();
        }
        if ($success == 'done') return true;
        else return false;
    }

    public function registerFourwheelerExteriorConditions()
    {
        $pdo = $this->pdo;
        foreach ($_POST as $key => $value) {
            if (isset($$key)) continue;
            $$key = $value;
        }
        $success = '';

        try {
            $stmt = $pdo->prepare('INSERT INTO fourwheeler_exterior_conditions 
            (repId, ExCGrill, ExCHeadLight, ExCHood, ExCFrontBumper, 
            ExCLeftFender, ExCRightFender, ExCLeftQuarter, ExCRightQuarter, ExCFrontWindshield, 
            ExCRightFrontDoor, ExCLeftFrontDoor, ExCRightRearDoor, ExCLeftRearDoor, ExCRoof, 
            ExCRearWindShield, ExCRearTailLight, ExCRearBumper, ExCBodyPaint, ExCDeckLid) VALUES (
                ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?
            )');
            $executeArray = array(
                $repId, $ExCGrill, $ExCHeadLight, $ExCHood, $ExCFrontBumper,
                $ExCLeftFender, $ExCRightFender, $ExCLeftQuarter, $ExCRightQuarter, $ExCFrontWindshield,
                $ExCRightFrontDoor, $ExCLeftFrontDoor, $ExCRightRearDoor, $ExCLeftRearDoor, $ExCRoof,
                $ExCRearWindShield, $ExCRearTailLight, $ExCRearBumper, $ExCBodyPaint, $ExCDeckLid
            );
            $stmt->execute($executeArray);
            //success
            $success = 'done';
        } catch (PDOException $e) {
            //error
            $this->msg = 'Four wheeler exterior conditions data insertion failed: ' . $e->getMessage();
        }
        if ($success == 'done') return true;
        else return false;
    }

    public function registerFourwheelerInteriorConditions()
    {
        $pdo = $this->pdo;
        foreach ($_POST as $key => $value) {
            if (isset($$key)) continue;
            $$key = $value;
        }
        $success = '';

        try {
            $stmt = $pdo->prepare('INSERT INTO fourwheeler_interior_conditions 
            (repId, InTDashboardCondition, InTFrontLeftSeat, InTFrontRightSeat, InTRearLeftSeat, 
            InTRearRightSeat, InTThirdRowSeatCondition, InTTrunkCargo, InTCruiseControl, InTAirbags, 
            InTPowerWindow, InTCarpetNFloorMat, IntOdometerCondition) VALUES (
                ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?,
                ?, ?, ?
            )');
            $executeArray = array(
                $repId, $InTDashboardCondition, $InTFrontLeftSeat, $InTFrontRightSeat, $InTRearLeftSeat,
                $InTRearRightSeat, $InTThirdRowSeatCondition, $InTTrunkCargo, $InTCruiseControl, $InTAirbags,
                $InTPowerWindow, $InTCarpetNFloorMat, $IntOdometerCondition
            );
            $stmt->execute($executeArray);
            //success
            $success = 'done';
        } catch (PDOException $e) {
            //error
            $this->msg = 'Four wheeler interior conditions data insertion failed: ' . $e->getMessage();
        }
        if ($success == 'done') return true;
        else return false;
    }

    public function registerFourwheelerVehicleCondition()
    {
        $pdo = $this->pdo;
        foreach ($_POST as $key => $value) {
            if (isset($$key)) continue;
            $$key = $value;
        }
        $success = '';

        try {
            $stmt = $pdo->prepare('INSERT INTO fourwheeler_vehicle_condition 
            (repId, VCRunningCondition, VCEngineStart, VCTransmissionCondition, VCTransmissionWorking, 
            VCGearShift, VCFrontSuspension, VCRearSuspension) VALUES (
                ?, ?, ?, ?, ?,
                ?, ?, ?
            )');
            $executeArray = array(
                $repId, $VCRunningCondition, $VCEngineStart, $VCTransmissionCondition, $VCTransmissionWorking,
                $VCGearShift, $VCFrontSuspension, $VCRearSuspension
            );
            $stmt->execute($executeArray);
            //success
            $success = 'done';
        } catch (PDOException $e) {
            //error
            $this->msg = 'Four wheeler Vehicle condition data insertion failed: ' . $e->getMessage();
        }
        if ($success == 'done') return true;
        else return false;
    }

    public function registerFourwheelerElectricalFunctions()
    {
        $pdo = $this->pdo;
        foreach ($_POST as $key => $value) {
            if (isset($$key)) continue;
            $$key = $value;
        }
        $success = '';

        try {
            $stmt = $pdo->prepare('INSERT INTO fourwheeler_electrical_functions 
            (repId, ECEletricalCondition, ECBatteryCondition, ECACCooling, ECPowerWindow, 
            ECACHeaterBlowerFan, ECElectricCoolingFan, ECCoolingSystemRadiator) VALUES (
                ?, ?, ?, ?, ?,
                ?, ?, ?
            )');
            $executeArray = array(
                $repId, $ECEletricalCondition, $ECBatteryCondition, $ECACCooling, $ECPowerWindow,
                $ECACHeaterBlowerFan, $ECElectricCoolingFan, $ECCoolingSystemRadiator
            );
            $stmt->execute($executeArray);
            //success
            $success = 'done';
        } catch (PDOException $e) {
            //error
            $this->msg = 'Four wheeler electrical functions data insertion failed: ' . $e->getMessage();
        }
        if ($success == 'done') return true;
        else return false;
    }

    public function registerFourwheelerTyreConditions()
    {
        $pdo = $this->pdo;
        foreach ($_POST as $key => $value) {
            if (isset($$key)) continue;
            $$key = $value;
        }
        $success = '';

        try {
            $stmt = $pdo->prepare('INSERT INTO fourwheeler_tyre_conditions 
            (repId, TCNoOfTyres, TCFrontRightWheelType, TCFrontLeftWheelType, TCRearRightWheelType, 
            TCRearLeftWheelType, TCSpareWheelType, TCFrontLeftWheel, TCFrontRightWheel, TCRearLeftWheel,
            TCRearRightWheel, TCSpareWheel) VALUES (
                ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?,
                ?, ?
            )');
            $executeArray = array(
                $repId, $TCNoOfTyres, $TCFrontRightWheelType, $TCFrontLeftWheelType, $TCRearRightWheelType,
                $TCRearLeftWheelType, $TCSpareWheelType, $TCFrontLeftWheel, $TCFrontRightWheel, $TCRearLeftWheel,
                $TCRearRightWheel, $TCSpareWheel
            );
            $stmt->execute($executeArray);
            //success
            $success = 'done';
        } catch (PDOException $e) {
            //error
            $this->msg = 'Four wheeler tyre conditions data insertion failed: ' . $e->getMessage();
        }
        if ($success == 'done') return true;
        else return false;
    }

    public function uploadFourwheelerImages()
    {
        $fileArray = array(
            "carAvatarImage", "chassisImprintImage", "carFrontImage", "carRightImage",
            "carRearImage", "carLeftImage", "dashboardImage", "gearAndSeatImage", "rearSeatImage", "odometerImage",
            "engineRoomImage", "regPlateImage", "chassisNoImage", "rcFrontImage", "rcBackImage",
            "tyre1Image", "tyre2Image", "tyre3Image", "tyre4Image"
        );
        $clearToInsert = false;
        $imageNames = array();
        $repId = $_POST["repId"];
        array_push($imageNames, $repId);
        foreach ($fileArray as $value) {
            $fileName = $this->uploadSingleImage($value);
            if ($fileName) {
                array_push($imageNames, $fileName);
                $clearToInsert = true;
            } else {
                $clearToInsert = false;
                break;
            }
        }
        if ($clearToInsert) {
            return $this->insertFourWheelerImagesUrl($imageNames);
        } else {
            return false;
        }
    }

    public function insertFourWheelerImagesUrl($imageNames)
    {
        $pdo = $this->pdo;
        foreach ($_POST as $key => $value) {
            if (isset($$key)) continue;
            $$key = $value;
        }
        $success = '';

        try {
            $stmt = $pdo->prepare('INSERT INTO fourwheeler_image_info
            (repId, carAvatarImage, chassisImprintImage, carFrontImage, carRightImage, 
            carRearImage, carLeftImage, dashboardImage, gearAndSeatImage, rearSeatImage,
            odometerImage, engineRoomImage, regPlateImage, chassisNoImage, rcFrontImage,
            rcBackImage, tyre1Image, tyre2Image, tyre3Image, tyre4Image) VALUES (
                ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?
            )');
            $stmt->execute($imageNames);
            //success
            $success = 'done';
        } catch (PDOException $e) {
            //error
            $this->msg = 'Image data insertion failed: ' . $e->getMessage();
        }
        if ($success == 'done') return true;
        else return false;
    }

    public function uploadSingleImage($image)
    {
        $file_name = $_FILES[$image]['name'];
        $file_size = $_FILES[$image]['size'];
        $file_tmp = $_FILES[$image]['tmp_name'];
        $target_dir = "/uploadedImages/";
        $target_file = $target_dir . basename($file_name);
        if (file_exists($target_dir . $target_file)) {
            $this->msg = "$image Image with same name already exists. Please upload a different image or rename the image file.";
            return false;
        }

        if ($file_size > 5242880) {
            $this->msg = "File size must be less than 5 MB in size for the file $image";
            return false;
        }
        $success = '';
        try {
            move_uploaded_file($file_tmp, SITE_ROOT . $target_file);
            //success
            $success = 'done';
        } catch (Exception $e) {
            //error
            $this->msg = 'Error in moving files inside server.' . $e->getMessage();
        }
        if ($success == 'done') return $file_name;
        else return false;
    }

    public function uploadCVImages()
    {
        $fileArray = array(
            "CVAvatarImage", "chassisImprintImage", "CVFrontImage", "CVRightImage",
            "CVRearImage", "CVLeftImage", "dashboardImage", "odometerImage", "insideCabinImage",
            "engineRoomImage", "regPlateImage", "chassisNoImage", "rcFrontImage", "rcBackImage",
            "tyre1Image", "tyre2Image", "tyre3Image", "tyre4Image", "tyre5Image",
            "tyre6Image", "tyre7Image", "tyre8Image", "tyre9Image", "tyre10Image"
        );
        $clearToInsert = false;
        $imageNames = array();
        $repId = $_POST["repId"];
        array_push($imageNames, $repId);
        foreach ($fileArray as $value) {
            $fileName = $this->uploadSingleImage($value);
            if ($fileName) {
                array_push($imageNames, $fileName);
                $clearToInsert = true;
            } else {
                $clearToInsert = false;
                break;
            }
        }
        if ($clearToInsert) {
            return $this->insertCVImagesUrl($imageNames);
        } else {
            return false;
        }
    }

    public function insertCVImagesUrl($imageNames)
    {
        $pdo = $this->pdo;
        foreach ($_POST as $key => $value) {
            if (isset($$key)) continue;
            $$key = $value;
        }
        $success = '';

        try {
            $stmt = $pdo->prepare('INSERT INTO CV_image_info
            (repId, CVAvatarImage, chassisImprintImage, CVFrontImage, CVRightImage, 
            CVRearImage, CVLeftImage, dashboardImage, odometerImage, insideCabinImage,
            engineRoomImage, regPlateImage, chassisNoImage, rcFrontImage, rcBackImage,
            tyre1Image, tyre2Image, tyre3Image, tyre4Image, tyre5Image,
            tyre6Image, tyre7Image, tyre8Image, tyre9Image, tyre10Image) VALUES (
                ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?,
                ?, ?, ?, ?
            )');
            $stmt->execute($imageNames);
            //success
            $success = 'done';
        } catch (PDOException $e) {
            //error
            $this->msg = 'Image data insertion failed: ' . $e->getMessage();
        }
        if ($success == 'done') return true;
        else return false;
    }

    public function registerCVExteriorConditions()
    {
        $pdo = $this->pdo;
        foreach ($_POST as $key => $value) {
            if (isset($$key)) continue;
            $$key = $value;
        }
        $success = '';

        try {
            $stmt = $pdo->prepare('INSERT INTO CV_exterior_conditions 
            (repId, ExCHeadLight, ExCRearTailLight, ExCHood, ExCLeftFender, 
            ExCRightFender, ExCWindshield, ExCChassisCondition) VALUES (
                ?, ?, ?, ?, ?,
                ?, ?, ?
            )');
            $executeArray = array(
                $repId, $ExCHeadLight, $ExCRearTailLight, $ExCHood, $ExCLeftFender,
                $ExCRightFender, $ExCWindshield, $ExCChassisCondition
            );
            $stmt->execute($executeArray);
            //success
            $success = 'done';
        } catch (PDOException $e) {
            //error
            $this->msg = 'CV exterior conditions data insertion failed: ' . $e->getMessage();
        }
        if ($success == 'done') return true;
        else return false;
    }

    public function registerCVElectricalFunctions()
    {
        $pdo = $this->pdo;
        foreach ($_POST as $key => $value) {
            if (isset($$key)) continue;
            $$key = $value;
        }
        $success = '';

        try {
            $stmt = $pdo->prepare('INSERT INTO CV_electrical_functions 
            (repId, ECEletricalCondition, ECBatteryCondition, ECACCooling, ECPowerWindow, 
            ECACRefrigrationUnit, ECACHvacCooling, ECACHeaterBlowerFan, ECElectricCoolingFan, ECCoolingSystemRadiator) VALUES (
                ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?
            )');
            $executeArray = array(
                $repId, $ECEletricalCondition, $ECBatteryCondition, $ECACCooling, $ECPowerWindow,
                $ECACRefrigrationUnit, $ECACHvacCooling, $ECACHeaterBlowerFan, $ECElectricCoolingFan, $ECCoolingSystemRadiator
            );
            $stmt->execute($executeArray);
            //success
            $success = 'done';
        } catch (PDOException $e) {
            //error
            $this->msg = 'CV Electrical functions data insertion failed: ' . $e->getMessage();
        }
        if ($success == 'done') return true;
        else return false;
    }

    public function registerCVTransmissionCondition()
    {
        $pdo = $this->pdo;
        foreach ($_POST as $key => $value) {
            if (isset($$key)) continue;
            $$key = $value;
        }
        $success = '';

        try {
            $stmt = $pdo->prepare('INSERT INTO CV_transmission_conditions 
            (repId, TCTransmissionCondition, TCTransmissionWorking, TCFrontSuspension, TCRearSuspension) VALUES (
                ?, ?, ?, ?, ?
            )');
            $executeArray = array(
                $repId, $TCTransmissionCondition, $TCTransmissionWorking, $TCFrontSuspension, $TCRearSuspension
            );
            $stmt->execute($executeArray);
            //success
            $success = 'done';
        } catch (PDOException $e) {
            //error
            $this->msg = 'CV transmission conditions data insertion failed: ' . $e->getMessage();
        }
        if ($success == 'done') return true;
        else return false;
    }

    public function registerCVVehicleBodyDetails()
    {
        $pdo = $this->pdo;
        foreach ($_POST as $key => $value) {
            if (isset($$key)) continue;
            $$key = $value;
        }
        $success = '';

        try {
            $stmt = $pdo->prepare('INSERT INTO CV_vehicle_body_details 
            (repId, LBType, LBBuild, LBLeftSideGate, LBRightSideGate,
            LBLoadFloor, LBOverallLoadBody, LBBodyPaint, LBFuelTank) VALUES (
                ?, ?, ?, ?, ?,
                ?, ?, ?, ?
            )');
            $executeArray = array(
                $repId, $LBType, $LBBuild, $LBLeftSideGate, $LBRightSideGate,
                $LBLoadFloor, $LBOverallLoadBody, $LBBodyPaint, $LBFuelTank
            );
            $stmt->execute($executeArray);
            //success
            $success = 'done';
        } catch (PDOException $e) {
            //error
            $this->msg = 'CV vehicle body data insertion failed: ' . $e->getMessage();
        }
        if ($success == 'done') return true;
        else return false;
    }

    public function registerCVCabinConditions()
    {
        $pdo = $this->pdo;
        foreach ($_POST as $key => $value) {
            if (isset($$key)) continue;
            $$key = $value;
        }
        $success = '';

        try {
            $stmt = $pdo->prepare('INSERT INTO CV_cabin_conditions
            (repId, CabinFrontBumper, CabinRearBumper, CabinRightDoor, CabinLeftDoor,
            CabinDashboardCondition, CabinDriverSeat, CabinCoDriverSeat, CabinThirdRow, CabinABS,
            CabinRadiator) VALUES (
                ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?,
                ?
            )');
            $executeArray = array(
                $repId, $CabinFrontBumper, $CabinRearBumper, $CabinRightDoor, $CabinLeftDoor,
                $CabinDashboardCondition, $CabinDriverSeat, $CabinCoDriverSeat, $CabinThirdRow, $CabinABS,
                $CabinRadiator
            );
            $stmt->execute($executeArray);
            //success
            $success = 'done';
        } catch (PDOException $e) {
            //error
            $this->msg = 'CV cabin conditions data insertion failed: ' . $e->getMessage();
        }
        if ($success == 'done') return true;
        else return false;
    }

    public function registerCVTyreConditions()
    {
        $pdo = $this->pdo;
        foreach ($_POST as $key => $value) {
            if (isset($$key)) continue;
            $$key = $value;
        }
        $success = '';

        try {
            $stmt = $pdo->prepare('INSERT INTO CV_tyre_conditions
            (repId, TCNofTyres, TCFrontLeftTyresCondition, TCFrontRightTyresCondition, TCRearLeftTyresCondition,
            TCRearRightTyresCondition, TCSpareTyresCondition, TCTyre5Condition, TCTyre6Condition, TCTyre7Condition,
            TCTyre8Condition, TCTyre9Condition, TCTyre10Condition, TCFrontLeftWheelLife, TCFrontRightWheelLife
            TCRearLeftWheelLife, TCRearRightWheelLife, TCSpareWheelLife, TCTyre5Life, TCTyre6Life,
            TCTyre7Life, TCTyre8Life, TCTyre9Life, TCTyre10Life) VALUES (
                ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?,
                ?, ?, ?, ?, ?,
                ?, ?, ?, ?
            )');
            $executeArray = array(
                $repId, $TCNofTyres, $TCFrontLeftTyresCondition, $TCFrontRightTyresCondition, $TCRearLeftTyresCondition,
                $TCRearRightTyresCondition, $TCSpareTyresCondition, $TCTyre5Condition, $TCTyre6Condition, $TCTyre7Condition,
                $TCTyre8Condition, $TCTyre9Condition, $TCTyre10Condition, $TCFrontLeftWheelLife, $TCFrontRightWheelLife,
                $TCRearLeftWheelLife, $TCRearRightWheelLife, $TCSpareWheelLife, $TCTyre5Life, $TCTyre6Life,
                $TCTyre7Life, $TCTyre8Life, $TCTyre9Life, $TCTyre10Life
            );
            $stmt->execute($executeArray);
            //success
            $success = 'done';
        } catch (PDOException $e) {
            //error
            $this->msg = 'CV Tyre conditions data insertion failed: ' . $e->getMessage();
        }
        if ($success == 'done') return true;
        else return false;
    }

    /**
     * Check if repid is already in the db
     * @param int $mobile User mobile number.
     * @return boolean of success.
     */
    private function checkforExistingRepId($repId)
    {
        $pdo = $this->pdo;
        $stmt = $pdo->prepare('SELECT repId FROM vehicle_details WHERE repId = ? limit 1');
        $stmt->execute([$repId]);
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    private function checkforExistingRegno($regNo)
    {
        $pdo = $this->pdo;
        $stmt = $pdo->prepare('SELECT repId FROM vehicle_details WHERE vehicleRegNo = ? limit 1');
        $stmt->execute([$regNo]);
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function editUser($username, $pass, $mobile, $usertype)
    {
        $pdo = $this->pdo;
        $pass = $this->hashPass($pass);
        $stmt = $pdo->prepare('UPDATE registered_users SET username = ?, password = ?, usertype = ? WHERE mobile = ?');
        if ($stmt->execute([$username, $pass, $usertype, $mobile])) {
            return $this->success("User changes saved successfully.");
        } else {
            return $this->error('User editing failed');
        }
    }

    public function deleteUser($mobile)
    {
        $pdo = $this->pdo;
        if (!(isset($mobile))) {
            echo 'Insert all valid required fields.';
        }
        if ($this->checkForExistingMobile($mobile)) {
            $stmt = $pdo->prepare('DELETE FROM registered_users WHERE mobile = ?');
            if ($stmt->execute([$mobile])) {
                echo "User deleted successfully.";
            } else {
                echo "User deleting failed";
            }
        } else {
            echo 'User with mobile number does not exist';
        }
    }

    public function deleteEntryFromTables($repId, $vehicleType)
    {
        if ($this->checkforExistingRepId($repId)) {
            if ($vehicleType == "four-wheeler") {
                $result = $this->deleteFourwheelerImages($repId) and
                    $this->deleteCommonValues($repId) and
                    $this->deleteFourWheelerFields($repId);
                if ($result) {
                    echo "Record deleted successfully.";
                } else {
                    $error = $this->msg;
                    echo "Record deleting failed:$error";
                }
            } else if ($vehicleType == "CV") {
                $result = $this->deleteCVImages($repId) and
                    $this->deleteCommonValues($repId) and
                    $this->deleteCVFields($repId);
                if ($result) {
                    echo "Record deleted successfully.";
                } else {
                    $error = $this->msg;
                    echo "Record deleting failed:$error";
                }
            }
        } else {
            echo 'Record with repId does not exist';
        }
    }

    public function deleteCommonValues($repId)
    {
        $pdo = $this->pdo;
        $success = '';

        try {
            $stmt = $pdo->prepare('DELETE t1, t2, t3, t4, t5, t6, t7 FROM
            vehicle_details as t1
            INNER JOIN  parivahan_details as t2 on t1.repId = t2.repId
            INNER JOIN  insurance_details as t3 on t1.repId=t3.repId
            INNER JOIN  tax_details as t4 on t1.repId=t4.repId
            INNER JOIN  testdrive_results as t5 on t1.repId=t5.repId
            INNER JOIN  stearing_conditions as t6 on t1.repId=t6.repId
            INNER JOIN  mechanical_conditions as t7 on t1.repId=t7.repId
            WHERE  t1.repId = ?');
            $stmt->execute([$repId]);
            //success
            $success = 'done';
        } catch (PDOException $e) {
            //error
            $this->msg = 'Common data deletion failed: ' . $e->getMessage();
        }
        if ($success == 'done') return true;
        else return false;
    }

    public function deleteFourWheelerFields($repId)
    {
        $pdo = $this->pdo;
        $success = '';

        try {
            $stmt = $pdo->prepare('DELETE t1, t2, t3, t4, t5 FROM
            fourwheeler_exterior_conditions as t1
            INNER JOIN  fourwheeler_interior_conditions as t2 on t1.repId = t2.repId
            INNER JOIN  fourwheeler_vehicle_condition as t3 on t1.repId=t3.repId
            INNER JOIN  fourwheeler_electrical_functions as t4 on t1.repId=t4.repId
            INNER JOIN  fourwheeler_tyre_conditions as t5 on t1.repId=t5.repId
            WHERE  t1.repId = ?');
            $stmt->execute([$repId]);
            //success
            $success = 'done';
        } catch (PDOException $e) {
            //error
            $this->msg = 'Four wheeler data deletion failed: ' . $e->getMessage();
        }
        if ($success == 'done') return true;
        else return false;
    }

    public function deleteFourwheelerImages($repId)
    {
        $pdo = $this->pdo;
        $success = '';

        try {
            if ($this->deleteIndividualFourwheelerImages($repId)) {
                $stmt1 = $pdo->prepare('DELETE FROM fourwheeler_image_info WHERE repId = ?');
                $stmt1->execute([$repId]);
                //success
                $success = 'done';
            }
        } catch (PDOException $e) {
            //error
            $this->msg = 'Four wheeler image deletion failed: ' . $e->getMessage();
        }
        if ($success == 'done') return true;
        else return false;
    }

    public function deleteIndividualFourwheelerImages($repId)
    {
        $pdo = $this->pdo;
        $success = '';

        try {
            $stmt = $pdo->prepare('SELECT * FROM fourwheeler_image_info WHERE repId = ?');
            $stmt->execute([$repId]);
            $columns = $stmt->fetch(PDO::FETCH_ASSOC);
            $target_dir = "/uploadedImages/";
            foreach ($columns as $key => $value) {
                if ($key != 'repId' and file_exists(SITE_ROOT . $target_dir . $value)) {
                    unlink(SITE_ROOT . $target_dir . $value);
                    $success = 'done';
                }
            }
        } catch (Exception $e) {
            //error
            $this->msg = 'Four wheeler image removal failed: ' . $e->getMessage();
        }
        if ($success == 'done') return true;
        else return false;
    }

    public function deleteCVFields($repId)
    {
        $pdo = $this->pdo;
        $success = '';

        try {
            $stmt = $pdo->prepare('DELETE t1, t3, t4, t5, t6, t7 FROM
            CV_cabin_conditions as t1
            INNER JOIN  CV_exterior_conditions as t3 on t1.repId=t3.repId
            INNER JOIN  CV_electrical_functions as t4 on t1.repId=t4.repId
            INNER JOIN  CV_transmission_conditions as t5 on t1.repId=t5.repId
            INNER JOIN  CV_vehicle_body_details as t6 on t1.repId=t6.repId
            INNER JOIN  CV_tyre_conditions as t7 on t1.repId=t7.repId
            WHERE  t1.repId = ?');
            $stmt->execute([$repId]);
            //success
            $success = 'done';
        } catch (PDOException $e) {
            //error
            $this->msg = 'Four wheeler data deletion failed: ' . $e->getMessage();
        }
        if ($success == 'done') return true;
        else return false;
    }

    public function deleteCVImages($repId)
    {
        $pdo = $this->pdo;
        $success = '';

        try {
            if ($this->deleteIndividualCVImages($repId)) {
                $stmt1 = $pdo->prepare('DELETE FROM CV_image_info WHERE repId = ?');
                $stmt1->execute([$repId]);
                //success
                $success = 'done';
            }
        } catch (PDOException $e) {
            //error
            $this->msg = 'CV image deletion failed: ' . $e->getMessage();
        }
        if ($success == 'done') return true;
        else return false;
    }
    public function deleteIndividualCVImages($repId)
    {
        $pdo = $this->pdo;
        $success = '';

        try {
            $stmt = $pdo->prepare('SELECT * FROM CV_image_info WHERE repId = ?');
            $stmt->execute([$repId]);
            $columns = $stmt->fetch(PDO::FETCH_ASSOC);
            $target_dir = "/uploadedImages/";
            // what happens if the image is not available, it wont return true then the image list will not be deleted.
            foreach ($columns as $key => $value) {
                if ($key != 'repId' and file_exists(SITE_ROOT . $target_dir . $value)) {
                    unlink(SITE_ROOT . $target_dir . $value);
                    $success = 'done';
                }
            }
        } catch (Exception $e) {
            //error
            $this->msg = 'CV image removal failed: ' . $e->getMessage();
        }
        if ($success == 'done') return true;
        else return false;
    }

    public function getVehicleDetails($repId, $vehicleType)
    {
        if ($this->checkforExistingRepId($repId)) {
            if ($vehicleType == "four-wheeler") {
                $success = $this->getFourwheelerDetails($repId);
                if ($success) {
                    $columns = $this->columns;
                    $columns["mainRating"] = $this->getFourWheelerRating($columns);
                    $columns["avatarImage"] = $columns["carAvatarImage"];
                    return $this->success($columns);
                } else {
                    $error = $this->msg;
                    return $this->error('getting vehicle details failed:' . $error);
                }
            } else if ($vehicleType == "CV") {
                $success = $this->getCVDetails($repId);
                if ($success) {
                    $columns = $this->columns;
                    $columns["mainRating"] = $this->getCVRating($columns);
                    $columns["avatarImage"] = $columns["CVAvatarImage"];
                    return $this->success($columns);
                } else {
                    $error = $this->msg;
                    return $this->error('getting vehicle details failed:' . $error);
                }
            }
        } else {
            return $this->error('Record with repId does not exist');
        }
    }

    public function getCVRating($columns)
    {
        $commonRating = $this->getMainRating($columns);
        $subTotal = $commonRating + $columns["LBLeftSideGate"] + $columns["LBRightSideGate"] + $columns["LBLoadFloor"]
            + $columns["LBOverallLoadBody"] + $columns["LBBodyPaint"] + $columns["LBFuelTank"] + $columns["ExCWindshield"]
            + $columns["ExCChassisCondition"] + $columns["ECEletricalCondition"] + $columns["ECBatteryCondition"] + $columns["ECACCooling"]
            + $columns["ECPowerWindow"] + $columns["ECACRefrigrationUnit"] + $columns["ECACHvacCooling"] + $columns["TCTransmissionCondition"]
            + $columns["TCTransmissionWorking"] + $columns["TCFrontSuspension"] + $columns["TCRearSuspension"] + $columns["TCFrontLeftTyresCondition"]
            + $columns["TCFrontRightTyresCondition"] + $columns["TCRearLeftTyresCondition"] +  $columns["TCRearRightTyresCondition"] + $columns["TCSpareTyresCondition"]
            + $columns["TCTyre5Condition"] + $columns["TCTyre6Condition"] + $columns["TCTyre7Condition"] + $columns["TCTyre8Condition"]
            + $columns["TCTyre9Condition"] + $columns["TCTyre10Condition"];
        $total = $subTotal;
        $result = $total / 30;
        $result = floor($result * 100) / 100;
        return $result;
    }

    public function getFourWheelerRating($columns)
    {
        $commonRating = $this->getMainRating($columns);
        $windshield = $columns["ExCRearWindShield"] === "Original" ? 5 : 3;
        $tailLight = $columns["ExCRearTailLight"] === "Working" ? 5 : 2;
        $subTotal = $commonRating + $columns["ExCGrill"] + $columns["ExCFrontBumper"] + $columns["ExCLeftQuarter"]
            + $columns["ExCRightQuarter"] + $columns["ExCRightFrontDoor"] + $columns["ExCLeftFrontDoor"] + $columns["ExCRightRearDoor"]
            + $columns["ExCLeftRearDoor"] + $columns["ExCRoof"] + $columns["ExCRearBumper"] + $columns["ExCBodyPaint"]
            + $columns["ExCDeckLid"] + $columns["InTDashboardCondition"] + $columns["InTFrontLeftSeat"] + $columns["InTFrontRightSeat"]
            + $columns["InTRearLeftSeat"] + $columns["InTRearRightSeat"] + $columns["InTThirdRowSeatCondition"] + $columns["InTTrunkCargo"]
            + $columns["IntOdometerCondition"] + $columns["VCRunningCondition"] + $columns["VCTransmissionCondition"] + $columns["VCTransmissionWorking"]
            + $columns["VCGearShift"] + $columns["VCFrontSuspension"] + $columns["VCRearSuspension"];
        $total = $windshield + $tailLight + $subTotal;
        $result = $total / 29;
        $result = floor($result * 100) / 100;
        return $result;
    }

    public function getMainRating($columns)
    {
        $engine = $columns["engineCondition"] === "Starts" ? 5 : 1;
        $vehicleCondition = $columns["vehicleCondition"] === "Running Condition" ? 5 : 1;
        $batteryStatus = $columns["batteryStatus"] === "Available" ? 5 : 1;
        $subTotal = $columns["tyreCondition"] + $columns["TDEngineCondition"] + $columns["TDClutch"] + $columns["TDAccelerator"]
            + $columns["TDGearShiftRatios"] + $columns["TDStearing"] + $columns["TDBreaking"] + $columns["MCEngineCondition"]
            + $columns["MCEngineOilLevel"] + $columns["MCEngineOilFunction"] + $columns["SCSteeringCondition"]
            + $columns["ECEletricalCondition"] + $columns["ECBatteryCondition"] + $columns["ECACCooling"] + $columns["ECPowerWindow"]
            + $columns["ECACHeaterBlowerFan"] + $columns["ECElectricCoolingFan"] + $columns["ECCoolingSystemRadiator"] + $columns["ExCHeadLight"]
            + $columns["ExCHood"] + $columns["ExCLeftFender"] + $columns["ExCRightFender"];
        $total = $engine + $vehicleCondition + $batteryStatus + $subTotal;
        $result = $total / 25;
        $result = floor($result * 100) / 100;
        return $result;
    }

    public function getFourwheelerDetails($repId)
    {
        $pdo = $this->pdo;
        $success = '';

        try {
            $stmt = $pdo->prepare('SELECT t1.*, t2.*, t3.*, t4.*, t5.*, t6.*, t7.*, t8.*, t9.*, t10.*, t11.*, t12.*, t13.*
                FROM vehicle_details as t1 
                INNER JOIN parivahan_details as t2 on t1.repId = t2.repId 
                INNER JOIN insurance_details as t3 on t1.repId=t3.repId 
                INNER JOIN tax_details as t4 on t1.repId=t4.repId 
                INNER JOIN testdrive_results as t5 on t1.repId=t5.repId 
                INNER JOIN stearing_conditions as t6 on t1.repId=t6.repId 
                INNER JOIN mechanical_conditions as t7 on t1.repId=t7.repId 
                INNER JOIN fourwheeler_exterior_conditions as t8 on t1.repId=t8.repId
                INNER JOIN fourwheeler_interior_conditions as t9 on t1.repId = t9.repId
                INNER JOIN fourwheeler_vehicle_condition as t10 on t1.repId=t10.repId
                INNER JOIN fourwheeler_electrical_functions as t11 on t1.repId=t11.repId
                INNER JOIN fourwheeler_tyre_conditions as t12 on t1.repId=t12.repId
                INNER JOIN fourwheeler_image_info as t13 on t1.repId=t13.repId
                WHERE t1.repId = ?');
            $stmt->execute([$repId]);
            $columns = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->columns = $columns;
            $success = 'done';
        } catch (PDOException $e) {
            //error
            $this->msg = 'Getting fourwheeler data from DB failed: ' . $e->getMessage();
        }
        if ($success == 'done') return true;
        else return false;
    }

    public function getCVDetails($repId)
    {
        $pdo = $this->pdo;
        $success = '';

        try {
            $stmt = $pdo->prepare('SELECT t1.*, t2.*, t3.*, t4.*, t5.*, t6.*, t7.*, t8.*, t9.*, t10.*, t11.*, t12.*, t13.*, t14.*
                FROM vehicle_details as t1 
                INNER JOIN parivahan_details as t2 on t1.repId = t2.repId 
                INNER JOIN insurance_details as t3 on t1.repId=t3.repId 
                INNER JOIN tax_details as t4 on t1.repId=t4.repId 
                INNER JOIN testdrive_results as t5 on t1.repId=t5.repId 
                INNER JOIN stearing_conditions as t6 on t1.repId=t6.repId 
                INNER JOIN mechanical_conditions as t7 on t1.repId=t7.repId
                INNER JOIN CV_cabin_conditions as t8 on t1.repId=t8.repId
                INNER JOIN CV_exterior_conditions as t9 on t1.repId = t9.repId
                INNER JOIN CV_electrical_functions as t10 on t1.repId=t10.repId
                INNER JOIN CV_transmission_conditions as t11 on t1.repId=t11.repId
                INNER JOIN CV_vehicle_body_details as t12 on t1.repId=t12.repId
                INNER JOIN CV_image_info as t13 on t1.repId=t13.repId
                INNER JOIN CV_tyre_conditions as t14 on t1.repId=t14.repId
                WHERE t1.repId = ?');
            $stmt->execute([$repId]);
            $columns = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->columns = $columns;
            $success = 'done';
        } catch (PDOException $e) {
            //error
            $this->msg = 'Getting CV data from DB failed: ' . $e->getMessage();
        }
        if ($success == 'done') return true;
        else return false;
    }

    /**
     * Password hash function
     * @param string $password User password.
     * @return string $password Hashed password.
     */
    private function hashPass($pass)
    {
        return password_hash($pass, PASSWORD_DEFAULT);
    }
}
