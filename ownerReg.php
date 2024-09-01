<?php
    include ("database.php") ;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="styles.css">
    <script defer src="script.js"></script>
</head>
<body>
    
    <div class="container">
        <form id="form" action=""  method="POST">    
        
        <h1>Owner Register</h1>

        <div class="input-control">
        <label >Firstname</label><br>
        <input type="text" id="fname" placeholder="name" name="fname">
        <div class="error"></div>
        </div>

        <div class="input-control">
            <label >Lastname</label><br>
            <input type="text" id="lname" placeholder="name" name="lname">
            <div class="error"></div>
            </div>
    

       <div class="input-control">
        <label>Email</label><br>
       <input type="email"  id="email" placeholder="password" name="email">
       <div class="error"></div>
       </div>
        
       <div class="input-control">
        <label>Phonenumber</label><br>
        <input type="number"  id="number" placeholder="Confirm password" name="number">
        <div class="error"></div>
        </div>
        <button type="submit" >submit</button>
        <p>Already have a account <a href="ownerlogin.php">Login</a> </p>


    </form>
    </div>
</body>
</html>

<?php
    if($_SERVER["REQUEST_METHOD"] == "POST")
  {
    $fname = $_POST["fname"];
    $email =   $_POST["email"];
    $lname = $_POST["lname"];
    $number = $_POST["number"];

     
     $sql = "INSERT INTO ownerreg(firstname,lastname,email,phonenumber)
           VALUES ('$fname','$lname','$email','$number')";

      try{
      mysqli_query($conn, $sql);
      header("location:ownerlogin.php");
      }
      catch(mysqli_sql_exception){
        echo 'ok';
      }
    }

      mysqli_close($conn);
  
?>    
      