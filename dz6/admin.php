<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8" />
  <title>DZ6</title>
  <style>
img{width:100px; padding:20px} 
.container{display: flex;align-items: center;justify-content: center}
.product{width:135px; height: 240px; border:2px solid coral;display: flex;flex-direction: column;align-items: center;justify-content: space-around;margin: 5px}
  </style>
 </head>
 <body> 
     <a href='createProduct.php' style='align-self:flex-start'>Добавить новый продукт</a>
<div class="container">     
     <?php
$linkDB = mysqli_connect("localhost", "root", "root", "db_products") or die("Не удалось подключить базу данных");;
$result = mysqli_query($linkDB, "SELECT * FROM products ORDER BY product_view DESC"); 
CONST IMG_SRC = 'images/';
     
foreach($result as $item){
         echo "<div class='product'>
         {$item['product_name']}<br>Просмотров: {$item['product_view']} <a href=product.php?id={$item['id']}><img src=" . IMG_SRC . "{$item['product_image']}></a>Цена: {$item['product_price']}<a href=editProduct.php?id={$item['id']}&img={$item['product_image']}>Редактировать товар</a>
         </div>";     
}

mysqli_close($linkDB);     
?>
     
</div>
    
 </body>
</html>