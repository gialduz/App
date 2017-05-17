<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    
    <title>Luoghi - Segni d'Infanzia</title>

</head>

<body style="max-width:640px; margin:0 auto;">
    
        
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
        
</body>

</html>