<?php 
$ID = $_GET['id'];
$linkDB = mysqli_connect("localhost", "root", "root", "db_images");
$result = mysqli_query($linkDB, "SELECT * FROM images WHERE id = $ID");     
$addView = mysqli_query($linkDB, "UPDATE images SET image_views = image_views+1 WHERE id = $ID");

while($row = mysqli_fetch_assoc($result)){
    $img[] = $row;
}
echo "<img src={$img['0']['image_src']}><br>";
echo "Число просмотров " . ($img['0']['image_views']+1) . "<br>";
echo "<a href='5.php'>Вернуться</a>";
?>
