<?php 
     session_start();  
?>
<!DOCTYPE html>
<html>
     <head>
     <meta charset="utf-8" />
     <title>DZ6</title>
<style>
      *{margin:0 auto;}
     img{width:100px; padding:20px} 
     .container{display: flex;align-items: center;justify-content: center; max-width: 1000px;flex-wrap: wrap}
     .product{width:150px; height: 250px; border:2px solid coral;display: flex;flex-direction: column;align-items: center;justify-content: space-around;margin: 7px}
     a{text-decoration: none;color:green;margin:2px}a:hover{color:goldenrod}
</style>
</head>
<body> 
<a href='catalog.php'>Перейти обратно в каталог</a>
    
<?php
$linkDB = mysqli_connect("localhost", "root", "root", "db_products") or die("Не удалось подключить базу данных");    
$login = $_SESSION['login'];
$password = $_SESSION['passwordWrited'];
$isAdmin = mysqli_query($linkDB, "SELECT login, password_hash from admins WHERE login ='$login'");
$row = mysqli_fetch_assoc($isAdmin);

if (($login == $row['login']) && !empty($login) && (password_verify($password,$row['password_hash']))){
    ?>
    <a href='createProduct.php' style='align-self:flex-start;margin:15px'>Добавить новый продукт</a>
    <?php    echo "Вы вошли как " . $login; ?>
    <div class="container">     
        
        <?php
    
    $result = mysqli_query($linkDB, "SELECT * FROM products ORDER BY product_view DESC"); 
    //CONST IMG_SRC = 'images/';
    
    $isProducts = mysqli_fetch_row($result);
    if(!isset($isProducts)) {
        echo "Список продуктов пуст";
    }
    
    foreach($result as $item){
        echo "<div class='product'>
        {$item['product_name']}<br>Просмотров: {$item['product_view']} 
        <img src=" . "{$item['product_image']}>Цена: {$item['product_price']} Р
        <a href=editProduct.php?id={$item['id']}>Редактировать товар</a>
        <a href=deleteProduct.php?id={$item['id']}>Удалить товар</a>
        </div>";
    }
    
    mysqli_close($linkDB);     
    
} else {
    echo "У вас нет доступа к этой странице";
}

?>    
<?php
//echo $login .  $_SESSION['login'] . $_SESSION['passwordWrited'];
  //      echo password_verify($password,$row['password_hash']);
?>
        
 </body>
</html>