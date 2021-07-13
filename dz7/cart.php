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
      .product{width:150px; height: 240px; border:2px dashed green;display: flex;flex-direction: column;align-items: center;justify-content: space-around;margin: 7px}
      a{text-decoration: none;color:green}a:hover{color:goldenrod}
  </style>
 </head>
 <body> 
     <h2>Корзина</h2>
<a href='catalog.php'>Обратно в каталог</a>

<div class="container">     
     <?php
  
$linkDB = mysqli_connect("localhost", "root", "root", "db_products") or die("Не удалось подключить базу данных");;
$result = mysqli_query($linkDB, "SELECT * FROM products ORDER BY product_view DESC"); 
//CONST IMG_SRC = 'images/';
     
$isProducts = mysqli_fetch_row($result);
if(!isset($isProducts)) {
     echo "Список продуктов пуст";
}

foreach($result as $item){
         echo "<div class='product'>
         {$item['product_name']}<br><img src=" . "{$item['product_image']}>Цена: {$item['product_price']} Р
         </div>";     
}

mysqli_close($linkDB);     
?>
     
</div>
    
 </body>
</html>