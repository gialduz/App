<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    
    <title>Evento - Segni d'Infanzia</title>
    
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/stile.css">
    <script src="js/jquery.js"></script>

</head>

<body style="max-width:650px; margin:0 auto;">

    
    
    
<?php

include 'php/mieFunzioni.php';

require 'php/configurazione.php';// richiamo il file di configurazione
require 'php/connessione.php';// richiamo lo script responsabile della connessione a MySQL
if (isset($_GET['evento']))
{
    $numeroEvento = $_GET['evento'];
}

    
//RICORDA DI NON STAMPARE MAI 2 MAPPE NELLA STESSA PAGINA
echo stampaEvento($numeroEvento);

$conn->close();
?>
</body>

</html>