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

if (isset($_GET['azuriraj'])) {
    $idLutrije = $_GET['azuriraj'];
    $upitDl = "SELECT Lutrija.id, Lutrija.naziv, Lutrija.temeljni_kapital, Korisnik.id FROM Lutrija, Korisnik, moderatori_lutrija "
            . "WHERE Korisnik.id = moderatori_lutrija.Korisnik_id AND Lutrija.id = moderatori_lutrija.Lutrija_id AND Lutrija.id = '$idLutrije'";
    $rezultatDl = $veza->selectDB($upitDl);
    $sve = mysqli_fetch_array($rezultatDl);

    $nazivAzur = $sve[1];
    $kapitalAzur = $sve[2];
}

if (isset($_GET['gumbDodaj'])) {
    if ($_GET['idIgre'] == "") {
        $nazivAzur = $_GET['naziv'];
        $brojAzur = $_GET['broj'];
        $cijenaAzur = $_GET['cijena'];

        $datumOd = $_GET['od'];
        $datumDo = $_GET['do'];
        $datumOdAzur = date("Y-m-d H:i:s", strtotime($datumOd));
        $datumDoAzur = date("Y-m-d H:i:s", strtotime($datumDo));

        $fondAzur = $_GET['fond'];
        
        $idKor = $_SESSION['korisnik'];

        $upitZaDodavanjeLutrije = "INSERT INTO `Igra_na_srecu` (`id`, `Korisnik_id`, `naziv`, `broj_brojeva_za_izvlacenje`, `cijena_listica`,"
                . " `datumvrijeme_pocetka`, `datumvrijeme_zavrsetka`, `fond_dobitka`) VALUES (NULL, '$idKor', '$nazivAzur', '$brojAzur', '$cijenaAzur', '$datumOdAzur', '$datumDoAzur', '$fondAzur')";
        $rezultatUpitaZaDodavanjeLutrije = $veza->selectDB($upitZaDodavanjeLutrije);
    } else {
        $poruka = "Za dodavanje igre na sreću polje Id mora ostati prazno!";
    }
}

if (isset($_GET['gumbAzuriraj'])) {
    $idIgre = $_GET['idIgre'];
    $nazivAzur = $_GET['naziv'];
    $brojAzur = $_GET['broj'];
    $cijenaAzur = $_GET['cijena'];
    $datumOd = $_GET['od'];
    $datumDo = $_GET['do'];
    $datumOdAzur = date("Y-m-d H:i:s", strtotime($datumOd));
    $datumDoAzur = date("Y-m-d H:i:s", strtotime($datumDo));
    $fondAzur = $_GET['fond'];

    if ($idIgre != "" && $nazivAzur != "" && $brojAzur != "" && $cijenaAzur != "" && $datumOd != "" && $datumDo != "" && $fondAzur != "") {

        $upitZaAzuriranje = "UPDATE `Igra_na_srecu` SET naziv = '$nazivAzur', broj_brojeva_za_izvlacenje = '$brojAzur', cijena_listica = '$cijenaAzur',"
                . " datumvrijeme_pocetka = '$datumOdAzur', datumvrijeme_zavrsetka = '$datumDoAzur', fond_dobitka = '$fondAzur' WHERE Igra_na_srecu.id = '$idIgre'";
        $veza->updateDB($upitZaAzuriranje);
    }
}

if (isset($_GET['azuriraj'])) {
    $idIgre = $_GET['azuriraj'];
    $upitDI = "SELECT * FROM `Igra_na_srecu` WHERE id = '$idIgre'";
    $rezultatDI = $veza->selectDB($upitDI);
    $sve = mysqli_fetch_array($rezultatDI);

    $nazivAzur = $sve[2];
    $brojAzur = $sve[3];
    $cijenaAzur = $sve[4];
    $datumOdAzur = $sve[5];
    $datumDoAzur = $sve[6];
    $fondAzur = $sve[7];
}

if (isset($_SESSION['korisnik'])) {
    $idKor = $_SESSION['korisnik'];

    $upit = "SELECT DISTINCT Igra_na_srecu.id, Igra_na_srecu.naziv, Igra_na_srecu.broj_brojeva_za_izvlacenje, Igra_na_srecu.cijena_listica, Igra_na_srecu.datumvrijeme_pocetka,"
            . " Igra_na_srecu.datumvrijeme_zavrsetka, Igra_na_srecu.fond_dobitka FROM Lutrija, moderatori_lutrija, Korisnik, Igra_na_srecu"
            . " WHERE moderatori_lutrija.Korisnik_id = Korisnik.id AND moderatori_lutrija.Lutrija_id = Lutrija.id AND Korisnik.id = '$idKor'"
            . " AND Igra_na_srecu.Korisnik_id = Korisnik.id";

    $rezultat = $veza->selectDB($upit);
}


