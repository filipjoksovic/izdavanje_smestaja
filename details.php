<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalji o aranzmanu</title>
    <?php require("comp/bootstrap.php"); ?>
</head>

<body>
    <?php require("comp/nav.php"); ?>
    <?php
    $appartment_id = $_GET["id"];
    $query = "SELECT * FROM appartments";
    $appartment = $database->query($query)->fetch_assoc();
    $image_query = "SELECT path from appartment_images WHERE appartment_id = $appartment_id";
    $image_results  = $database->query($image_query)->fetch_all(MYSQLI_ASSOC);
    ?>

    <div class="container mt-5">
        <h3>Detalji o apartmanu</h3>
        <div class="row">
            <div class="col-md-3 mt-5">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="<?php echo $image_results[0]["path"]; ?>" class="d-block w-100 carousel-image" alt="...">
                        </div>
                        <?php for ($i = 1; $i < count($image_results); $i++) : ?>
                            <div class="carousel-item">
                                <img src="<?php echo $image_results[$i]['path']; ?>" class="d-block w-100 carousel-image" alt="...">
                            </div>
                        <?php endfor; ?>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <h3><?php echo $appartment["name"]; ?></h4>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <?php echo $appartment["location"]; ?><br><br>
                                Broj soba: <?php echo $appartment["number_of_rooms"]; ?><br><br>
                                Broj posetilaca: <?php echo $appartment["max_customers"]; ?><br><br>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="inlineCheckbox1">Parking</label>
                                    <input disabled class="ml-2 form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" <?php if ($appartment["has_parking"] == 1) echo "checked"; ?>><br><br>
                                </div><br>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="inlineCheckbox1">Wifi </label>
                                    <input disabled class="form-check-input ml-2 " type="checkbox" id="inlineCheckbox1" value="option1" <?php if ($appartment["has_wifi"] == 1) echo "checked"; ?>><br><br>
                                </div><br>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="inlineCheckbox1">Dozvoljeno pusenje </label>
                                    <input disabled class="form-check-input ml-2 " type="checkbox" id="inlineCheckbox1" value="option1" <?php if ($appartment["smoking_allowed"] == 1) echo "checked"; ?>><br><br>
                                </div><br>
                            </div>
                        </div>
                        Opis: <?php echo $appartment["description"]; ?>
                        Cena: <strong><?php echo $appartment["price"]; ?>.00 din</strong>
                    </div>
            </div>
            <div class="col-md-3">
                <h4 class="text-center">Rezervisi </h6>
                    <?php if (isset($_SESSION["user"]["username"])) : ?>
                        <form action="server.php" method="POST">
                            <div class="form-group">
                                <label for="date_start">Datum pocetka</label>
                                <input class="form-control" type="date" name="date_start">
                            </div>
                            <div class="form-group">
                                <label for="date_start">Datum kraja</label>
                                <input class="form-control" type="date" name="date_end">
                            </div>
                            <div class="form-group">
                                <label for="date_start">Placanje</label>

                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="payment" id="cash" value="0" checked>
                                        Kes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="card" id="card" value="1">
                                        Kartica
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="create_reservation" value="1">
                            <input type="hidden" name="appartment_id" value="<?php echo $appartment['id']; ?>">
                            <input type="submit" class="btn btn-primary btn-block" value="Rezervisi - <?php echo $appartment["price"]; ?>.00 din">
                        </form>
                    <?php else : ?>
                        <h6 class="text-center">Morate biti ulogovani kako biste mogli da rezervisete smestaj</h6>
                    <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-3">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Opis</a>
                    <a class="nav-link" id="v-pi lls-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Ocene</a>
                    <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Licna ocena</a>
                </div>
            </div>
            <div class="col-9">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                        <?php echo $appartment["description"]; ?>
                    </div>
                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                        <h6>Ocene korisnika</h6>
                        <?php
                        $query = "SELECT users.*,reviews.* FROM reviews INNER JOIN users on users.id = reviews.user_id WHERE appartment_id = {$_GET["id"]}";
                        $results = ($database->query($query) != false) ? $database->query($query)->fetch_all(MYSQLI_ASSOC) : [];
                        ?>
                        <?php foreach ($results as $review) : ?>
                            <div class="card">
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
                        <?php endforeach; ?>

                    </div>
                    <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                        <?php if (!isset($_SESSION['user']['username'])) : ?>
                            <h6 class="text-center my-auto">Trenutno niste prijavljeni na nalog. Morate biti prijavljeni
                                kako biste mogli da ostavite ocenu.</h6>
                        <?php else : ?>
                            <?php
                            $query = "SELECT * FROM reservations WHERE user_id = {$_SESSION["user"]["id"]} AND appartment_id = {$_GET["id"]}";
                            $result = ($database->query($query) != false) ? $database->query($query)->fetch_assoc() : null;
                            ?>
                            <?php if ($result != null) : ?>
                                <?php if ($result["date_end"] < date("Y-m-d")) : ?>
                                    <?php
                                    $reviewed = false;
                                    $query = "SELECT * FROM reviews where user_id = {$_SESSION["user"]["id"]} AND appartment_id = {$_GET["id"]}";
                                    $review = ($database->query($query)) ? $database->query($query)->fetch_assoc() : null;
                                    ?>

                                    <?php if ($review == null) : ?>
                                        <h5 class="my-3">Ocenite aranzman</h5>
                                        <form action="server.php" method="post">
                                            <div class="form-group d-flex w-100 justify-content-around">
                                                <div class="form-check  form-check-inline">
                                                    <input class="form-check-input" type="radio" name="rate" id="exampleRadios1" value="1">
                                                    <label class="form-check-label" for="exampleRadios1">
                                                        1
                                                    </label>
                                                </div>
                                                <div class="form-check  form-check-inline">
                                                    <input class="form-check-input" type="radio" name="rate" id="exampleRadios2" value="2">
                                                    <label class="form-check-label" for="exampleRadios2">
                                                        2
                                                    </label>
                                                </div>
                                                <div class="form-check  form-check-inline">
                                                    <input class="form-check-input" type="radio" name="rate" id="exampleRadios3" value="3">
                                                    <label class="form-check-label" for="exampleRadios3">
                                                        3
                                                    </label>
                                                </div>
                                                <div class="form-check  form-check-inline">
                                                    <input class="form-check-input" type="radio" name="rate" id="exampleRadios4" value="4">
                                                    <label class="form-check-label" for="exampleRadios4">
                                                        4
                                                    </label>
                                                </div>
                                                <div class="form-check  form-check-inline">
                                                    <input class="form-check-input" type="radio" name="rate" id="exampleRadios5" value="5">
                                                    <label class="form-check-label" for="exampleRadios5">
                                                        5
                                                    </label>
                                                </div>

                                            </div>
                                            <div class="form-group">
                                                <label for="review">Komentar</label>
                                                <textarea name="review" class="form-control" name="review"></textarea>
                                            </div>
                                            <input type="hidden" name="submit_review" value="1">
                                            <input type="hidden" name="appartment_id" value="<?php echo $appartment["id"] ?>">
                                            <input type="submit" value="Oceni" class="btn btn-success btn-block w-50 mx-auto">
                                        </form>
                                    <?php else : ?>
                                        <h5 class="my-3">Izmenite ocenu</h5>
                                        <form action="server.php" method="post">
                                            <div class="form-group d-flex w-100 justify-content-around">
                                                <div class="form-check  form-check-inline">
                                                    <input class="form-check-input" type="radio" name="rate" id="exampleRadios1" value="1" <?php if ($review["rate"] == 1) : ?>checked<?php endif; ?>>
                                                    <label class="form-check-label" for="exampleRadios1">
                                                        1
                                                    </label>
                                                </div>
                                                <div class="form-check  form-check-inline">
                                                    <input class="form-check-input" type="radio" name="rate" id="exampleRadios2" value="2" <?php if ($review["rate"] == 2) : ?>checked<?php endif; ?>>
                                                    <label class="form-check-label" for="exampleRadios2">
                                                        2
                                                    </label>
                                                </div>
                                                <div class="form-check  form-check-inline">
                                                    <input class="form-check-input" type="radio" name="rate" id="exampleRadios3" value="3" <?php if ($review["rate"] == 3) : ?>checked<?php endif; ?>>
                                                    <label class="form-check-label" for="exampleRadios3">
                                                        3
                                                    </label>
                                                </div>
                                                <div class="form-check  form-check-inline">
                                                    <input class="form-check-input" type="radio" name="rate" id="exampleRadios4" value="4" <?php if ($review["rate"] == 4) : ?>checked<?php endif; ?>>
                                                    <label class="form-check-label" for="exampleRadios4">
                                                        4
                                                    </label>
                                                </div>
                                                <div class="form-check  form-check-inline">
                                                    <input class="form-check-input" type="radio" name="rate" id="exampleRadios5" value="5" <?php if ($review["rate"] == 5) : ?>checked<?php endif; ?>>
                                                    <label class="form-check-label" for="exampleRadios5">
                                                        5
                                                    </label>
                                                </div>

                                            </div>
                                            <div class="form-group">
                                                <label for="review">Komentar</label>
                                                <textarea name="review" class="form-control" name="review"><?php echo $review["review"]; ?></textarea>
                                            </div>
                                            <input type="hidden" name="update_review" value="1">
                                            <input type="hidden" name="appartment_id" value="<?php echo $appartment["id"] ?>">
                                            <input type="submit" value="Izmeni" class="btn btn-warning btn-block w-50 mx-auto">
                                        </form>
                                    <?php endif; ?>
                                <?php else : ?>
                                    Ne mozete ostaviti ocenu
                                <?php endif; ?>
                            <?php else : ?>
                                Nemate rezervaciju
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>

</html>