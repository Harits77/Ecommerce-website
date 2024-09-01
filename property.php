<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Property</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
     <style>
        body{
            background:linear-gradient(#010a27,#010d31);
             box-sizing: border-box;
            background-attachment: fixed;
             background-repeat: no-repeat;
        }
        .box{
          margin-top: -220px;
           width: 1000px;
           border:2px solid aqua;
           padding: 20px;
           margin-left: 25%;
        }
        input{
            width: 350px;
            height: 40px;
           display: block;
            background-color: rgb(189, 189, 193);
        }
        label{
            font-size: 20px;
           padding-top: 30px;
            color: white;
        }
        .row{
           margin-left: 5%;
        }
        #btn{
            margin-left: 30%;
            margin-top: 50px;
        }
        h1{
            color: white;
            text-align: center;
        }
        .wrap a{
            display: block;
        }
        button{
            width: 200px;
            height: 60px;
            margin: 20px;
            margin-top: 50px;
        }
     </style>
</head>
<body>
    <div class="wrap">
   <a href="view.php"><button class="btn btn-success text-white">View Property</button></a> 
   <a href="index.html"><button class="btn  btn-success text-white">Home</button></a>  
   </div>
   <div class="box">
    <form action="property.php" method="POST" enctype="multipart/form-data" >
        <div class="row">
        <h1>Post Your Property</h1>
        <div class="col-6">
        <label for="title">Property Title:</label>
        <input type="text" id="title" name="title" required>

        <label for="place">Place:</label>
        <input type="text" id="place" name="place" required>

        <label for="area">Area (in sq ft):</label>
        <input type="number" id="area" name="area" required>

        <label for="bedrooms">Number of Bedrooms:</label>
        <input type="number" id="bedrooms" name="bedrooms" required>
        </div>
         
        <div class="col-6">
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" required>

        <label for="college_nearby">Nearby College:</label>
        <input type="text" id="college_nearby" name="college_nearby">
      
        <label for="hospital_nearby">Nearby Hospital:</label>
        <input type="text" id="hospital_nearby" name="hospital_nearby">
      
        <label for="image">Property Image:</label>
        <input type="file" id="image" name="image" accept="image/*" required>
        </div>    
        </div>
        
        <input type="submit" id="btn" value="Post Property">
       
    </form>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>

<?php
 
 include ("database.php") ;

 session_start();

 if (!isset($_SESSION['user_id'])) {
    die("User not logged in. Please log in first.");
}

 if($_SERVER["REQUEST_METHOD"] == "POST")
 {

$owner_id = $_SESSION['user_id'];
$title = $_POST['title'];
$place = $_POST['place'];
$area = $_POST['area'];
$bedrooms = $_POST['bedrooms'];
$price = $_POST['price'];
$college_nearby = $_POST['college_nearby'];
$hospital_nearby = $_POST['hospital_nearby'];

$image = $_FILES['image']['name'];
$target_dir = "uploads/";
$target_file = $target_dir . basename($image);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

$check = getimagesize($_FILES['image']['tmp_name']);
if ($check === false) {
    die("File is not an image.");
}

$allowed_types = array('jpg', 'jpeg', 'png', 'gif');
if (!in_array($imageFileType, $allowed_types)) {
    die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
}

if ($_FILES['image']['size'] > 5000000) {
    die("Sorry, your file is too large.");
}

if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
    die("Sorry, there was an error uploading your file.");
}


$sql = "INSERT INTO properties (title, place, area, bedrooms, price, college_nearby, hospital_nearby, image,owner_id) 
        VALUES ('$title', '$place', '$area', '$bedrooms', '$price', '$college_nearby', '$hospital_nearby','$image','$owner_id')";

try{
    mysqli_query($conn, $sql);
    header("location:view.php");
    }
    catch(mysqli_sql_exception){
      echo 'ok';
    }
  }

    mysqli_close($conn);
?>
