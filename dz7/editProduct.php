<?php 
session_start();
?>
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
<?php     
$linkDB = mysqli_connect("localhost", "root", "root", "db_products") or die("Не удалось подключить базу данных");    
$login = $_SESSION['login'];
$password = $_SESSION['passwordWrited'];
$isAdmin = mysqli_query($linkDB, "SELECT login, password_hash from admins WHERE login ='$login'");
$row = mysqli_fetch_assoc($isAdmin);

if (($login == $row['login']) && !empty($login) && (password_verify($password,$row['password_hash']))){     
?>     
     
<a href='admin.php' style='align-self:flex-start'>На главную</a>
<div class="container">     
     <?php
//CONST IMG_SRC = 'images/';
$idProd = (int)$_GET['id'];
$linkDB = mysqli_connect("localhost", "root", "root", "db_products") or die("Не удалось подключить базу данных");
$result = mysqli_query($linkDB, "SELECT * FROM products WHERE id = $idProd");    
     
while($row = mysqli_fetch_assoc($result)){
         echo "<div class='product'>
         {$row['product_name']}<br>Просмотров: {$row['product_view']} <img src=" . "{$row['product_image']}>Цена: {$row['product_price']} Р
         </div>";     
    $prodName = $row['product_name'];
    $prodPrice = $row['product_price'];
    $prodImage = $row['product_image'];
}
    
if(isset($_POST['change_product'])){
    $product_name = htmlspecialchars(strip_tags($_POST['product_name']));
    $product_price = (int)$_POST['product_price'];
    $id = $_POST['id'];
    
    //$linkDB = sqli_connect("localhost","root","root", "db_products") or die ("Не удалось подключить базу данных");
    $result = mysqli_query($linkDB, "SELECT product_image FROM products WHERE id = $id");
    $del = mysqli_fetch_row($result)[0];  
//    $del = $_POST['oldImage'];
    //$del = IMG_SRC . $del;
    if ($_FILES['product_file']['name'] === ''){
        if (mysqli_query($linkDB, "UPDATE `products` SET `product_name` = '$product_name', `product_price` = '$product_price' WHERE `id` = $id")){
            echo "Продукт был изменен <br>";     
        }
    } else {
        
        if (!isset($_FILES['product_file'])) {
            return "Файл не выбран";
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
        }
        
        $product_file = $_FILES['product_file']['name'];
        
        if (mysqli_query($linkDB, "UPDATE `products` SET `product_name` = '$product_name', `product_price` = '$product_price', `product_image` = '$product_file' WHERE `id` = $id")){
            echo "Продукт был изменен <br>";  
        }
    }
    if ($_POST['delete_check'] == ''){
        echo "Изображение не было удалено";
    } else {
        echo "Изображение " . $_POST['oldImage'] . " удалено";
        unlink($del);
    }
    echo 
    "<script>
        setTimeout(function () {
        window.location.href = 'admin.php';
        }, 3000);
    </script>";
}

?>
<form enctype="multipart/form-data" action="editProduct.php" method="POST">
    <input type="hidden" name="id" value="<?= $idProd ?>">
    <!-- Текущее изображение<br><img src="<?= $prodImage ?>"> -->
    <input type="text" name="product_name" value="<?= $prodName ?>" required> Название продукта<br>
    <input type="text" name="product_price" value="<?= $prodPrice ?>" required> Цена продукта<br>
    <input type="checkbox" name="delete_check">Удалить старое изображение<br>
    Выбрать новое изображение <input type="file" name="product_file" title="what" style="color:transparent;"><br>
    <input type="submit" name="change_product" value="Изменить продукт">
</form>
     
</div>
<?php
} else {
     echo "У вас нет доступа к этой странице";
    }?>
 </body>
</html>