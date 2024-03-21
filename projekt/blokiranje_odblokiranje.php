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

if (isset($_GET['blokiraj'])) {
    $idZaBlokiranje = $_GET['blokiraj'];
    $upitBlokiranje = "UPDATE `Korisnik` SET `blokiran`= 1  WHERE id = '$idZaBlokiranje'";
    $veza->updateDB($upitBlokiranje);
}

if (isset($_GET['odblokiraj'])) {
    $idOdBlokiranje = $_GET['odblokiraj'];
    $upitOdBlokiranje = "UPDATE `Korisnik` SET `blokiran`= 0  WHERE id = '$idOdBlokiranje'";
    $veza->updateDB($upitOdBlokiranje);
}

$upitBlokirani = "SELECT * FROM `Korisnik` WHERE Korisnik.blokiran = 1";
$rezultatUpitaBlokirani = $veza->selectDB($upitBlokirani);

$upitNeBlokirani = "SELECT * FROM `Korisnik` WHERE Korisnik.blokiran = 0";
$rezultatNeBlokirani = $veza->selectDB($upitNeBlokirani);

$veza->zatvoriDB();
?>
<!DOCTYPE html>
<html lang="hr">
    <head>
        <title>Pregled korisničkih računa</title>
        <meta charset="utf-8">
        <meta name="author" content="Patricio Poldrugac">
        <meta name="description" content="14.3.2022.">
        <link href="css/ppoldruga.css" rel="stylesheet" type="text/css">
    </head>
    <body id="vrh">
        <header>
            <h1 class="naslov">Upravljanje korisničkim računima</h1>
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
        <form novalidate id="formBlokirani" method="get" name="formBlokirani" action="blokiranje_odblokiranje.php">
            <div id="okoTablice">
                <table id="tablica">
                    <caption style="padding: 20px; color: #004654; font-weight: bold; font-size: 30px;">Popis blokiranih korisnika</caption>
                    <thead class="zaglavlje">
                        <tr>
                            <th>Id</th>
                            <th>Ime</th>
                            <th>Prezime</th>
                            <th>Korisničko ime</th>
                            <th>Datum rođenja</th>
                            <th>Email</th>
                            <th>Odblokiranje</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($red = mysqli_fetch_array($rezultatUpitaBlokirani)) {
                            ?>
                            <tr>
                                <td><?php echo $red[0] ?></td>
                                <td><?php echo $red[2] ?></td>
                                <td><?php echo $red[3] ?></td>
                                <td><?php echo $red[4] ?></td>
                                <td><?php echo $red[5] ?></td>
                                <td><?php echo $red[9] ?></td>
                                <td> <input name="odblokiraj" id="odblok" type="submit" value="<?php echo"$red[0]"; ?>"></td> 
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


        <form novalidate id="formNeBlokirani" method="get" name="formNeBlokirani" action="blokiranje_odblokiranje.php">
            <div id="okoTablice">
                <table id="tablica">
                    <caption style="padding: 20px; color: #004654; font-weight: bold; font-size: 30px;">Popis neblokiranih korisnika</caption>
                    <thead class="zaglavlje">
                        <tr>
                            <th>Id</th>
                            <th>Ime</th>
                            <th>Prezime</th>
                            <th>Korisničko ime</th>
                            <th>Datum rođenja</th>
                            <th>Email</th>
                            <th>Blokiranje</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($red = mysqli_fetch_array($rezultatNeBlokirani)) {
                            ?>
                            <tr>
                                <td><?php echo $red[0] ?></td>
                                <td><?php echo $red[2] ?></td>
                                <td><?php echo $red[3] ?></td>
                                <td><?php echo $red[4] ?></td>
                                <td><?php echo $red[5] ?></td>
                                <td><?php echo $red[9] ?></td>
                                <td> <input name="blokiraj" id="blok" type="submit" value="<?php echo"$red[0]"; ?>"></td> 
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
