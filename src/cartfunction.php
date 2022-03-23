<?php

session_start();

$servername = "mysql-server";
$username = "root";
$password = "secret";
$cartdb="db_cart";
 
if(isset($_POST['addtocart'])){
    $userid = $_SESSION['user'];
    $productid = $_POST['addtocart'];
   

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$cartdb", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * FROM tb_product WHERE productID = '$productid' ");
        $stmt->execute();
      
       
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        foreach($stmt->fetchAll() as $k=>$v) {
            $price = $v['productPrice'];
            $pname = $v['productName'];
          
        }  
      } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
      $conn = null;

      try {
        $conn = new PDO("mysql:host=$servername;dbname=$cartdb", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * FROM `tb_cart`  ");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        foreach($stmt->fetchAll() as $k=>$v) {
           $cartid = $v['cartid'];
            if($v['productId'] == $productid && $v['userid'] == $userid){
                try {
                    $conn = new PDO("mysql:host=$servername;dbname=$cartdb", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt = $conn->prepare("UPDATE tb_cart SET quantity = quantity+1 , totalprice = price*quantity WHERE tb_cart.cartid = '$cartid' ");
                    $stmt->execute();
                    
                      
                    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    
                  } catch(PDOException $e) {
                    echo "Error: " . $e->getMessage();
                  }
                  $conn = null;
                 $flag = 1;

            }  
        }
      } 
    
      catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
      $conn = null;

      if($flag != 1){
        try {
          $conn = new PDO("mysql:host=$servername;dbname=$cartdb", $username, $password);
              $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
             $stmt = $conn->prepare("INSERT INTO `tb_cart`(`cartid`, `userid`, `productId`, `price`, `quantity`, `totalprice`, `productname`) 
            VALUES (Null,'$userid','$productid','$price',1,'$price','$pname') ");
              $stmt->execute();
         
           
              $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
           
            } catch(PDOException $e) {
              echo "Error: " . $e->getMessage();
            }
            $conn = null;
      }


         
       }

       header("Location: index.php");
       exit();
   
?>