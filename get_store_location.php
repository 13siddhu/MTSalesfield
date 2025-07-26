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

// Get parameters
// Note: Parameter names now match what JavaScript sends
$selectedSE = isset($_GET['se_name']) ? $conn->real_escape_string($_GET['se_name']) : '';
$selectedAccount = isset($_GET['account']) ? $conn->real_escape_string($_GET['account']) : '';
$selectedStoreCode = isset($_GET['store_code']) ? $conn->real_escape_string($_GET['store_code']) : '';

$locationData = ['city_area' => '']; // Default empty response

// Only proceed if all necessary parameters are provided
if (!empty($selectedSE) && !empty($selectedAccount) && !empty($selectedStoreCode)) {
    // Prepare a SQL statement to prevent SQL injection vulnerabilities
    // Use SE, account, and store_code to precisely find the location
    $stmt = $conn->prepare("SELECT city_area FROM store_list WHERE SE = ? AND account = ? AND store_code = ?");
    
    if ($stmt) {
        $stmt->bind_param("sss", $selectedSE, $selectedAccount, $selectedStoreCode);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $locationData['city_area'] = $row['city_area'];
        }
        
        $stmt->close();
    } else {
        error_log("Failed to prepare statement for location: " . $conn->error);
    }
}

// Close the database connection
$conn->close();

// Set the content type header to application/json
header('Content-Type: application/json');

// Encode the location data as a JSON string and output it
echo json_encode($locationData);
?>