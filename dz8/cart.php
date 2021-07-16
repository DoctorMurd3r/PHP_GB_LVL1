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
  </style>
 </head>
 <body> 
     <h2>Корзина</h2>
<a href='catalog.php'>Обратно в каталог</a>

<div class="container">     
     <?php
  
$linkDB = mysqli_connect("localhost", "root", "root", "db_products") or die("Не удалось подключить базу данных");
$sessionId = session_id();
$finalSum = 0;
//$result = mysqli_query($linkDB, "SELECT * FROM products ORDER BY product_view DESC"); 
//CONST IMG_SRC = 'images/';
  
if(!empty($_GET['add'])){
    $idProd = (int)$_GET['add'];
    mysqli_query($linkDB, "INSERT INTO cart (product_id, quantity, session_id)
    VALUES($idProd, 1, '$sessionId') ON DUPLICATE KEY UPDATE quantity = quantity + 1");
}   

$select = mysqli_query($linkDB, "SELECT * FROM cart 
INNER JOIN products ON cart.product_id = products.id 
WHERE session_id = '$sessionId'");
    
if (mysqli_num_rows($select)){
    foreach($select as $product){
        $sumItem = ($product['product_price']*$product['quantity']);
        $finalSum = $finalSum + $sumItem;
        echo 
        "<div class='product'>
        {$product['product_name']}<br><img src='{$product['product_image']}'> Цена: {$product['product_price']} Р<br>
        Количество: {$product['quantity']}<br>
        Сумма только за этот товар: {$sumItem} Р
        <a href='?del={$product['product_id']}' style='color:blue'>Удалить товар из корзины</a>
        </div>";
        
    }
} else {
    echo "Корзина пуста";
}

if($_GET['del']){
$delete = (int)$_GET['del'];
    mysqli_query($linkDB, "DELETE FROM cart WHERE product_id = $delete");
    echo "Сейчас продукт будет удален из корзины";
    echo "<script>
        setTimeout(function () {
        window.location.href = 'cart.php';
        }, 2000);
    </script>";
}
//mysqli_close($linkDB);     
?>
     
</div>
     <?php   echo "<h3>Итоговая сумма: " . $finalSum . " Р</h3>"; 
     echo "<a href='order.php?sess={$sessionId}'><h3>Перейти к оформлению заказа</h3></a>";
     ?>

 </body>
</html>