<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8" />
  <title>DZ6</title>
  <style>
img{width:100px; padding:20px} 
.container{display: flex;align-items: center;justify-content: center}
.product{width:135px; height: 220px; border:2px solid coral;display: flex;flex-direction: column;align-items: center;justify-content: space-around;margin: 5px}
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
         {$item['product_name']}<br>Просмотров: {$item['product_view']} <a href=product.php?id={$item['id']}><img src=" . IMG_SRC . "{$item['product_image']}></a>Цена: {$item['product_price']}  <a href=editProduct.php?id={$item['id']}&name={$item['product_name']}>Редактировать товар</a>
         </div>";     
}

/*
if (!empty($_GET['edit'])) : 
$idProd =(int) $_GET['edit'];
$result = mysqli_query($linkDB, "SELECT * FROM products WHERE id = $idProd");
$row = mysqli_fetch_assoc($result);
     if(!$row){
         echo "Нет такого продукта";
     } else : 
     ?>
  <form enctype="multipart/form-data" action="catalog.php" method="POST">
    <input type="hidden" name="id" value="<?=$row $idProd ?>">
    <input type="text" name="product_name" value="<?= $row['product_name'] ?>"><br>
    <input type="text" name="product_price" value="<?= $row['product_price'] ?>"><br>
    <input type="file" name="product_file" value="<?= $row['product_image'] ?>"><br>
    <input type="submit" name="save_product" value="Сохранить изменения">
</form>
<?php 
endif;
     
}    

           
function uploadImage($linkDB)
{
    if (!isset($_FILES['image_file'])) {
    return;
    }
    if ($_FILES['image_file']['error'] !== 0){
        return "Ошибка при загрузке файла";
    }
    if ($_FILES['image_file']['type'] != 'image/jpeg'){
        return "Файл не картинка!";
    }
    if (!move_uploaded_file($_FILES['image_file']['tmp_name'], $_FILES['image_file']['name'])) {
        return "Не получилось сохранить изображение<br>";
    }
    if(($_FILES['image_file']['size'] > 1000000)){
        return "Размер файла слишком большой<br>";
    } else {
            if(!mysqli_query($linkDB, "INSERT INTO `images`(`image_src`,`image_name`) VALUES ('{$_FILES['image_file']['name']}', '{$_POST['image_name']}')")){
            echo mysqli_error($linkDB). "<br>";
    }   
    return "Файл был успешно загружен <br><a href='51.php'>Обновить список</a>";
    }
}

echo uploadImage($linkDB);  
      */ 
mysqli_close($linkDB);     
?>
     
</div>
    
 </body>
</html>