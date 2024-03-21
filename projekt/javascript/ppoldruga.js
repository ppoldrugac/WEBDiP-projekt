window.addEventListener("load", registracija);

var poruka = "";

function registracija() {
    document.getElementById("btn2").addEventListener("click", function () {

        provjeriMaloljetan();
        provjeriIme();
        provjeriPrezime();
        provjeriKorIme();
        provjeriEmail();
        provjeriLozinku();
        usporediLozinke();

        if (poruka !== "") {
            event.preventDefault();
            alert(poruka);
            poruka = "";
        }

    });
}

function provjeriMaloljetan() {
    var datumRodenja = document.getElementById("godRod").value;
    var splitano = datumRodenja.split("-");
    var godina = splitano[0];
    var trenutnaGodina = new Date().getFullYear();

    if ((trenutnaGodina - godina) < 18) {
        poruka += "Ne možete se registrirati na stranicu jer nemate 18 godina! \n";
    }

}

function provjeriIme() {
    var ime = document.getElementById("ime").value;
    var prvoSlovo = ime.charAt(0);

    if (prvoSlovo !== prvoSlovo.toUpperCase()) {
        poruka += "Ime mora započeti velikim početnim slovom! \n";
    }

}

function provjeriPrezime() {
    var prezime = document.getElementById("prezime").value;
    var prvoSlovo2 = prezime.charAt(0);

    if (prvoSlovo2 !== prvoSlovo2.toUpperCase()) {
        poruka += "Prezime mora započeti velikim početnim slovom! \n";
    }
}

function provjeriKorIme() {
    var korisnickoIme = document.getElementById("korIme").value;
    if (korisnickoIme.length <= 5 || korisnickoIme.length >= 25) {
        poruka += "Korisničko ime mora imati najmanje 5, a najviše 25 znakova! \n";
    }
}

function provjeriEmail() {
    var email = document.getElementById("email").value;
    var indeksEt;
    var indeksT;
    for (var i = 0; i < email.length; i++) {
        if (email[i] === "@") {
            indeksEt = i;
        }
        if (email[i] === ".") {
            indeksT = i;
        }
    }
    if (indeksEt > 0 && indeksT > 0 && indeksT > indeksEt) {
        return true;
    }else {
        poruka += "Email je neispravan. Mora sadržavati znak '@' i znak '.' te tekst prije i poslije tih znakova! \n";
    }
}

function provjeriLozinku(){
    var lozinka = document.getElementById("lozinka").value;
    if (lozinka.length < 8 || lozinka.length > 45){
        poruka += "Lozinka je krivog formata! Mora sadržavati više od 8, a manje od 45 znakova! \n";
    }
}

function usporediLozinke (){
    var lozinka = document.getElementById("lozinka").value;
    var lozinka2 = document.getElementById("potvrdaLozinke").value;
    
    if (lozinka !== lozinka2){
        poruka += "Orginalna i ponovljena lozinka se ne poklapaju. Unesite ih ponovo! \n";
    }
}