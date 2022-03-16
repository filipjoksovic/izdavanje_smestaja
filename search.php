<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rezultati pretrage</title>
    <?php include("./comp/bootstrap.php"); ?>
</head>

<body>
    <?php include("./comp/nav.php"); ?>
    <?php
    $query = "SELECT * FROM appartments";
    $allAppartments = $database->query($query)->fetch_all(MYSQLI_ASSOC);
    $name = null;
    $pricemin = null;
    $pricemax = null;
    $pnum;
    if ($_GET["name"] != "") {
        $name = $_GET["name"];
    }
    if ($_GET["priceMin"] != "") {
        $priceMin = $_GET["priceMin"];
    }
    if ($_GET["priceMax"] != "") {
        $priceMax = $_GET["priceMax"];
    }
    if ($_GET["pnum"] != "") {
        $pnum = $_GET["pnum"];
    }
    for ($i = 0; $i < count($allAppartments); $i++) {
        if (!str_contains(strtolower($allAppartments[$i]["name"]), strtolower($name))) {
            unset($allAppartments[$i]);
            $i++;
        }
        if (isset($priceMin)) {
            if ($allAppartments[$i]["price"] <= $priceMin) {
                unset($allAppartments[$i]);
                $i++;
            }
        }
        if (isset($priceMax)) {
            if ($allAppartments[$i]["price"] >= $priceMax) {
                unset($allAppartments[$i]);
                $i++;
            }
        }
        if (isset($pnum)) {
            if ($allAppartments[$i]["max_customers"] >= $pnum) {
                unset($allAppartments[$i]);
                $i++;
            }
        }
    }
    ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3">
                <form action="search.php" method="GET">
                    <div class="form-group">
                        <label for="name">Naziv</label>
                        <input class="form-control" name="name" id="name" value="<?php if ($_GET["name"] != "") echo $name; ?>">
                    </div>
                    <div class="form-group">
                        <label for="pnum">Maksimalan broj musterija</label>
                        <input class="form-control" name="pnum" id="pnum" value="<?php if ($_GET["pnum"] != "") echo $pnum; ?>">
                    </div>
                    <div class="form-group">
                        <label for="priceMin">Donja cenovna granica</label>
                        <input class="form-control" name="priceMin" id="priceMin" value="<?php if ($_GET["priceMin"] != "") echo  $priceMin; ?>">
                    </div>
                    <div class="form-group">
                        <label for="priceMax">Gornja cenovna granica</label>
                        <input class="form-control" name="priceMax" id="priceMax" value="<?php if ($_GET["priceMax"] != "") echo $priceMax; ?>">
                    </div>
                    <button class="btn btn-outline-success btn-block w-50 mx-auto" type="submit">Pretrazi</button>
                </form>
            </div>
            <div class="col-md-9">
                <h3 class="mb-4">Rezultati pretrage</h3>
                <?php foreach ($allAppartments as $appartment) : ?>
                    <?php
                    $query = "SELECT * FROM appartment_images WHERE appartment_id = {$appartment['id']} LIMIT 1";
                    $appartment_image = $database->query($query)->fetch_assoc();
                    $appartment["image"] = $appartment_image["path"];
                    ?>
                    <div class="card">
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
        </div>

    </div>
</body>

</html>