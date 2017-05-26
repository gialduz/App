<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    
    <title>Test</title>
    
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/stile.css">
    <script src="js/jquery.js"></script>

</head>

<body style="max-width:640px; margin:0 auto;">

    
    
    
<?php

include 'php/mieFunzioni.php';

require 'php/configurazione.php';// richiamo il file di configurazione
require 'php/connessione.php';// richiamo lo script responsabile della connessione a MySQL


$numeroEvento = 15;
    
//RICORDA DI NON STAMPARE MAI 2 MAPPE NELLA STESSA PAGINA
//echo stampaEvento($numeroEvento, $conn);
echo '---------------------------------------------------------------------------------------------------';
echo stampaListaIstanzeEvento();
echo '---------------------------------------------------------------------------------------------------';
echo stampaMappaLuoghi();
echo '---------------------------------------------------------------------------------------------------';
echo stampaElencoLuoghi();
echo '---------------------------------------------------------------------------------------------------';


$conn->close();
?>
</body>

</html>