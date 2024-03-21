<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL ^ E_NOTICE);
$direktorij = dirname(getcwd());
$putanja = dirname(dirname($_SERVER['REQUEST_URI']));

include "../zaglavlje.php";
include_once '../funkcije.php';

if(isset($_GET['aktiviran']) && $_GET['aktiviran'] == 'ne'){
    $poruka = "Vaš kod za registraciju je istekao. Morate se ponovo registrirati!";
}

$veza = new Baza();
$veza->spojiDB();

$ime = $_GET['ime'];
$prezime = $_GET['prezime'];
$datumRodenja = $_GET['godRod'];
$email = $_GET['email'];
$korisnickoIme = $_GET['korIme'];
$lozinka = $_GET['lozinka'];
$potvrdaLozinke = $_GET['potvrdaLozinke'];

//$_GET['g-recaptcha-response'] != ""

if (isset($_GET['registriraj'])) {
    $secret = '6LfnM38gAAAAAMCKHj-2NKw72qB1sXdWSAHtkzCA';
    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_GET['g-recaptcha-response']);
    $responseData = json_decode($verifyResponse);
    if ($responseData->success) {
        $potvrdenaCaptcha = true;
    }else{
        $potvrdenaCaptcha = false;
        $poruka .= "Niste označili Captcha provjeru!<br><br>";
    }
}

$korisnikMaloljetan = false;
if (isset($datumRodenja)) {
    $datumSplitano = explode("-", $datumRodenja);
    $g = $datumSplitano[0];

    if ((date("Y") - $g) < 18) {
        $poruka .= "Ne možete se registrirati na stranicu jer nemate 18 godina!<br>";
        $korisnikMaloljetan = true;
    }
}

$imeIspravno = false;
if (isset($ime)) {
    $prvoSlovo = $ime[0];
    if (strtoupper($prvoSlovo) === $prvoSlovo) {
        $imeIspravno = true;
    }
    if ($imeIspravno == false) {
        $poruka .= "Ime mora započeti velikim početnim slovom!<br>";
    }
}

$prezimeIspravno = false;
if (isset($prezime)) {
    $prvoSlovo2 = $prezime[0];
    if (strtoupper($prvoSlovo2) === $prvoSlovo2) {
        $prezimeIspravno = true;
    }
    if ($prezimeIspravno == false) {
        $poruka .= "Prezime mora započeti velikim početnim slovom!<br>";
    }
}

$korimeIspravno = false;
if (isset($korisnickoIme)) {
    if (strlen($korisnickoIme) >= 5 && strlen($korisnickoIme) <= 25) {
        $korimeIspravno = true;
    }
    if ($korimeIspravno == false) {
        $poruka .= "Korisničko ime mora imati najmanje 5, a najviše 25 znakova!<br>";
    }
}

$emailIspravan = false;
if (isset($email)) {
    $index1 = strpos($email, '@');
    $index2 = strrpos($email, '.');
    if ($index1 > 0 && $index2 > 0 && $index2 > $index1) {
        $emailIspravan = true;
    }
    if ($emailIspravan == false) {
        $poruka .= "Email je neispravan. Mora sadržavati znak '@' i znak '.' te tekst prije i poslije tih znakova!<br>";
    }
}

$lozinkaIspravna = false;
if (isset($lozinka)) {
    if (strlen($lozinka) >= 8 && strlen($lozinka) < 45) {
        $lozinkaIspravna = true;
    }
    if ($lozinkaIspravna == false) {
        $poruka .= "Lozinka je krivog formata! Mora sadržavati više od 8, a manje od 45 znakova!<br>";
    }
}

$usporedbaLozinkiIspravna = false;
if (isset($potvrdaLozinke)) {
    if ($potvrdaLozinke === $lozinka) {
        $usporedbaLozinkiIspravna = true;
    }
    if ($usporedbaLozinkiIspravna == false) {
        $poruka .= "Orginalna i ponovljena lozinka se ne poklapaju. Unesite ih ponovo!<br>";
    }
}

