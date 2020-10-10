-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 03, 2020 at 08:26 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fast-value-inspection`
--
CREATE DATABASE IF NOT EXISTS `fast-value-inspection` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `fast-value-inspection`;

-- --------------------------------------------------------

--
-- Table structure for table `CV_cabin_conditions`
--

CREATE TABLE `CV_cabin_conditions` (
  `repId` varchar(255) NOT NULL,
  `CabinFrontBumper` int(3) NOT NULL,
  `CabinRearBumper` int(3) NOT NULL,
  `CabinRightDoor` int(3) NOT NULL,
  `CabinLeftDoor` int(3) NOT NULL,
  `CabinDashboardCondition` int(3) NOT NULL,
  `CabinDriverSeat` int(3) NOT NULL,
  `CabinCoDriverSeat` int(3) NOT NULL,
  `CabinThirdRow` int(3) NOT NULL,
  `CabinABS` int(3) NOT NULL,
  `CabinRadiator` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `CV_electrical_functions`
--

CREATE TABLE `CV_electrical_functions` (
  `repId` varchar(255) NOT NULL,
  `ECEletricalCondition` int(3) NOT NULL,
  `ECBatteryCondition` int(3) NOT NULL,
  `ECACCooling` int(3) NOT NULL,
  `ECPowerWindow` int(3) NOT NULL,
  `ECACRefrigrationUnit` int(3) NOT NULL,
  `ECACHvacCooling` int(3) NOT NULL,
  `ECACHeaterBlowerFan` int(3) NOT NULL,
  `ECElectricCoolingFan` int(3) NOT NULL,
  `ECCoolingSystemRadiator` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `CV_exterior_conditions`
--

CREATE TABLE `CV_exterior_conditions` (
  `repId` varchar(255) NOT NULL,
  `ExCHeadLight` int(3) NOT NULL,
  `ExCRearTailLight` varchar(50) NOT NULL,
  `ExCHood` int(3) NOT NULL,
  `ExCLeftFender` int(3) NOT NULL,
  `ExCRightFender` int(3) NOT NULL,
  `ExCWindshield` int(3) NOT NULL,
  `ExCChassisCondition` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `CV_image_info`
--

CREATE TABLE `CV_image_info` (
  `repId` varchar(255) NOT NULL,
  `CVAvatarImage` tinytext NOT NULL,
  `chassisImprintImage` tinytext NOT NULL,
  `CVFrontImage` tinytext NOT NULL,
  `CVRightImage` tinytext NOT NULL,
  `CVRearImage` tinytext NOT NULL,
  `CVLeftImage` tinytext NOT NULL,
  `dashboardImage` tinytext NOT NULL,
  `odometerImage` tinytext NOT NULL,
  `insideCabinImage` tinytext NOT NULL,
  `engineRoomImage` tinytext NOT NULL,
  `regPlateImage` tinytext NOT NULL,
  `chassisNoImage` tinytext NOT NULL,
  `rcFrontImage` tinytext NOT NULL,
  `rcBackImage` tinytext NOT NULL,
  `tyre1Image` tinytext NOT NULL,
  `tyre2Image` tinytext NOT NULL,
  `tyre3Image` tinytext NOT NULL,
  `tyre4Image` tinytext NOT NULL,
  `tyre5Image` tinytext NOT NULL,
  `tyre6Image` tinytext NOT NULL,
  `tyre7Image` tinytext NOT NULL,
  `tyre8Image` tinytext NOT NULL,
  `tyre9Image` tinytext NOT NULL,
  `tyre10Image` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `CV_transmission_conditions`
--

CREATE TABLE `CV_transmission_conditions` (
  `repId` varchar(255) NOT NULL,
  `TCTransmissionCondition` int(3) NOT NULL,
  `TCTransmissionWorking` int(3) NOT NULL,
  `TCFrontSuspension` int(3) NOT NULL,
  `TCRearSuspension` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `CV_tyre_conditions`
--

CREATE TABLE `CV_tyre_conditions` (
  `repId` varchar(255) NOT NULL,
  `TCNofTyres` varchar(10) NOT NULL,
  `TCFrontLeftTyresCondition` int(3) NOT NULL,
  `TCFrontRightTyresCondition` int(3) NOT NULL,
  `TCRearLeftTyresCondition` int(3) NOT NULL,
  `TCRearRightTyresCondition` int(3) NOT NULL,
  `TCSpareTyresCondition` int(3) NOT NULL,
  `TCTyre5Condition` int(3) NOT NULL,
  `TCTyre6Condition` int(3) NOT NULL,
  `TCTyre7Condition` int(3) NOT NULL,
  `TCTyre8Condition` int(3) NOT NULL,
  `TCTyre9Condition` int(3) NOT NULL,
  `TCTyre10Condition` int(3) NOT NULL,
  `TCFrontLeftWheelLife` varchar(50) NOT NULL,
  `TCFrontRightWheelLife` varchar(50) NOT NULL,
  `TCRearLeftWheelLife` varchar(50) NOT NULL,
  `TCRearRightWheelLife` varchar(50) NOT NULL,
  `TCSpareWheelLife` varchar(50) NOT NULL,
  `TCTyre5Life` varchar(50) NOT NULL,
  `TCTyre6Life` varchar(50) NOT NULL,
  `TCTyre7Life` varchar(50) NOT NULL,
  `TCTyre8Life` varchar(50) NOT NULL,
  `TCTyre9Life` varchar(50) NOT NULL,
  `TCTyre10Life` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `CV_vehicle_body_details`
--

CREATE TABLE `CV_vehicle_body_details` (
  `repId` varchar(255) NOT NULL,
  `LBType` varchar(50) NOT NULL,
  `LBBuild` varchar(50) NOT NULL,
  `LBLeftSideGate` int(3) NOT NULL,
  `LBRightSideGate` int(3) NOT NULL,
  `LBLoadFloor` int(3) NOT NULL,
  `LBOverallLoadBody` int(3) NOT NULL,
  `LBBodyPaint` int(3) NOT NULL,
  `LBFuelTank` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fourwheeler_electrical_functions`
