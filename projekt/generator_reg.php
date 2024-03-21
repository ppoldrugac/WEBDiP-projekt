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

if (isset($_SESSION['uloga']) && ($_SESSION['uloga']) < 2) {
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

if (isset($_GET['generiraj'])) {
    if (isset($_GET['od']) && isset($_GET['do']) && isset($_GET['broj'])) {
        $prvi = $_GET['od'];
        $zadnji = $_GET['do'];
        $kolikoBrojeva = $_GET['broj'];
    }
}
?>
<!DOCTYPE html>
<html lang="hr">
    <head>
        <title>Generator brojeva</title>
        <meta charset="utf-8">
        <meta name="author" content="Patricio Poldrugac">
        <meta name="description" content="14.3.2022.">
        <link href="css/ppoldruga.css" rel="stylesheet" type="text/css">
    </head>
    <body id="vrh">
        <header>
            <h1 class="naslov">Generator brojeva</h1>
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
        <div class="containerProjekt">
            <form novalidate id="formProjekt" method="get" name="formProjekt" action="generator_reg.php">
                <label id="od" for="od">Početni broj:</label>
                <input type="number" id="od" name="od"><br>
                <label id="do" for="do">Završni broj: </label>
                <input type="text" id="do" name="do"><br>
                <label id="broj" for="broj">Koliko brojeva želite generirati:</label>
                <input type="number" id="broj" name="broj"><br>

                <input name="generiraj" id="btnFiltriraj" type="submit" style="margin-left: 250px; margin-bottom: 10px;" value="Generiraj"><br>
            </form>
        </div>

        <div id="okoTablice" style="margin-bottom: 20px; display: flex; justify-content: center;">
            <label id="generirano" for="generirano"></label>
            <input style=" text-align: center; color: #004654; font-size: 40px; font-weight: bold; width: 80%;" type="text" id="generirano" name="generirano" 
                   value="<?php
                   if (isset($_GET['generiraj'])) {
                       $brojevi = array();
                       for ($i = 0; $i< $kolikoBrojeva; $i++){
                           do{
                               $br = rand($prvi, $zadnji);
                           }while(in_array($br, $brojevi));
                           array_push($brojevi, $br);  
                       }
                       foreach ($brojevi as $b){
                           echo $b . "    ";
                       }
                   }else{
                       echo "";
                   }
                   ?>">

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
