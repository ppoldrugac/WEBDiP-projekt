<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL ^ E_NOTICE);

if (!isset($_SERVER['HTTPS'])) {
    $novaPutanja = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header("Location: " . $novaPutanja);
}

$direktorij = dirname(getcwd());
$putanja = dirname(dirname($_SERVER['REQUEST_URI']));

include_once '../zaglavlje.php';
include_once '../funkcije.php';

$greska = "";

$veza = new Baza();
$veza->spojiDB();

$upitKonfiguracija = "SELECT `broj_neuspjesnih_prijava`,`trajanje_kolacica`  FROM `Konfiguracija`";
$rezultatKonfiguracija = $veza->selectDB($upitKonfiguracija);
$sve = mysqli_fetch_array($rezultatKonfiguracija);
$dozvoljenBrojNeuspjeha = $sve[0];
$trajanjeKolacica = $sve[1];
$trenutnoVrijeme = date("Y-m-d H:i:s");
$doKadCeTrajatKolacic = strtotime($trenutnoVrijeme) + $trajanjeKolacica * 24 * 60 * 60;

if (isset($_GET['aktiviran']) && $_GET['aktiviran'] == 'da') {
    $poruka = "Uspješno ste se registrirali!";
}

if (isset($_GET['prijavaSe'])) {
    //var_dump($_GET);
    $uzorak = "/^\S+.*$/";
    foreach ($_GET as $k => $v) {
        if (!preg_match($uzorak, $v)) { // ili empty($v)
            $greska .= "Nije popunjeno: " . $k . "<br>";
        }
    }
    if (empty($greska)) {

        $korime = $_GET['korisnickoIme'];
        $lozinka = $_GET['lozinka'];
        $lozinkaHashirana = hash("sha256", $lozinka);

        $veza = new Baza();
        $veza->spojiDB();

        $upit = "SELECT * FROM `Korisnik` WHERE " . "`korisnicko_ime`='{$korime}'";

        $rezultat = $veza->selectDB($upit);

        $autenticiran = false;
        while ($red = mysqli_fetch_array($rezultat)) {
            if ($red) {
                $autenticiran = true;
                $tip = $red["tip_korisnika_id"];
                $email = $red["email"];
                $korisnikid = $red["id"];
                $lozinkaSHA = $red["lozinka_sha256"];
                $brojNeuspjeha = $red["broj_neuspjesnih_prijava"];
                $blokiran = $red["blokiran"];
                $aktiviran = $red["aktiviran"];
            }
        }

        $veza->zatvoriDB();

        if ($autenticiran == false) {
            $poruka = "Unijeli ste krivo korisničko ime. Pokušajte ponovo!";
        }
        if ($autenticiran && $blokiran == 1) {
            $poruka = "Ne možete se prijaviti jer ste blokirani. Zatražite administratora da vas odblokira.";
        }

        if ($autenticiran && $aktiviran == 0) {
            $poruka = "Ne možete se prijaviti jer još niste aktivirali korisnički račun. Na mejl Vam je poslan link i kod za aktivaciju računa.";
        }


        if ($autenticiran && $aktiviran != 0 && $blokiran != 1 && $brojNeuspjeha <= $dozvoljenBrojNeuspjeha) {
            if ($lozinkaHashirana != $lozinkaSHA) {
                $poruka = "Pogrešna lozinka! Pokušajte ponovo, imate još " . (2 - $brojNeuspjeha) . " pokušaja.";
                $brojNeuspjeha = $brojNeuspjeha + 1;
                $veza = new Baza();
                $veza->spojiDB();
                $upitZaPovecanje = "UPDATE `Korisnik` SET `broj_neuspjesnih_prijava`=" . $brojNeuspjeha . "  WHERE " . "`korisnicko_ime`='{$korime}'";
                $veza->updateDB($upitZaPovecanje);
                $veza->zatvoriDB();
            } else if ($lozinkaHashirana == $lozinkaSHA) {
                if (isset($_GET['zapamti'])) {
                    //$poruka = 'Uspješna prijava, zapamćeni ste!';
                    setcookie("autenticiran", $korime, $doKadCeTrajatKolacic, '/', false);
                    setcookie("kolacic_za_pamcenje_korisnika", $korime);
                    Sesija::kreirajKorisnika($korisnikid, $tip);
                    $brojNeuspjeha = 0;
                    $veza = new Baza();
                    $veza->spojiDB();
                    $upitZaPovecanje = "UPDATE `Korisnik` SET `broj_neuspjesnih_prijava`=" . $brojNeuspjeha . "  WHERE " . "`korisnicko_ime`='{$korime}'";
                    $veza->updateDB($upitZaPovecanje);
                    $veza->zatvoriDB();

                    $veza = new Baza();
                    $veza->spojiDB();
                    $datumvrijeme = date("Y-m-d H:i:s");

                    $upit = "INSERT INTO `Dnevnik_rada` (`id`, `tip_radnje_id`, `Korisnik_id`, `opis_radnje`, `vrijeme`, `upit`) VALUES (NULL, '1', '$korisnikid', 'Prijava korisnika u sustav.', '$datumvrijeme', NULL)";
                    $rezultat = $veza->selectDB($upit);
                    $veza->zatvoriDB();

                    header("Location: ../index.php");
                    exit();
                } else {
                    //$poruka = 'Uspješna prijava!';
                    setcookie("autenticiran", $korime, $doKadCeTrajatKolacic, '/', false);
                    if (isset($_COOKIE['kolacic_za_pamcenje_korisnika'])) {
                        //unset($_COOKIE['kolacic_za_pamcenje_prijave']);
                        setcookie("kolacic_za_pamcenje_korisnika", "", time() - 3600);
                    }
                    Sesija::kreirajKorisnika($korisnikid, $tip);
                    $brojNeuspjeha = 0;
                    $veza = new Baza();
                    $veza->spojiDB();
                    $upitZaPovecanje = "UPDATE `Korisnik` SET `broj_neuspjesnih_prijava`=" . $brojNeuspjeha . "  WHERE " . "`korisnicko_ime`='{$korime}'";
                    $veza->updateDB($upitZaPovecanje);
                    $veza->zatvoriDB();

                    $veza = new Baza();
                    $veza->spojiDB();
                    $datumvrijeme = date("Y-m-d H:i:s");

                    $upit = "INSERT INTO `Dnevnik_rada` (`id`, `tip_radnje_id`, `Korisnik_id`, `opis_radnje`, `vrijeme`, `upit`) VALUES (NULL, '1', '$korisnikid', 'Prijava korisnika u sustav.', '$datumvrijeme', NULL)";
                    $rezultat = $veza->selectDB($upit);
                    $veza->zatvoriDB();

                    header("Location: ../index.php");
                    exit();
                }
            }

            if ($brojNeuspjeha == $dozvoljenBrojNeuspjeha) {
                $poruka = "Upravo ste blokirani zbog previše puta promašene lozinke! Zatražite administratora da vas odblokira.";
                $veza = new Baza();
                $veza->spojiDB();
                $upitZaBlokiranjeKorisnika = "UPDATE `Korisnik` SET `blokiran`= 1  WHERE " . "`korisnicko_ime`='{$korime}'";
                $veza->updateDB($upitZaBlokiranjeKorisnika);
                $veza->zatvoriDB();

                $veza = new Baza();
                $veza->spojiDB();
                $datumvrijeme = date("Y-m-d H:i:s");

                $upit = "INSERT INTO `Dnevnik_rada` (`id`, `tip_radnje_id`, `Korisnik_id`, `opis_radnje`, `vrijeme`, `upit`) VALUES (NULL, '1', '$korisnikid', 'Prijava korisnika u sustav.', '$datumvrijeme', NULL)";
                $rezultat = $veza->selectDB($upit);
                $veza->zatvoriDB();

                header("Location: ../index.php");
                exit();
            }
        }
    }
}

