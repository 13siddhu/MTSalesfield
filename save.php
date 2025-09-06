<?php
// save.php
// This script processes the combined form data and saves it to the MTMARKET table.

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection info
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mdmtg";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// --- 1. Collect fixed data from the first form (passed via hidden fields) ---
$sename       = isset($_POST['sename']) ? $conn->real_escape_string($_POST['sename']) : '';
$accountname  = isset($_POST['accout']) ? $conn->real_escape_string($_POST['accout']) : '';
$store_code   = isset($_POST['sname']) ? $conn->real_escape_string($_POST['sname']) : '';
$slocation    = isset($_POST['slocation']) ? $conn->real_escape_string($_POST['slocation']) : '';
$sarea        = isset($_POST['sarea']) ? (int)$_POST['sarea'] : null;
$srevenue     = isset($_POST['srevenue']) ? (int)$_POST['srevenue'] : null;
$crevenue     = isset($_POST['crevenue']) ? (int)$_POST['crevenue'] : null;

// The checkboxes send an array of values, so we implode them into a string
$totasset     = isset($_POST['totasset']) ? $conn->real_escape_string(implode(", ", $_POST['totasset'])) : "";
$paidasset    = isset($_POST['paidasset']) ? $conn->real_escape_string(implode(", ", $_POST['paidasset'])) : "";
$unpaidasset  = isset($_POST['unpaidasset']) ? $conn->real_escape_string(implode(", ", $_POST['unpaidasset'])) : "";

// --- 2. Dynamically collect all MSL data from the second form ---
$mslColumns = [];
$mslPlaceholders = [];
$mslParamTypes = '';
$mslParamValues = [];

foreach ($_POST as $key => $value) {
    // Check if the POST key is an MSL status field (e.g., ends with '_status')
    if (strpos($key, '_status') !== false) {
        $mslColumns[] = $key;
        $mslPlaceholders[] = '?';
        $mslParamTypes .= 's';
        $mslParamValues[] = $value;
    }
}

// Check if any MSL data was collected
if (empty($mslColumns)) {
    // Fallback if no MSL data is present, for debugging or partial submissions
    echo "No MSL data received. The script cannot save a complete record.";
    exit;
}

// --- 3. Prepare and execute the combined INSERT query ---

// List the fixed columns from the first form
$fixedColumns = ['sename', 'accountname', 'store_code', 'store_location', 'store_area_sqft', 'store_monthly_revenue', 'cadbury_monthly_revenue', 'totasset', 'paidasset', 'unpaidasset'];

// Combine all column names
$allColumns = array_merge($fixedColumns, $mslColumns);
// Combine all placeholders
$allPlaceholders = array_merge(array_fill(0, count($fixedColumns), '?'), $mslPlaceholders);

$query = "INSERT INTO MTMMARKET (" . implode(', ', $allColumns) . ") VALUES (" . implode(', ', $allPlaceholders) . ")";

// Prepare the statement
$stmt = $conn->prepare($query);

if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

// Build the array of all parameters for binding
$allParamValues = array_merge(
    [$sename, $accountname, $store_code, $slocation, $sarea, $srevenue, $crevenue, $totasset, $paidasset, $unpaidasset],
    $mslParamValues
);

// Build the string of parameter types ('s' for string, 'i' for int)
$fixedParamTypes = 'sssiisiiss';
$allParamTypes = $fixedParamTypes . $mslParamTypes;

// Call bind_param dynamically with the correct number of arguments
$bindParams = [&$allParamTypes];
foreach ($allParamValues as $key => $value) {
    $bindParams[] = &$allParamValues[$key];
}

call_user_func_array([$stmt, 'bind_param'], $bindParams);

// Execute the statement
if ($stmt->execute()) {
    echo "All data has been saved successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>