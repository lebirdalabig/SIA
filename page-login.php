<!DOCTYPE html>
<?php
    session_start();

    require("connect.php");

 if(isset($_POST['submitLogin'])){
        
        $idNum = mysqli_real_escape_string($conn, $_POST['idNum']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $password = md5($password);
        
        
     
        $sql2 = "SELECT user_id FROM user WHERE user_id = '$idNum';";
        $resultT = mysqli_query($conn, $sql2);
        $searched = mysqli_fetch_assoc($resultT);
        
        $_SESSION["user_id"] = $searched['user_id'];
       
        $userID = $_SESSION['user_id'];
        
        $sql = "SELECT user_id, user_password 
                FROM user 
                WHERE user_id = '$idNum' 
                AND user_password ='$password' 
                ";
        
        $result = mysqli_query($conn, $sql);
        
        if(mysqli_num_rows($result) == 1){
            $_SESSION['user'] = $idNum;
            $_SESSION['password']= $password;
            
        
            $user = $_SESSION['user'];
            
            header("Location:index.php?user_id=$userID");
        } else {
            echo "<script type='text/javascript'>alert('Incorrect email/password!');</script>";
        }
    }
?>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Parker Records</title>
    <meta name="description" content="CCR">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">


    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/selectFX/css/cs-skin-elastic.css">

    <link rel="stylesheet" href="assets/css/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>



</head>

<body class="bg-dark">


    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-logo">
                    <a href="index.php">
                        <img class="align-content" src="images/logo.png" alt="">
                    </a>
                </div>
                <div class="login-form">
                    <form method="POST" action='page-login.php'>
                        <div class="form-group">
                            <label>ID Number</label>
                            <input type="text" class="form-control" placeholder="ID Number" name="idNum">
                        </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" placeholder="Password" name="password">
                        </div>
                                <button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30" name="submitLogin">Sign in</button>
                                
                                <div class="register-link m-t-15 text-center">
                                    <p>Don't have account ? <a href="page-register.php"> Sign Up Here</a></p>
                                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>


</body>

</html>
