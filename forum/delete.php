<?php


if (isset($_POST['zmaz'])) {
    require "connect.php";
    $id = $_POST['id'];
    $query = "DELETE FROM forum WHERE id='$id'";
    $query_run =  mysqli_query($conn, $query);
    
    if ($query_run) {
        echo '<script>alert("Data boli zmazané");</script>';
        header("LOCATION: admin.php");
    }else {
        echo "Data neboli zmazané";
    }
} 
?>