<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    
    <title>Programma - Segni d'Infanzia</title>
    
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/stile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
    <script src="js/jquery.js"></script>

</head>

<body style="max-width:640px; margin:0 auto;">
    
    <script src="js/menu.js"></script>
    <div class="w3-container w3-purple w3-text-white w3-center">
    <h2>Programma</h2>
    </div>
    
    <br>
    
    <div class="w3-row" >
        <div class="w3-center">
            <!--<button class="w3-button" onclick="">&#10094;</button>-->
            
            <?php
            include 'php/mieFunzioni.php';
            require 'php/configurazione.php';// richiamo il file di configurazione
            require 'php/connessione.php';// richiamo lo script responsabile della connessione a MySQL

            $stmt = $conn->prepare("SELECT data_ora FROM eventoLuogoData WHERE data_ora LIKE '2016%' ORDER BY data_ora");
            $stmt->execute();
            $stmt->bind_result($data_ora);
            
            $ultimaData = 'pippo';
            $stampaMese= "primoMese"; //contatore usato in funzioniOraData.php -> dataFiltroBtn()
            while($stmt->fetch()){
                $data = soloData($data_ora);
                if($data != $ultimaData) // elimina duplicati data
                {
                    $dataStr= '"'.$data.'"';
                    $daRitornare.= "<button id=".$dataStr." class='w3-button dataBtn' onclick='filtraGiorno(".$dataStr.")'>" . dataFiltroBtn($data) . "</button>";
                    $ultimaData = $data;
                }
            }
            
            echo $daRitornare;
            $stmt->close();
            ?>
            
            <!--<button class="w3-button" onclick="">&#10095;</button>-->

        </div>        
    </div>
    
    <div class="w3-center">
        <div class='w3-padding' style="cursor: pointer">
            <span id='vediTuttiEventi' class='w3-green w3-padding' onclick="resetProgramma()">Clicca qui per tornare alla<br>programmazione completa</span>
        </div>
    </div>
    
    <br>
    
    <?php
    echo stampaListaIstanzeEvento();
    $conn->close();
    ?>
    
    <script>
        function resetProgramma() {
            //Visualizza programma giorno selezionato
            $(".giornoTutti").show();
            $(".dataBtn").show();
            $(".dataBtn").removeClass("w3-orange w3-hover-orange");
            $("#vediTuttiEventi").hide();
            
        }
        resetProgramma();
        function filtraGiorno(data) {
            //Visualizza programma giorno selezionato
            $(".giornoTutti").hide();
            $(".giorno"+data).show();
            //aggiunge pulsante resetProgramma
            $("#vediTuttiEventi").show();
            //nasconde tutti bottoni tranne 2 vicini (NB: in teoria jquery verifica esistenza)
            $(".dataBtn").hide();
            $(".dataBtn#"+data).show();
            $(".dataBtn#"+data).next().show();
            $(".dataBtn#"+data).next().next().show();
            $(".dataBtn#"+data).prev().show();
            $(".dataBtn#"+data).prev().prev().show();
            //seleziona di arancio giorno scelto
            $(".dataBtn").removeClass("w3-orange w3-hover-orange");
            $("#"+data).addClass("w3-orange w3-hover-orange");
        }
    </script>
</body>

</html>