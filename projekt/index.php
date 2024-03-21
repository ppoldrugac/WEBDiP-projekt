<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL ^ E_NOTICE);
$direktorij = getcwd();
$putanja = dirname($_SERVER['REQUEST_URI']);
$putanja2 = $_SERVER["SERVER_NAME"];
$putanja3 = $_SERVER['REQUEST_URI'];
$adresa = $putanja2 . $putanja3;

include "zaglavlje.php";

if (!strpos($_SERVER['REQUEST_URI'], 'index.php') !== false) {
    header("Location: index.php");
    exit();
}

/*preusmjeriNaHttps();

function preusmjeriNAHttps() {
    if ($_SERVER['HTTPS'] != 'on') {
        $novaPutanja = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        header("Location:$novaPutanja");
    }
}*/

//if (!isset($_SESSION['korisnik'])) {
    //if (!isset($_COOKIE['uvjeti_koristenja'])) {
        //header("Location: uvjetiKoristenja.php");
        //exit();
    //}
//}

if (isset($_COOKIE)) {

    if (isset($_GET['obrisi']) && $_GET['obrisi'] == "da") {

        $korisnikid = $_SESSION["korisnik"];
        $datumvrijeme = date("Y-m-d H:i:s");

        $veza = new Baza();
        $veza->spojiDB();

        $upit = "INSERT INTO `Dnevnik_rada` (`id`, `tip_radnje_id`, `Korisnik_id`, `opis_radnje`, `vrijeme`, `upit`) VALUES (NULL, '2', '$korisnikid', 'Odjava korisnika iz sustava.', '$datumvrijeme', NULL)";

        $rezultat = $veza->selectDB($upit);

        $veza->zatvoriDB();

        setcookie("autenticiran", "", time() - 3600, "/");
        unset($_COOKIE['autenticiran']);
        Sesija::obrisiSesiju();
    }
}
?>
<!DOCTYPE html>
<html lang="hr">
    <head>
        <title>Početna stranica</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Patricio Poldrugac">
        <meta name="description" content="14.3.2022.">
        <link href="css/ppoldruga.css" rel="stylesheet" type="text/css">
    </head>
    <body id="vrh">
        <header>
            <h1 class="naslov">Početna stranica</h1>
<?php ?>
            <a href="index.php">
                <img src="materijali/lutrijalogo.png" alt="Logo" class="logo"></a> 
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
        </header>
        <section id="sadrzaj">
            <div class="pozadinaslika">
                <div class="slideshow">
                    <img src="materijali/loto3.png" alt="Auti u ponudi"/> 
                    <img src="materijali/loto2.png" alt="Preuzmanje ključeva"/> 
                    <img src="materijali/loto1.png" alt="Vozi i uživaj"/> 
                </div>
            </div>
        </section>    
        <footer class="podnozje">
            <a class="linkzafooter"
               href="http://validator.w3.org/check?uri=http://barka.foi.hr/WebDiP/2021/zadaca_01/ppoldruga/index.html"><img src="materijali/HTML5.png" alt="html icon"></a>
            <a class="linkzafooter"
               href="https://jigsaw.w3.org/css-validator/validator?uri=http://barka.foi.hr/WebDiP/2021/zadaca_01/ppoldruga/css/ppoldruga.css"><img src="materijali/CSS3.png" alt="css icon"></a>
            <address>Kontakt: 
                <a style="color: white;" href="mailto:ppoldruga@foi.hr">
                    <b>Patricio Poldrugač</b></a></address>
            <p>&copy; 2022 P.Poldrugač</p>
        </footer>
    </body>
</html>

