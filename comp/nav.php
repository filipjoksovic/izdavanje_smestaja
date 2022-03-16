<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$database = mysqli_connect("localhost", "root", "", "izdavanje_smestaja");
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="home.php">Izdavanje smestaja</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav w-100 justify-content-between">
            <div class="d-flex">
                <li class="nav-item active">
                    <a class="nav-link" href="home.php">Pocetna <span class="sr-only">(current)</span></a>
                </li>
                <?php if ($_SESSION["user"]["role"] == "user") : ?>
                    <li class="nav-item ">
                        <a class="nav-link" href="account.php">Nalog</a>
                    </li>
                <?php endif; ?>
                <?php if ($_SESSION["user"]["role"] == "seller") : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="appartments.php">Dodavanje smestaja</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="reservations.php">Rezervacije</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="reviews.php">Ocene</a>
                    </li>
                <?php endif; ?>
            </div>

            <div class='d-flex'>
                <?php if ($_SESSION["user"]["username"] == null) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Ulogujte se</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Registrujte se</a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php"><?php echo $_SESSION["user"]["username"]; ?> - Odjavi se</a>
                    </li>

                <?php endif; ?>
            </div>
        </ul>
    </div>
</nav>

<?php include("messagerender.php"); ?>