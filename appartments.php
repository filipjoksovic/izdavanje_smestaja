<?php require("seller_mw.php");?>
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
    $query = "SELECT * FROM appartments where user_id = {$_SESSION['user']['id']}";
    $results = (!$database->query($query)) ? [] : $database->query($query)->fetch_all(MYSQLI_ASSOC);
    ?>
    <div class="container mt-5">
        <?php if (count($results) == 0) : ?>
            <h5>Izgleda da nemate ni jedan dodat apartman. Dodajte ga u formi ispod</h5>
            <form method="POST" action="server.php" enctype="multipart/form-data">
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Naziv</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="location">Lokacija</label>
                            <input type="text" class="form-control" id="location" name="location">
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="wifi">Ima wifi</label>
                            <select class="form-control" name="hasWifi" id="wifi">
                                <option value="1">Da</option>
                                <option value="0">Ne</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="parking">Ima parking</label>
                            <select class="form-control" name="hasParking" id="parking">
                                <option value="1">Da</option>
                                <option value="0">Ne</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="smoking">Dozvoljeno pusenje</label>
                            <select class="form-control" name="smokingAllowed" id="smoking">
                                <option value="1">Da</option>
                                <option value="0">Ne</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <label for="roomNum">Broj soba</label>
                        <input type="number" class="form-control" name="roomNum">
                    </div>
                    <div class="col-md-4">
                        <label for="personNum">Broj osoba</label>
                        <input type="number" class="form-control" name="personNum">
                    </div>
                    <div class="col-md-4">
                        <label for="price">Cena</label>
                        <input type="number" class="form-control" name="price">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-9">
                        <label for="description">Opis</label>
                        <textarea class="form-control" name="description" id="description"></textarea>
                    </div>
                    <div class="col-md-3">
                        <label for="img">Slike</label><br>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" multiple class="custom-file-input" id="inputGroupFile01" name="images[]" aria-describedby="inputGroupFileAddon01">
                                <label class="custom-file-label" for="inputGroupFile01">Odaberite fajl</label>
                            </div>
                        </div>
                        <small class="text-muted mb-5">Za vise slika prevucite misem preko njih</small>
                    </div>
                </div>
                <input type="hidden" name="create_appartment">
                <button class="btn btn-primary" type="submit">Kreiraj apartman</button>
            </form>
        <?php else : ?>
            <div class="row">
                <div class="col-md-6">
                    <?php foreach ($results as $appartment) : ?>
                        <div class="card my-4">
                            <div class="card-header d-flex w-100 justify-content-between align-items-center">
                                <div>
                                    <?php echo $appartment["name"]; ?>
                                </div>
                                <div>
                                    <form method="POST" action="server.php">
                                        <input type="hidden" name="appartment_id" value="<?php echo $appartment["id"]; ?>">
                                        <input type="hidden" name="delete_appartment" value="<?php echo $appartment["id"]; ?>">

                                        <button class="btn btn-danger m-2">Ukloni</button>
                                    </form>
                                    <button class="btn btn-warning m-2" onclick = "location.href = 'editapt.php?id=<?php echo $appartment["id"];?>'">Izmeni</button>

                                </div>
                            </div>
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
                                        <div>
                                            Cena: <strong><?php echo $appartment["price"]; ?>.00 din</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body mt-0 pt-0">
                                Opis: <?php echo $appartment["description"]; ?>
                            </div>
                        </div>
                    <?php endforeach ?>

                </div>

                <div class="col-md-6">
                    <form method="POST" action="server.php" enctype="multipart/form-data">
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Naziv</label>
                                    <input type="text" class="form-control" id="name" name="name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="location">Lokacija</label>
                                    <input type="text" class="form-control" id="location" name="location">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="wifi">Ima wifi</label>
                                    <select class="form-control" name="hasWifi" id="wifi">
                                        <option value="1">Da</option>
                                        <option value="0">Ne</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="parking">Ima parking</label>
                                    <select class="form-control" name="hasParking" id="parking">
                                        <option value="1">Da</option>
                                        <option value="0">Ne</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="smoking">Dozvoljeno pusenje</label>
                                    <select class="form-control" name="smokingAllowed" id="smoking">
                                        <option value="1">Da</option>
                                        <option value="0">Ne</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <label for="roomNum">Broj soba</label>
                                <input type="number" class="form-control" name="roomNum">
                            </div>
                            <div class="col-md-4">
                                <label for="personNum">Broj osoba</label>
                                <input type="number" class="form-control" name="personNum">
                            </div>
                            <div class="col-md-4">
                                <label for="price">Cena</label>
                                <input type="number" class="form-control" name="price">
                            </div>
                        </div>
                        <div>
                            <label for="description">Opis</label>
                            <textarea class="form-control" name="description" id="description"></textarea>
                        </div>
                        <div>
                            <label for="img">Slike</label><br>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" multiple class="custom-file-input" id="inputGroupFile01" name="images[]" aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label" for="inputGroupFile01">Odaberite fajl</label>
                                </div>
                            </div>
                            <small class="text-muted mb-5">Za vise slika prevucite misem preko njih</small>
                        </div>
                        <input type="hidden" name="create_appartment">
                        <button class="btn mt-3 btn-primary" type="submit">Kreiraj apartman</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>

    </div>

</body>

</html>