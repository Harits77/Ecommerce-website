<?php
session_start(); // Start the session to access session variables

include("database.php");

$owner_id = $_SESSION['user_id']; // Get the logged-in user's ID from the session
$id = $_GET['id'];

// Retrieve existing property data
$sql = "SELECT * FROM properties WHERE id='$id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Check if the current user is the owner of the property
    if ($row['owner_id'] != $owner_id) {
        die("You do not have permission to delete this property.");
    }
} else {
    die("Property not found.");
}

// Proceed with deletion logic
$target_dir = __DIR__ . "/uploads/";
$old_image = $target_dir . $row['image'];
if (file_exists($old_image)) {
    unlink($old_image);
}

$sql = "DELETE FROM properties WHERE id='$id' AND owner_id='$owner_id'";

if ($conn->query($sql) === TRUE) {
    echo "Property deleted successfully";
    header("Location: view.php");
    exit;
} else {
    echo "Error deleting property: " . $conn->error;
}

$conn->close();
?>
