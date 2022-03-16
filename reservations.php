<?php require("seller_mw.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pregled rezervacija</title>
    <?php include("./comp/bootstrap.php"); ?>
</head>

<body>
    <?php include("./comp/nav.php"); ?>

    <?php
    $query = "SELECT reservations.id as 'reservation_id',reservations.*, users.*, appartments.* FROM reservations INNER JOIN appartments on appartments.id = reservations.appartment_id INNER JOIN users on users.id = reservations.user_id where appartments.user_id = {$_SESSION["user"]["id"]}";
    $reservations = ($database->query($query) != false) ? $database->query($query)->fetch_all(MYSQLI_ASSOC) : [];
    ?>
    <div class="container mt-5">
        <?php if (count($reservations) == 0) : ?>
            <h3 class="text-center">Nemate ni jednu rezervaciju za Vase apartmane</h3>
        <?php else : ?>
            <?php foreach ($reservations as $reservation) : ?>
                <div class="card">
                    <div class="card-header w-100 d-flex justify-content-between align-items-center">
                        <div>
                            <?php echo $reservation["name"]; ?>
                        </div>
                        <div>
                            <form action='server.php' method="POST">
                                <input type="hidden" name="cancel_reservation" value='1'>
                                <input type="hidden" name="reservation_id" value="<?php echo $reservation["reservation_id"]; ?>">
                                <button class="btn btn-danger">Otkazi rezervaciju</button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 text-center">
                                Korisnicko ime: <?php echo $reservation["username"]; ?><br>
                                Ime i prezime: <?php echo $reservation["first_name"] . " " . $reservation["last_name"]; ?> <br>
                            </div>
                            <div class="col-md-6 text-center">
                                Datum dolaska: <?php echo $reservation["date_start"]; ?><br>
                                Datum odlaska: <?php echo $reservation["date_end"]; ?><br>
                                <strong>Placanje: <?php echo ($reservation["payment"] == 0) ? "Kes" : "Kartica"; ?></strong>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>
</body>

</html>