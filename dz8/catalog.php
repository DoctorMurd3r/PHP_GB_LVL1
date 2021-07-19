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
.container{display: flex;align-items: center;justify-content: center; max-width: 1000px;flex-wrap: wrap;margin-top: 15px;}
.product{width:150px; height: 240px; border:2px solid coral;display: flex;flex-direction: column;align-items: center;justify-content: space-around;margin: 7px}
      a{text-decoration: none;color:green;margin:2px;}a:hover{color:goldenrod}
      input{margin:2px}
  </style>
 </head>
 <body> 
<!-- логин администратора: admin, пароль: catdog -->


     
     
<a href='cart.php' style='font-size:20px'>Перейти в корзину</a>
<div class="container">     
     <?php
  
$linkDB = mysqli_connect("localhost", "root", "root", "db_products") or die("Не удалось подключить базу данных");
$result = mysqli_query($linkDB, "SELECT * FROM products ORDER BY product_view DESC"); 
//CONST IMG_SRC = 'images/';
     

   

if (isset($_POST['check_loginPass'])){
    $login = mysqli_real_escape_string($linkDB, htmlspecialchars(strip_tags($_POST['login'])));
    $password = $_POST['password'];
    $check = mysqli_query($linkDB, "SELECT id, password_hash from admins WHERE login = '$login'");
    if (!mysqli_num_rows($check)){
        echo "Нет такого пользователя<br>";
    } else {
        $row = mysqli_fetch_assoc($check);
        $hash = $row['password_hash'];
        if (!password_verify($password, $hash)){
            echo "Неверный пароль<br>";
        } else {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['login'] = $login;
            $_SESSION['passwordWrited'] = $password;
        }
    }
}    
    
    if(isset($_GET['logout'])){
    unset($_SESSION['login']);
    unset($_SESSION['user_id']);
    unset($_SESSION['passwordWrited']);
}
    
    
 if (empty($_SESSION['login'])){
        echo "
<form action='catalog.php' method='POST'>
    <input type='login' name='login' required> Логин<br>
    <input type='text' name='password' required> Пароль<br>
    <input type='submit' name='check_loginPass' value='Войти'>
</form>
    ";
    }
    else{
        echo 
        "<div>
        <a href='?logout'>Разлогиниться</a>
        <br><a href='admin.php'>Перейти на страницу управления продуктами</a>
        </div>";   
    }
    
    
echo "Привет, " . ($_SESSION['login'] ?? "Гость"). "<br>";
    

    
$isProducts = mysqli_fetch_row($result);
if(!isset($isProducts)) {
     echo "Список продуктов пуст";
}
    
//////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////

foreach($result as $item){
         echo "
         <div class='product'>
         
         {$item['product_name']}<br>Просмотров: {$item['product_view']} 
         <a href=product.php?id={$item['id']}><img src=" . "{$item['product_image']}></a>Цена: {$item['product_price']} Р
         <a href='cart.php?add={$item['id']}'>Добавить в корзину</a>
         
         </div>";     
}
    

    //echo $_SESSION['login'] . " " .  $_SESSION['user_id'] . " ";
    //echo session_id();
mysqli_close($linkDB);     
?>
     
</div>
    
 </body>
</html>
