<?php
// Database connection info
$servername = "localhost";
$username = "root";
$password = ""; // Use your own DB password. If using XAMPP/WAMP/MAMP default, it's often empty.
$dbname = "mdmtg"; // Make sure this DB exists

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the selected Sales Executive
$selectedSE = isset($_GET['se_selected']) ? $conn->real_escape_string($_GET['se_selected']) : '';
// Get the selected account (if filtering by account as well)
$selectedAccount = isset($_GET['account_selected']) ? $conn->real_escape_string($_GET['account_selected']) : '';

$data = []; // Initialize an empty array for results

// --- Logic to fetch Accounts based on SE ---
// This condition is true when only SE is sent (for populating account dropdown)
if (!empty($selectedSE) && $selectedSE !== "Not Selected" && empty($selectedAccount)) {
    $stmt = $conn->prepare("SELECT DISTINCT account FROM store_list WHERE SE = ?");
    if ($stmt) {
        $stmt->bind_param("s", $selectedSE);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row['account']; // Just return a list of account names
        }
        $stmt->close();
    } else {
        error_log("Failed to prepare statement for accounts: " . $conn->error);
    }
}
// --- Logic to fetch Store Codes based on SE and Account ---
// This condition is true when both SE and Account are sent (for populating store code datalist)
else if (!empty($selectedSE) && $selectedSE !== "Not Selected" && !empty($selectedAccount) && $selectedAccount !== "Not Selected") {
    $stmt = $conn->prepare("SELECT store_code FROM store_list WHERE SE = ? AND account = ?");
    if ($stmt) {
        $stmt->bind_param("ss", $selectedSE, $selectedAccount);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row['store_code']; // Just return a list of store codes
        }
        $stmt->close();
    } else {
        error_log("Failed to prepare statement for store codes: " . $conn->error);
    }
}

$conn->close();
header('Content-Type: application/json');
echo json_encode($data);
?>