<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL ^ E_NOTICE);

$direktorij = dirname(getcwd());
include_once "$direktorij/klase/baza.class.php";

$veza = new Baza();
$veza->spojiDB();

$upitPopuniKorisnike = "SELECT korisnicko_ime, lozinka FROM Korisnik";
$rezultatUpitaPopuniKorisnike = $veza->selectDB($upitPopuniKorisnike);

?>

<!DOCTYPE html>
<html lang="hr">
    <head>
        <link href="../css/ppoldruga.css" rel="stylesheet" type="text/css">
    </head>
    <table id="tablica">
        <thead class="zaglavlje">
            <tr>
                <th>Korisničko ime</th>
                <th>Lozinka</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($data = mysqli_fetch_array($rezultatUpitaPopuniKorisnike)) {
                ?>
                <tr>
                    <td><?php echo $data["korisnicko_ime"] ?></td><
                    <td><?php echo $data["lozinka"] ?></td>
                </tr>
                <?php
            }
            ?>   
        </tbody>
        <tfoot>
        </tfoot>
    </table>
</html>
