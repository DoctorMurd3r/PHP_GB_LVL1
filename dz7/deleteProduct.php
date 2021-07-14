<?php
session_start();
$linkDB = mysqli_connect("localhost", "root", "root", "db_products") or die("Не удалось подключить базу данных");    
$login = $_SESSION['login'];
$password = $_SESSION['passwordWrited'];
$isAdmin = mysqli_query($linkDB, "SELECT login, password_hash from admins WHERE login ='$login'");
$row = mysqli_fetch_assoc($isAdmin);

if (($login == $row['login']) && !empty($login) && (password_verify($password,$row['password_hash']))){
    

//$linkDB = mysqli_connect("localhost", "root", "root", "db_products") or die("Не удалось подключить базу данных");
$idProd = (int)$_GET['id'];
$result = mysqli_query($linkDB, "SELECT product_image FROM products WHERE id = $idProd");
$del = mysqli_fetch_row($result)[0];
unlink($del);

$deleteProduct = mysqli_query($linkDB, "DELETE FROM products WHERE id = $idProd"); 
echo "Продукт с ID " . $idProd . " удалена";
?>
<script>    
    setTimeout(function () {
   window.location.href = "admin.php"; 
}, 3000);
</script>
<?php
} else {
    echo $login;
    echo $login .  $_SESSION['login'] . $_SESSION['passwordWrited'];
    echo "У вас нет доступа к этой странице";
    }
?>