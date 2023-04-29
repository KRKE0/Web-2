<?php
  session_start();
  if (isset($_SESSION["user"])) {
    header("LOCATION: admin.php"); 
  }
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <title>Fórum</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<section class="vh-100 bg-image"
  style="background-image: url('https://mdbcdn.b-cdn.net/img/Photos/new-templates/search-box/img4.webp');">
  <div class="mask d-flex align-items-center h-100 gradient-custom-3">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
          <div class="card" style="border-radius: 15px;">
            <div class="card-body p-5">
              <h2 class="text-uppercase text-center mb-5">Prihláste sa</h2>

              <?php
              if (isset($_POST["login"])) {
                $email = $_POST["email"];
                $heslo = $_POST["heslo"];
                 require_once "connect.php";
                 $sql = "SELECT * FROM users WHERE email = '$email'"; 
                 $result = mysqli_query($conn,$sql);
                 $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
                 if ($user) {
                  if (password_verify($heslo,$user["heslo"])) {
                    session_start();
                    $_SESSION["user"] = "yes";
                    header("Location: admin.php");
                    die(); 
                  }else {
                    echo "<div class='alert alert-danger'>Heslo sa nezhoduje</div>";
                  }
                 }else {
                  echo "<div class='alert alert-danger'>Email neexistuje</div>";
                 } 
              }

              ?>
              <form action="login.php" method="post">


                <div class="form-group">
                  <input type="email" name="email" class="form-control form-control-lg" />
                  <label class="form-label" for="email">Email</label>
                </div>

                <div class="form-group">
                  <input type="password" name="heslo" class="form-control form-control-lg" />
                  <label class="form-label" for="heslo">Heslo</label>
                </div>

                <div class="d-flex justify-content-center">
                  <input type="submit" name="login" value="Prihláste sa!" class="btn btn-outline-primary btn-block btn-lg gradient-custom-4 text-body"></input >
                </div>


                <div class="d-flex justify-content-center">
                  <a href="index.php"
                    class="btn btn-outline-secondary btn-block btn-lg gradient-custom-4 text-body" style="margin-top:15px;">Späť!</a>
                </div>

                <p class="text-center text-muted mt-5 mb-0">Nemáte účet? <a href="register.php"
                    class="fw-bold text-body"><u>Registrujte sa!</u></a></p>

              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
  


</body>
</html>
