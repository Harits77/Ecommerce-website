<?php
include("database.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$owner_id = $_SESSION['user_id']; 
$query = "SELECT * FROM properties WHERE owner_id = '$owner_id'";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Properties</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{
        background:linear-gradient(#010a27,#010d31);
        box-sizing: border-box;
        background-attachment: fixed;
        background-repeat: no-repeat;
        }
        button{
            width: 200px;
            height: 60px;
            margin: 20px 20px 20px 0px; 
        }
    </style>
</head>
<body>
    <div class="container mt-4">
    <a href="property.php"><button class="btn btn-success text-white fs-5">Post Property</button></a> 
    <a href="index.html"><button class="btn  btn-success text-white fs-5">Home</button></a>  
        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="row">
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <?php if ($row['image']): ?>
                                <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top" alt="Property Image">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                                <p class="card-text">Place: <?php echo htmlspecialchars($row['place']); ?></p>
                                <p class="card-text">Area: <?php echo htmlspecialchars($row['area']); ?> sq ft</p>
                                <p class="card-text">Bedrooms: <?php echo htmlspecialchars($row['bedrooms']); ?></p>
                                <p class="card-text">Price: <?php echo htmlspecialchars($row['price']); ?></p>
                                <p class="card-text">Nearby College: <?php echo htmlspecialchars($row['college_nearby']); ?></p>
                                <p class="card-text">Nearby Hospital: <?php echo htmlspecialchars($row['hospital_nearby']); ?></p>
                                <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Edit</a>
                                <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this property?')">Delete</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>No properties found.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
mysqli_close($conn);
?>
