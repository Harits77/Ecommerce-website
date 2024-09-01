<?php
    include("database.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>login</title>
    <link rel="stylesheet" href="styles.css">
    <script defer src="script.js"></script>
</head>
<body>
   <nav>
    <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="ownerlogin.php">Owner</a></li>
        <li><a href="customerlogin.php">Customer</a></li>
    </ul>
   </nav>
    
    <div class="container1">
        <form id="form1" action=""  method="POST">    
        
        <h1>Owner Login</h1>

       
        <div class="input-control">
                <label for="email">Email</label><br>
                <input type="email" id="email" placeholder="Email" name="email" >
                <div class="error"></div>
            </div>

            <div class="input-control">
                <label for="number">Phonenumber</label><br>
                <input type="number" id="number" placeholder="Phone Number" name="number" >
                <div class="error"></div>
            </div>
            <button type="submit" name="Login">Login</button>
  
        <p>Don't have a account <a href="ownerReg.php">Register</a> </p>

        
    </form>
    </div>
</body>
</html>

<?php
include("database.php");
session_start();

if (isset($_POST['Login'])) {
    $email = $_POST['email'];
    $number = $_POST['number'];
    
    $query = "SELECT * FROM ownerreg WHERE email='$email' AND phonenumber='$number'";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['id']; // Ensure 'id' is the correct column name for user ID
        header("location: property.php");
    } else {
        echo '<script>alert("Invalid email or phone number.")</script>';
    }
}
?>
