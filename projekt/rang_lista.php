<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL ^ E_NOTICE);

$direktorij = getcwd();
$putanja = dirname($_SERVER['REQUEST_URI']);

include_once 'zaglavlje.php';

$veza = new Baza();
$veza->spojiDB();

$upitIgre = "SELECT DISTINCT naziv FROM `Igra_na_srecu`";
$rezultatUpitaIgreNaSrecu = $veza->selectDB($upitIgre);

if(isset(($_GET['Filtriraj']))){
    
    $datumOd = $_GET['od'];
    $datumDo = $_GET['do'];
    $odabranOd = date("Y-m-d H:i:s", strtotime($datumOd));
    $odabranDo = date("Y-m-d H:i:s", strtotime($datumDo));
    
    $odabranaIgra = $_GET['igra'];
    
    
    if($datumOd != "" && $datumDo != "" && $odabranaIgra != ""){
        
        $upitPostavi = "SELECT Korisnik.ime, Korisnik.prezime, Igra_na_srecu.fond_dobitka, Igra_na_srecu.naziv FROM Listić, Kolo, Korisnik, Igra_na_srecu"
                . " WHERE Kolo.datum_i_vrijeme_isplate BETWEEN '$odabranOd' AND '$odabranDo' AND Igra_na_srecu.id = Kolo.Igra_na_srecu_id"
                . " AND Listić.status = 'isplaćen' AND Listić.Kolo_id = Kolo.id AND Korisnik.id = Listić.Korisnik_id AND Igra_na_srecu.naziv LIKE '$odabranaIgra%'";
    }
    
}else{
    $upitPostavi = "SELECT Korisnik.ime, Korisnik.prezime, Igra_na_srecu.fond_dobitka, Igra_na_srecu.naziv FROM Listić, Kolo, Korisnik, Igra_na_srecu"
            . " WHERE Igra_na_srecu.id = Kolo.Igra_na_srecu_id AND Listić.status = 'isplaćen' AND Listić.Kolo_id = Kolo.id AND Korisnik.id = Listić.Korisnik_id";
}



?>
<!DOCTYPE html>
<html lang="hr">
    <head>
        <title>Rang lista prema isplaćenim dobicima</title>
        <meta charset="utf-8">
        <meta name="author" content="Patricio Poldrugac">
        <meta name="description" content="14.3.2022.">
        <link href="css/ppoldruga.css" rel="stylesheet" type="text/css">
    </head>
    <body id="vrh">
        <header>
            <h1 class="naslov">Rang lista prema isplaćenim dobicima</h1>
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
            <form novalidate id="formProjekt" method="get" name="formProjekt" action="rang_lista.php">
                <label id="od" for="od">Od:</label>
                <input type="text" id="od" name="od"><br>
                <label id="do" for="do">Do: </label>
                <input type="text" id="do" name="do"><br>
                <label id="igra" for="igra">Igra na sreću:</label>
                <select name = "igra" id = "igra">
                    <option value="prazno" style="text-align: center;">---Odaberite---</option>
                    <?php
                    while ($red = mysqli_fetch_array($rezultatUpitaIgreNaSrecu)) {

                        echo "<option value ='$red[0]'>$red[0]</option>";
                    }
                    $veza->zatvoriDB();
                    ?>
                </select>
                <input name="Filtriraj" id="btnFiltriraj" type="submit" style="margin-left: 250px; margin-bottom: 10px;" value="Filtriraj"><br>
            </form>
        </div>
        
        <div id="okoTablice">
        <table id="tablica">
            <thead class="zaglavlje">
                <tr>
                    <th>Ime</th>
                    <th>Prezime</th>
                    <th>Dobitak</th>
                    <th>Igra</th>
                </tr>
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
