<link href="css/ppoldruga.css" rel="stylesheet" type="text/css">
<?php

if(empty($_SESSION["uloga"])){
    echo "<li><a class='menu__tekst' href=\"$putanja/obrasci/prijava.php\">Prijava</a></li>";
    echo "<li><a class='menu__tekst' href=\"$putanja/obrasci/registracija.php\">Registracija</a></li>";
    
}

echo "
        <li><a class='menu__tekst' href=\"$putanja/rang_lista.php\">Rang lista</a></li>
        <li><a class='menu__tekst' href=\"$putanja/galerija_slika.php\">Galerija slika</a></li>
        <li><a class='menu__tekst' href=\"$putanja/index.php\">Početna stranica</a></li>
        <li><a class='menu__tekst' href=\"$putanja/dokumentacija.html\">Dokumentacija</a></li>
        <li><a class='menu__tekst' href=\"$putanja/o_autoru.html\">O autoru</a></li>
      ";
if (isset($_SESSION["uloga"]) && $_SESSION["uloga"] >= 2) {
    echo "<li><a class='menu__tekst' href=\"$putanja/generator_reg.php\">Generator</a></li>";
    echo "<li><a class='menu__tekst' href=\"$putanja/listici.php\">Uplaćeni listići</a></li>";
}

if (isset($_SESSION["uloga"]) && $_SESSION["uloga"] == 3) {
    echo "<li><a class='menu__tekst' href=\"$putanja/igre_moderator.php\">Igre</a></li>";
    echo "<li><a class='menu__tekst' href=\"$putanja/kolo.php\">Kola</a></li>";

}

if (isset($_SESSION["uloga"]) && $_SESSION["uloga"] >= 3) {
    echo "<li><a class='menu__tekst' href=\"$putanja/isplata_dobitka.php\">Isplata dobitka</a></li>";

}

if (isset($_SESSION["uloga"]) && $_SESSION["uloga"] == 4) {
    echo "<li><a class='menu__tekst' href=\"$putanja/blokiranje_odblokiranje.php\">Popis blokiranih korisnika</a></li>";
    echo "<li><a class='menu__tekst' href=\"$putanja/konfiguracija_sustava.php\">Konfiguracija sustava</a></li>";
    echo "<li><a class='menu__tekst' href=\"$putanja/dnevnik.php\">Dnevnik</a></li>";
    echo "<li><a class='menu__tekst' href=\"$putanja/lutrije.php\">Lutrije</a></li>";
    echo "<li><a class='menu__tekst' href=\"$putanja/igre.php\">Igre</a></li>";
}

if(isset($_SESSION["uloga"])){
    echo "<li><a class='menu__tekst' href=\"$putanja/index.php?obrisi=da\">Odjava</a></li>";
}
