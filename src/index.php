<?php
session_start();


$userid = $_SESSION['user'];

$servername = "mysql-server";
$username = "root";
$password = "secret";
$newdb="db_cart";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$newdb", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT COUNT(quantity) as countq FROM tb_cart WHERE userid = '$userid' ");
    $stmt->execute();
  
    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    foreach($stmt->fetchAll() as $k=>$v) {
        $count = $v['countq'];
      }
    
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  $conn = null;
  
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
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Shop Hompeage</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
</head>

<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#!"><b>Shopingo</b></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#!">About</a></li>

                    <li class="nav-item dropdown"><form class="form-inline my-2 my-lg-0" >
                        <select class="form-select" aria-label="Default select example" name="select" id="select" onchange="selectcat()" value="select" >
                            <option selected class="disabled"  >Sort By</option>
                            <option value="Electronics" >Electronics</option>
                            <option value="Furniture" >Furniture</option>
                            <option value="Jwellery" >Jwellery</option>
                            
                        </select>
                    </li>
                    <li class="nav-item">
                        
                   
                            <input class="form-control mr-sm-2" type="hidden" placeholder="category" aria-label="Search" id="serinput" name="serinput" >

                    </li>
                    <li class="nav-item">
                        <!-- <button class="btn btn-outline-success my-2 my-sm-0"  name="btnfilt" id="btnfilt" >Search</button></form> -->
                    </li></form>
                         
                </ul>
                <form class="d-flex" method="POST" action="">
                    <a class="btn btn-outline-dark" href="cart.php">
                        <i class="bi-cart-fill me-1"></i>
                        Cart
                        <span class="badge bg-dark text-white ms-1 rounded-pill"><?php echo $count?></span>
                    </a>

                    
   
     <button class="btn btn-outline-danger my-2 my-sm-0 rounded-pill" style="margin-left: 2px;" type="submit" name='logout' >Log Out</button>

                </form>
            </div>
        </div>
    </nav>
    <!-- Header-->
    <header class=" ">
        <div class="container">
            <div class="text-center text-white">
                <img src="images/onlineshopping.jpg" class="w-100 " height="300" alt="">
                
            </div>
        </div>
    </header>
    <!-- Section-->
    <section class="py-5" id="divcard" >
        <form method="POST" action="cartfunction.php">
            
            <div class="container-fluid mt-4 mb-5">

                <div class="row justify-content-center" >


                <div class="col-1 mt-4">

                  </div>
               

                    <?php
                    
                   
                    $servername = "mysql-server";
                    $username = "root";
                    $password = "secret";
                    $cartdb = "db_cart";
                    $numberpage = 5;
                    $page = $_GET['start'];
                    $start = $page * $numberpage;
                    
                     
                    
                    try {
                        $conn = new PDO("mysql:host=$servername;dbname=$cartdb", $username, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $stmt = $conn->prepare("SELECT * FROM tb_product limit $start,$numberpage");
                        $stmt->execute();

                       
                        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                        foreach ($stmt->fetchAll() as $k => $v) {
            

                        echo   '<div class="col-2 mt-4">
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
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    $conn = null;
                    ?>
                    <div class="col-1 mt-4">

                  </div>

                </div>

                


            </div></form >
     </section>










     <section class="py-4" id="divcard2" >
        <form method="POST" action="cartfunction.php">
            
            <div class="container-fluid mt-4 mb-5">

                <div class="row justify-content-center" >
                    <div class="container"> <div id='dispval' ></div></div>
               
              
                   
                    

                    

                </div>

                


            </div></form >
     </section>

     <div class="container text-center">
     <nav aria-label="...">
       <ul class="pagination pagination-lg">
     <?php
     
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$newdb", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("SELECT COUNT(productId) FROM tb_product ");
            $stmt->execute();
             $result = $stmt->fetch();
            $numrecord = $result[0];
            $numlinks = ceil($numrecord/$numberpage);
            
          } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
          }
          $conn = null;
         for($i =0; $i<$numlinks;$i++){
             $y = $i+1;
             echo  '<li class="page-item "><a class="page-link" href="index.php?start='.$i.'">'.$y.'</a></li>';
         }
     
     
     
     ?>

      
      
     
      </ul>
       </nav>

       </div>



 
    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Your Website 2021</p>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="myscript.js"></script>

    <script>
      var jarr=[];
        function selectcat(){
            $('#divcard').hide();
            var category =  document.getElementById('select').value;
           
           $.ajax({
        url : "frontend.php",
        type : "POST",
        datatype : "JSON",
        data : {
            category : category ,
            "action" : "filter"
        }
    }).done(function(data){
    
     displayfilter(data);
   
    }) 
        }
function displayfilter(data){
document.getElementById('dispval').innerHTML = data;
}

    </script>
</body>

</html>