--

CREATE TABLE `fourwheeler_electrical_functions` (
  `repId` varchar(255) NOT NULL,
  `ECEletricalCondition` int(3) NOT NULL,
  `ECBatteryCondition` int(3) NOT NULL,
  `ECACCooling` int(3) NOT NULL,
  `ECPowerWindow` int(3) NOT NULL,
  `ECACHeaterBlowerFan` int(3) NOT NULL,
  `ECElectricCoolingFan` int(3) NOT NULL,
  `ECCoolingSystemRadiator` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fourwheeler_electrical_functions`
--

INSERT INTO `fourwheeler_electrical_functions` (`repId`, `ECEletricalCondition`, `ECBatteryCondition`, `ECACCooling`, `ECPowerWindow`, `ECACHeaterBlowerFan`, `ECElectricCoolingFan`, `ECCoolingSystemRadiator`) VALUES
('123', 5, 5, 5, 5, 5, 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `fourwheeler_exterior_conditions`
--

CREATE TABLE `fourwheeler_exterior_conditions` (
  `repId` varchar(255) NOT NULL,
  `ExCGrill` int(3) NOT NULL,
  `ExCHeadLight` int(3) NOT NULL,
  `ExCHood` int(3) NOT NULL,
  `ExCFrontBumper` int(3) NOT NULL,
  `ExCLeftFender` int(3) NOT NULL,
  `ExCRightFender` int(3) NOT NULL,
  `ExCLeftQuarter` int(3) NOT NULL,
  `ExCRightQuarter` int(3) NOT NULL,
  `ExCFrontWindshield` varchar(50) NOT NULL,
  `ExCRightFrontDoor` int(3) NOT NULL,
  `ExCLeftFrontDoor` int(3) NOT NULL,
  `ExCRightRearDoor` int(3) NOT NULL,
  `ExCLeftRearDoor` int(3) NOT NULL,
  `ExCRoof` int(3) NOT NULL,
  `ExCRearWindShield` varchar(50) NOT NULL,
  `ExCRearTailLight` varchar(50) NOT NULL,
  `ExCRearBumper` int(3) NOT NULL,
  `ExCBodyPaint` int(3) NOT NULL,
  `ExCDeckLid` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fourwheeler_exterior_conditions`
--

INSERT INTO `fourwheeler_exterior_conditions` (`repId`, `ExCGrill`, `ExCHeadLight`, `ExCHood`, `ExCFrontBumper`, `ExCLeftFender`, `ExCRightFender`, `ExCLeftQuarter`, `ExCRightQuarter`, `ExCFrontWindshield`, `ExCRightFrontDoor`, `ExCLeftFrontDoor`, `ExCRightRearDoor`, `ExCLeftRearDoor`, `ExCRoof`, `ExCRearWindShield`, `ExCRearTailLight`, `ExCRearBumper`, `ExCBodyPaint`, `ExCDeckLid`) VALUES
('123', 5, 5, 5, 5, 5, 5, 5, 5, 'Original', 5, 5, 5, 5, 5, 'Original', 'Working', 5, 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `fourwheeler_image_info`
--

CREATE TABLE `fourwheeler_image_info` (
  `repId` varchar(255) NOT NULL,
  `carAvatarImage` tinytext NOT NULL,
  `chassisImprintImage` tinytext NOT NULL,
  `carFrontImage` tinytext NOT NULL,
  `carRightImage` tinytext NOT NULL,
  `carRearImage` tinytext NOT NULL,
  `carLeftImage` tinytext NOT NULL,
  `dashboardImage` tinytext NOT NULL,
  `gearAndSeatImage` tinytext NOT NULL,
  `odometerImage` tinytext NOT NULL,
  `engineRoomImage` tinytext NOT NULL,
  `regPlateImage` tinytext NOT NULL,
  `chassisNoImage` tinytext NOT NULL,
  `rcFrontImage` tinytext NOT NULL,
  `rcBackImage` tinytext NOT NULL,
  `tyre1Image` tinytext NOT NULL,
  `tyre2Image` tinytext NOT NULL,
  `tyre3Image` tinytext NOT NULL,
  `tyre4Image` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fourwheeler_image_info`
--

INSERT INTO `fourwheeler_image_info` (`repId`, `carAvatarImage`, `chassisImprintImage`, `carFrontImage`, `carRightImage`, `carRearImage`, `carLeftImage`, `dashboardImage`, `gearAndSeatImage`, `odometerImage`, `engineRoomImage`, `regPlateImage`, `chassisNoImage`, `rcFrontImage`, `rcBackImage`, `tyre1Image`, `tyre2Image`, `tyre3Image`, `tyre4Image`) VALUES
('123', 'zero.png', 'akshata2.png', 'bitmap.jpg', 'brand_ambassador_program.jpg', 'gift_a_healthy_living.jpeg', 'hygiene.png', 'medical32.png', 'on_health_and_wellness_products_300X138.jpg', 'on_health_and_wellness_products.jpg', 'safety.png', 'sid.png', 'subscribe_now_300X130.jpg', 'subscribe_now.jpg', 'teammed.png', 'tele_consultation_300X138.jpg', 'tele_consultation.jpg', 'text2.png', 'worldhealthlogo.png');

-- --------------------------------------------------------

--
-- Table structure for table `fourwheeler_interior_conditions`
--

CREATE TABLE `fourwheeler_interior_conditions` (
  `repId` varchar(255) NOT NULL,
  `InTDashboardCondition` int(3) NOT NULL,
  `InTFrontLeftSeat` int(3) NOT NULL,
  `InTFrontRightSeat` int(3) NOT NULL,
  `InTRearLeftSeat` int(3) NOT NULL,
  `InTRearRightSeat` int(3) NOT NULL,
  `InTThirdRowSeatCondition` int(3) NOT NULL,
  `InTTrunkCargo` int(3) NOT NULL,
  `InTCruiseControl` varchar(50) NOT NULL,
  `InTAirbags` varchar(50) NOT NULL,
  `InTPowerWindow` varchar(50) NOT NULL,
  `InTCarpetNFloorMat` int(3) NOT NULL,
  `IntOdometerCondition` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fourwheeler_interior_conditions`
--

INSERT INTO `fourwheeler_interior_conditions` (`repId`, `InTDashboardCondition`, `InTFrontLeftSeat`, `InTFrontRightSeat`, `InTRearLeftSeat`, `InTRearRightSeat`, `InTThirdRowSeatCondition`, `InTTrunkCargo`, `InTCruiseControl`, `InTAirbags`, `InTPowerWindow`, `InTCarpetNFloorMat`, `IntOdometerCondition`) VALUES
('123', 5, 5, 5, 5, 5, 5, 5, 'Available', 'Available', 'Available', 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `fourwheeler_tyre_conditions`
--

CREATE TABLE `fourwheeler_tyre_conditions` (
  `repId` varchar(255) NOT NULL,
  `TCNoOfTyres` int(3) NOT NULL,
  `TCFrontRightWheelType` varchar(50) NOT NULL,
  `TCFrontLeftWheelType` varchar(50) NOT NULL,
  `TCRearRightWheelType` varchar(50) NOT NULL,
  `TCRearLeftWheelType` varchar(50) NOT NULL,
  `TCSpareWheelType` varchar(50) NOT NULL,
  `TCFrontLeftWheel` varchar(50) NOT NULL,
  `TCFrontRightWheel` varchar(50) NOT NULL,
  `TCRearLeftWheel` varchar(50) NOT NULL,
  `TCRearRightWheel` varchar(50) NOT NULL,
  `TCSpareWheel` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fourwheeler_tyre_conditions`
--

INSERT INTO `fourwheeler_tyre_conditions` (`repId`, `TCNoOfTyres`, `TCFrontRightWheelType`, `TCFrontLeftWheelType`, `TCRearRightWheelType`, `TCRearLeftWheelType`, `TCSpareWheelType`, `TCFrontLeftWheel`, `TCFrontRightWheel`, `TCRearLeftWheel`, `TCRearRightWheel`, `TCSpareWheel`) VALUES
('123', 5, 'Rim', 'Rim', 'Rim', 'Rim', 'Rim', '10', '10', '10', '10', '10');

-- --------------------------------------------------------

--
-- Table structure for table `fourwheeler_vehicle_condition`
--

CREATE TABLE `fourwheeler_vehicle_condition` (
  `repId` varchar(255) NOT NULL,
  `VCRunningCondition` int(3) NOT NULL,
  `VCEngineStart` varchar(30) NOT NULL,
  `VCTransmissionCondition` int(3) NOT NULL,
  `VCTransmissionWorking` int(3) NOT NULL,
  `VCGearShift` int(3) NOT NULL,
  `VCFrontSuspension` int(3) NOT NULL,
  `VCRearSuspension` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fourwheeler_vehicle_condition`
--

INSERT INTO `fourwheeler_vehicle_condition` (`repId`, `VCRunningCondition`, `VCEngineStart`, `VCTransmissionCondition`, `VCTransmissionWorking`, `VCGearShift`, `VCFrontSuspension`, `VCRearSuspension`) VALUES
('123', 5, 'Starts', 5, 5, 5, 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `insurance_details`
--

CREATE TABLE `insurance_details` (
  `repId` varchar(255) NOT NULL,
  `insuranceType` varchar(255) NOT NULL,
  `insuranceCompany` tinytext NOT NULL,
  `insuranceFrom` varchar(50) NOT NULL,
  `InsuranceUpTo` varchar(50) NOT NULL,
  `insuranceValue` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `insurance_details`
--

INSERT INTO `insurance_details` (`repId`, `insuranceType`, `insuranceCompany`, `insuranceFrom`, `InsuranceUpTo`, `insuranceValue`) VALUES
('123', 'Full', 'HDFC', 'May 08, 2020', 'May 31, 2020', '1450000');

-- --------------------------------------------------------

--
-- Table structure for table `mechanical_conditions`
--

CREATE TABLE `mechanical_conditions` (
  `repId` varchar(255) NOT NULL,
  `MCEngineCondition` int(3) NOT NULL,
  `MCEngineRunning` varchar(5) NOT NULL,
  `MCEngineOilLevel` int(3) NOT NULL,
  `MCEngineOilFunction` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mechanical_conditions`
--

INSERT INTO `mechanical_conditions` (`repId`, `MCEngineCondition`, `MCEngineRunning`, `MCEngineOilLevel`, `MCEngineOilFunction`) VALUES
('123', 5, 'Yes', 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `parivahan_details`
--

CREATE TABLE `parivahan_details` (
  `repId` varchar(255) NOT NULL,
  `parivahanOwnerName` varchar(100) NOT NULL,
  `parivahanMaker` varchar(255) NOT NULL,
  `parivahanModel` varchar(255) NOT NULL,
  `parivahanManufacturedYear` varchar(10) NOT NULL,
  `parivahanRegDate` varchar(50) NOT NULL,
  `vehicleCategory` varchar(255) NOT NULL,
  `engineNumber` varchar(100) NOT NULL,
  `chassisNumber` varchar(100) NOT NULL,
  `bodyType` varchar(255) NOT NULL,
  `ladenWeight` varchar(100) NOT NULL,
  `unladenWeight` varchar(100) NOT NULL,
  `sleeperCapacity` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `parivahan_details`
--

INSERT INTO `parivahan_details` (`repId`, `parivahanOwnerName`, `parivahanMaker`, `parivahanModel`, `parivahanManufacturedYear`, `parivahanRegDate`, `vehicleCategory`, `engineNumber`, `chassisNumber`, `bodyType`, `ladenWeight`, `unladenWeight`, `sleeperCapacity`) VALUES
('123', 'Dhinesh S', 'Skoda', 'Rapid', '2019', 'May 04, 2020', 'Four wheeler', 'skdjfhd98mnsbdfk', 'jwyer876687jhsgdfu', 'Sedan', '2390', '1890', '4');

-- --------------------------------------------------------

--
-- Table structure for table `registered_users`
--

CREATE TABLE `registered_users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `usertype` varchar(255) NOT NULL,
  `mobile` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `registered_users`
--

INSERT INTO `registered_users` (`id`, `username`, `password`, `usertype`, `mobile`) VALUES
(8, 'Dhinesh S', '$2y$10$0YOsWaIwJNetEQhG5VoWne5VYcO.PCmiv81P5ePvfBUnoMMIf2Nny', 'admin', 9751819308),
(9, 'Saravanan K', '$2y$10$YZcoMXrDC2x0J22x44zAyeJqFjtW8w.XT.PorCqRZ5EX1wWv5kLe.', 'admin', 8489710738);

-- --------------------------------------------------------

--
-- Table structure for table `stearing_conditions`
--

CREATE TABLE `stearing_conditions` (
  `repId` varchar(255) NOT NULL,
  `SCSteeringPlay` varchar(10) NOT NULL,
  `SCPowerSteering` varchar(50) NOT NULL,
  `SCStearing` varchar(50) NOT NULL,
  `SCSteeringCondition` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stearing_conditions`
--

INSERT INTO `stearing_conditions` (`repId`, `SCSteeringPlay`, `SCPowerSteering`, `SCStearing`, `SCSteeringCondition`) VALUES
('123', 'Yes', 'Working', 'Power', 5);

-- --------------------------------------------------------

--
-- Table structure for table `tax_details`
--

CREATE TABLE `tax_details` (
  `repId` varchar(255) NOT NULL,
  `taxAmount` varchar(100) NOT NULL,
  `taxRecipientDate` varchar(50) NOT NULL,
  `taxUpTo` varchar(100) NOT NULL,
  `taxClearUpTo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tax_details`
--

INSERT INTO `tax_details` (`repId`, `taxAmount`, `taxRecipientDate`, `taxUpTo`, `taxClearUpTo`) VALUES
('123', '120000', 'May 31, 2020', '11323', '3455');

-- --------------------------------------------------------

--
-- Table structure for table `testdrive_results`
--

CREATE TABLE `testdrive_results` (
  `repId` varchar(255) NOT NULL,
  `TDEngineCondition` int(3) NOT NULL,
  `TDClutch` int(3) NOT NULL,
  `TDAccelerator` int(3) NOT NULL,
  `TDGearShiftRatios` int(3) NOT NULL,
  `TDStearing` int(3) NOT NULL,
  `TDBreaking` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `testdrive_results`
--

INSERT INTO `testdrive_results` (`repId`, `TDEngineCondition`, `TDClutch`, `TDAccelerator`, `TDGearShiftRatios`, `TDStearing`, `TDBreaking`) VALUES
('123', 5, 5, 5, 5, 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_details`
--

CREATE TABLE `vehicle_details` (
  `repId` varchar(255) NOT NULL,
  `inspectionDate` varchar(50) NOT NULL,
  `loanNo` varchar(30) NOT NULL,
  `location` varchar(255) NOT NULL,
  `vehicleMake` varchar(255) NOT NULL,
  `vehicleModel` varchar(255) NOT NULL,
  `vehicleVariant` varchar(255) NOT NULL,
  `vehicleRegNo` varchar(255) NOT NULL,
  `vehicleRegDate` varchar(50) NOT NULL,
  `ownerName` varchar(255) NOT NULL,
  `rcType` varchar(20) NOT NULL,
  `manufacturedYear` varchar(10) NOT NULL,
  `insuranceStatus` varchar(20) NOT NULL,
  `vehicleInsuranceDate` varchar(50) NOT NULL,
  `odometerReading` varchar(30) NOT NULL,
  `vehicleOwnership` int(3) NOT NULL,
  `reportType` varchar(20) NOT NULL,
  `hpaStatus` varchar(255) NOT NULL,
  `hpaBank` varchar(255) NOT NULL,
  `transmissionType` varchar(20) NOT NULL,
  `fuelType` varchar(20) NOT NULL,
  `vehicleColor` varchar(30) NOT NULL,
  `engineCondition` varchar(30) NOT NULL,
  `vehicleCondition` varchar(30) NOT NULL,
  `structuralCondition` varchar(20) NOT NULL,
  `ownerSerial` int(3) NOT NULL,
  `vehicleKey` varchar(20) NOT NULL,
  `batteryStatus` varchar(20) NOT NULL,
  `tyreCondition` int(3) NOT NULL,
  `reportRequestedBy` varchar(30) NOT NULL,
  `valuationPrice` varchar(30) NOT NULL,
  `remarks` mediumtext NOT NULL,
  `createdBy` varchar(255) NOT NULL,
  `createdOn` date NOT NULL,
  `vehicleType` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vehicle_details`
--

INSERT INTO `vehicle_details` (`repId`, `inspectionDate`, `loanNo`, `location`, `vehicleMake`, `vehicleModel`, `vehicleVariant`, `vehicleRegNo`, `vehicleRegDate`, `ownerName`, `rcType`, `manufacturedYear`, `insuranceStatus`, `vehicleInsuranceDate`, `odometerReading`, `vehicleOwnership`, `reportType`, `hpaStatus`, `hpaBank`, `transmissionType`, `fuelType`, `vehicleColor`, `engineCondition`, `vehicleCondition`, `structuralCondition`, `ownerSerial`, `vehicleKey`, `batteryStatus`, `tyreCondition`, `reportRequestedBy`, `valuationPrice`, `remarks`, `createdBy`, `createdOn`, `vehicleType`) VALUES
('123', 'May 09, 2020', '9876', 'Bengaluru', 'Skoda', 'Rapid', 'TSI', 'KA51HH9037', 'Jul 08, 2019', 'Dhinesh S', 'Available', '2019', 'Available', 'May 31, 2020', '4300', 1, 'Retail', 'Good', 'HDFC Bank', 'Manual', 'Diesel', 'Black', 'Starts', 'Running Conditio', 'Good', 1, 'Available', 'Available', 5, 'Saravanan K', '1500000', 'The vehicle is in good condition', 'Dhinesh S', '2020-05-09', 'four-wheeler');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `CV_cabin_conditions`
--
ALTER TABLE `CV_cabin_conditions`
  ADD PRIMARY KEY (`repId`);

--
-- Indexes for table `CV_electrical_functions`
--
ALTER TABLE `CV_electrical_functions`
  ADD PRIMARY KEY (`repId`);

--
-- Indexes for table `CV_exterior_conditions`
--
ALTER TABLE `CV_exterior_conditions`
  ADD PRIMARY KEY (`repId`);

--
-- Indexes for table `CV_image_info`
--
ALTER TABLE `CV_image_info`
  ADD PRIMARY KEY (`repId`);

--
-- Indexes for table `CV_transmission_conditions`
--
ALTER TABLE `CV_transmission_conditions`
  ADD PRIMARY KEY (`repId`);

--
-- Indexes for table `CV_tyre_conditions`
--
ALTER TABLE `CV_tyre_conditions`
  ADD PRIMARY KEY (`repId`);

--
-- Indexes for table `CV_vehicle_body_details`
--
ALTER TABLE `CV_vehicle_body_details`
  ADD PRIMARY KEY (`repId`);

--
-- Indexes for table `fourwheeler_electrical_functions`
--
ALTER TABLE `fourwheeler_electrical_functions`
  ADD PRIMARY KEY (`repId`);

--
-- Indexes for table `fourwheeler_exterior_conditions`
--
ALTER TABLE `fourwheeler_exterior_conditions`
  ADD PRIMARY KEY (`repId`);

--
-- Indexes for table `fourwheeler_image_info`
--
ALTER TABLE `fourwheeler_image_info`
  ADD PRIMARY KEY (`repId`);

--
-- Indexes for table `fourwheeler_interior_conditions`
--
ALTER TABLE `fourwheeler_interior_conditions`
  ADD PRIMARY KEY (`repId`);

--
-- Indexes for table `fourwheeler_tyre_conditions`
--
ALTER TABLE `fourwheeler_tyre_conditions`
  ADD PRIMARY KEY (`repId`);

--
-- Indexes for table `fourwheeler_vehicle_condition`
--
ALTER TABLE `fourwheeler_vehicle_condition`
  ADD PRIMARY KEY (`repId`);

--
-- Indexes for table `insurance_details`
--
ALTER TABLE `insurance_details`
  ADD PRIMARY KEY (`repId`);

--
-- Indexes for table `mechanical_conditions`
--
ALTER TABLE `mechanical_conditions`
  ADD PRIMARY KEY (`repId`);

--
-- Indexes for table `parivahan_details`
--
ALTER TABLE `parivahan_details`
  ADD PRIMARY KEY (`repId`);

--
-- Indexes for table `registered_users`
--
ALTER TABLE `registered_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stearing_conditions`
--
ALTER TABLE `stearing_conditions`
  ADD PRIMARY KEY (`repId`);

--
-- Indexes for table `tax_details`
--
ALTER TABLE `tax_details`
  ADD PRIMARY KEY (`repId`);

--
-- Indexes for table `testdrive_results`
--
ALTER TABLE `testdrive_results`
  ADD PRIMARY KEY (`repId`);

--
-- Indexes for table `vehicle_details`
--
ALTER TABLE `vehicle_details`
  ADD PRIMARY KEY (`repId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `registered_users`
--
ALTER TABLE `registered_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
