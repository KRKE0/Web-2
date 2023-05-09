<?php
  session_start();
  if (!isset($_SESSION["user"])) {
    header("LOCATION: login.php");
  }
?>

<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href="script/css/index.css">
	

	<title>Fórum</title>
</head>

<body>
<nav class="navbar navbar-expand-sm bg-light">
<?php
  require "connect.php";

  
  $result = mysqli_query($conn, "SELECT * FROM forum");

?>
<div class="container-fluid">
	<a class="navbar-brand" href="register.php">
      <img src="images/admin.png" alt="Avatar Logo" style="width:40px;" class="rounded-pill"> 
    </a>
    <div class="collapse navbar-collapse" id="mynavbar">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="add.php">Pridaj</a>
        </li>
		<li class="nav-item">
          <a class="nav-link" href="logout.php">Odhás sa!</a>
        </li>
      </ul>
      
    </div>
  </div>
</nav>
<div class="container-fluid mt-100">
     <div class="row">
         <div class="col-md-12">
             <div class="card mb-4">
                 <div class="card-header">
                  <table class="table table-bordered text-center align-middle">
                    <tr>
                      <?php
                     
                        while ($row = mysqli_fetch_assoc($result)) {
                         ?>
                         <td><?php echo $row['id'];?></td>
                         <td><?php echo $row['meno'];?></td>
                         <td><?php echo $row['datum'];?></td>
                         <td><?php echo $row['texts'];?></td>
                         <form action="delete.php" method="post">
                          <input type="hidden" name="id" value="<?php echo $row['id']?>">
                         <td><input class="btn btn-outline-danger" type="submit" name="zmaz" value="Odstráň" ></input></td>
                        </form>
                        </tr>
                         <?php
                        }
                      ?>
                  </table>
             </div>
         </div>
     </div>
 </div>