<?php require("seller_mw.php");?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Izmeni apartman</title>
    <?php require("./comp/bootstrap.php"); ?>
</head>

<body>
    <?php require("./comp/nav.php"); ?>

    <?php $query = "SELECT * FROM appartments where id = {$_GET["id"]}";
    $appartment = $database->query($query)->fetch_assoc();
    ?>
    <div class="container">
        <form method="POST" action="server.php">
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Naziv</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $appartment['name']; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="location">Lokacija</label>
                        <input type="text" class="form-control" id="location" name="location" value="<?php echo $appartment['location']; ?>">
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="wifi">Ima wifi</label>
                        <select class="form-control" name="hasWifi" id="wifi">
                            <option value="1" <?php if ($appartment["has_wifi"] == 1) echo "selected"; ?>>Da</option>
                            <option value="0" <?php if ($appartment["has_wifi"] == 0) echo "selected"; ?>>Ne</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="parking">Ima parking</label>
                        <select class="form-control" name="hasParking" id="parking">
                            <option value="1" <?php if ($appartment["has_parking"] == 1) echo "selected"; ?>>Da</option>
                            <option value="0" <?php if ($appartment["has_parking"] == 0) echo "selected"; ?>>Ne</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="smoking">Dozvoljeno pusenje</label>
                        <select class="form-control" name="smokingAllowed" id="smoking">
                            <option value="1" <?php if ($appartment["smoking_allowed"] == 1) echo "selected"; ?>>Da</option>
                            <option value="0" <?php if ($appartment["smoking_allowed"] == 0) echo "selected"; ?>>Ne</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-4">
                    <label for="roomNum">Broj soba</label>
                    <input type="number" class="form-control" name="roomNum" value="<?php echo $appartment['number_of_rooms']; ?>">
                </div>
                <div class=" col-md-4">
                    <label for="personNum">Broj osoba</label>
                    <input type="number" class="form-control" name="personNum" value="<?php echo $appartment['max_customers']; ?>">
                </div>
                <div class="col-md-4">
                    <label for="price">Cena</label>
                    <input type="number" class="form-control" name="price" value="<?php echo $appartment['price']; ?>">
                </div>
            </div>
            <div>
                <label for="description">Opis</label>
                <textarea class="form-control" name="description" id="description"><?php echo $appartment['description']; ?></textarea>
            </div>
            <input type="hidden" name="id" value = "<?php echo $appartment['id'];?>">

            <input type="hidden" name="edit_appartment">
            <button class="btn mt-3 btn-warning w-50 mx-auto btn-block" type="submit">Izmeni apartman</button>

        </form>

    </div>
</body>

</html>