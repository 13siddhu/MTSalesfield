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

// Collect POST data
// Using real_escape_string for all string inputs as a first line of defense,
// though prepared statements are generally preferred for INSERT/UPDATE queries as well.
$sename       = $conn->real_escape_string($_POST['sename']);
$accountname  = $conn->real_escape_string($_POST['accout']);
$scode        = $conn->real_escape_string($_POST['sname']);
$slocation    = $conn->real_escape_string($_POST['slocation']);
$sarea        = $conn->real_escape_string($_POST['sarea']);
$srevenue     = $conn->real_escape_string($_POST['srevenue']);
$crevenue     = $conn->real_escape_string($_POST['crevenue']);

// These will now work correctly due to added 'value' attributes in index.php
$totasset     = isset($_POST['totasset']) ? implode(", ", $_POST['totasset']) : "";
$paidasset    = isset($_POST['paidasset']) ? implode(", ", $_POST['paidasset']) : "";
$unpaidasset  = isset($_POST['unpaidasset']) ? implode(", ", $_POST['unpaidasset']) : "";

// Insert into database
$sql = "INSERT INTO MTMARKET (sename, accountname, scode, slocation, sarea, srevenue, crevenue, totasset, paidasset, unpaidasset) VALUES ('$sename', '$accountname', '$scode', '$slocation', '$sarea', '$srevenue', '$crevenue', '$totasset', '$paidasset', '$unpaidasset')";

if ($conn->query($sql) === TRUE) {
    echo "Data saved successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>