<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL ^ E_NOTICE);

$direktorij = getcwd();
$putanja = dirname($_SERVER['REQUEST_URI']);

include_once 'zaglavlje.php';

if (!isset($_SESSION["uloga"])) {
    header("Location: obrasci/prijava.php");
    exit();
}

if (isset($_SESSION['uloga']) && ($_SESSION['uloga']) < 4) {
    $datumvrijeme = date("Y-m-d H:i:s");
    $korisnikid = $_SESSION["korisnik"];

    $veza = new Baza();
    $veza->spojiDB();

    $upit = "INSERT INTO `Dnevnik_rada` (`id`, `tip_radnje_id`, `Korisnik_id`, `opis_radnje`, `vrijeme`, `upit`)"
            . " VALUES (NULL, '7', '$korisnikid', 'Korisnik je pokušao pristupiti stranici preko linka, a nema ulogu"
            . " dozvoljenu za to, stoga je automatski odjavljen i prebačen na stranicu prijave.', '$datumvrijeme', NULL)";

    $rezultat = $veza->selectDB($upit);

    $veza->zatvoriDB();

    setcookie("autenticiran", "", time() - 3600, "/");
    unset($_COOKIE['autenticiran']);
    Sesija::obrisiSesiju();

    header("Location: obrasci/prijava.php");
    exit();
}




$veza = new Baza();
$veza->spojiDB();


if (isset($_GET['azuriraj']) && $_GET['azuriraj'] != "") {

    if (isset($_GET['kont']) && $_GET['kont'] == 0 && isset($_GET['nova'])) {
        $novaVrijednost = $_GET['nova'];

        $upitKonfiguracijaId = "SELECT broj_neuspjesnih_prijava FROM `Konfiguracija`";
        $rezultatKonfiguracijaId = $veza->selectDB($upitKonfiguracijaId);
        $red = mysqli_fetch_array($rezultatKonfiguracijaId);
        $id = $red[0];
        
        $upitZaPromjenu = "UPDATE `Konfiguracija` SET broj_neuspjesnih_prijava = '$novaVrijednost' WHERE broj_neuspjesnih_prijava = '$id'";
        $veza->updateDB($upitZaPromjenu);
        
    }
}

if (isset($_GET['azuriraj']) && $_GET['azuriraj'] != "") {

    if (isset($_GET['kont']) && $_GET['kont'] == 0 && isset($_GET['nova'])) {
        $novaVrijednost = $_GET['nova'];

        $upitKonfiguracijaId = "SELECT broj_neuspjesnih_prijava FROM `Konfiguracija`";
        $rezultatKonfiguracijaId = $veza->selectDB($upitKonfiguracijaId);
        $red = mysqli_fetch_array($rezultatKonfiguracijaId);
        $id = $red[0];
        
        $upitZaPromjenu = "UPDATE `Konfiguracija` SET broj_neuspjesnih_prijava = '$novaVrijednost' WHERE broj_neuspjesnih_prijava = '$id'";
        $veza->updateDB($upitZaPromjenu);
        
    }
    
    if (isset($_GET['kont']) && $_GET['kont'] == 1 && isset($_GET['nova'])) {
        $novaVrijednost = $_GET['nova'];

        $upitKonfiguracijaId = "SELECT broj_neuspjesnih_prijava FROM `Konfiguracija`";
        $rezultatKonfiguracijaId = $veza->selectDB($upitKonfiguracijaId);
        $red = mysqli_fetch_array($rezultatKonfiguracijaId);
        $id = $red[0];
        
        $upitZaPromjenu = "UPDATE `Konfiguracija` SET broj_redaka_za_stranicenje = '$novaVrijednost' WHERE broj_neuspjesnih_prijava = '$id'";
        $veza->updateDB($upitZaPromjenu);
        
    }
    
    if (isset($_GET['kont']) && $_GET['kont'] == 2 && isset($_GET['nova'])) {
        $novaVrijednost = $_GET['nova'];

        $upitKonfiguracijaId = "SELECT broj_neuspjesnih_prijava FROM `Konfiguracija`";
        $rezultatKonfiguracijaId = $veza->selectDB($upitKonfiguracijaId);
        $red = mysqli_fetch_array($rezultatKonfiguracijaId);
        $id = $red[0];
        
        $upitZaPromjenu = "UPDATE `Konfiguracija` SET trajanje_kolacica = '$novaVrijednost' WHERE broj_neuspjesnih_prijava = '$id'";
        $veza->updateDB($upitZaPromjenu);
        
    }
    
    if (isset($_GET['kont']) && $_GET['kont'] == 3 && isset($_GET['nova'])) {
        $novaVrijednost = $_GET['nova'];

        $upitKonfiguracijaId = "SELECT broj_neuspjesnih_prijava FROM `Konfiguracija`";
        $rezultatKonfiguracijaId = $veza->selectDB($upitKonfiguracijaId);
        $red = mysqli_fetch_array($rezultatKonfiguracijaId);
        $id = $red[0];
        
        $upitZaPromjenu = "UPDATE `Konfiguracija` SET trajanje_sesije = '$novaVrijednost' WHERE broj_neuspjesnih_prijava = '$id'";
        $veza->updateDB($upitZaPromjenu);
        
    }
    
    if (isset($_GET['kont']) && $_GET['kont'] == 4 && isset($_GET['nova'])) {
        $novaVrijednost = $_GET['nova'];

        $upitKonfiguracijaId = "SELECT broj_neuspjesnih_prijava FROM `Konfiguracija`";
        $rezultatKonfiguracijaId = $veza->selectDB($upitKonfiguracijaId);
        $red = mysqli_fetch_array($rezultatKonfiguracijaId);
        $id = $red[0];
        
        $upitZaPromjenu = "UPDATE `Konfiguracija` SET pomak_vremena = '$novaVrijednost' WHERE broj_neuspjesnih_prijava = '$id'";
        $veza->updateDB($upitZaPromjenu);
        
    }
    
    if (isset($_GET['kont']) && $_GET['kont'] == 5 && isset($_GET['nova'])) {
        $novaVrijednost = $_GET['nova'];

        $upitKonfiguracijaId = "SELECT broj_neuspjesnih_prijava FROM `Konfiguracija`";
        $rezultatKonfiguracijaId = $veza->selectDB($upitKonfiguracijaId);
        $red = mysqli_fetch_array($rezultatKonfiguracijaId);
        $id = $red[0];
        
        $upitZaPromjenu = "UPDATE `Konfiguracija` SET istek_verifikacije = '$novaVrijednost' WHERE broj_neuspjesnih_prijava = '$id'";
        $veza->updateDB($upitZaPromjenu);
        
    }
}


