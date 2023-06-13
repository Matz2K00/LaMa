<?php
require 'sessionStart.php';
if(!isset($_SESSION['id_corso'])){
  echo "<p> Non ci sono video selezionati</p>";
  exit();
}
$id_corso = intval($_SESSION['id_corso']);
require 'db.php';
$conn = new mysqli($hostData, $userData, $paswData, $database);
$sql = "SELECT * FROM Corsi
        WHERE id = ? ";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_corso);

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $id = $row["id"];
    $titolo = $row["titolo"];
    $autore = $row["autore"];
    $descrizione = $row["descrizione"];
    $prezzo = $row["prezzo"];
    $valutazioneMedia = $row["valutazioneMedia"];
    // $link = $row["link"];
    // immagine
    $altImg = $row["altImg"];
    $urlImg = "../assets/img/corsi/".$id.".jpg";
  
  }
} else {
  echo "Non esiste il corso selezionato";
}
$stmt->close();
$conn->close();
?>  

<video poster='<?php echo $urlImg; ?>' width="50%" height="50%" controls>
  <source src="../assets/video.mp4" type="video/mp4">
  Your browser does not support the video tag.
</video>
<div class="video-info">
  <div class="video-info__left">
    <!-- <img src='<?php echo $urlImg; ?>' alt='<?php echo $altImg; ?>' height="300"> -->
    <h2><?php echo $titolo; ?></h2>
    <p><?php echo $autore; ?></p>
    <p><?php echo $descrizione; ?></p>
  </div>
  <div class="video-info__right">
    <div class="valutazione">
      <p>E' stato valutato</p>
      <div> 
          <?php //stelline
          if ($valutazioneMedia !== NULL && $valutazioneMedia >= 0 && $valutazioneMedia < 6) {
            $gialla = $valutazioneMedia;
            $grigia = 5-$valutazioneMedia;
            // togliere height="30"
            for ($i = 0; $i < $gialla; $i++) { echo '<img src="../assets/icon/star/gialla.svg" alt="stella gialla" height="30">'; }
            for ($i = 0; $i < $grigia; $i++) { echo '<img src="../assets/icon/star/grigia.svg" alt="stella grigia" height="30">'; }
          }
          if ($valutazioneMedia === NULL) {
            for ($i = 0; $i < 5; $i++) { echo '<img src="../assets/icon/star/grigia.svg" alt="stella grigia" height="30">'; }
          }
          ?>
      </div>
    </div>

    <div class="prezzo">
      <p><?php echo $prezzo." €"; ?></p>
      <p>Disponibilità immediata</p>
      <p>Il corso sarà disponibile<br>in <b>I miei corsi</b><br>Non ha una scadenza</p>
      <p>Potrai guardarlo più volte<br>nell'ordine che preferisci</p>

      <?php 
      include 'cookie.php';
      if (in_array($id, $corsi)) {
        
        echo '<button class="carrelloBtn">Aggiunto al carrello</button>';
      } else {
        echo '<button class="carrelloBtn" id="aggiungiAlCarrello" onclick="showCheck()">Aggiungi al carrello</button>';
      }
      ?>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
      <script>
      $(document).ready(function() {
          $("#aggiungiAlCarrello").click(function() {
            var id_corso = parseInt(<?php echo intval($id_corso);?>);
              $.ajax({
                  url: "aggiungiAlCarrello.php", 
                  type: "POST",
                  data: { id_corso: id_corso }, 
                  success: function(response) {
                    setTimeout(function() {
                      location.reload();
                    }, 60000); // Ritardo di 1 minuto
                  }
              });
          });
      });
      function showCheck() {
        var button = document.getElementById("aggiungiAlCarrello");
        button.innerHTML = '<i class="fas fa-check"></i>';
      }
      </script>

      <?php // attenzione solo se schiacci il pulsante
        $_SESSION['id_corso'] = $id_corso;
        if(!isset($_SESSION['id_utente'])){
        // $nome = 'acquistaOra';
        // $acquisti = true;
        // $scadenza = time() + 60;
        // setcookie($nome, $acquisti, time() + 60, '/'); // un minuto
        echo '<button class="primaAccedi acquistaBtn">Acquista ora</button> ';
      ?>
        <script>
          document.addEventListener('DOMContentLoaded', function() {
            var button = document.querySelector('.primaAccedi');
            var nome = 'acquistaOra';
            var acquisti = true;
            var scadenza = new Date();
            scadenza.setTime(scadenza.getTime() + 30 * 1000);
            var scadenzaString = scadenza.toUTCString();
            button.addEventListener('click', function() {
              document.cookie = nome + "=" + acquisti + "; expires=" + scadenzaString + "; path=/";
              window.location.href = 'accesso.php';
            });
          });
        </script>
      <?php
      } else {
        echo '<button class="acquistaOra acquistaBtn">Acquista ora</button> ';
        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="../typescript/click.js"></script>
        <script>
        $(document).ready(function() {
          $(".acquistaOra").click(function() {
            $.ajax({
              url: "acquistaOra.php", 
              type: "POST",
              success: function(response) {
                $("#rispostaAcquistaOra").html(response);
              }
            });
          });
        });
        </script>
        <div id="rispostaAcquistaOra"></div>
        <?php
      }
      ?>
    </div>
  </div>
</div>

<div class="other" >
  <a href="cerca.php">Altri corsi</a>
</div>

