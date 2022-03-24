<?php
session_start();
$servername = "mysql-server";
    $username = "root";
    $password = "secret";
    $cartdb="db_cart";

if(isset($_POST['removeproduct'])){
    $remove = $_POST['removeproduct'];
     try {
         $conn = new PDO("mysql:host=$servername;dbname=$cartdb", $username, $password);
         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
         $sql = " DELETE FROM `tb_cart` WHERE `tb_cart`.`cartid` = $remove ";
         $stmt = $conn->prepare($sql);
         $stmt->execute();
        
        
       } catch(PDOException $e) {
         echo "Error: " . $e->getMessage();
       }
       $conn = null;
}

if(isset($_POST['update'])){
 $upquantity = $_POST['uquantity'];
 $updateid = $_POST['update'];
 try {
    $conn = new PDO("mysql:host=$servername;dbname=$cartdb", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
    $sql = " UPDATE tb_cart SET quantity = '$upquantity', totalprice= quantity * price  WHERE tb_cart.cartid = '$updateid' ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
   
   
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
 

}

function displaycart(){
    $servername = "mysql-server";
    $username = "root";
    $password = "secret";
    $newdb="db_cart";
    $userid = $_SESSION['user'];
    
    
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$newdb", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * FROM tb_cart WHERE userid = '$userid' ");
        $stmt->execute();
      
        // set the resulting array to associative
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        echo '<h2>Your Cart</h2>
        <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th scope="col">Product </th>
            <th scope="col">Price</th>
            <th scope="col">Quantity</th>
            <th scope="col"></th>
            <th scope="col">Total</th>
            <th scope="col"></th>
            
          </tr>
        </thead>
        <tbody>
          ';
          $grand = 0;
        foreach($stmt->fetchAll() as $k=>$v) {
          $grand += $v['totalprice'];
       
          echo '<form method="POST" action="" ><tr><td>'.$v["productname"].'</td>
              <td>'.$v["price"].'</td>
              <td><input class="form-control" type="text"  value= "'.$v["quantity"].'" name = "uquantity"></td>
              <td><button class="btn btn-primary" type="submit" value="'.$v["cartid"].'" name="update" >Update</button></td>
              <td>'.$v["totalprice"].'</td>
              <td><button class="btn btn-danger" type="submit" value="'.$v["cartid"].'" name="removeproduct" >X</button></td>        
                  </tr></form>';   

        }
        echo '<tr><form method="POST" action="" >
        <td><span>Grand Total:- </span>'.$grand.'</td>
        
        </tr>';
        
      } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
      $conn = null;
      echo "</tbody></table></form>";


}
if (isset($_POST['logout'])){
    // session_unset($_SESSION['user']);
    // session_unset($_SESSION['username']);
    session_destroy();

    header("location:userlogin.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Document</title>
</head>
<body>
    

<div class="container">
<nav class="navbar navbar-light bg-light justify-content-between">
  <a class="navbar-brand"><i class="fa fa-fw fa-user"></i> <?php echo $_SESSION['username']?></a>
  <form class="form-inline" method="POST" action="">
   
    <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name='logout' >Log Out</button>
  </form>
</nav>
</div>

<div class="container">
    <?php 
    
    displaycart();
    ?>
    
</div>
<div class="container">

<form method="POST" action="checkout.php">
<table><tr><td><button class="btn btn-success" type="submit" value="" name= >Checkout</button></td>        
</tr></table>
</form>
</div>



</body>
</html>