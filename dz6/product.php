<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8" />
  <title>DZ6</title>
  <style>
img{padding:10px} 
.container{display: flex;align-items: center;justify-content: center}
.product{max-width:800px;height:70%; display: flex;flex-direction: column;align-items: center;justify-content: space-around;margin: 5px}
  </style>
 </head>
 <body> 
     <a href='catalog.php' style='align-self:flex-start'>Вернуться на главную</a>
     <div class="container">     
<?php 
$idProd = (int)$_GET['id'];
CONST IMG_SRC = 'images/';
$linkDB = mysqli_connect("localhost", "root", "root", "db_products");
$addView = mysqli_query($linkDB, "UPDATE products SET product_view = product_view+1 WHERE id = $idProd");
$result = mysqli_query($linkDB, "SELECT * FROM products WHERE id = $idProd");     

foreach($result as $item){
         echo "<div class='product'>
         {$item['product_name']}<br>Просмотров: {$item['product_view']} <a href=product.php?id={$item['id']}><img src=" . IMG_SRC . "{$item['product_image']}></a>Цена: {$item['product_price']}
         </div>";      
}
?>
     </div>
    
 </body>
</html>