<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8" />
  <title>HTML5</title>
  <style>
      img{width:100px; padding:20px};
  </style>
 </head>
 <body>
     <?php
$linkDB = mysqli_connect("localhost", "root", "root", "db_images");
$result = mysqli_query($linkDB, "SELECT * FROM images");     
$imgArrDB = [];
$imgSrc = [];
$imgId = [];
$imgName = [];
     
while($row = mysqli_fetch_assoc($result)){
    $imgArrDB[] = $row;
}
     
foreach($imgArrDB as $item => $img){
    $imgId[] = $img['id'];
    $imgName[] = $img['image_name'];
    $imgSrc[] = $img['image_src'];
}
     
for ($i = 0;$i < count($imgSrc);$i++){
    echo $imgName[$i] . "<a href=fullimg.php?id=$imgId[$i]><img src=$imgSrc[$i]></a>";
}
     
mysqli_close($linkDB);     
?>
 </body>
</html>