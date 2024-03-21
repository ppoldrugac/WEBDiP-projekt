<?php

include_once "../klase/baza.class.php";

$korime = $_GET['korIme'];

$baza = new Baza();
$baza->spojiDB();

$upitDohvatiSveKorisnike = "SELECT * FROM `Korisnik`";
$rezultatUpitaZaDohvatSvihKorisnika = $baza->selectDB($upitDohvatiSveKorisnike)->fetch_all(MYSQLI_ASSOC);

$pronadjen = false;
foreach ($rezultatUpitaZaDohvatSvihKorisnika as $red) {
    if ($red['korisnicko_ime'] == $korime) {
        $pronadjen = true;
    }
}

$baza->zatvoriDB();

if ($pronadjen == true) {
    echo json_encode('postoji');
} else {
    echo json_encode('ne postoji');
}

