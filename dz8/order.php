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
<a href='catalog.php'>Обратно в корзину</a>

<div class="container">     
     <?php
  
$linkDB = mysqli_connect("localhost", "root", "root", "db_products") or die("Не удалось подключить базу данных");
//$sessionId = session_id();
//$finalSum = 0;
$sessionId = $_GET['sess'];    
    
mysqli_query($linkDB, "INSERT INTO (tab order)order_items (order_id, product_id, quantity, price)
    SELECT $orderId, cart.product_id, cart.quantity, products.price FROM cart
        INNER JOIN products ON products.id = cart.product_id
        WHERE user_id = 1; or session_id = 1
")    
    
    
//удаление  из корзины
//   DELETE FORM cart WHERE user_id = 1; 
//  
    
    
//$result = mysqli_query($linkDB, "SELECT * FROM products ORDER BY product_view DESC"); 
//CONST IMG_SRC = 'images/';
  
    
    
?>
<form action="orderProduct.php" method="POST">
    <input type="hidden" name="id" value="<?= $idProd ?>">
    <!-- Текущее изображение<br><img src="<?= $prodImage ?>"> -->
    <input type="text" name="cart_name" required> Ваше имя<br>
    <input type="text" name="cart_phone" required> телефон<br>
    <input type="text" name="cart_address" required> адрес<br>
    <input type="submit" name="change_product" value="Изменить продукт">
</form>
    
    
    
    
    
    
    
    
    
    
    
    <?php
    
   
//mysqli_close($linkDB);     
?>
     
</div>
   <?php   echo "<h3>Итоговая сумма: " . $finalSum . " Р</h3>"; ?>

 </body>
</html>