$rezultat = $veza->selectDB($upit);

$veza->zatvoriDB();
?>
<!DOCTYPE html>
<html lang="hr">
    <head>
        <title>Upravljanje igrama na sreću moderator</title>
        <meta charset="utf-8">
        <meta name="author" content="Patricio Poldrugac">
        <meta name="description" content="14.3.2022.">
        <link href="css/ppoldruga.css" rel="stylesheet" type="text/css">
    </head>
    <body id="vrh">
        <header>
            <h1 class="naslov">Upravljanje igrama na sreću</h1>
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
        <form novalidate id="formLutrije" method="get" name="formLutrije" action="igre_moderator.php">       
            <div id="okoTablice">
                <table id="tablica">
                    <caption style="padding: 20px; color: #004654; font-weight: bold; font-size: 30px;">Popis igra na sreću</caption>
                    <thead class="zaglavlje">
                        <tr>
                            <th>Naziv</th>
                            <th>Broj brojeva za izvlačenje</th>
                            <th>Cijena listića</th>
                            <th>Datum i vrijeme početka</th>
                            <th>Datum i vrijeme završetka</th>
                            <th>Fond dobitka</th>
                            <th>Ažuriraj</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($red = mysqli_fetch_array($rezultat)) {
                            ?>
                            <tr>
                                <td><?php echo $red[1] ?></td>
                                <td><?php echo $red[2] ?></td>
                                <td><?php echo $red[3] ?></td>
                                <td><?php echo $red[4] ?></td>
                                <td><?php echo $red[5] ?></td>
                                <td><?php echo $red[6] ?></td>
                                <td> <input name="azuriraj" id="azuriraj" type="submit" value="<?php echo"$red[0]"; ?>"></td> 
                            </tr>
                            <?php
                        }
                        ?>   
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>
        </form>

        <div class="containerProjekt3">
            <form novalidate id="formProjekt" method="get" name="formLutrijeAzuriraj" action="igre_moderator.php">
                <p style="text-align: center; padding: 5px; color: #004654; font-weight: bold; font-size: 20px;">Dodavanje/Ažuriranje igra na sreću</p>
                <label id="idIgre" for="idIgre">Id:</label>
                <input type="text" id="idIgre" name="idIgre" value="<?php
                if (isset($_GET['azuriraj'])) {
                    echo $idIgre;
                } else {
                    echo "";
                }
                ?>"><br>

                <label id="naziv" for="naziv">Naziv:</label>
                <input type="text" id="naziv" name="naziv" value="<?php
                if (isset($_GET['azuriraj'])) {
                    echo $nazivAzur;
                } else {
                    echo "";
                }
                ?>"><br>

                <label id="broj" for="broj">Broj brojeva za izvlačenje:</label>
                <input type="number" id="broj" name="broj" value="<?php
                if (isset($_GET['azuriraj'])) {
                    echo $brojAzur;
                } else {
                    echo "";
                }
                ?>"><br>

                <label id="cijena" for="cijena">Cijena listića:</label>
                <input type="number" id="cijena" name="cijena" value="<?php
                if (isset($_GET['azuriraj'])) {
                    echo $cijenaAzur;
                } else {
                    echo "";
                }
                ?>"><br>

                <label id="od" for="od">Početak:</label>
                <input type="text" id="od" name="od" value="<?php
                if (isset($_GET['azuriraj'])) {
                    echo $datumOdAzur;
                } else {
                    echo "";
                }
                ?>"><br>

                <label id="do" for="do">Završetak: </label>
                <input type="text" id="do" name="do" value="<?php
                if (isset($_GET['azuriraj'])) {
                    echo $datumDoAzur;
                } else {
                    echo "";
                }
                ?>"><br>

                <label id="fond" for="fond">Fond dobitka:</label>
                <input type="number" id="fond" name="fond" value="<?php
                if (isset($_GET['azuriraj'])) {
                    echo $fondAzur;
                } else {
                    echo "";
                }
                ?>"><br><br>


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
