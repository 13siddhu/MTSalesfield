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
    // In a production environment, you would log this error and show a user-friendly message.
    // For development, we'll die here.
    die("Connection failed: " . $conn->connect_error);
}

// Get the selected account from the GET request
// Using ternary operator for brevity and isset check
$account = isset($_GET['account']) ? $conn->real_escape_string($_GET['account']) : '';

$storeCodes = []; // Initialize an empty array to hold store codes

// Only proceed if an account is provided and it's not "Not Selected"
if (!empty($account) && $account !== "Not Selected") {
    // Prepare a SQL statement to prevent SQL injection vulnerabilities
    $stmt = $conn->prepare("SELECT store_code FROM store_list WHERE account = ?");
    
    // Check if the statement was prepared successfully
    if ($stmt) {
        // Bind the parameter: 's' indicates a string type
        $stmt->bind_param("s", $account);
        
        // Execute the statement
        $stmt->execute();
        
        // Get the result set
        $result = $stmt->get_result();

        // Fetch rows and add store codes to the array
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $storeCodes[] = $row['store_code'];
            }
        }
        
        // Close the statement
        $stmt->close();
    } else {
        // Handle error if statement preparation failed (e.g., table not found)
        error_log("Failed to prepare statement: " . $conn->error);
    }
}

// Close the database connection
$conn->close();

// Set the content type header to application/json
header('Content-Type: application/json');

// Encode the store codes array as a JSON string and output it
echo json_encode($storeCodes);
?>