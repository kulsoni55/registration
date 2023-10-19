<?php
    session_start();
    if(isset($_SESSION["user1"])){
        header("Location:index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta viewport content="width=device-width,initial-scale=1.0">
        <title>REgistraion Page</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="css/form.css">
    </head>
    <body>
        <div class="alert-box">
            <p class="alert">msg</p>
        </div>
            <div class="form">
            <?php
               if(isset($_POST["submit"]))
               {
                $fullname=$_POST["fullname"];
                $Useremail=$_POST["Useremail"];
                $Password=$_POST["Password"];
                $errors=array();
                $_session['name']=$fullname;
                if(empty($fullname) OR empty($Useremail) OR empty($Password)){
                array_push($errors,"all fields are required");
                }
               if(!filter_var($Useremail,FILTER_VALIDATE_EMAIL)){
                array_push($errors,"Email not valid");
               }               
               if(strlen($Password)<8){
                array_push($errors,"Password most be at least 8 long");
               }
               require_once "dbconn.php";
               $sql1="SELECT * FROM reg where Useremail='$Useremail'";
               $result=mysqli_query($conn,$sql1);
               $norow=mysqli_num_rows($result);
               if($norow>0)
               {
                array_push($errors,"Already existed email!");
               }
               if(count($errors)>0){
                foreach($errors as $error){
                    echo"<div class='alert alert-danger'>$error</div>";
                }
            }else {
                
                $sql="INSERT INTO reg (fullname,Useremail,Password) values (?,?,?)";
                $stmt=mysqli_stmt_init($conn);
                $prepareStmt=mysqli_stmt_prepare($stmt,$sql);
                if($prepareStmt){
                    mysqli_stmt_bind_param($stmt,"sss",$fullname,$Useremail,$Password);
                    mysqli_stmt_execute($stmt);
                    
                    echo"<div class='alert alert-success'>You are register Successfully.</div>";
                }else{
                    die("Something went wrong!");
                }
            }
            }
            ?>
            <form action="reg.php" method="post">  
                <h1 class="heading">Registraion</h1>
                <input type="name" placeholder="name" autocomplete="off" class="name" name="fullname" />
                <input type="email" placeholder="email" autocomplete="off" class="email" name="Useremail" />
                <input type="password" placeholder="password" autocomplete="off" class="password" name="Password" />
                <button class="submit-btn" name="submit">Register</button>
                <a href="log.php" class="link">Alreday have an account? Login</a>
            </form> 
            </div>
        
        <script src=js/form.js></script>
    </body>
</html>