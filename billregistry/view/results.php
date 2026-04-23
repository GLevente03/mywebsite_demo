<?php
session_start();
$results = $_SESSION["results"];

if(isset($_SESSION["results"])){
?>
    <section>
        <p>Számla azonosítószáma</p>
        <p>Összeg</p>
        <p>Befizetés dátuma</p>
        <p>Regisztrálás dátuma</p>
        <p>Szolgáltató neve</p>
        <p>Megjegyzés</p>
    </section>
<?php
}
?>