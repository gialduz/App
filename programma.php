<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    
    <title>Programma - Segni d'Infanzia</title>
    
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/stile.css">
    <script src="js/jquery.js"></script>

</head>

<body style="max-width:650px; margin:0 auto;">
    
    <br><br>
    <div class="w3-row" >
        <div class="w3-center">
          <button class="w3-button" onclick="$('.giornoTutti').show()">&#10094; (reset programma)</button>

          <button class="w3-button demo" onclick="">Mar 26</button>
          <button class="w3-button demo w3-orange" onclick="$('.giornoTutti').not('.giorno2017-04-06').hide()">GIOVEDì 6 APRILE</button>
          <button class="w3-button demo" onclick="">Gio 28</button>
            
          <button class="w3-button" onclick="">&#10095;</button>

        </div>        
    </div>
    
    
<?php
include 'php/mieFunzioni.php';
require 'php/configurazione.php';// richiamo il file di configurazione
require 'php/connessione.php';// richiamo lo script responsabile della connessione a MySQL

echo stampaListaIstanzeEvento();


$conn->close();
?>
    
    <script>//$('.giornoTutti').not('.giorno2017-04-06').hide();//FILTRO DI RICERCA GIORNI</script>
</body>

</html>