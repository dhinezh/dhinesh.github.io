<?php
//fetch.php
if (!$settings = parse_ini_file('database.ini', TRUE)) throw new exception('Unable to open ' . $file . '.');
$host = $settings['database']['host'];
$username = $settings['database']['username'];
$pass = $settings['database']['password'];
$db = $settings['database']['schema'];
$connect = mysqli_connect($host, $username, $pass, $db);
$columns = array(
    'repId', 'ownerName', 'vehicleMake', 'vehicleModel',
    'vehicleVariant', 'vehicleRegNo', 'valuationPrice','reportType', 'remarks',
    'inspectionDate', 'createdBy', 'createdOn'
);

$query = "SELECT * FROM vehicle_details ";

if (isset($_POST["search"]["value"])) {
    $query .= '
 WHERE repId LIKE "%' . $_POST["search"]["value"] . '%" 
 OR ownerName LIKE "%' . $_POST["search"]["value"] . '%" 
 OR vehicleMake LIKE "%' . $_POST["search"]["value"] . '%" 
 OR vehicleModel LIKE "%' . $_POST["search"]["value"] . '%" 
 OR vehicleVariant LIKE "%' . $_POST["search"]["value"] . '%" 
 OR vehicleRegNo LIKE "%' . $_POST["search"]["value"] . '%" 
 OR valuationPrice LIKE "%' . $_POST["search"]["value"] . '%" 
 OR remarks LIKE "%' . $_POST["search"]["value"] . '%" 
 OR inspectionDate LIKE "%' . $_POST["search"]["value"] . '%" 
 OR createdBy LIKE "%' . $_POST["search"]["value"] . '%" 
 OR createdOn LIKE "%' . $_POST["search"]["value"] . '%"
 ';
}

if (isset($_POST["order"])) {
    $query .= 'ORDER BY ' . $columns[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' 
 ';
} else {
    $query .= 'ORDER BY repId DESC ';
}

$query1 = '';

if ($_POST["length"] != -1) {
    $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$number_filter_row = mysqli_num_rows(mysqli_query($connect, $query));

$result = mysqli_query($connect, $query . $query1);

$data = array();

while ($row = mysqli_fetch_array($result)) {
    $sub_array = array();
    $sub_array[] = '<div>' . $row["repId"] . '</div>';
    $sub_array[] = '<div>' . $row["ownerName"] . '</div>';
    $sub_array[] = '<div>' . $row["vehicleMake"] . '</div>';
    $sub_array[] = '<div>' . $row["vehicleModel"] . '</div>';
    $sub_array[] = '<div>' . $row["vehicleVariant"] . '</div>';
    $sub_array[] = '<div>' . $row["vehicleRegNo"] . '</div>';
    $sub_array[] = '<div>' . $row["valuationPrice"] . '</div>';
    $sub_array[] = '<div>' . $row["reportType"] . '</div>';
    $sub_array[] = '<div>' . $row["remarks"] . '</div>';
    $sub_array[] = '<div>' . $row["inspectionDate"] . '</div>';
    $sub_array[] = '<div>' . $row["createdBy"] . '</div>';
    $sub_array[] = '<div>' . $row["createdOn"] . '</div>';
    $sub_array[] = '<a class="btn-floating waves-effect waves-light btn-small red deleteData" data-vehicleType="' . $row["vehicleType"] . '" id="' . $row["repId"] . '"><i class="material-icons">delete</i></a>';
    $sub_array[] = '<button type="button" class="btn btn-primary waves-effect waves-light d-flex align-items-center viewReport" data-vehicleType="' . $row["vehicleType"] . '" id="' . $row["repId"] . '">Report <i class="material-icons">description</i></button>';
    $data[] = $sub_array;
}

function get_all_data($connect)
{
    $query = 'SELECT * FROM vehicle_details';
    $result = mysqli_query($connect, $query);
    return mysqli_num_rows($result);
}

$output = array(
    "draw"    => intval($_POST["draw"]),
    "recordsTotal"  =>  get_all_data($connect),
    "recordsFiltered" => $number_filter_row,
    "data"    => $data
);

echo json_encode($output);
