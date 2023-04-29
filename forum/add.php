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
              <h2 class="text-uppercase text-center mb-5">Nahraj text</h2>
              <?php
                if(isset($_POST["submit"])) {
                  $meno = $_POST["meno"];
                  $texts = $_POST["text"];

                  $errors = array();

                  if (empty($meno) OR empty($texts)) {
                    array_push($errors,"Všetky polia musia byť vyplnené");
                  }
                  if (strlen($texts)<=0) {
                    array_push($errors, "Vyplnte text");
                  }

                  require_once "connect.php";
                  if (count($errors)>0) {
                    foreach ($errors as $error) {
                      echo "<div class='alert alert-danger'>$error</div>";
                    }
                  }else{
                    $sql = "INSERT INTO forum (meno,texts) VALUES (?,?)";
                    $stmt = mysqli_stmt_init($conn);
                    $prepareStmt = mysqli_stmt_prepare ($stmt,$sql );
                    if ($prepareStmt) {
                      mysqli_stmt_bind_param($stmt,"ss",$meno, $texts);
                      mysqli_stmt_execute($stmt);
                      echo "<div class='alert alert-success'>Úspešne ste nahrali článok.</div>";
                    }else{
                      die("Niečo nieje v poriadku");
                    }
                  }

                }
              ?>
              <form action="add.php" method="post">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" name="meno"/>
                  <label class="form-label" for="meno">Meno</label>
                </div>
                <div class="form-group">
                  <textarea rows="5" cols="33" name="text"></textarea>
                  <label class="form-label" for="text">Text</label>
                </div>
                <div class="d-flex justify-content-center">
                  <input type="submit"
                    class="btn btn-outline-primary btn-block btn-lg gradient-custom-4 text-body" value="Nahraj" name="submit"></input>
                </div>
                <div class="d-flex justify-content-center">
                  <a href="index.php"
                    class="btn btn-outline-secondary btn-block btn-lg gradient-custom-4 text-body" style="margin-top:15px;">Späť!</a>
                </div>
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
