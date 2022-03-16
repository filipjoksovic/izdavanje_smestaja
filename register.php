<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registracija</title>
    <?php include("comp/bootstrap.php"); ?>
</head>

<body>
    <?php include("comp/nav.php"); ?>
    <div class="container mt-5">
        <div class="my-3">
            <h2>Ulogujte se</h2>
            <h5 class="text-muted">Registrujte Vas nalog</h5>
        </div>
        <form method="POST" action="server.php">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="username">Korisnicko ime</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email adresa</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="exampleInputPassword1">Lozinka</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="password">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="fname">Ime</label>
                        <input type="text" class="form-control" id="fname" name="first_name">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="lname">Prezime</label>
                        <input type="text" class="form-control" id="lname" name="last_name" aria-describedby="emailHelp">
                    </div>
                </div>
            </div>
            <label for = "role">Uloga</label>
            <select name = "role" id = "role" class = "form-control mb-5">
                <option value = "user">Korisnik</option>
                <option value = "seller">Prodavac</option>
            </select>

            <input type="hidden" name="register">
            <button type="submit" class="btn btn-primary">Registrujte se</button>
        </form>
    </div>
</body>

</html>