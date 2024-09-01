<?php
    include ("database.php") ;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width>, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="styles.css">
    <script defer src="script.js"></script>
</head>
<body>
    
    <div class="container">
        <form id="form" action=""  method="POST">    
        
        <h1>Customer Register</h1>

        <div class="input-control">
        <label >Firstname</label><br>
        <input type="text" id="fname" placeholder="Firstname" name="fname">
        <div class="error"></div>
        </div>

        <div class="input-control">
            <label >Lastname</label><br>
            <input type="text" id="lname" placeholder="Lastname" name="lname">
            <div class="error"></div>
            </div>
    

       <div class="input-control">
        <label>Email</label><br>
       <input type="email"  id="email" placeholder="Email" name="email">
       <div class="error"></div>
       </div>
        
       <div class="input-control">
        <label>Phonenumber</label><br>
        <input type="text"  id="number" placeholder="Phonenumber" name="number">
        <div class="error"></div>
        </div>
        <button type="submit" >submit</button>
        <p>Already have a account <a href="customerlogin.php">Login</a> </p>


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

     
     $sql = "INSERT INTO customerreg(firstname,lastname,email,phonenumber)
           VALUES ('$fname','$lname','$email','$number')";

      try{
      mysqli_query($conn, $sql);
      header("location:customerlogin.php");
      }
      catch(mysqli_sql_exception){
        echo 'ok';
      }
    }

      mysqli_close($conn);
  
?>    
      