$upitKonfiguracija = "SELECT * FROM `Konfiguracija`";
$rezultatKonfiguracija = $veza->selectDB($upitKonfiguracija);

$veza->zatvoriDB();
?>
<!DOCTYPE html>
<html lang="hr">
    <head>
        <title>Konfiguriranje postavki aplikacije</title>
        <meta charset="utf-8">
        <meta name="author" content="Patricio Poldrugac">
        <meta name="description" content="14.3.2022.">
        <link href="css/ppoldruga.css" rel="stylesheet" type="text/css">
    </head>
    <body id="vrh">
        <header>
            <h1 class="naslov">Konfiguriranje postavki aplikacije</h1>
            <a href="index.php">
                <img src="materijali/lutrijalogo.png" alt="Logo" class="logo"></a> 
        </header>
        <nav>
            <input id="menu__toggle" type="checkbox" />
            <label class="menu__gumb" for="menu__toggle">
                <span></span>
            </label>
            <ul class="menu__cijeli">
                <?php
                include 'meni.php';
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

        <div class="containerKonf">
            <form novalidate id="formProjekt" method="get" name="formProjekt" action="konfiguracija_sustava.php">
                <select name = "kont" id = "konf">
                    <option value="prazno" style="text-align: center;">---Odaberite konfiguraciju koju želite promijeniti---</option>
                    <option value="0" style="text-align: center;">Broj neuspješnih prijava</option>
                    <option value="1" style="text-align: center;">Broj redaka za straničenje</option>
                    <option value="2" style="text-align: center;">Trajanje kolačića</option>
                    <option value="3" style="text-align: center;">Trajanje sesije</option>
                    <option value="4" style="text-align: center;">Pomak vremena</option>
                    <option value="5" style="text-align: center;">Istek verifikacije</option>
                </select><br><br>
                <label id="nova" for="nova">Nova vrijednost:</label>
                <input type="number" id="nova" name="nova"><br>

                <input name="azuriraj" id="btnFiltriraj" type="submit" style="margin-left: 250px; margin-bottom: 10px;" value="Ažuriraj"><br>
            </form>
        </div>

        <div id="okoTablice">
            <table id="tablica">
                <thead class="zaglavlje">
                    <tr>
                        <th>Broj neuspješnih prijava</th>
                        <th>Broj redaka za straničenje</th>
                        <th>Trajanje kolačića</th>
                        <th>Trajanje sesije</th>
                        <th>Pomak vremena</th>
                        <th>Istek verifikacije</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($red = mysqli_fetch_array($rezultatKonfiguracija)) {
                        ?>
                        <tr>
                            <td><?php echo $red[0] ?></td>
                            <td><?php echo $red[1] ?></td>
                            <td><?php echo $red[2] ?></td>
                            <td><?php echo $red[3] ?></td>
                            <td><?php echo $red[4] ?></td>
                            <td><?php echo $red[5] ?></td>
                        </tr>
                        <?php
                    }
                    ?>   
                </tbody>
                <tfoot>
                </tfoot>
            </table>
        </div>   


        <footer class="podnozje" style="margin-bottom: -10px;">
            <a class="linkzafooter"
               href="http://validator.w3.org/check?uri=http://barka.foi.hr/WebDiP/2021/zadaca_01/ppoldruga/obrasci/prijava.html"><img src="materijali/HTML5.png" alt="html icon"></a>
            <a class="linkzafooter"
               href="https://jigsaw.w3.org/css-validator/validator?uri=http://barka.foi.hr/WebDiP/2021/zadaca_01/ppoldruga/css/ppoldruga.css"><img src="materijali/CSS3.png" alt="css icon"></a>
            <address>Kontakt: 
                <a style="color: white;" href="mailto:ppoldruga@foi.hr">
                    <b>Patricio Poldrugač</b></a></address>
            <p>&copy; 2022 P.Poldrugač</p>
        </footer>
    </body>
</html>
