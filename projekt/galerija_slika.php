<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL ^ E_NOTICE);

$direktorij = getcwd();
$putanja = dirname($_SERVER['REQUEST_URI']);

include_once 'zaglavlje.php';

$veza = new Baza();
$veza->spojiDB();


$upitLutrije = "SELECT * FROM `Lutrija`";
$rezultatLutrije = $veza->selectDB($upitLutrije);

$veza->zatvoriDB();

if(isset(($_GET['Filtriraj']))){
    
    $odabranaLutrija = $_GET['lutrija'];

    
    if($odabranaLutrija){
        
        $upitPostavi = "SELECT Igra_na_srecu.naziv, Lutrija.naziv, Kolo.id, Listić.slika, Igra_na_srecu.fond_dobitka FROM Igra_na_srecu, Lutrija, Kolo, Listić"
                . " WHERE Igra_na_srecu.id = Listić.Igra_na_srecu_id AND Lutrija.id = Listić.Lutrija_id AND Listić.status = 'uplacen' AND Kolo.otvoreno = 1 AND"
                . " Kolo.id = Listić.Kolo_id AND Lutrija.id = '$odabranaLutrija'";
    }
    
}elseif (isset($_GET['sortKolo'])) {
        
        $upitPostavi = "SELECT Igra_na_srecu.naziv, Lutrija.naziv, Kolo.id, Listić.slika, Igra_na_srecu.fond_dobitka FROM Igra_na_srecu, Lutrija, Kolo, Listić"
                . " WHERE Igra_na_srecu.id = Listić.Igra_na_srecu_id AND Lutrija.id = Listić.Lutrija_id AND Listić.status = 'uplacen' AND Kolo.otvoreno = 1 AND"
                . " Kolo.id = Listić.Kolo_id ORDER BY Kolo.id";
   
}elseif (isset($_GET['sortFond'])) {
        
        $upitPostavi = "SELECT Igra_na_srecu.naziv, Lutrija.naziv, Kolo.id, Listić.slika, Igra_na_srecu.fond_dobitka FROM Igra_na_srecu, Lutrija, Kolo, Listić"
                . " WHERE Igra_na_srecu.id = Listić.Igra_na_srecu_id AND Lutrija.id = Listić.Lutrija_id AND Listić.status = 'uplacen' AND Kolo.otvoreno = 1"
                . " AND Kolo.id = Listić.Kolo_id ORDER BY 5";
}

else{
    $upitPostavi = "SELECT Igra_na_srecu.naziv, Lutrija.naziv, Kolo.id, Listić.slika, Igra_na_srecu.fond_dobitka FROM Igra_na_srecu, Lutrija, Kolo, Listić"
            . " WHERE Igra_na_srecu.id = Listić.Igra_na_srecu_id AND Lutrija.id = Listić.Lutrija_id AND Listić.status = 'uplacen' AND Kolo.otvoreno = 1 AND Kolo.id = Listić.Kolo_id";
}



?>
<!DOCTYPE html>
<html lang="hr">
    <head>
        <title>Galerija</title>
        <meta charset="utf-8">
        <meta name="author" content="Patricio Poldrugac">
        <meta name="description" content="14.3.2022.">
        <link href="css/ppoldruga.css" rel="stylesheet" type="text/css">
    </head>
    <body id="vrh">
        <header>
            <h1 class="naslov">Galerija slika</h1>
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
        <div class="containerProjekt" style="height: 420px;">
            <form novalidate id="formProjekt" method="get" name="formProjekt" action="galerija_slika.php">
                <p style="font-weight: bold;">Sortiraj po:</p>
                
                <input name="sortKolo" id="btnFiltriraj" type="submit" style="margin-left: 250px; margin-bottom: 10px;" value="Kolo"><br>
                
                <input name="sortFond" id="btnFiltriraj" type="submit" style="margin-left: 250px; margin-bottom: 10px;" value="Ukupan fond uplaćenih listića"><br>
                
                
                <p style="font-weight: bold;">Filtriraj po:</p>
                  
                <label id="lutrija" for="lutrija">Lutrija:</label>
                <select name = "lutrija" id = "lutrija">
                    <option style="text-align: center;" value="prazno">---Odaberite---</option>
                    <?php
                    while ($red = mysqli_fetch_array($rezultatLutrije)) {

                        echo "<option value ='$red[0]'>$red[1]</option>";
                    }
                    
                    ?>
                </select>
                <input name="Filtriraj" id="btnFiltriraj" type="submit" style="margin-left: 250px; margin-bottom: 10px;" value="Filtriraj"><br>
            </form>
        </div>
        
        <div id="okoTablice">
        <table id="tablica">
            <caption style="padding: 20px;">Galerija slika ispunjenih listića otvorenih igra na sreću</caption>
            <thead class="zaglavlje">
                <tr>
                    <th>Igra na sreću</th>
                    <th>Lutrija</th>
                    <th>Kolo</th>
                    <th>Slika listića</th>
                    <th>Ukupan fond uplaćenih listića</th>
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
                        <td><img src="materijali/<?php echo $red[3]?>"></td>
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
