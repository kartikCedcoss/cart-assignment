<?php
session_start();
$servername = "mysql-server";
$username = "root";
$password = "secret";
$newdb="db_cart";
$userid = $_SESSION['user'];

$temp = 0;
if(isset($_POST['orderplace'])){


try {
    $conn = new PDO("mysql:host=$servername;dbname=$newdb", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT * FROM tb_cart WHERE userid = '$userid' ");
    $stmt->execute();
  
    
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    
    foreach($stmt->fetchAll() as $k=>$v) {
        $productname = $v['productname'];
        $productid = $v['productId'];
        $quantity = $v['quantity'];
        $price = $v['price'];

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$newdb", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("INSERT INTO `tb_order`(`orderid`, `userid`, `productId`, `productname`, `price`, `quantity`,`dlstatus`)
             VALUES (null,'$userid','$productid','$productname','$price','$quantity','In Transit') ");
            $stmt->execute();
          
            
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $temp = 1;
          } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
          }
    }
     
    } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
   }
  $conn = null;



  try {
    $conn = new PDO("mysql:host=$servername;dbname=$newdb", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
    $sql = " DELETE FROM `tb_cart` WHERE `tb_cart`.`userid` = $userid ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
   
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Document</title>
</head>
<body>
    <div class="container">
    <?php
    if($temp !=0){
        echo "<tr></td>your Order Has Been Placed</td></tr>";
        echo "<a href='index.php' class='btn'> Continue Shopping  </a>";
    }
    
    
    ?>
    </div>
   
    
</body>
</html>