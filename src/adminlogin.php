<?php

$servername = "mysql-server";
$username = "root";
$password = "secret";
$newdb="db_cart";

if(isset($_POST['adminlogin'])){
  
  $eadd = $_POST['adlemail'];
  $adlpass = $_POST['adlpass'];
try {
    $conn = new PDO("mysql:host=$servername;dbname=$newdb", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT * FROM usertable WHERE email = '$eadd'");
    $stmt->execute();
    
    
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    foreach($stmt->fetchAll() as $k=>$v) {
     if($v['passw'] != $adlpass){
  echo '<div class="alert alert-danger" role="alert">
  Wrong Password
  </div>';
  }

  else{
      if( $v['userstatus']=="pending" || $v['userrole'] !="admin" ){
        echo '<div class="alert alert-danger" role="alert">
        You Are In Pending State!
        </div>';
      }
     

      else if($v['userstatus']=="approved" && $v['userrole'] == "admin"){
        $_SESSION['admin']=true;
        $_SESSION['admin'] = $v['username'];
        header("Location: dashboard.php");
        exit();
      }
      else {
        echo '<div class="alert alert-danger" role="alert">
        there is a problem
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

    <title>Admin Login</title>
</head>
<body>
<section class="vh-100" style="background-color: #9A616D;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-xl-10">
        <div class="card" style="border-radius: 1rem;">
          <div class="row g-0">
            
            <div class="col-md-6 col-lg-7 d-flex align-items-center">
              <div class="card-body p-4 p-lg-5 text-black">

                <form method="POST" action="">

                 


                  <div class="form-outline mb-4">
                    <input type="email" id="form2Example17" class="form-control form-control-lg" name="adlemail" />
                    <label class="form-label" for="form2Example17">Admin Name</label>
                  </div>

                  <div class="form-outline mb-4">
                    <input type="password" id="form2Example27" class="form-control form-control-lg" name="adlpass"/>
                    <label class="form-label" for="form2Example27">Password</label>
                  </div>

                  <div class="pt-1 mb-4">
                    <button class="btn btn-dark btn-lg btn-block" type="submit" name="adminlogin">Login</button>
                  </div>

                  
                  <p class="mb-5 pb-lg-2" style="color: #393f81;">Don't have an account? <a href="adminreg.php" style="color: #393f81;">Register here</a></p>
                  
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</body>
</html>