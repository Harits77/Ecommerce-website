<?php
include("database.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$user_id = $_SESSION['user_id']; 

// Initialize variables
$property_id = isset($_GET['property_id']) ? intval($_GET['property_id']) : 0;

// Fetch properties
$query = "SELECT * FROM properties";
if (isset($_GET['title']) || isset($_GET['min_price']) || isset($_GET['max_price']) || isset($_GET['min_area']) || isset($_GET['max_area'])) {
    $conditions = [];
    if (!empty($_GET['title'])) {
        $title = mysqli_real_escape_string($conn, $_GET['title']);
        $conditions[] = "title LIKE '%$title%'";
    }
    if (!empty($_GET['min_price'])) {
        $min_price = intval($_GET['min_price']);
        $conditions[] = "price >= $min_price";
    }
    if (!empty($_GET['max_price'])) {
        $max_price = intval($_GET['max_price']);
        $conditions[] = "price <= $max_price";
    }
    if (!empty($_GET['min_area'])) {
        $min_area = intval($_GET['min_area']);
        $conditions[] = "area >= $min_area";
    }
    if (!empty($_GET['max_area'])) {
        $max_area = intval($_GET['max_area']);
        $conditions[] = "area <= $max_area";
    }
    if (count($conditions) > 0) {
        $query .= " WHERE " . implode(' AND ', $conditions);
    }
}

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(#010a27, #010d31);
            color: white;
            box-sizing: border-box;
            background-attachment: fixed;
            background-repeat: no-repeat;
        }
        .property-card {
            margin-bottom: 20px;
        }
        .filter-bar {
            margin-bottom: 20px;
            background-color: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
        }
        .filter-bar input, .filter-bar select {
            margin-right: 15px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1>Available Properties <a href="index.html"><button class="btn btn-success text-white fs-5" > Home</button></a> </h1>
        <div class="filter-bar">
            <form action="" method="GET">
                <input type="text" name="title" placeholder="Search by Title" value="<?php echo htmlspecialchars($_GET['title'] ?? ''); ?>">
                <input type="number" name="min_price" placeholder="Min Price" value="<?php echo htmlspecialchars($_GET['min_price'] ?? ''); ?>">
                <input type="number" name="max_price" placeholder="Max Price" value="<?php echo htmlspecialchars($_GET['max_price'] ?? ''); ?>">
                <input type="number" name="min_area" placeholder="Min Area (sq ft)" value="<?php echo htmlspecialchars($_GET['min_area'] ?? ''); ?>">
                <input type="number" name="max_area" placeholder="Max Area (sq ft)" value="<?php echo htmlspecialchars($_GET['max_area'] ?? ''); ?>">
                <input type="submit" value="Apply Filters" class="btn btn-primary">
            </form>
        </div>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="row">
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="col-md-4 property-card">
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
                                <button class="btn btn-success" onclick="showOwnerDetails(<?php echo $row['id']; ?>)">I am interested</button>
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
    <script>
        function showOwnerDetails(propertyId) {
            fetch('get_owner_details.php?property_id=' + propertyId)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert('Error: ' + data.error);
                    } else {
                        alert('Owner Details:\n' +
                              'Name: ' + data.firstname + ' ' + data.lastname + '\n' +
                              'Email: ' + data.email + '\n' +
                              'Phone Number: ' + data.phonenumber);
                    }
                })
                .catch(error => alert('An error occurred: ' + error));
        }
    </script>
</body>
</html>

<?php
mysqli_close($conn);
?>
