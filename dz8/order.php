<?php
session_start();
?>
<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8" />
  <title>Корзина</title>
  <style>
      *{margin:0 auto}
      h2{margin:0 auto;}
      img{width:100px; padding:20px} 
      body,.container{display: flex;align-items: center;justify-content: center; max-width: 1000px;flex-wrap: wrap;margin-top: 15px}
      body{flex-direction: column}
      .product{width:160px; height: 250px; border:2px dashed green;display: flex;flex-direction: column;align-items: center;justify-content: space-around;margin: 7px;padding:7px}
      a{text-decoration: none;color:green}a:hover{color:goldenrod}
      input{margin:3px}
  </style>
 </head>
 <body> 
     <h2>Заказ</h2>
<a href='cart.php'>Обратно в корзину</a>

<div class="container">     
     <?php
  
$linkDB = mysqli_connect("localhost", "root", "root", "db_products") or die("Не удалось подключить базу данных");
//$sessionId = session_id();
//$finalSum = 0;

if(!empty($_GET['sess'])){

//защита
$sessId = $_GET['sess'];    
var_dump($sessId);
$abc = '300';
// INSERT INTO order_items (order_id, product_id, qty, price) 
//     SELECT 10, product_id, qty, price FROM cart 
//     INNER JOIN products ON products.id = cart.product_id
//     WHERE session_id = 1;
mysqli_query($linkDB, "INSERT INTO order_items (order_id, product_id, quantity, price)
    SELECT cart.session_id, product_id, quantity, price 
    FROM cart 
    
    WHERE `session_id` = '$sessId'");    

}

//insert into appointment (col1, col2, col3, ...) values
//($id,(select doctorid from doctors where doctorName like '$docName' ), $date,$symptoms,(select patientid from patient where patientFName like '$nameOfUser'),$time)";
    
//удаление  из корзины
//   DELETE FORM cart WHERE user_id = 1; 
//  

    
    
?>
<form action="orderProduct.php" method="POST">
    <input type="hidden" name="id" value="<?= $idProd ?>">
    <!-- Текущее изображение<br><img src="<?= $prodImage ?>"> -->
    <input type="text" name="cart_name" required> Ваше имя<br>
    <input type="text" name="cart_phone" required> телефон<br>
    <input type="text" name="cart_address" required> адрес<br>
    <input type="submit" name="change_product" value="aaa">
</form>
    
    
    <?php
    
   
//mysqli_close($linkDB);     
?>
     
</div>
   <?php   echo "<h3>Итоговая сумма: " . $finalSum . " Р</h3>"; ?>

 </body>
</html>
