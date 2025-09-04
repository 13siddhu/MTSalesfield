<?php
// get_list.php
// This file handles the database connection and data retrieval functions for item lists.

// Database connection details
$servername = "localhost";
$username = "root"; // Your database username
$password = "";     // Your database password
$dbname = "mdmtg";  // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/**
 * Fetches items from the 'item_list' table based on category.
 *
 * @param mysqli $conn The database connection object.
 * @param string $category The category to filter by (e.g., 'Chocolate', 'Biscuit', 'MFD').
 * @return array An array of item names (line_sku).
 */
function getItemsByCategory($conn, $category) {
    $items = [];
    $sql = "SELECT line_sku FROM item_list WHERE category = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $items[] = $row['line_sku'];
    }
    $stmt->close();
    return $items;
}

/**
 * Fetches all items from 'item_list' and groups them by category.
 *
 * @param mysqli $conn The database connection object.
 * @return array A nested associative array of items grouped by category.
 */
function getAllItemsGroupedByCategory($conn) {
    $groupedItems = [];
    $sql = "SELECT category, line_sku FROM item_list ORDER BY category, line_sku";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $category = $row['category'];
        $lineSku = $row['line_sku'];
        
        if (!isset($groupedItems[$category])) {
            $groupedItems[$category] = [];
        }
        $groupedItems[$category][] = $lineSku;
    }
    $stmt->close();
    return $groupedItems;
}

// Note: The connection ($conn) is kept open so it can be used by the including script.
?>