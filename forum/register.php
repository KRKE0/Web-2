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
              <h2 class="text-uppercase text-center mb-5">Vytvorte si účet</h2>
              <?php
                if(isset($_POST["submit"])) {
                  $meno = $_POST["meno"];
                  $email = $_POST["email"];
                  $heslo = $_POST["heslo"];
                  $hesloZnova = $_POST["heslo_znova"];

                  $hesloHash = password_hash($heslo, PASSWORD_DEFAULT);

                  $errors = array();

                  if (empty($meno) OR empty($email) OR empty($heslo) OR empty($hesloZnova)) {
                    array_push($errors,"Všetky polia musia byť vyplnené");
                  }
                  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    array_push($errors, "Email nie je správny");
                  }
                  if (strlen($heslo)<8) {
                    array_push($errors, "Heslo je krátke");
                  }
                  if ($heslo!== $hesloZnova) {
                    array_push($errors,"Heslá sa nezhodujú");
                  }

                  require_once "connect.php";
                  $sql = "SELECT * FROM users WHERE email = '$email' ";
                  $result = mysqli_query($conn,$sql);
                  $rowCount = mysqli_num_rows($result);
                  if ($rowCount>0) {
                    array_push($errors,"Email už existuje!");
                  }
                  if (count($errors)>0) {
                    foreach ($errors as $error) {
                      echo "<div class='alert alert-danger'>$error</div>";
                    }
                  }else{
                    $sql = "INSERT INTO users (meno,email,heslo) VALUES (?,?,?)";
                    $stmt = mysqli_stmt_init($conn);
                    $prepareStmt = mysqli_stmt_prepare ($stmt,$sql );
                    if ($prepareStmt) {
                      mysqli_stmt_bind_param($stmt,"sss",$meno, $email, $hesloHash);
                      mysqli_stmt_execute($stmt);
                      echo "<div class='alert alert-success'>Úspešne ste sa registrovali.</div>";
                    }else{
                      die("Niečo nieje v poriadku");
                    }
                  }

                }
              ?>
              <form action="register.php" method="post">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" name="meno"/>
                  <label class="form-label" for="meno">Meno</label>
                </div>
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" name="email"/>
                  <label class="form-label" for="email">Email</label>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" name="heslo"/>
                  <label class="form-label" for="heslo">Heslo</label>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" name="heslo_znova"/>
                  <label class="form-label" for="heslo">Opakujte heslo</label>
                </div>
                <div class="d-flex justify-content-center">
                  <input type="submit"
                    class="btn btn-outline-primary btn-block btn-lg gradient-custom-4 text-body" value="Registruj sa!" name="submit"></input>
                </div>
                <div class="d-flex justify-content-center">
                  <a href="index.php"
                    class="btn btn-outline-secondary btn-block btn-lg gradient-custom-4 text-body" style="margin-top:15px;">Späť!</a>
                </div>
                <p class="text-center text-muted mt-5 mb-0">Už máte účet? <a href="login.php"
                    class="fw-bold text-body"><u>Prihláste sa</u></a></p>
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
