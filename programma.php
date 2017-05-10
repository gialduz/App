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
    <script src="js/menuOverlay.js"></script>
    <script src="js/menuBar.js"></script>
    
    <div id="corpo">
        <div id="spazioBarra"></div>
        
        
        
        <div class="w3-container w3-purple w3-text-white w3-center">
        <h2>Programma 2017</h2>
        </div>
        
        
        <script> var listaDate =[]; var iData=0; </script>
        
        <?php
        include 'php/mieFunzioni.php';
        require 'php/configurazione.php';// richiamo il file di configurazione
        require 'php/connessione.php';// richiamo lo script responsabile della connessione a MySQL

        $stmt = $conn->prepare("SELECT data_ora FROM eventoLuogoData WHERE 1 ORDER BY data_ora");
        $stmt->execute();
        $stmt->bind_result($data_ora);

        $ultimaData = 'pippo';
        $stampaMese= "primoMese"; //contatore usato in funzioniOraData.php -> dataFiltroBtn()
        while($stmt->fetch()){
            $data = soloData($data_ora);
            if($data != $ultimaData) // elimina duplicati data
            {
                $dataStr= '"'.$data.'"';
                $daRitornare.= "<button id=".$dataStr." class='w3-button dataBtn'>" . dataFiltroBtn($data) . "</button>";
                $ultimaData = $data;
                //salvo listadate in array
                $daRitornare.= "<script> listaDate[iData]= ".$dataStr."; iData++ </script>";
            }
        }

        echo $daRitornare;
        $stmt->close();
        ?>

        
        <br><br>
        <div class="w3-center w3-yellow padded10">
            Seleziona un giorno per vedere gli eventi in programma, <br> OPPURE <br> <div class="w3-btn showAll"> Clicca qui per il programma completo </div>
        </div>
        <div id="wrapIstanze" class="w3-row"> </div>
        
        
        
        

        <script>
            $(document).ready(function(){
                var j=0;
                var modalitaTutto=0;
                
                //SINGOLO Giorno
                $(".dataBtn").click(function(){
                    $('#wrapIstanze').empty();
                    giorno = $(this).prop("id");
                    $('#wrapIstanze').append("<h2 class='w3-orange'>"+giorno+"</h2>");
                    $('#wrapIstanze').append($('<div>').load('programmaGiorno.php?giorno=' + giorno));
                    modalitaTutto=0;
                    j=0; // azzero contatore ogni volta che cambio modalità
                    $(".showAll").parent().show(); //mostro PROG COMPLETO
                });
                //alert(listaDate); sì, salva tutte le date
                
                
                function stampaProssimoGiorno(){
                    if(j<listaDate.length){
                        $('#wrapIstanze').append("<h2 class='w3-orange'>"+listaDate[j]+"</h2>");
                        $('#wrapIstanze').append($('<div class="paginaIstanzeGiorno">').load('programmaGiorno.php?giorno='+listaDate[j]));
                        j++;
                   }
                }
                
                function initWrapTutto(){
                    if($(window).height() >= $("body").height()-10 ) {
                        stampaProssimoGiorno();
                        
                        setTimeout(function(){ initWrapTutto(); }, 100);
                        //delay premette corretto calcolo distanze/altezze -testato con 50 va, con 100 non disturba
                    };
                }
                
                
                //MOSTRA TUTTO
                $(".showAll").click(function(){
                    $('#wrapIstanze').empty();
                    initWrapTutto();
                    modalitaTutto=1;
                    $(".showAll").parent().hide(); //nascondo PROG COMPLETO
                });
                
                //aggiungo man mano che arrivo in fondo alla pag
                $(window).scroll(function() {
                   if($(window).scrollTop() + $(window).height() >= $(document).height() -10 && modalitaTutto) {
                       
                       stampaProssimoGiorno();
                       
                       
                   }
                });
                
                
                
                
            });

        </script>
        
    </div>
        
</body>

</html>