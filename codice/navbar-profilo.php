<?php
if(!isset($_SESSION['id_utente'])){
    echo "sessione non impostata";
    exit();
}
$imgAvatar = $_SESSION['imgAvatar'];
?>
<div class="navbar">
    <div class="navbar__left">
        <a href="home.php">
            <img class="logo" src="../assets/icon/navbar/logo-senzasfondo.png" alt="logo: disegno di un lama affiancato dal titolo LAMa">
        </a>
    </div>
    <div class="navbar__right">
        <a href="cerca.php">
            Tutti i corsi
        </a>
        <a href="cerca.php" class="round">
            <img  class="cerca" src="../assets/icon/navbar/Cerca-senzasfondo.png" alt="icona bianca di una lente di ingrandimento stilizzato">
        </a>
        <a href="carrello.php" class="round">
            <img  class="carrello" src="../assets/icon/navbar/Carrello-senzasfondo.png" alt="icona bianca del carrello stilizzato">
        </a>
        <a href="imieicorsi.php">
            I miei corsi
        </a>
        <a href="esci.php">
            Esci
        </a>
        <a href="show_profile.php" class="profile">
            <img  class="profilo" src="../assets/icon/navbar/<?php echo $imgAvatar?>.png" alt="icona grafica stilizzata di una persona con i capelli castano il cappello nero e gli occhiali" height="300">
        </a>
    </div>
    
</div>