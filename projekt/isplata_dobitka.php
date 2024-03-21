<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL ^ E_NOTICE);

$direktorij = getcwd();
$putanja = dirname($_SERVER['REQUEST_URI']);

include_once 'zaglavlje.php';

$veza = new Baza();
$veza->spojiDB();

if (!isset($_SESSION["uloga"])) {
    header("Location: obrasci/prijava.php");
    exit();
}

if (isset($_SESSION['uloga']) && ($_SESSION['uloga']) < 3) {
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


$upitPostavi = "SELECT Listić.id, Igra_na_srecu.naziv, Kolo.id, Listić.status, Igra_na_srecu.fond_dobitka"
        . "  FROM Zahtjev_za_isplatom, Igra_na_srecu, Kolo, Listić, Korisnik WHERE Kolo.id = Listić.Kolo_id AND Listić.Korisnik_id = Korisnik.id"
        . " AND Listić.Igra_na_srecu_id = Igra_na_srecu.id AND Zahtjev_za_isplatom.Listić_id = Listić.id GROUP BY 2, 3, 1, 4, 5";

$veza->zatvoriDB();

?>
<!DOCTYPE html>
<html lang="hr">
    <head>
        <title>Isplata</title>
        <meta charset="utf-8">
        <meta name="author" content="Patricio Poldrugac">
        <meta name="description" content="14.3.2022.">
        <link href="css/ppoldruga.css" rel="stylesheet" type="text/css">
    </head>
    <body id="vrh">
        <header>
            <h1 class="naslov">Potvrđivanje zahtjeva za isplatom</h1>
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
   
        <div id="okoTablice">
        <table id="tablica">
            <thead class="zaglavlje">
                <tr>
                    <th>Listić Id</th>
                    <th>Igra na sreću</th>
                    <th>Kolo Id</th>
                    <th>Status listića</th>
                    <th>Fond dobitka</th>
            </thead>
            <tbody>
                <?php
                
                $veza = new Baza();
                $veza->spojiDB();
                
                //$upit = $upitPostavi;
                
                $rezultat = $veza->selectDB($upitPostavi);
                
                while ($red = mysqli_fetch_array($rezultat)) {
                    ?>
                    <tr>
                        <td><?php echo $red[0] ?></td>
                        <td><?php echo $red[1] ?></td>
                        <td><?php echo $red[2] ?></td> 
                        <td><?php echo $red[3] ?></td>
                        <td><?php echo $red[4] ?></td> 
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