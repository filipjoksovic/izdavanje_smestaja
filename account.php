<?php require("user_mw.php");?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nalog</title>
    <?php include("./comp/bootstrap.php"); ?>
</head>

<body>
    <?php include("./comp/nav.php"); ?>
    <?php
    $query = "SELECT reservations.id as 'reservation_id',reservations.*, appartments.* FROM reservations INNER JOIN appartments on appartments.id = reservations.appartment_id where reservations.user_id = {$_SESSION["user"]["id"]}";
    $reservations = ($database->query($query) != false) ? $database->query($query)->fetch_all(MYSQLI_ASSOC) : [];
    ?>
    <div class="container mt-5">
        <h3>Pregled rezervacija</h3>
        <?php if (count($reservations) == 0) : ?>
            <h3 class="text-center mt-5">Nemate ni jednu rezervaciju za Vase apartmane</h3>
        <?php else : ?>
            <?php foreach ($reservations as $reservation) : ?>
                <div class="card my-3">
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

                        <div class="">
                            <h5>Datum dolaska: <?php echo $reservation["date_start"]; ?><br>
                                Datum odlaska: <?php echo $reservation["date_end"]; ?><br>
                                <strong>Placanje: <?php echo ($reservation["payment"] == 0) ? "Kes" : "Kartica"; ?></strong>
                            </h5>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>

</html>