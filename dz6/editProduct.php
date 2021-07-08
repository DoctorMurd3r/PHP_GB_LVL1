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
     
while($row = mysqli_fetch_assoc($result)){
         echo "<div class='product'>
         {$row['product_name']}<br>Просмотров: {$row['product_view']} <a href=product.php?id={$row['id']}><img src=" . IMG_SRC . "{$row['product_image']}></a>Цена: {$row['product_price']}
         </div>";     
    $prodName = $row['product_name'];
    $prodPrice = $row['product_price'];
    $prodImage =  $row['product_image'];
    $idProd = (int)$_GET['id'];
}
    
if(isset($_POST['change_product'])){
    $product_name = mysqli_real_escape_string($linkDB, htmlspecialchars(strip_tags($_POST['product_name'])));
    $product_price = (int)$_POST['product_price'];
    $id = $_POST['id'];
    if ($_FILES['product']['name'] === ''){
    
        foreach($result as $item){
            $product_file = $item['product_image'];
        }
    }else{
        $product_file = $_FILES['product_file']['name'];
    }
    if (mysqli_query($linkDB, "UPDATE `products` SET `product_name` = '$product_name', `product_price` = '$product_price', `product_image` = '$product_file' WHERE `id` = $id")){
        echo "Продукт был изменен " . $_FILES['product_file']['name']." ". $product_file;
    }
}
    
    /*
$useName = $_GET['name'];
echo $useName;  
echo $prodImage;*/
 ?>
    <form enctype="multipart/form-data" action="editProduct.php" method="POST">
    <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
    <input type="text" name="product_name" value="<?= $prodName ?>" required> Название продукта<br>
    <input type="text" name="product_price" value="<?= $prodPrice ?>" required> Цена продукта<br>
    <input type="file" name="product_file">Изображение продукта<br>
    <input type="submit" name="change_product" value="Изменить продукт">
</form>
     
</div>
    
 </body>
</html>