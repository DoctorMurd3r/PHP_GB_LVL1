<?php
$linkDB = mysqli_connect("localhost", "root", "root", "db_products") or die("Не удалось подключить базу данных");
$idProd = $_GET['id'];
$deleteProduct = mysqli_query($linkDB, "DELETE FROM products WHERE id = $idProd"); 
echo "Запись с ID " . $idProd . " удалена";
?>
<script>    
    setTimeout(function () {
   window.location.href = "admin.php"; //will redirect to your blog page (an ex: blog.html)
}, 3000);
</script>

    

