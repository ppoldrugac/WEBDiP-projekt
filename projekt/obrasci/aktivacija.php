<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL ^ E_NOTICE);
$direktorij = dirname(getcwd());
$putanja = dirname($_SERVER['REQUEST_URI'], 2);

include_once '../zaglavlje.php';

$veza = new Baza();
$veza->spojiDB();

if (isset($_GET['Aktiviraj']) && $_GET['kod'] != "") {
    $kod = $_GET['kod'];
    $upitKorisnik = "SELECT * FROM `Korisnik` WHERE aktivacijski_kod='$kod'";
    $rezultatKorisnik = $veza->selectDB($upitKorisnik);

    $pronaden = false;
    while ($red = mysqli_fetch_array($rezultatKorisnik)) {
        if ($red) {
            $pronaden = true;
            $korisnikid = $red["id"];
            $email = $red["email"];
            $datumRege = $red["datum_registracije"];
            $aktiviran = $red["aktiviran"];
        }
    }
}

if ($pronaden == true) {
    
    $upitIstekAktivacije = "SELECT istek_verifikacije FROM `Konfiguracija`";
    $rezultatUpitaIstekAktivacije = $veza->selectDB($upitIstekAktivacije);
    $sve = mysqli_fetch_array($rezultatUpitaIstekAktivacije);
    $istekKoda = $sve[0];
    
    if ($aktiviran == 0){
        
        $trenutnoVrijeme = date("Y-m-d H:i:s");
        $vrijemeIsteka = date('Y-m-d H:i:s', strtotime($datumRege . ' + ' . $istekKoda . ' hours'));
        
        if(strtotime($vrijemeIsteka) > strtotime($trenutnoVrijeme)){
            $upitZaAktiviranje = "UPDATE `Korisnik` SET aktiviran = 1 WHERE id = " . "'" . $korisnikid . "'";
            $veza->updateDB($upitZaAktiviranje);
            header("Location: prijava.php?aktiviran=da");
        } else{
            $upitZaBrisanje = "DELETE FROM `Korisnik` WHERE id = " . "'" . $korisnikid . "'";
            $veza->updateDB($upitZaBrisanje);
            header("Location: registracija.php?aktiviran=ne"); 
        }
    }
    
} else {
    $poruka .= "Unesite ispravan kod koji Vam je poslan na mejl!";
}

$veza->zatvoriDB();


?>

<!DOCTYPE html>
<html lang = "hr">
    <head>
        <title>Aktivacija korisničkog računa</title>
        <meta charset = "utf-8">
        <meta name = "author" content = "Patricio Poldrugac">
        <meta name = "description" content = "14.3.2022.">
        <link href = "../css/ppoldruga.css" rel = "stylesheet" type = "text/css">
    </head>
    <body id="vrh">
        <header>
            <h1 class="naslov">Aktivacija korisničkog računa</h1>
            <a href="index.php">
                <img src="../materijali/lutrijalogo.png" alt="Logo" class="logo"></a> 
        </header>
        <div id="greske">
            <?php
            if (isset($poruka)) {
                echo $poruka;
            }
            ?>
        </div>
        <div class="containerAktivacije">
            <form novalidate id="formAktivacija" method="get" name="formAktivacija" action="aktivacija.php">
                <label style='padding: 100px;' id="kod1" for="kod">Unesite aktivacijski kod: </label><br>
                <input type="text" id="kod" name="kod" required><br>
                <input name="Aktiviraj" id="btn" type="submit" style="margin-left: 125px; margin-bottom: 10px;" value="Aktiviraj račun">
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
