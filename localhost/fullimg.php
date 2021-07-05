<?php 
$ID = $_GET['id'];
$linkDB = mysqli_connect("localhost", "root", "root", "db_images");
$result = mysqli_query($linkDB, "SELECT * FROM images WHERE id = $ID");     
     
while($row = mysqli_fetch_assoc($result)){
    $img[] = $row;
}
echo "<img src={$img['0']['image_src']}><br>";

echo "<a href='5.php'>Вернуться</a>";
?>