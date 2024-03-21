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

if (isset($_SESSION['uloga']) && ($_SESSION['uloga']) != 3) {
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

$upitIgre = "SELECT DISTINCT naziv FROM `Igra_na_srecu`";
$rezultatUpitaIgreNaSrecu = $veza->selectDB($upitIgre);

$idKor = $_SESSION['korisnik'];

$upitIgre2 = "SELECT DISTINCT Igra_na_srecu.naziv, Igra_na_srecu.id FROM Kolo, Lutrija, moderatori_lutrija, Korisnik, Igra_na_srecu"
        . " WHERE moderatori_lutrija.Korisnik_id = Korisnik.id AND moderatori_lutrija.Lutrija_id = Lutrija.id AND Korisnik.id = '$idKor' "
        . "AND Igra_na_srecu.Korisnik_id = Korisnik.id AND Kolo.Igra_na_srecu_id = Igra_na_srecu.id";
$rezultatUpita2 = $veza->selectDB($upitIgre2);

if (isset($_GET['azuriraj'])) {
    $idKola = $_GET['azuriraj'];
    $upitDk = "SELECT * FROM Kolo WHERE Kolo.id = '$idKola'";
    $rezultatDk = $veza->selectDB($upitDk);
    $sve = mysqli_fetch_array($rezultatDk);

    $igra = $sve[1];
    $dv = $sve[2];
    $st = $sve[3];
}

if(isset($_GET['zatvori'])){
    $idKola = $_GET['zatvori'];
    $upitUpdateStatus = "UPDATE `Kolo` SET otvoreno = 0 WHERE Kolo.id = '$idKola'";
    $veza->updateDB($upitUpdateStatus);
}

if(isset($_GET['otvori'])){
    $idKola = $_GET['otvori'];
    $upitUpdateStatus = "UPDATE `Kolo` SET otvoreno = 1 WHERE Kolo.id = '$idKola'";
    $veza->updateDB($upitUpdateStatus);
}

if (isset($_GET['gumbDodaj'])) {
    if ($_GET['idKola'] == "") {
        $datumv = $_GET['datumvrijeme'];
        $datv = date("Y-m-d H:i:s", strtotime($datumv));
        $igr = $_GET['igra'];
        $stat = $_GET['status'];

        $upitZaDodavanjeKola= "INSERT INTO `Kolo` (`id`, `Igra_na_srecu_id`, `datum_i_vrijeme_isplate`, `otvoreno`) VALUES (NULL, $igr, '$datv', '$stat') ";
        $rezultatUpitaZaDodavanjeKola = $veza->selectDB($upitZaDodavanjeKola);

    } else {
        $poruka = "Za dodavanje kola polje Id mora ostati prazno!";
    }
}

if (isset($_GET['gumbAzuriraj'])) {
    $idKola = $_GET['idKola'];
    $dvv = $_GET['datumvrijeme'];
    $datumNovi = date("Y-m-d H:i:s", strtotime($dvv));
    $statusNovi = $_GET['status'];
    $idIgreNovi = $_GET['igra'];
    $moderatorNovi = $_GET['moderator'];
    if ($idKola != "" && $dvv != "" && $statusNovi != "" && $idIgreNovi != "") {
        $upitZaAzuriranje = "UPDATE `Kolo` SET Igra_na_srecu_id = '$idIgreNovi', datum_i_vrijeme_isplate = '$datumNovi', otvoreno = '$statusNovi' WHERE Kolo.id = '$idKola'";
        $veza->updateDB($upitZaAzuriranje);
    } else {
        $poruka = "Niste odabrali Igru na sreću!";
    }
}

if (isset(($_GET['Filtriraj'])) && $_GET['igra'] != "") {
    $nazivIgre = $_GET['igra'];

    $upitPostavi = "SELECT DISTINCT Igra_na_srecu.id, Igra_na_srecu.naziv, Kolo.id, Kolo.datum_i_vrijeme_isplate, Kolo.otvoreno FROM Kolo, Lutrija, moderatori_lutrija, Korisnik, Igra_na_srecu"
            . " WHERE moderatori_lutrija.Korisnik_id = Korisnik.id AND moderatori_lutrija.Lutrija_id = Lutrija.id AND Korisnik.id = '2' AND"
            . " Igra_na_srecu.Korisnik_id = Korisnik.id AND Kolo.Igra_na_srecu_id = Igra_na_srecu.id AND Igra_na_srecu.naziv LIKE '$nazivIgre%'";
} else {
    $idKor = $_SESSION['korisnik'];

    $upitPostavi = "SELECT DISTINCT Igra_na_srecu.id, Igra_na_srecu.naziv, Kolo.id, Kolo.datum_i_vrijeme_isplate, Kolo.otvoreno FROM Kolo, Lutrija, moderatori_lutrija, Korisnik, Igra_na_srecu"
            . " WHERE moderatori_lutrija.Korisnik_id = Korisnik.id AND moderatori_lutrija.Lutrija_id = Lutrija.id AND Korisnik.id = '$idKor' AND"
            . " Igra_na_srecu.Korisnik_id = Korisnik.id AND Kolo.Igra_na_srecu_id = Igra_na_srecu.id";
}


$veza->zatvoriDB();
?>
<!DOCTYPE html>
<html lang="hr">
    <head>
        <title>Kola</title>
        <meta charset="utf-8">
        <meta name="author" content="Patricio Poldrugac">
        <meta name="description" content="14.3.2022.">
        <link href="css/ppoldruga.css" rel="stylesheet" type="text/css">
    </head>
    <body id="vrh">
        <header>
            <h1 class="naslov">Kola</h1>
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
        <div class="containerProjekt4">
            <form novalidate id="formProjekt" method="get" name="formProjekt" action="kolo.php">
                <p style="text-align: center; padding: 5px; color: #004654; font-weight: bold; font-size: 20px;">Pretraži kola</p>
                <label id="igra" for="igra">Igra na sreću:</label>
                <select name = "igra" id = "igra">
                    <option value="" style="text-align: center;">---Odaberite---</option>
                    <?php
                    while ($red = mysqli_fetch_array($rezultatUpitaIgreNaSrecu)) {

                        echo "<option value ='$red[0]'>$red[0]</option>";
                    }
                    ?>
                </select>
                <input name="Filtriraj" id="btnFiltriraj" type="submit" style="margin-left: 250px; " value="Filtriraj"><br>
            </form>
        </div>

        <form novalidate id="formKolo" method="get" name="formKolo" action="kolo.php">
            <div id="okoTablice" style="margin-bottom: 20px;">
                <table id="tablica">
                    <thead class="zaglavlje">
                        <tr>
                            <th>ID igre</th>
                            <th>Igra na sreću</th>
                            <th>Kolo ID</th>
                            <th>Datum i vrijeme isplate</th>
                            <th>Status kola</th>
                            <th>Otvori/Zatvori kolo</th>
                            <th>Ažuriraj</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $veza = new Baza();
                        $veza->spojiDB();

                        $rezultat = $veza->selectDB($upitPostavi);

                        while ($red = mysqli_fetch_array($rezultat)) {
                            ?>
                            <tr>
                                <td><?php echo $red[0] ?></td>
                                <td><?php echo $red[1] ?></td>
                                <td><?php echo $red[2] ?></td>
                                <td><?php echo $red[3] ?></td>
                                <td><?php echo $red[4] ?></td>
                                <td><?php if ($red[4] == 1) {
                            echo "<input name='zatvori' id='zatvori' type='submit' value='$red[2]' >";
                        } else {
                            echo "<input name='otvori' id='otvori' type='submit' value='$red[2]' >";
                        } ?></td>
                                <td> <input name="azuriraj" id="azuriraj" type="submit" value="<?php echo"$red[2]"; ?>"></td>
                            </tr>
                            <?php
                        }
                        $veza->zatvoriDB();
                        ?>   
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>  
        </form>

        <div class="containerProjekt2">
            <form novalidate id="formProjekt" method="get" name="formLutrijeAzuriraj" action="kolo.php">
                <p style="text-align: center; padding: 5px; color: #004654; font-weight: bold; font-size: 20px;">Dodavanje/Ažuriranje kola</p>
                <label id="idKola" for="idKola">Id kola:</label>
                <input type="text" id="idKola" name="idKola" value="<?php
                if (isset($_GET['azuriraj'])) {
                    echo $idKola;
                } else {
                    echo "";
                }
                ?>"><br>
                <label id="datumvrijeme" for="datumvrijeme">Datum i vrijeme isplate:</label>
                <input type="text" id="datumvrijeme" name="datumvrijeme" value="<?php
                if (isset($_GET['azuriraj'])) {
                    echo $dv;
                } else {
                    echo "";
                }
                ?>"><br>
                <label id="status" for="status">Status (1-otvoreno/0-zatvoreno):</label>
                <input type="text" id="status" name="status" value="<?php
                if (isset($_GET['azuriraj'])) {
                    echo $st;
                } else {
                    echo "";
                }
                ?>"><br>
                <label id="igra" for="igra">Igra na sreću:</label>
                <select name = "igra" id = "igra">
                    <option value="" style="text-align: center;">---Odaberite---</option>
                    <?php
                    while ($red = mysqli_fetch_array($rezultatUpita2)) {

                        echo "<option value ='$red[1]'>$red[0]</option>";
                    }
                    ?>
                </select><br><br>

                <div style="display: flex;"><input name="gumbDodaj" id="btnFiltriraj" type="submit" style="margin-left: 100px; margin-bottom: 10px;" value="Kreiraj">
                    <input name="gumbAzuriraj" id="btnFiltriraj" type="submit" style="margin-left: 100px; margin-bottom: 10px;" value="Ažuriraj"></div>
            </form>
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
