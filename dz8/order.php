<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

session_start();

?>
<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8" />
  <title>Корзина</title>
  <style>
      *{margin:0 auto}
      h2{margin:0 auto;}
      img{width:100px; padding:20px} 
      body,.container{display: flex;align-items: center;justify-content: center; max-width: 1000px;flex-wrap: wrap;margin-top: 15px}
      body{flex-direction: column}
      .product{width:150px; height: 200px; border:2px dashed green;display: flex;flex-direction: column;align-items: center;justify-content: space-around;margin: 7px;padding:7px}
      a{text-decoration: none;color:green}a:hover{color:goldenrod}
      input{margin:3px}
  </style>
 </head>
 <body> 
     <h2>Заказ</h2>
<a href='cart.php'>Обратно в корзину</a>

<div class="container">     
     <?php
   
$linkDB = mysqli_connect("localhost", "root", "root", "db_products") or die("Не удалось подключить базу данных");
//$sessionId = session_id();
$finalSum = 0;
 $sessId = $_GET['sess']; 
    var_dump($sessId);
    
if(!empty($_GET['sess'])){

//защита
$sessId = $_GET['sess'];    
$sessId = htmlspecialchars(strip_tags($sessId));
    var_dump($sessId);

// INSERT INTO order_items (order_id, product_id, qty, price) 
//     SELECT 10, product_id, qty, price FROM cart 
//     INNER JOIN products ON products.id = cart.product_id
//     WHERE session_id = 1;
mysqli_query($linkDB, "INSERT INTO order_items (order_id, product_id, quantity, price)
    (SELECT session_id, product_id, quantity, price 
    FROM cart 
    INNER JOIN products ON products.id = cart.product_id
    WHERE `session_id` = '$sessId') ON DUPLICATE KEY UPDATE order_items.quantity = cart.quantity");// update на случай, если бы корзина не удалялась после перехода в заказ
    
mysqli_query($linkDB, "DELETE FROM cart WHERE session_id = '$sessId'");
} else {
    echo "ПУСТОЙ ЗАКАЗ";
}

    
$result = mysqli_query($linkDB, "SELECT * FROM order_items 
    INNER JOIN products ON products.id = order_items.product_id 
    WHERE order_id = '$sessId'");   
    foreach($result as $item){
         $sumItem = ($item['product_price']*$item['quantity']);
         $finalSum = $finalSum + $sumItem;
         echo "<div class='product'><h3>В вашем заказе</h3>
         {$item['product_name']}<br>
         Цена за 1 шт {$item['price']} Р<br>
         Количество {$item['quantity']}<br>
         <a href='?del={$item['product_id']}&sess={$item['order_id']}' style='color:blue'>Удалить товар из заказа</a>
         </div>";     
}
  

if($_GET['del']){
$delete = (int)$_GET['del'];
    mysqli_query($linkDB, "DELETE FROM order_items WHERE product_id = $delete");
    echo "Сейчас продукт будет удален из заказа";
    echo "<script>
        setTimeout(function () {
        window.location.href = 'order.php?sess={$sessId}';
        }, 10000);
    </script>";
}  

if (isset($_POST['buy_products'])){
    $finalSum = $_POST['price'];
    var_dump($finalSum);
    
    $id = $_POST['id'];
    var_dump($id);
    $name = mysqli_real_escape_string($linkDB, htmlspecialchars(strip_tags($_POST['order_name'])));
    $phone = mysqli_real_escape_string($linkDB, htmlspecialchars(strip_tags($_POST['order_phone'])));
    $address = mysqli_real_escape_string($linkDB, htmlspecialchars(strip_tags($_POST['order_address'])));
    //var_dump($sessId);
mysqli_query($linkDB, "INSERT INTO order_client (session_id, name, phone, address, final_price)
VALUES ('$id', '$name', '$phone','$address','$finalSum') ON DUPLICATE KEY UPDATE
session_id = '$id', name = '$name', phone = '$phone', address = '$address', final_price = '$finalSum'
");
echo "Заказ оформлен <br>
Сейчас вы будете перенаправлены на главную страницу " . 
"<script>
        setTimeout(function () {
        window.location.href = 'catalog.php';
        }, 5000);
    </script>";
}     
    
?>
<form action="order.php" method="POST">
    <input type="hidden" name="id" value="<?= $sessId ?>">
    <input type="hidden" name="price" value="<?= $finalSum ?>">
    <input type="text" name="order_name" required> Ваше имя<br>
    <input type="text" name="order_phone" required> телефон<br>
    <input type="text" name="order_address" required> адрес<br>
    <input type="submit" name="buy_products" value="Завершить покупку">
</form>
    
    
    <?php
    
   
//mysqli_close($linkDB);     
?>
     
</div>
   <?php   echo "<h3>Итоговая сумма: " . $finalSum . " Р</h3>"; ?>

 </body>
</html>
