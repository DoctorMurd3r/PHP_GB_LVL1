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
<a href='admin.php' style='align-self:flex-start'>На главную</a>
<div class="container">     
     <?php
CONST IMG_SRC = 'images/';
$idProd = (int)$_GET['id'];
$linkDB = mysqli_connect("localhost", "root", "root", "db_products") or die("Не удалось подключить базу данных");
$result = mysqli_query($linkDB, "SELECT * FROM products WHERE id = $idProd");    


     
while($row = mysqli_fetch_assoc($result)){
         echo "<div class='product'>
         {$row['product_name']}<br>Просмотров: {$row['product_view']} <img src=" . IMG_SRC . "{$row['product_image']}>Цена: {$row['product_price']}
         </div>";     
    $prodName = $row['product_name'];
    $prodPrice = $row['product_price'];
    $prodImage = $row['product_image'];
}
    
if(isset($_POST['change_product'])){
    $product_name = mysqli_real_escape_string($linkDB, htmlspecialchars(strip_tags($_POST['product_name'])));
    $product_price = (int)$_POST['product_price'];
    $id = $_POST['id'];
    if ($_FILES['product_file']['name'] === ''){
        if (mysqli_query($linkDB, "UPDATE `products` SET `product_name` = '$product_name', `product_price` = '$product_price' WHERE `id` = $id")){
            echo "Продукт был изменен ";
            
        }
    } else {
        $product_file = $_FILES['product_file']['name'];
        if (mysqli_query($linkDB, "UPDATE `products` SET `product_name` = '$product_name', `product_price` = '$product_price', `product_image` = '$product_file' WHERE `id` = $id")){
            echo "Продукт был изменен " . $_FILES['product_file']['name']." ". $product_file . $prodImage;
            
        }
    }
}



if (!empty($_GET['del'])) {
    if (mysqli_query($db, "DELETE FROM `pupils` WHERE id = {$_GET['del']}")) { ?>
      РЈРґР°Р»РµРЅР° Р·Р°РїРёСЃСЊ #<?= $_GET['del'] ?><br>
      <script>
      setTimeout(function () {
     window.location.href = "lesson6.php"; //will redirect to your blog page (an ex: blog.html)
  }, 4000);
      </script>
  <?php
      exit();
    } else { ?>
      РћС€РёР±РєР° - РЅРµ СѓРґР°Р»РѕСЃСЊ СѓРґР°Р»РёС‚СЊ Р·Р°РїРёСЃСЊ<br>
      <script>
      setTimeout(function () {
     window.location.href = "lesson6.php"; //will redirect to your blog page (an ex: blog.html)
  }, 4000);
      </script>
      <?php
      exit();
    }
  }






?>
<form enctype="multipart/form-data" action="editProduct.php" method="POST">
    <input type="hidden" name="id" value="<?= $idProd ?>">
    <input type="text" name="product_name" value="<?= $prodName ?>" required> Название продукта<br>
    <input type="text" name="product_price" value="<?= $prodPrice ?>" required> Цена продукта<br>
    <input type="file" name="product_file"><input type="button" value="Удалить картинку" name="delete_button"><br>
    <input type="submit" name="change_product" value="Изменить продукт">
</form>
     
</div>
    
 </body>
</html>