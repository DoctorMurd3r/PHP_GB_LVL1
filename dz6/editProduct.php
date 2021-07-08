<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8" />
  <title>Редактирование продукта</title>
  <style>
img{width:100px; padding:20px} 
.container{display: flex;align-items: center;justify-content: center}
.product{width:135px; height: 220px; border:2px solid coral;display: flex;flex-direction: column;align-items: center;justify-content: space-around;margin: 5px}
input{margin:3px}
  </style>
 </head>
 <body> 
     <a href='catalog.php' style='align-self:flex-start'>На главную</a>
<div class="container">     
     <?php
CONST IMG_SRC = 'images/';
$idProd = (int)$_GET['id'];
$linkDB = mysqli_connect("localhost", "root", "root", "db_products") or die("Не удалось подключить базу данных");
$result = mysqli_query($linkDB, "SELECT * FROM products WHERE id = $idProd");    
     
    
  /*  while($row = mysqli_fetch_assoc($result)) {
  echo "{$row['product_name']} {$row['product_price']} ({$row['age']})<a href='?del={$row['id']}'>Del</a><br>";
}
    */
while($row = mysqli_fetch_assoc($result)){
         echo "<div class='product'>
         {$row['product_name']}<br>Просмотров: {$row['product_view']} <a href=product.php?id={$row['id']}><img src=" . IMG_SRC . "{$row['product_image']}></a>Цена: {$row['product_price']}
         </div>";     
}
    
    
    /*
$useName = $_GET['name'];
echo $useName;  */
    
 ?>
    <form enctype="multipart/form-data" action="createProduct.php" method="POST">
    <input type="text" name="product_name" value="" required> Название продукта<br>
    <input type="text" name="product_price" required> Цена продукта<br>
    <input type="file" name="product_file" required>Изображение продукта<br>
    <input type="submit" value="Изменить продукт">
</form>
     
</div>
    
 </body>
</html>