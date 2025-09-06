<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// The rest of your script follows...
// Database connection info
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mdmtg";
$tableName = "MTMMARKET";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to generate the correct, clean name
function getCorrectName($productName, $category) {
    // This is the correct naming logic
    $cleanName = strtolower(preg_replace('/[^a-z0-9]+/', '_', $productName));
    return $category . '_' . $cleanName . '_status';
}

echo "<h1>Starting Column Renaming Process...</h1>";

// Get all product data from the item_list table
$products = [];
$sql = "SELECT category, line_sku FROM item_list";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

// Get all column names from the MTMMARKET table
$columns = [];
$sql = "SHOW COLUMNS FROM " . $tableName;
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $columns[] = $row['Field'];
}

$fixedColumns = 0;

// Loop through the columns in MTMMARKET and check for mismatches
foreach ($columns as $oldColumnName) {
    // Check if the column is a product status column
    if (strpos($oldColumnName, '_status') !== false) {
        // Find the matching product in our list
        foreach ($products as $product) {
            $expectedName = getCorrectName($product['line_sku'], $product['category']);
            
            // If the old name is a potential match but is not correct
            if ($oldColumnName !== $expectedName && (strpos($oldColumnName, strtolower(str_replace(' ', '_', $product['line_sku']))) !== false || strpos($expectedName, strtolower(str_replace(' ', '_', $product['line_sku']))) !== false)) {
                // Execute the ALTER TABLE query to rename the column
                $sql = "ALTER TABLE `{$tableName}` CHANGE `{$oldColumnName}` `{$expectedName}` VARCHAR(3);";
                
                if ($conn->query($sql) === TRUE) {
                    echo "<p style='color:green;'>SUCCESS: Renamed column '{$oldColumnName}' to '{$expectedName}'</p>";
                    $fixedColumns++;
                    break;
                } else {
                    echo "<p style='color:red;'>ERROR: Could not rename '{$oldColumnName}'. " . $conn->error . "</p>";
                }
            }
        }
    }
}

if ($fixedColumns > 0) {
    echo "<h2><br>Process complete! " . $fixedColumns . " columns have been fixed.</h2>";
} else {
    echo "<h2><br>Process complete. No column mismatches were found.</h2>";
}

$conn->close();
?>