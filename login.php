<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <?php include("comp/bootstrap.php"); ?>
</head>

<body>
    <?php include("comp/nav.php"); ?>
    <div class="container mt-5">
        <div class = "my-3">
            <h2>Ulogujte se</h2>
            <h5 class="text-muted">Prijavite se na svoj nalog</h5>
        </div>
        <form method = "POST" action = "server.php">
            <div class="form-group">
                <label for="exampleInputEmail1">Korisnicko ime</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name = "username" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name = "password">
            </div>
            <input type = "hidden" name = "login">
            <button type="submit" class="btn btn-primary">Ulogujte se</button>
        </form>
    </div>
</body>

</html>