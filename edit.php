<?php
include("database.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

if (isset($_GET['id'])) {
    $property_id = $_GET['id'];
    $query = "SELECT * FROM properties WHERE id = '$property_id' AND owner_id = '{$_SESSION['user_id']}'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $property = mysqli_fetch_assoc($result);
    } else {
        die("Property not found.");
    }
} else {
    die("No property ID provided.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $place = mysqli_real_escape_string($conn, $_POST['place']);
    $area = mysqli_real_escape_string($conn, $_POST['area']);
    $bedrooms = mysqli_real_escape_string($conn, $_POST['bedrooms']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $college_nearby = mysqli_real_escape_string($conn, $_POST['college_nearby']);
    $hospital_nearby = mysqli_real_escape_string($conn, $_POST['hospital_nearby']);

    $image = $property['image']; 

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
       
        $image_name = $_FILES['image']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image_name);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array($imageFileType, $allowed_types) && $_FILES['image']['size'] <= 5000000) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
              
                $image = $image_name;
            } else {
                echo "Error uploading file.";
            }
        } else {
            echo "Invalid file type or file too large.";
        }
    }

    $update_query = "UPDATE properties SET title='$title', place='$place', area='$area', bedrooms='$bedrooms', price='$price', college_nearby='$college_nearby', hospital_nearby='$hospital_nearby', image='$image' WHERE id='$property_id' AND owner_id='{$_SESSION['user_id']}'";
    
    if (mysqli_query($conn, $update_query)) {
        header("Location: view.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Property</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{
         background:linear-gradient(#010a27,#010d31);
        box-sizing: border-box;
        background-attachment: fixed;
        background-repeat: no-repeat;
        }
         .form-control{
            width: 350px;
            height: 40px;
            background: rgb(189, 189, 193);
        }
        label{
            color: white;
            padding-top: 20px;
        }
        form{
            width: 800px;
            margin-left: 35%;
            margin-top: -100px;
        }
        #btn{
            margin-top: 20px;
            width: 400px;
            height: 40px;
            margin-left: 22%;
           
        }
        h1{
            margin-top: 20px;
        }
        .wrap button{
            width: 200px;
            height: 50px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
    <h1 class="text-white ">Edit Property</h1>
    <div class="wrap">
   <a href="view.php"><button class="btn btn-success text-white fs-5" > Back</button></a> 
   </div>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="row">
              <div class="col-6">
                <label for="title" class="form-label">Property Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($property['title']); ?>" required>
            
                <label for="place" class="form-label">Place</label>
                <input type="text" class="form-control" id="place" name="place" value="<?php echo htmlspecialchars($property['place']); ?>" required>
           
                <label for="area" class="form-label">Area (in sq ft)</label>
                <input type="number" class="form-control" id="area" name="area" value="<?php echo htmlspecialchars($property['area']); ?>" required>
    
          
                <label for="bedrooms" class="form-label">Number of Bedrooms</label>
                <input type="number" class="form-control" id="bedrooms" name="bedrooms" value="<?php echo htmlspecialchars($property['bedrooms']); ?>" required>
                </div>
            <div class="col-6">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($property['price']); ?>" required>
        
                <label for="college_nearby" class="form-label">Nearby College</label>
                <input type="text" class="form-control" id="college_nearby" name="college_nearby" value="<?php echo htmlspecialchars($property['college_nearby']); ?>">
    
                <label for="hospital_nearby" class="form-label">Nearby Hospital</label>
                <input type="text" class="form-control" id="hospital_nearby" name="hospital_nearby" value="<?php echo htmlspecialchars($property['hospital_nearby']); ?>">
       
                <label for="image" class="form-label">Property Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                <?php if ($property['image']): ?>
                    <img src="uploads/<?php echo htmlspecialchars($property['image']); ?>" alt="Property Image" style="width: 200px; height: auto;">
                <?php endif; ?>
            </div>
            <button type="submit" id="btn" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>
