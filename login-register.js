function autentifikacija() {
    var korisnicko_ime = document.getElementById("korisnicko_ime").value;
    var lozinka = document.getElementById("lozinka").value;
    if (korisnicko_ime == "test1" && lozinka == "loz1") {
        window.location.assign("materijalihub.html");
        alert("Prijavljeni ste.");
    }
    else {
        alert("Neuspjesna prijava");
        return;
    }
}