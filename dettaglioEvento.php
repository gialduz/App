<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <title>Evento - Segni d'Infanzia</title>
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/stile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="js/jquery.js"></script>
</head>

<body style="max-width:640px; margin:0 auto;">
    <script src="js/menuOverlay.js"></script>
    <script src="js/menuBar.js"></script>
    
    <div id="corpo">
        <div id="spazioBarra"></div>
        
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
            <br>
            <br>
            <br> Stampo anche SPONSOR -> prima stampaPersona() e stampaAltro()
            <br> Istanza evento speciale -> stella e rosso
            <script>
                $(".badge").addClass("w3-card-2");
            </script>
    </div>
</body>

</html>