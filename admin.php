<?php require("admin_mw.php");?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <?php require("./comp/bootstrap.php"); ?>
</head>

<body>
    <?php require("./comp/nav.php"); ?>
    <?php
    $query = "SELECT * FROM users WHERE id != '{$_SESSION["user"]["id"]}'";
    $results =  ($database->query($query) != false) ? $database->query($query)->fetch_all(MYSQLI_ASSOC) : [];
    ?>

    <div class="container mt-5">
        <h3>Prikaz korisnika</h3>
        <?php foreach ($results as $user) : ?>
            <div class="card my-3">
                <div class="card-header align-items-center d-flex w-100 justify-content-between">
                    <div><?php echo $user["username"]; ?></div>
                    <form method="POST" action="server.php">
                        <input type = "hidden" name = "user_id" value ="<?php echo $user["id"];?>">
                        <input type = "hidden" name = "delete_user" value = "1">
                        <div><button class="btn btn-danger">Ukloni</button></div>
                    </form>
                </div>
                <div class="card-body">
                    <form action="server.php" method="POST">
                        <div class="form-group">
                            <input name="first_name" class="form-control" value="<?php echo $user["first_name"]; ?>">
                        </div>
                        <div class="form-group">
                            <input name="last_name" class="form-control" value="<?php echo $user["last_name"]; ?>">
                        </div>

                        <div class="form-group">
                            <input name="email" class="form-control" value="<?php echo $user["email"]; ?>">
                        </div>
                        <div class="form-group">
                            Uloga: <?php echo $user["role"]; ?>
                        </div>
                </div>
                <div class="card-footer">
                    <input type="hidden" name="edit_user" value="1">
                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                    <button class="btn btn-info btn-block w-50 mx-auto" type="submit">Izmeni</button>
                    </form>

                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>