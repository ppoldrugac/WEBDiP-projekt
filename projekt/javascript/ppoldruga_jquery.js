$(document).ready(function () {
    naslov = $(document).find("title").text();
    console.log(naslov);
    switch (naslov) {
        case "Registracija":
            $("#korIme").keyup(function (event) {
                korIme = $("#korIme").val();
                if (korIme != "") {
                    $.ajax({
                        url: "../json/provjera_kor_ime.php",
                        dataType: "JSON",
                        type: "GET",
                        data: {"korIme": korIme},
                        success: function (rez) {
                            if (rez == "postoji") {
                                document.getElementById("korIme").style.border = "3px solid red";
                                alert("Korisničko ime je već zauzeto!");
                            } else if (rez == "ne postoji") {
                                document.getElementById("korIme").style.border = "3px solid green";
                            }
                        }
                    });
                }
            });
            break;
        default:
            alert("Stranica ne postoji!");
            break;
    }
});

