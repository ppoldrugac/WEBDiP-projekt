# WEBDiP-projekt

## Opis projektnog zadatka
U sklopu kolegija "Web dizajn i programiranje" bilo je potrebno izraditi web stranicu. Tema moje grupe bila je "Igra na sreću". Cilj ovog projekta je kreiranje, upravljanje i isplata dobitaka igara na sreću. Postoje 4 vrste uloga, a to su: neregistrirani korisnik, registrirani korisnik, moderator i administrator. Svaka uloga obilježava različite funkcionalnosti. Korisnici imaju opciju prijave i odjave s web stranice. Administratori imaju najveće ovlasti te oni kreiraju lutrije i dodjeljuju im moderatora. Također, kreiraju igre na sreću. Moderatori pridružuju igre na sreću za lutrije u kojima je dodijeljen te kreira kola. Registrirani korisnici uz pomoć generatora slučajnih brojeva mogu ispisati brojeve za igru na sreću. Neregistrirani korisnici imaju najmanje ovlasti te oni mogu vidjeti rang listu korisnika prema isplaćenim dobicima i galeriju slika ispunjenih listića.

## Opis projektnog rješenja
Na početnoj stranici korisnik se ima pravo prijaviti te ovisno o svojoj ulogi ima opcije kojima može pristupiti. Korisnik kada se ne prijavi smatra se kao neregistrirani korisnik te ima dvije opcije: pregleda rang liste isplaćenih dobitaka u nekom vremenskom razdoblju i pregled galerija slika ispunjenih listića uz mogućnost sortiranja po kolu ili ukupnom fondu uplaćenih listića te filtriranja po lutriji. Ukoliko je prijavljen registrirani korisnik, tada on može odigrati igru na sreću, tj. generirat će sebi slučajne brojeve za tu igru. Moderatori kreiraju/pregledavaju/ažuriraju igre na sreću za lutrije kojima je dodijeljen. Isto tako, kreira/pregledava/ažurira kola za određenu igru na sreću. Administrator ima najveće ovlasti te ima funkcionalnosti prethodno opisanih uloga uz dodatak kreiranja/pregledavanja/ažuriranja lutrija te kreiranja/pregledavanja/ažuriranja igri na sreću.

## Tehnologije i oprema
- Javascript - validacija na strani klijenta
- JQuery - provjera putem ajaxa
- PHP - rad s bazom, provjera zahtjeva POST i GET metodama
- Filezilla - alat za prijenos datoteka na server
- phpMyAdmin - unos podataka u tablice baze podataka i izrada potrebnih upita
- MySQL Workbench - alat u kojem je izrađena baza podataka (ERA model)
- Netbeans IDE - alat u kojem je napravljen projekt
- Terminal - web server pomoću kojeg je testirano programsko rješnje
