<?php
include("database.php");

if (isset($_GET['property_id'])) {
    $property_id = intval($_GET['property_id']);
    
    $owner_query = "SELECT o.firstname, o.lastname, o.email, o.phonenumber
                    FROM properties p
                    JOIN ownerreg o ON p.owner_id = o.id
                    WHERE p.id = ?";
    $stmt = $conn->prepare($owner_query);
    $stmt->bind_param('i', $property_id);
    $stmt->execute();
    $owner_result = $stmt->get_result();
    $owner_details = $owner_result->fetch_assoc();
    $stmt->close();
    
    echo json_encode($owner_details);
} else {
    echo json_encode(['error' => 'No property ID provided.']);
}

mysqli_close($conn);
?>
