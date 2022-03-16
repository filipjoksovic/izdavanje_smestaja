<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pocetna</title>
    <?php include("comp/bootstrap.php"); ?>
</head>

<body>
    <?php include("comp/nav.php"); ?>
    <?php
    $query = "SELECT * FROM appartments";
    $results = (!$database->query($query)) ? [] : $database->query($query)->fetch_all(MYSQLI_ASSOC);
    ?>
    <div class="container mt-3 mb-5">
        <form action="search.php" method = "GET">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input name="name" class="form-control" placeholder="Naziv smestaja">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input name="pnum" class="form-control" placeholder="Broj osoba">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input name="priceMin" class="form-control" placeholder="Donji cenovni rang" type = "number">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input name="priceMax" class="form-control" placeholder="Gornji cenovni rang" type = "number">
                    </div>
                </div>
            </div>
            <button class = "btn btn-outline-success btn-block w-50 mx-auto">Pretrazi</button>
        </form>

    </div>
    <div class="container mt-5">
        <?php foreach ($results as $appartment) : ?>
            <?php
            $query = "SELECT * FROM appartment_images WHERE appartment_id = {$appartment['id']} LIMIT 1";
            $appartment_image = $database->query($query)->fetch_assoc();
            $appartment["image"] = $appartment_image["path"];
            ?>
            <div class="card my-3">
                <div class="card-header d-flex w-100 justify-content-between align-items-center">
                    <div>
                        <?php echo $appartment["name"]; ?>
                    </div>
                    <?php if ($_SESSION["user"]["role"] == "seller") : ?>
                        <div>
                            <form method="POST" action="server.php">
                                <input type="hidden" name="appartment_id" value="<?php echo $appartment["id"]; ?>">
                                <input type="hidden" name="delete_appartment" value="<?php echo $appartment["id"]; ?>">

                                <button class="btn btn-danger">Ukloni</button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <img class="img-thumbnail" src="<?php echo $appartment["image"]; ?>">
                    </div>
                    <div class="col-md-9">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <?php echo $appartment["location"]; ?><br>
                                    Broj soba: <?php echo $appartment["number_of_rooms"]; ?><br>
                                    Broj posetilaca: <?php echo $appartment["max_customers"]; ?><br>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="inlineCheckbox1">Parking</label>
                                        <input disabled class="ml-2 form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" <?php if ($appartment["has_parking"] == 1) echo "checked"; ?>>
                                    </div><br>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="inlineCheckbox1">Wifi </label>
                                        <input disabled class="form-check-input ml-2 " type="checkbox" id="inlineCheckbox1" value="option1" <?php if ($appartment["has_wifi"] == 1) echo "checked"; ?>>
                                    </div><br>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="inlineCheckbox1">Dozvoljeno pusenje </label>
                                        <input disabled class="form-check-input ml-2 " type="checkbox" id="inlineCheckbox1" value="option1" <?php if ($appartment["smoking_allowed"] == 1) echo "checked"; ?>>
                                    </div><br>
                                </div>
                            </div>

                        </div>
                        <div class="card-body mt-0 pt-0">
                            Opis: <?php echo $appartment["description"]; ?>
                        </div>
                        <div class="card-footer">
                            <a class="btn btn-primary btn-block mx-auto" href="details.php?id=<?php echo $appartment["id"]; ?>">Detalji proizvoda</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>


    </div>
</body>

</html>