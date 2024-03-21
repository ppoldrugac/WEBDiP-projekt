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

$upitRadnje = "SELECT * FROM `tip_radnje`";
$rezultatUpitaRadnje = $veza->selectDB($upitRadnje);

$upitKor = "SELECT id, CONCAT(ime, ' ', prezime) FROM Korisnik";
$rezultatUpitaKor = $veza->selectDB($upitKor);

if (isset($_GET['pretrazi']) && $_GET['pretrazi'] != "") {

    if (isset($_GET['od']) && $_GET['od'] != "" && isset($_GET['do']) && $_GET['do'] != "") {
        $datumOd = $_GET['od'];
        $datumDo = $_GET['do'];
        $odabranOd = date("Y-m-d H:i:s", strtotime($datumOd));
        $odabranDo = date("Y-m-d H:i:s", strtotime($datumDo));
        
        $upitPopuniDnevnik = "SELECT Korisnik.ime, Korisnik.prezime, tip_korisnika.naziv, tip_radnje.naziv, Dnevnik_rada.opis_radnje, Dnevnik_rada.vrijeme"
                . " FROM Korisnik, tip_radnje, tip_korisnika, Dnevnik_rada WHERE Korisnik.id = Dnevnik_rada.Korisnik_id AND"
                . " Korisnik.tip_korisnika_id = tip_korisnika.id AND Dnevnik_rada.tip_radnje_id = tip_radnje.id AND Dnevnik_rada.vrijeme"
                . " BETWEEN '$odabranOd' AND '$odabranDo'";
    }
    
    if(isset($_GET['tipRadnje']) && $_GET['tipRadnje'] != ""){
        $odabranTipRadnje = $_GET['tipRadnje'];
        
        $upitPopuniDnevnik = "SELECT Korisnik.ime, Korisnik.prezime, tip_korisnika.naziv, tip_radnje.naziv, Dnevnik_rada.opis_radnje, Dnevnik_rada.vrijeme"
                . " FROM Korisnik, tip_radnje, tip_korisnika, Dnevnik_rada WHERE Korisnik.id = Dnevnik_rada.Korisnik_id AND Korisnik.tip_korisnika_id = tip_korisnika.id"
                . " AND Dnevnik_rada.tip_radnje_id = tip_radnje.id AND Dnevnik_rada.vrijeme AND tip_radnje.id = $odabranTipRadnje";
        
    }
    
    if(isset($_GET['korisnik']) && $_GET['korisnik'] != ""){
        $odabranKorisnik = $_GET['korisnik'];
        
        $upitPopuniDnevnik = "SELECT Korisnik.ime, Korisnik.prezime, tip_korisnika.naziv, tip_radnje.naziv, Dnevnik_rada.opis_radnje, Dnevnik_rada.vrijeme"
                . " FROM Korisnik, tip_radnje, tip_korisnika, Dnevnik_rada WHERE Korisnik.id = Dnevnik_rada.Korisnik_id AND Korisnik.tip_korisnika_id = tip_korisnika.id"
                . " AND Dnevnik_rada.tip_radnje_id = tip_radnje.id AND Dnevnik_rada.vrijeme AND Korisnik.id = $odabranKorisnik";
        
    }
    
    if( $_GET['od'] != "" && $_GET['do'] != "" && $_GET['tipRadnje'] != "" && $_GET['korisnik'] != ""){
        $datumOd = $_GET['od'];
        $datumDo = $_GET['do'];
        $odabranOd = date("Y-m-d H:i:s", strtotime($datumOd));
        $odabranDo = date("Y-m-d H:i:s", strtotime($datumDo));
        $odabranTipRadnje = $_GET['tipRadnje'];
        $odabranKorisnik = $_GET['korisnik'];
        
        $upitPopuniDnevnik = "SELECT Korisnik.ime, Korisnik.prezime, tip_korisnika.naziv, tip_radnje.naziv, Dnevnik_rada.opis_radnje, Dnevnik_rada.vrijeme"
                . " FROM Korisnik, tip_radnje, tip_korisnika, Dnevnik_rada WHERE Korisnik.id = Dnevnik_rada.Korisnik_id AND Korisnik.tip_korisnika_id = tip_korisnika.id"
                . " AND Dnevnik_rada.tip_radnje_id = tip_radnje.id AND Dnevnik_rada.vrijeme AND Korisnik.id = $odabranKorisnik AND tip_radnje.id = $odabranTipRadnje AND Dnevnik_rada.vrijeme"
                . " BETWEEN '$odabranOd' AND '$odabranDo'";
    }
    
    
}else{
    $upitPopuniDnevnik = "SELECT Korisnik.ime, Korisnik.prezime, tip_korisnika.naziv, tip_radnje.naziv, Dnevnik_rada.opis_radnje, Dnevnik_rada.vrijeme"
        . " FROM Korisnik, tip_radnje, tip_korisnika, Dnevnik_rada WHERE Korisnik.id = Dnevnik_rada.Korisnik_id AND Korisnik.tip_korisnika_id = tip_korisnika.id"
        . " AND Dnevnik_rada.tip_radnje_id = tip_radnje.id";
}

$rezultatUpitaPopuniDnevnik = $veza->selectDB($upitPopuniDnevnik);

$veza->zatvoriDB();
?>
<!DOCTYPE html>
<html lang="hr">
    <head>
        <title>Dnevnik</title>
        <meta charset="utf-8">
        <meta name="author" content="Patricio Poldrugac">
        <meta name="description" content="14.3.2022.">
        <link href="css/ppoldruga.css" rel="stylesheet" type="text/css">
    </head>
    <body id="vrh">
        <header>
            <h1 class="naslov">Pregled i pretraživanje dnevnika</h1>
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
            <form novalidate id="formProjekt" method="get" name="formProjekt" action="dnevnik.php">
                <p style="font-weight: bold; text-align: center;">Pretraži po:</p>

                <label id="od" for="od">Datum od:</label>
                <input type="text" id="od" name="od"><br>
                <label id="do" for="do">Datum do: </label>
                <input type="text" id="do" name="do"><br>


                <label id="tipRadnje" for="tipRadnje">Tip radnje:</label>
                <select name = "tipRadnje" id = "tipRadnje">
                    <option value="" style="text-align: center;">---Odaberite---</option>
                    <?php
                    while ($red = mysqli_fetch_array($rezultatUpitaRadnje)) {

                        echo "<option value ='$red[0]'>$red[1]</option>";
                    }
                    ?>
                </select>

                <label id="korisnik" for="korisnik">Korisnik:</label>
                <select name = "korisnik" id = "korisnik">
                    <option value="" style="text-align: center;">---Odaberite---</option>
                    <?php
                    while ($red = mysqli_fetch_array($rezultatUpitaKor)) {

                        echo "<option value ='$red[0]'>$red[1]</option>";
                    }
                    ?>
                </select><br><br>

                <input name="pretrazi" id="btnFiltriraj" type="submit" style="margin-left: 250px; margin-bottom: 10px;" value="Pretraži"><br>
            </form>
        </div>

        <div id="okoTablice">
            <table id="tablica">
                <thead class="zaglavlje">
                    <tr>
                        <th>Ime</th>
                        <th>Prezime</th>
                        <th>Tip Korisnika</th>
                        <th>Tip radnje</th>
                        <th>Opis radnje</th>
                        <th>Vrijeme radnje</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($red = mysqli_fetch_array($rezultatUpitaPopuniDnevnik)) {
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
