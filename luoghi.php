<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    
    <title>Luoghi - Segni d'Infanzia</title>
    
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/stile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
    <script src="js/jquery.js"></script>

</head>

<body style="max-width:640px; margin:0 auto;">
    
    
    <div id="corpo">
        <script src="js/menuOverlay.js"></script>
        <script src="js/menuBar.js"></script>
    
    <div class="w3-container w3-blue w3-center">
    <h2>Luoghi</h2>
    </div>
    
    <?php

    include 'php/mieFunzioni.php';
    require 'php/configurazione.php';// richiamo il file di configurazione
    require 'php/connessione.php';// richiamo lo script responsabile della connessione a MySQL

    echo stampaMappaLuoghi();
    echo stampaElencoLuoghi();

    $conn->close();
    ?>
        
    </div>
</body>

</html>