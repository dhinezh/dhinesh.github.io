<?php
//fetch.php
if (!$settings = parse_ini_file('database.ini', TRUE)) throw new exception('Unable to open ' . $file . '.');
$host = $settings['database']['host'];
$username = $settings['database']['username'];
$pass = $settings['database']['password'];
$db = $settings['database']['schema'];
$connect = mysqli_connect($host, $username, $pass, $db);
$columns = array('username', 'mobile', 'usertype');

$query = "SELECT * FROM registered_users ";

if (isset($_POST["search"]["value"])) {
    $query .= '
 WHERE username LIKE "%' . $_POST["search"]["value"] . '%" 
 OR mobile LIKE "%' . $_POST["search"]["value"] . '%" 
 OR usertype LIKE "%' . $_POST["search"]["value"] . '%"
 ';
}

if (isset($_POST["order"])) {
    $query .= 'ORDER BY ' . $columns[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' 
 ';
} else {
    $query .= 'ORDER BY username DESC ';
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
    $sub_array[] = '<div>' . $row["username"] . '</div>';
    $sub_array[] = '<div>' . $row["mobile"] . '</div>';
    $sub_array[] = '<div>' . $row["usertype"] . '</div>';
    $sub_array[] = '<a class="btn-floating waves-effect waves-light btn-small red deleteData" id="' . $row["mobile"] . '"><i class="material-icons">delete</i></a>';
    $data[] = $sub_array;
}

function get_all_data($connect)
{
    $query = "SELECT * FROM registered_users";
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