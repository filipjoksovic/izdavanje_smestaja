<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<?php if (isset($_SESSION['message'])) : ?>
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
        </button>
        <?php echo $_SESSION["message"];
        unset($_SESSION["message"]); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
        </button>
        <?php echo $_SESSION["error"];
        unset($_SESSION["error"]); ?>
    </div>
<?php endif; ?>