if ($potvrdenaCaptcha === true && $korisnikMaloljetan === false && $imeIspravno === true && $prezimeIspravno === true && $korimeIspravno === true && $emailIspravan === true && $lozinkaIspravna === true && $usporedbaLozinkiIspravna === true) {

    $lozinkaSHA256 = hash("SHA256", $lozinka);
    $uloga = 2;
    $datumRegistracije = date("Y-m-d H:i:s");
    
    $kod = GenerirajAktivacijskiKod();

    $upitZaUnosKorisnika = "INSERT INTO `Korisnik` (`id`, `tip_korisnika_id`, `ime`, `prezime`, `korisnicko_ime`, `datum_rodenja`, `lozinka`,"
            . " `lozinka_sha256`, `datum_registracije`, `email`, `uvjeti_koristenja`, `broj_neuspjesnih_prijava`, `blokiran`, `aktiviran`, `aktivacijski_kod`)"
            . " VALUES (NULL, '$uloga', '$ime', '$prezime', '$korisnickoIme', '$datumRodenja', '$lozinka', '$lozinkaSHA256', '$datumRegistracije', '$email', NULL, NULL, '0', '0', '$kod')";

    $rezultatUpitaZaUnosKorisnika = $veza->selectDB($upitZaUnosKorisnika);
    $veza->zatvoriDB();
    
    
    $putanja = "https://barka.foi.hr/WebDiP/2021_projekti/WebDiP2021x088/obrasci/aktivacija.php?email=$email";
    
    $porukaMejl = "Pritiskom na link ispod i unosom koda koji Vam je poslan u ovome mejlu mozete dovrsiti aktivaciju Vasega racuna.\n\nLink: " . $putanja . "\nAktivacijski kod: " . $kod;
    
    mail($email, "Aktivacija korisnickog racuna", $porukaMejl);
    
    header("Location: aktivacija.php?email=$email"); 
}
?>
<!DOCTYPE html>
<html lang="hr">
    <head>
        <title>Registracija</title>
        <meta charset="utf-8">
        <meta name="author" content="Patricio Poldrugac">
        <meta name="description" content="14.3.2022.">
        <link href="../css/ppoldruga.css" rel="stylesheet" type="text/css">
        <script src="../javascript/ppoldruga.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="../javascript/ppoldruga_jquery.js"></script>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    </head>
    <body id="vrh">
        <header>
            <h1 class="naslov">Registracija</h1>
            <a href="../index.php">
                <img src="../materijali/lutrijalogo.png" alt="Logo" class="logo"></a> 
        </header>
        <nav>
            <input id="menu__toggle" type="checkbox" />
            <label class="menu__gumb" for="menu__toggle">
                <span></span>
            </label>
            <ul class="menu__cijeli">
                <?php
                include '../meni.php';
                ?>
            </ul>
        </nav>
        <div id="greske">
            <?php
            if (isset($poruka)) {
                echo "<p style = 'border-color:#fff2e6; background-color: #fff2e6; padding: 10px; font-weight:bold; line-height: 1.6; color:#004654;'>$poruka</p>";
            }
            ?>
        </div>
        <div class="containerRege">
            <form id="formaRega" action="registracija.php" method="get">
                <label for="ime">Ime:</label>
                <input type="text" placeholder="Unesite ime" name="ime" id="ime" autofocus required="required"><br>
                <label for="prezime">Prezime:</label>
                <input type="text" placeholder="Unesite prezime" name="prezime" id="prezime" required="required"><br>
                <label for="godRod">Datum rođenja:</label>
                <input type="date" name="godRod" id="godRod" required><br><br>
                <label for="email">Email adresa:</label>
                <input type="text" placeholder="Unesite email" name="email" id="email" required="required"><br>
                <label for="korIme">Korisničko ime:</label>
                <input type="text" placeholder="Unesite korisničko ime" name="korIme" id="korIme" maxlength="25" size="25" required="required"><br>
                <label for="lozinka">Lozinka:</label>
                <input type="password" placeholder="Unesite lozinku" name="lozinka" id="lozinka" maxlength="50" size="50" required="required"><br>
                <label for="potvrdaLozinke">Potvrda lozinke:</label>
                <input type="password" placeholder="Potvrdite lozinku" name="potvrdaLozinke" id="potvrdaLozinke" maxlength="50" size="50" required="required"><br>
                <div style="position: relative; left: 150px; top: 20px;" class="g-recaptcha" data-sitekey="6LfnM38gAAAAAA1iId7OBiTDhDAtmHXu1Ca3gBQi"></div><br>
            </form>
            <button name="registriraj" id="btn2" type="submit" form="formaRega">Registriraj se</button>
        </div>                
        <footer class="podnozje" style="margin-bottom: -10px;">
            <a class="linkzafooter"
               href="http://validator.w3.org/check?uri=http://barka.foi.hr/WebDiP/2021/zadaca_01/ppoldruga/obrasci/egistracija.html"><img src="../materijali/HTML5.png" alt="html icon"></a>
            <a class="linkzafooter"
               href="https://jigsaw.w3.org/css-validator/validator?uri=http://barka.foi.hr/WebDiP/2021/zadaca_01/ppoldruga/css/ppoldruga.css"><img src="../materijali/CSS3.png" alt="css icon"></a>
            <address>Kontakt: 
                <a style="color: white;" href="mailto:ppoldruga@foi.hr">
                    <b>Patricio Poldrugač</b></a></address>
            <p>&copy; 2022 P.Poldrugač</p>
        </footer>
    </body>
</html>
