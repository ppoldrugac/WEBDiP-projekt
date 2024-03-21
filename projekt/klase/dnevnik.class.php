<?php
class Dnevnik {
    
    private $nazivDatoteke = "izvorne_datoteke/dnevnik.log";
    
    public function setNazivDatoteke($nazivDatoteke) {
        $this->nazivDatoteke = $nazivDatoteke;
    }
        
    public function spremiDnevnik($tekst,$baza=false) {
        if($baza){
            $upit = "INSERT INTO `DZ4_dnevnik` (`id`, `apsolutna_putanja_skripte`, `datum_i_vrijeme_pristupa`, `uloga`, `korisnik`) VALUES (NULL, '', '', '', '')";
        } else {
            $f = fopen($this->nazivDatoteke,"a+");
            fwrite($f, date("d.m.Y. H:i:s").", ".$tekst."\n");
            fclose($f);
        }
    }
    
    public function citajDnevnik($baza=false){
        if($baza){
            //TODO spremi u bazu
        } else {
            return file($this->nazivDatoteke);
        }
    }
}
?>