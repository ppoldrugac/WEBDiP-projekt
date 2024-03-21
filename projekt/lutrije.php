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
    if ($_GET['idLutrije'] == "") {
        $nazivLut = $_GET['naziv'];
        $kapitalLut = $_GET['kapital'];
        $moderatorLut = $_GET['moderator'];

        $upitZaDodavanjeLutrije = "INSERT INTO `Lutrija` (`id`, `naziv`, `temeljni_kapital`) VALUES (NULL, '$nazivLut', '$kapitalLut') ";
        $rezultatUpitaZaDodavanjeLutrije = $veza->selectDB($upitZaDodavanjeLutrije);

        $upitZaDohvatIdDodaneLutirje = "SELECT id FROM Lutrija WHERE naziv LIKE '$nazivLut%'";
        $rezultatUpitaZaDohvatIdDodaneLutrije = $veza->selectDB($upitZaDohvatIdDodaneLutirje);
        $sve = mysqli_fetch_array($rezultatUpitaZaDohvatIdDodaneLutrije);
        $idNoveLutrije = $sve[0];

        $upitZaPovezatModeratora = "INSERT INTO `moderatori_lutrija` (`Korisnik_id`, `Lutrija_id`) VALUES ('$moderatorLut', '$idNoveLutrije') ";
        $rezultatUpitaZaPovezatModeratora = $veza->selectDB($upitZaPovezatModeratora);
    } else {
        $poruka = "Za dodavanje lutrije polje Id mora ostati prazno!";
    }
}

if (isset($_GET['gumbAzuriraj'])) {
    $idLut = $_GET['idLutrije'];
    $nazivNovi = $_GET['naziv'];
    $kapitalNovi = $_GET['kapital'];
    $moderatorNovi = $_GET['moderator'];
    if ($idLut != "" && $nazivNovi != "" && $kapitalNovi != "" && $moderatorNovi == "") {
        $upitZaAzuriranje = "UPDATE Lutrija SET naziv = '$nazivNovi', temeljni_kapital = '$kapitalNovi' WHERE Lutrija.id = '$idLut'";
        $veza->updateDB($upitZaAzuriranje);
    } else {
        $poruka = "Za ažuriranje lutrije moderatora ostavite prazno";
    }
}

//OVO SU UPITI KOJI BI PRILIKOM AZURIRANJA LUTRIJE RADILI I AUTOMATSKO AZURIRANJE MODERATORA LUTRIJA, RADILI SU NA PHPMYADMINU ALi MI NIJE IMALO
// TO TU SMISLA ZATO STO JE PREVISE STVARI NA JEDNOJ FORMI IONAKO


/* $upitStariKorisnik = "SELECT Korisnik.id FROM Korisnik, moderatori_lutrija, Lutrija"
  . " WHERE Korisnik.id = moderatori_lutrija.Korisnik_id AND moderatori_lutrija.Lutrija_id = Lutrija.id AND Lutrija.id = '2'";
  $rezultatUpitaStariKorisnik = $veza->selectDB($upitStariKorisnik);
  $sve = mysqli_fetch_array($rezultatUpitaStariKorisnik);
  $idStariKorisnik = $sve[0];

  $upitZaAzuriranje2 = "UPDATE `moderatori_lutrija` SET `Korisnik_id` = '$moderatorNovi' "
  . "WHERE `moderatori_lutrija`.`Korisnik_id` = 1 AND `moderatori_lutrija`.`Lutrija_id` = '$idStariKorisnik'";
  $veza->updateDB($upitZaAzuriranje2); */



$upit = "SELECT Lutrija.id, Lutrija.naziv, Lutrija.temeljni_kapital, CONCAT (Korisnik.ime, ' ', Korisnik.prezime) "
        . "FROM Lutrija, Korisnik, moderatori_lutrija WHERE Korisnik.id = moderatori_lutrija.Korisnik_id AND Lutrija.id = moderatori_lutrija.Lutrija_id";

$rezultat = $veza->selectDB($upit);

$upitModerator = "SELECT Korisnik.id, CONCAT (Korisnik.ime, ' ', Korisnik.prezime) FROM Korisnik, tip_korisnika"
        . " WHERE Korisnik.tip_korisnika_id = tip_korisnika.id AND tip_korisnika.naziv LIKE 'moderator%'";

$rezultatModerator = $veza->selectDB($upitModerator);

$veza->zatvoriDB();
?>
<!DOCTYPE html>
<html lang="hr">
    <head>
        <title>Upravljanje lutrijama</title>
        <meta charset="utf-8">
        <meta name="author" content="Patricio Poldrugac">
        <meta name="description" content="14.3.2022.">
        <link href="css/ppoldruga.css" rel="stylesheet" type="text/css">
    </head>
    <body id="vrh">
        <header>
            <h1 class="naslov">Upravljanje lutrijama</h1>
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
        <form novalidate id="formLutrije" method="get" name="formLutrije" action="lutrije.php">       
            <div id="okoTablice">
                <table id="tablica">
                    <caption style="padding: 20px; color: #004654; font-weight: bold; font-size: 30px;">Popis lutrija s dodjeljenim moderatorima</caption>
                    <thead class="zaglavlje">
                        <tr>
                            <th>Id</th>
                            <th>Naziv</th>
                            <th>Temeljni kapital</th>
                            <th>Moderator</th>
                            <th>Ažuriraj</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($red = mysqli_fetch_array($rezultat)) {
                            ?>
                            <tr>
                                <td><?php echo $red[0] ?></td>
                                <td><?php echo $red[1] ?></td>
                                <td><?php echo $red[2] ?></td>
                                <td><?php echo $red[3] ?></td>
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

        <div class="containerProjekt2">
            <form novalidate id="formProjekt" method="get" name="formLutrijeAzuriraj" action="lutrije.php">
                <p style="text-align: center; padding: 5px; color: #004654; font-weight: bold; font-size: 20px;">Dodavanje/Ažuriranje lutrije</p>
                <label id="idLutrije" for="idLutrije">Id:</label>
                <input type="text" id="idLutrije" name="idLutrije" value="<?php
                        if (isset($_GET['azuriraj'])) {
                            echo $idLutrije;
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
                <label id="kapital" for="kapital">Kapital:</label>
                <input type="number" id="kapital" name="kapital" value="<?php
                if (isset($_GET['azuriraj'])) {
                    echo $kapitalAzur;
                } else {
                    echo "";
                }
                        ?>"><br>
                <label id="moderator" for="moderator">Moderator:</label>
                <select name = "moderator" id = "moderator">
                    <option value="" style="text-align: center;">---Odaberite---</option>
                    <?php
                    while ($red = mysqli_fetch_array($rezultatModerator)) {

                        echo "<option value ='$red[0]'>$red[1]</option>";
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