if (isset($_GET["zaboravljenaLozinka"])) {
    if (isset($_GET["korisnickoIme"])) {
        $korime = $_GET["korisnickoIme"];
        $Lozinke = GenerirajLozinku();
        $novaLozinkaSHA = $Lozinke[1];
        $novaLozinka = $Lozinke[0];

        $veza = new Baza();
        $veza->spojiDB();
        $upitNovaLoz = "UPDATE `Korisnik` SET `lozinka`='$novaLozinka'  WHERE " . "`korisnicko_ime`='{$korime}'";
        $veza->updateDB($upitNovaLoz);
        $veza->zatvoriDB();

        $veza = new Baza();
        $veza->spojiDB();
        $upitNovaLozSHA = "UPDATE `Korisnik` SET `lozinka_sha256`='$novaLozinkaSHA'  WHERE " . "`korisnicko_ime`='{$korime}'";
        $veza->updateDB($upitNovaLozSHA);
        $veza->zatvoriDB();

        $porukaEmail = "Postovani,\r\n Vasa nova lozinka je: " . $novaLozinka;

        $veza = new Baza();
        $veza->spojiDB();
        $upitZaDohvatEmaila = "SELECT email FROM Korisnik WHERE `korisnicko_ime`='{$korime}'";
        $rezultatDohvataEmaila = $veza->selectDB($upitZaDohvatEmaila);
        $sve = mysqli_fetch_array($rezultatDohvataEmaila);
        $email2 = $sve[0];
        mail($email2, "Nova lozinka", $porukaEmail);
    }
}
?>
<!DOCTYPE html>
<html lang="hr">
    <head>
        <title>Prijava</title>
        <meta charset="utf-8">
        <meta name="author" content="Patricio Poldrugac">
        <meta name="description" content="14.3.2022.">
        <link href="../css/ppoldruga.css" rel="stylesheet" type="text/css">
        <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="../javascript/prijava.js"></script>-->
    </head>
    <body id="vrh">
        <header>
            <h1 class="naslov">Prijava</h1>
            <a href="index.php">
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
                <!--<li><a class="menu__tekst" href="../index.php">Početna stranica</a></li>
                <li><a class="menu__tekst" href="registracija.php">Registracija</a></li>
                <li><a class="menu__tekst" href="obrazac.php">Obrazac</a></li>
                <li><a class="menu__tekst" href="../multimedija.php">Multimedija</a></li>
                <li><a class="menu__tekst" href="../popis.php">Popis</a></li>-->
            </ul>
        </nav>
        <div id="greske">
                <?php
                if (isset($greska)) {
                    echo "<p>$greska</p>";
                } else {
                    echo "Nema greške";
                }
                if (isset($poruka)) {
                    echo "<p style = 'border-color:#fff2e6; background-color: #fff2e6; padding: 10px; font-weight:bold; line-height: 1.6; color:#004654;'>$poruka</p>";
                }
                ?>
        </div>
        <div class="containerPrijave">
            <form novalidate id="form1" method="get" name="form1" action="prijava.php">
                <label id="korime" for="korisnickoIme">Korisničko ime: </label><br>
                <input type="text" id="korisnickoIme" name="korisnickoIme" size="30" maxlength="30" placeholder="Unesite Vaše korisničko ime" required="required" value="<?php echo isset($_COOKIE['kolacic_za_pamcenje_korisnika']) ? $_COOKIE['kolacic_za_pamcenje_korisnika'] : ''; ?>"><br>
                <label id="pw" for="lozinka">Lozinka: </label><br>
                <input type="password" id="lozinka" name="lozinka" size="30" maxlength="30" placeholder="Unesite Vašu lozinku" required="required"><br>
                <label for="zapamti" style="margin-left: 10px;">Zapamti prijavu: </label>
                <input type="checkbox" name="zapamti" style="margin-left: 10px; margin-bottom: 20px;"><br>
                <input name="prijavaSe" id="btn" type="submit" style="margin-left: 125px; margin-bottom: 10px;" value="Prijavi se">
                <input name="zaboravljenaLozinka" id="btnZaboravljena" type="submit" value ="Zaboravljena lozinka?" style="margin-left: 105px; margin-bottom: 10px;">
            </form>
        </div>

        <footer class="podnozje" style="margin-bottom: -10px;">
            <a class="linkzafooter"
               href="http://validator.w3.org/check?uri=http://barka.foi.hr/WebDiP/2021/zadaca_01/ppoldruga/obrasci/prijava.html"><img src="../materijali/HTML5.png" alt="html icon"></a>
            <a class="linkzafooter"
               href="https://jigsaw.w3.org/css-validator/validator?uri=http://barka.foi.hr/WebDiP/2021/zadaca_01/ppoldruga/css/ppoldruga.css"><img src="../materijali/CSS3.png" alt="css icon"></a>
            <address>Kontakt: 
                <a style="color: white;" href="mailto:ppoldruga@foi.hr">
                    <b>Patricio Poldrugač</b></a></address>
            <p>&copy; 2022 P.Poldrugač</p>
        </footer>
    </body>
</html>
