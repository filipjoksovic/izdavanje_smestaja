<?php require("seller_mw.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pregled ocena</title>
    <?php include("./comp/bootstrap.php"); ?>
</head>

<body>
    <?php include("./comp/nav.php") ?>
    <?php
    $query = "SELECT users.*, reviews.*, appartments.* FROM reviews  INNER JOIN appartments on appartments.id = reviews.appartment_id INNER JOIN users on users.id = reviews.user_id WHERE appartments.user_id = {$_SESSION["user"]["id"]}";
    $reviews = ($database->query($query)) ? $database->query($query)->fetch_all(MYSQLI_ASSOC) : [];
    ?>
    <div class="container mt-5">
        <h3>Pregled ocena</h3>
        <?php foreach ($reviews as $review) : ?>
            <div class="card mt-5">
                <div class="card-header d-flex w-100 justify-content-between">
                    <div>
                        <?php echo $review["username"]; ?>
                    </div>
                    <div>
                        <?php echo $review["rate"] ?> / 5
                    </div>
                </div>
                <div class="card-body">
                    <?php echo $review["review"]; ?>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</body>

</html>