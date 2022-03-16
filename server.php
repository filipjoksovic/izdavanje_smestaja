<?php 
    $database = mysqli_connect("localhost","root","","izdavanje_smestaja");
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }
    if(isset($_POST['register'])){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $role = $_POST["role"];
        if($username == "" || $email == "" || $password == "" || $first_name == "" || $last_name == "" || $role == ""){
            $_SESSION["error"] = "Morate uneti neke podatke kako biste mogli da se registrujete";
            header("location: register.php");
            return ;
        }
        $check_query = "SELECT * FROM users where username = '{$username}' OR email = '${email}'";
        if($database->query($check_query)->num_rows != 0){
            $_SESSION["error"] = "Vec postoji korisnik sa datim parametrima";
            header("location:register.php");
        }
        else{
            $query = "INSERT INTO users(username,email,first_name,last_name,role, password) VALUES ('$username','$email','$first_name','$last_name','$role', '$password')";
            if($database->query($query) === TRUE){
                $_SESSION["message"] = "Uspesno registrovan nalog. Dobrodosli, ". $username;
                $_SESSION['user']['username'] = $username;
                $_SESSION["user"]["role"] = $role; 
                $_SESSION["user"]["id"] = $database->insert_id;
                if($role == "user"){
                    header("location: home.php");
                }
                else{
                    header("location:appartments.php");
                }
                return;
            }
            else{
                $_SESSION["error"] = "Doslo je do greske prilikom kreiranja vaseg naloga";
                header("location: register.php");
                return;
            }
        }

    }
    if(isset($_POST['login'])){
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        if ($username == "" || $password == "") {
            $_SESSION["error"] = "Morate uneti neke podatke kako biste mogli da prijavite";
            header("location: login.php");
            return;
        }
        $check_query = "SELECT * FROM users where (username = '{$username}' OR email = '${username}') AND password = '{$password}' LIMIT 1";
        $user = $database->query($check_query)->fetch_assoc();
        if(!$user){
            $_SESSION["error"] = "Uneti podaci nisu ispravni. Proverite unete podatke i pokusajte ponovo";
            header("location: login.php");
            return;
        }        
        $_SESSION["message"] = "Uspesno logovanje na nalog. Dobrodosli, " . $username;
        $_SESSION['user']['username'] = $username;
        $_SESSION["user"]["role"] = $user["role"];
        $_SESSION["user"]["id"] = $user["id"];
        if ($user["role"] == "user") {
            header("location: home.php");
        } elseif ($user["role"] == "seller"){
            header("location:appartments.php");
        }
        else{
            header("location:admin.php");
        }
    }
    if(isset($_POST['create_appartment'])){
        $name = $_POST['name'];
        $location = $_POST['location'];
        $hasWifi = $_POST['hasWifi'];
        $hasParking = $_POST['hasParking'];
        $smokingAllowed = $_POST['smokingAllowed'];
        $room_number = $_POST['roomNum'];
        $person_number = $_POST["personNum"];
        $description = $_POST['description'];
        $user_id = $_SESSION['user']['id'];
        $price = $_POST['price'];
        if($_SESSION['user']['role'] != 'seller'){
            $_SESSION['error'] = "Nemate prava pristupa ovom delu sajta";
            header("location: home.php");
            return;
        }
        $query = "INSERT INTO appartments(user_id,name,location,number_of_rooms,max_customers,has_parking,has_wifi,smoking_allowed,description, price) VALUES ($user_id,'$name','$location',$room_number,$person_number,$hasParking, $hasWifi,$smokingAllowed,'$description', $price)";
        if($database->query($query) === TRUE){
            $insert_id = $database->insert_id;
            $countfiles = count($_FILES['images']['name']);
            for ($i = 0; $i < $countfiles; $i++) {
                $filename = $_FILES['images']['name'][$i];
                $query = "INSERT INTO appartment_images(appartment_id,path) VALUES ($insert_id,'upload/{$filename}')";
                if($database->query($query) === FALSE){
                    $_SESSION["error"] = "Doslo je do greske prilikom cuvanja slike aranzmana. Tekst greske: ". $database->error;
                }
                else{
                    move_uploaded_file($_FILES['images']['tmp_name'][$i], 'upload/' . $filename);
                }
            }
            $_SESSION["message"] = "Uspesno kreiran novi apartman";
        }
        else{
            $databsae->error = "Doslo je do greske prilikom kreiranja smestaja. Tekst greske: ". $database->error;
        }
        header("location: appartments.php");
    }
    if (isset($_POST['edit_appartment'])) {
        $name = $_POST['name'];
        $location = $_POST['location'];
        $hasWifi = $_POST['hasWifi'];
        $hasParking = $_POST['hasParking'];
        $smokingAllowed = $_POST['smokingAllowed'];
        $room_number = $_POST['roomNum'];
        $person_number = $_POST["personNum"];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $appartment_id = $_POST["id"];
        if ($_SESSION['user']['role'] != 'seller') {
            $_SESSION['error'] = "Nemate prava pristupa ovom delu sajta";
            header("location: home.php");
            return;
        }
        $query = "UPDATE appartments SET name = '$name',location = '$location',number_of_rooms = $room_number,max_customers = $person_number,has_parking = $hasParking,has_wifi = $hasWifi,smoking_allowed = $smokingAllowed, description = '$description', price = $price WHERE id = $appartment_id";
        if ($database->query($query) === TRUE) {
        
            $_SESSION["message"] = "Uspesno izmenjen apartman";
        } else {
            $databsae->error = "Doslo je do greske prilikom izmene smestaja. Tekst greske: " . $database->error;
        }
        header("location: appartments.php");
    }
    if(isset($_POST['delete_appartment'])){
        $ap_id = $_POST['appartment_id'];
        $uid = $_SESSION["user"]["id"];
        $query = "SELECT * FROM appartments WHERE id = $ap_id";
        $result = $database->query($query)->fetch_assoc();
        if($result["user_id"] != $uid){
            $_SESSION['error'] = "Nemate pravo pristupa ovom delu sajta";
            header("location:index.php");
        }
        else{
            $query = "DELETE FROM appartments WHERE id = $ap_id";
            if($database->query($query) === TRUE){
                $_SESSION["message"] = "Uspesno uklonjen apartman iz ponude";
            }
            else{
                $_SESSION["error"] = "Greska prilikom uklanjanja apartmana iz ponude";
            }
            header("location: appartments.php");
        }
    }
    if(isset($_POST['edit_user'])){
        $user_id = $_POST['user_id'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        if(isset($_SESSION["user"]["role"]) && $_SESSION["user"]["role"] === "admin"){
            $query = "SELECT * FROM users WHERE id != $user_id AND email = '{$email}'";
            if($database->query($query)->fetch_assoc() === null){
                $query = "UPDATE users SET first_name = '{$first_name}', last_name = '{$last_name}', email = '{$email}' WHERE id = $user_id";
                if($database->query($query) === TRUE){
                    $_SESSION["message"] = "Korisnik je uspesno izmenjen";
                    header("location:admin.php");
                }
            }
            else{
                $_SESSION["error"] = "Korisnik sa ovim podacima vec postoji";
                header("location:admin.php"); 
            }
        }
        else{
            $_SESSION["error"] = "Nemate dozvolu pristupa ovom sajtu";
            header("location: index.php");
        }
    }
    if(isset($_POST['delete_user'])){
        $user_id = $_POST['user_id'];
        if(isset($_SESSION["user"]["role"]) && $_SESSION["user"]["role"] == "admin"){
            $query = "DELETE FROM users WHERE id = {$user_id}";
            if($database->query($query) === TRUE){
                $_SESSION["message"] = "Korisnik je uspesno obrisan";
                header("location:admin.php");
            }
        }
        else{
            $_SESSION["error"] = "Nemate dozvolu pristupa ovom sajtu";
            header("location:home.php");
        }
    }
    if(isset($_POST["create_reservation"])){
        $user_id = $_SESSION["user"]["id"];
        $appartment_id = $_POST["appartment_id"];
        $date_start = $_POST["date_start"];
        $date_end = $_POST["date_end"];
        $payment = $_POST["payment"];
        $query = "SELECT * FROM reservations where date_start <= '{$date_start}' AND date_end >= '{$date_start}'";
        if($database->query($query)->fetch_assoc() == null){
            $query = "INSERT INTO reservations (user_id, appartment_id, date_start, date_end, payment) VALUES($user_id, $appartment_id, '{$date_start}', '{$date_end}',$payment)";
            if($database->query($query) === TRUE){
                $_SESSION["message"] = "Uspesno rezervisan apartman";
                header("location:home.php");
            }
            else{
                $_SESSION["error"] = "Doslo je do greske prilikom kreiranja rezervacije. Tekst greske: {$database->error}";
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
        }
        else{
            $_SESSION["error"] = "Postoji vec rezervacija ovog apartmana u ovom vremenskom intervalu";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
    if(isset($_POST["cancel_reservation"])){
        if(!isset($_SESSION["user"]["username"])){
            $_SESSION['error'] = "Morate biti ulogovani kako biste mogli da uklonite rezervaciju";
            header("location:home.php");
        }
        else{
            $reservation_id = $_POST['reservation_id'];
            $query = "SELECT * FROM reservations WHERE id = $reservation_id";
            $result = $database->query($query)->fetch_assoc();
            if($_SESSION["user"]["id"] != $result["user_id"] && $_SESSION["user"]["role"] != "seller"){
                $_SESSION["error"] = "Morate biti vlasnik ove rezervacije ili prodavac kako biste mogli da otkazete ovu rezervaciju";
            }
            else{
                $query = "DELETE FROM reservations WHERE id = $reservation_id";
                if($database->query($query) === TRUE){
                    $_SESSION["message"] = "Uspesno uklonjena rezervacija";
                }
                else{
                    $_SESSION["error"] = "Doslo je do greske prilikom uklanjanja rezervacije. Tekst greske {$database->error}";
                }
                if($_SESSION["user"]["role"] == 'user'){
                    header("location:home.php");
                }
                else{
                    header("location: reservations.php");
                }
            }
        }
    }
    if(isset($_POST["submit_review"])){
        $appartment_id = $_POST["appartment_id"];
        $rate = $_POST["rate"];
        $comment = $_POST['review'];
        $query = "INSERT INTO reviews(appartment_id,user_id, rate, review) VALUES($appartment_id, {$_SESSION["user"]["id"]},$rate, '$comment' )";
        if($database->query($query) === TRUE){
            $_SESSION["message"] = "Uspesno ocenjen apartman";
        }
        else{
            $_SESSION["message"] = "Greska prilikom ocenjivanja aranzmana. Tekst greske: {$database->error}." . "\n" . "Upit = {$query}";
        }
        header("location:home.php");
    }
    if(isset($_POST['update_review'])){
        $appartment_id = $_POST["appartment_id"];
        $rate = $_POST["rate"];
        $comment = $_POST['review'];
        $query = "UPDATE reviews SET appartment_id = $appartment_id,rate = $rate, review = '{$comment}' WHERE appartment_id = $appartment_id AND user_id = {$_SESSION["user"]["id"]}";
        if ($database->query($query) === TRUE) {
            $_SESSION["message"] = "Uspesno izmenjena ocena";
        } else {
            $_SESSION["message"] = "Greska prilikom izmene ocene aranzmana. Tekst greske: {$database->error}." . "\n" . "Upit = {$query}";
        }
        header("location:home.php");
    }
?>