<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8" />
  <title>Добавление нового продукта</title>
  <style>
img{width:100px; padding:20px} 
.container{display: flex;align-items: center;justify-content: center}
.product{width:135px; height: 220px; border:2px solid coral;display: flex;flex-direction: column;align-items: center;justify-content: space-around;margin: 5px}
      input{margin:3px}
  </style>
 </head>
 <body> 
     <a href='admin.php' style='align-self:flex-start'>На главную</a>
<div class="container">     
<?php
$linkDB = mysqli_connect("localhost", "root", "root", "db_products");
    
function createProduct($linkDB)
{ 
    $Name = htmlspecialchars(strip_tags($_POST['product_name']));
    $Price = (int)$_POST['product_price'];
    if (!isset($_FILES['product_file'])) {
    return;
    }
    if ($_FILES['product_file']['error'] !== 0){
        return "Ошибка при загрузке файла";
    }
    if ($_FILES['product_file']['type'] != 'image/jpeg'){
        return "Файл не картинка!";
    }
    if (!move_uploaded_file($_FILES['product_file']['tmp_name'], $_FILES['product_file']['name'])) {
        return "Не получилось сохранить изображение<br>";
    }
    if(($_FILES['product_file']['size'] > 1000000)){
        return "Размер файла слишком большой<br>";
    } else {
            if(!mysqli_query($linkDB, "INSERT INTO `products`(`product_name`,`product_price`,`product_image`) 
            VALUES ('$Name','$Price','{$_FILES['product_file']['name']}')")) {
            echo mysqli_error($linkDB). "<br>";
            return;
            
    }  echo "Продукт был успешно добавлен с ID " . mysqli_insert_id($linkDB) . 
"<script>
    setTimeout(function () {
        window.location.href = 'admin.php';
    }, 3000);
</script>"; 
    }

} 
createProduct($linkDB);
?>
  
   
<form enctype="multipart/form-data" action="createProduct.php" method="POST">
    <input type="text" name="product_name" required> Название продукта<br>
    <input type="text" name="product_price" required> Цена продукта<br>
    <input type="file" name="product_file" required>Изображение продукта<br>
    <input type="submit" value="Загрузить новый продукт">
</form>

     
</div>
    
 </body>
</html>