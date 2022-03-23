<?php

if(isset($_POST['action']) && $_POST['action']=='filter'){
   
    $cat = $_POST['category'];
    
         filteritem($cat);
         
           
}



function filteritem($cat){
    $servername = "mysql-server";
                    $username = "root";
                    $password = "secret";
                    $cartdb = "db_cart";
         
        try {
        $conn = new PDO("mysql:host=$servername;dbname=$cartdb", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * FROM `tb_product` where productCategory = '$cat' ");
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        
        foreach($stmt->fetchAll() as $k=>$v) {
            echo '<div class="col-2 mt-4">
            <div class="card">
            <img src="images/' . $v['productImage'] . '" alt="...   ">
             <div class="card-body">
            <span class="card-title"><b>' . $v['productName'] . '</b></span>
           
           <span class="card-text"><small>(' . $v['productCategory'] . ')</small></span>
           <div class=" ">
           <span class=" text-danger"><b>Rs' . $v['productPrice'] . '</b></span>

        </div>
           
           <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
           <div class="text-center"><button class="btn btn-outline-dark mt-auto" value="'.$v["productId"].'"  name="addtocart" >Add to cart</button></div>
           <div class="text-center mt-1"><button class="btn btn-outline-danger border-0 mt-auto" value="'.$v["productId"].'"  name="moreinfo" >more info</button></div>

       </div>



       </div>
   </div>


</div>';

 


          }
       
      } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
      $conn = null;
      
     
 
    



 }



?>