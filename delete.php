<?php
require(base_path('db-connection.php'));
$id = $_GET['ID'];
$sql = "DELETE FROM planer WHERE ID = $id";
if (mysqli_query($connection,$sql)){
    header("location: http://localhost:3000/category");
}else{
    echo"Delete Fail...";
}?>