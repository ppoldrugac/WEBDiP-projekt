<?php

function GenerirajLozinku(){
    
    $sviZnakovi = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ1234567890";
    $novaLozinka = "";
    $duljina = strlen($sviZnakovi);
    
    for($i = 1; $i <= 10; $i++){
        $novaLozinka .= $sviZnakovi[rand(0, $duljina-1)];
    }
    
    $novaLozinkaSHA = hash("SHA256", $novaLozinka);
    
    return array($novaLozinka, $novaLozinkaSHA);
}

function GenerirajAktivacijskiKod(){
    $sviZnakovi = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ1234567890";
    $kod = "";
    $duljina = strlen($sviZnakovi);
    
    for($i = 1; $i <=6; $i++){
        $kod .= $sviZnakovi[rand(0, $duljina-1)];
    }
    
    return $kod;
}

?>

