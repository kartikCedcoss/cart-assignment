<?php
session_start();
$servername = "mysql-server";
$username = "root";
$password = "secret";
$newdb="db_cart";

if(isset($_POST['userlogin'])){

  $eadd = $_POST['lemail'];
  $lpass = $_POST['lpass'];
try {
    $conn = new PDO("mysql:host=$servername;dbname=$newdb", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT * FROM usertable WHERE email = '$eadd'");
    $stmt->execute();
    
    
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    foreach($stmt->fetchAll() as $k=>$v) {
if($v['passw']!=$lpass){
  echo '<div class="alert alert-danger" role="alert">
  Wrong Password
  </div>';
  }

  else{
      if( $v['userstatus']=="pending" || $v['userrole'] !="customer" ){
        echo '<div class="alert alert-danger" role="alert">
        You Are In Pending State!
        </div>';
      }
     

      else if($v['userstatus']=="approved" && $v['userrole'] == "customer"){
          
        $_SESSION['user']= true;
        $_SESSION['user']=$v['userid'];
        $_SESSION['username'] = true;
        $_SESSION['username'] = $v['username'];
        
        header("Location: index.php");
        exit();
      }
      else {
        echo '<div class="alert alert-danger" role="alert">
        contact your admin!
        </div>';
      }
    }
    }
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
     
    <title>User Login</title>
</head>
<body>
    
<div class="container">
<section class="vh-100">
  <div class="container-fluid h-custom">
    <div class="row d-flex justify-content-center align-items-center h-100">
     
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
        <form method = "POST" action="" >
          <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
           
          </div>

          <div class="divider d-flex align-items-center my-4">
           
          </div>

          <!-- Email input -->
          <div class="form-outline mb-4">
            <input type="email" id="form3Example3" class="form-control form-control-lg"
              placeholder="Enter a valid email address" name="lemail" />
            <label class="form-label" for="form3Example3" >Email address</label>
          </div>

          <!-- Password input -->
          <div class="form-outline mb-3">
            <input type="password" id="form3Example4" class="form-control form-control-lg"
              placeholder="Enter password" name="lpass" />
            <label class="form-label" for="form3Example4" >Password</label>
          </div>

          

          <div class="text-center text-lg-start mt-4 pt-2">
            <button type="submit" class="btn btn-primary btn-lg"
              style="padding-left: 2.5rem; padding-right: 2.5rem;" name="userlogin" >Login</button>
            <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="userreg.php"
                class="link-danger">Register</a></p>
          </div>

        </form>
      </div>
    </div>
  </div>
  
</section>
</div>
</body>
</html>