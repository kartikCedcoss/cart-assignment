<?php

session_start();
if(!isset($_SESSION['admin'])){
  //header("Location: adminlogin.php");
  //exit();
}

$servername = "mysql-server";
$username = "root";
$password = "secret";
$cartdb="db_cart";

if(isset($_POST['changestatus'])){
     
     
    $statusid = $_POST['changestatus'];

    try {
      $conn = new PDO("mysql:host=$servername;dbname=$cartdb", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $stmt = $conn->prepare("SELECT userstatus FROM usertable WHERE userid = '$statusid' ");
      $stmt->execute();
    
      
      $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
      foreach($stmt->fetchAll() as $k=>$v) {
        if($v['userstatus']=="pending"){
          try {
               $conn = new PDO("mysql:host=$servername;dbname=$cartdb", $username, $password);
                 $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                 $sql = "UPDATE `usertable` SET `userstatus` = 'approved' WHERE `usertable`.`userid` = '$statusid'";
                 $stmt = $conn->prepare($sql);
                $stmt->execute();
               
                
             } catch(PDOException $e) {
                 echo "Error: " . $e->getMessage();
               }
               $conn = null;
               //displayusers();
        }
     else{
      try {
        $conn = new PDO("mysql:host=$servername;dbname=$cartdb", $username, $password);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         
          $sql = "UPDATE `usertable` SET `userstatus` = 'pending' WHERE `usertable`.`userid` = '$statusid'";
          $stmt = $conn->prepare($sql);
         $stmt->execute();
        
         
      } catch(PDOException $e) {
          echo "Error: " . $e->getMessage();
        }
        $conn = null;

     }
    }
    } 
    
    catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
    $conn = null;
  
}

if(isset($_POST['deleteuser'])){
   
    $deleteid = $_POST['deleteuser'];
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$cartdb", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $sql = " DELETE FROM `usertable` WHERE `usertable`.`userid` = '$deleteid'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        
        
      } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
      $conn = null;
      
      }

     
      if(isset($_POST['adduser'])){
      
        $uname = $_POST['newuname'];
        $uemail = $_POST['newuemail'];
        $upass =  $_POST['newupass'];
        $ustatus = $_POST['newustatus'];
        $urole = $_POST['newurole'];
    
    try {
       $conn = new PDO("mysql:host=$servername;dbname=$cartdb", $username, $password);
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       
       $sql = " INSERT INTO usertable ( userid, username, email, passw, userstatus, userrole) 
       VALUES (Null,'$uname ','$uemail','$upass','$ustatus','$urole')";
       $stmt = $conn->prepare($sql);
       $stmt->execute();
       
       
     } catch(PDOException $e) {
       echo "Error: " . $e->getMessage();
     }
     $conn = null;
     displayusers();
    
    }









    function displayusers(){
        $servername = "mysql-server";
           $username = "root";
           $password = "secret";
           $newdb="db_cart";
           
           try {
               $conn = new PDO("mysql:host=$servername;dbname=$newdb", $username, $password);
               $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
               $stmt = $conn->prepare("SELECT * FROM usertable WHERE userid NOT IN (SELECT MIN(userid) FROM usertable) ORDER BY userid");
               $stmt->execute();
             
               // set the resulting array to associative
               $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
               echo '<div class="container" ><h2>All Users </h2>
               <table class=" table-striped table-sm">
               <thead>
                 <tr>
                   <th scope="col">USER ID</th>
                   <th scope="col">USER NAME</th>
                   <th scope="col">EMAIL</th>
                   <th scope="col">PASSWORD</th>
                   <th scope="col">STATUS</th>
                   <th scope="col">ROLE</th>
                 </tr>
               </thead>
               <tbody>
                 <tr>';
               foreach($stmt->fetchAll() as $k=>$v) {
              
                 echo '<td>'.$v["userid"].'</td>
                     <td>'.$v["username"].'</td>
                     <td>'.$v["email"].'</td>
                     <td>'.$v["passw"].'</td>
                     <td>'.$v["userrole"].'</td>
                     <td>'.$v["userstatus"].'</td>
                    
                     <td><button class="btn btn-primary" type="submit" value="'.$v["userid"].'" name="changestatus" >Change Status</button></td>
                     <td><button class="btn btn-danger" type="submit" value="'.$v["userid"].'" name="deleteuser" >Delete</button></td></tr>
       
       
                   </tr>';   
       
               }
               echo '<tr>
               <td><input class="form-control" type="text" placeholder=" Name" name="newuname"></td>
               <td><input class="form-control" type="text" placeholder="Email" name="newuemail"></td>
               <td><input class="form-control" type="text" placeholder="Password" name="newupass"></td>
               <td><input class="form-control" type="text" placeholder="Status" name="newustatus"></td>
               <td><input class="form-control" type="text" placeholder="Role" name="newurole"></td></tr>
             <tr>  <td><button type="submit" class="btn btn-primary" name="adduser" value="aduser" >Add User</button>
               </tr>';
             } catch(PDOException $e) {
               echo "Error: " . $e->getMessage();
             }
             $conn = null;
             echo "</tbody></table></div>";
       
       
       }

?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Dashboard Template · Bootstrap v5.1</title>
    <link rel="stylesheet" href="dashboard.css">
      <link rel="stylesheet" href="dashboard.rtl.css">


    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/dashboard/">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    

    <!-- Bootstrap core CSS -->
<link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">
  </head>
  <body>
    
<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Company name</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
  <div class="navbar-nav">
    <div class="nav-item text-nowrap">
      <a class="nav-link px-3" href="#">Sign out</a>
    </div>
  </div>
</header>

<div class="container-fluid">
  <form method="POST" action="">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="dashboard.php">
              <span data-feather="home"></span>
              Dashboard
            </>
          </li>
          <li class="nav-item">
            <a type="submit" class="nav-link  " href="order.php"  >
              <span data-feather="file"></span>
              Orders
    </a>
          </li>
          <li class="nav-item">
            <a class="nav-link "  href="products.php">
              <span data-feather="shopping-cart"></span>
              Products
    </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="user.php" >
              <span data-feather="users"></span>
              Users
    </a>
          </li>
          <li class="nav-item">
            
          </li>
          <li class="nav-item">
            
          </li>
        </ul>

        
        <ul class="nav flex-column mb-2">
         
        </ul>
      </div>
    </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
          </div>
          <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <span data-feather="calendar"></span>
            This week
          </button>
        </div>
      </div>
    
     
      
        <?php
       
         displayusers();
    
        ?>
            
        </table>

        

     </form>
      </div>
    </main>
  </div>
</div>

<link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/dashboard/">
    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

    <script src="myscript.js"></script>  
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="dashboard.js"></script>
  </body>
</html>
