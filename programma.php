<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    
</head>

<body style="max-width:640px; margin:0 auto;">
    
        
        
        
        <div class="w3-container w3-purple w3-text-white w3-center">
        <h2>Programma 2017</h2>
        </div>
        
        
        <script> var listaDate =[]; var iData=0; </script>
        
        <div id='rigaBtn' class="w3-row w3-center padded10tb">

        
        <?php
        include 'php/mieFunzioni.php';
        require 'php/configurazione.php';// richiamo il file di configurazione
        require 'php/connessione.php';// richiamo lo script responsabile della connessione a MySQL

        $stmt = $conn->prepare("SELECT data_ora FROM eventoLuogoData WHERE 1 ORDER BY data_ora");
        $stmt->execute();
        $stmt->bind_result($data_ora);
        $arrayDate = "";

        $ultimaData = 'pippo';
        $stampaMese= "primoMese"; //contatore usato in funzioniOraData.php -> dataFiltroBtn()
        while($stmt->fetch()){
            $data = soloData($data_ora);
            if($data != $ultimaData) // elimina duplicati data
            {
                $dataStr= '"'.$data.'"';
                $daRitornare.= "<button id=".$dataStr." class='dataBtn w3-round padded10' style='border:none; margin:4px;'>" . dataFiltroBtn($data) . "</button>";
                $ultimaData = $data;
                //salvo listadate in array
                $arrayDate.= "<script> listaDate[iData]= ".$dataStr."; iData++ </script>";
            }
        }

        echo $daRitornare . $arrayDate;
        $stmt->close();
        ?>
            
        </div>

        
        
        
        <div id="wrapIstanze" class="w3-row"> </div>
        
        <div id="caricamento" class="w3-row w3-center"><i class="fa fa-spinner fa-spin w3-xxlarge" aria-hidden="true"></i></div>
        <script>$("#caricamento").hide();</script>
        
        <div class="w3-center w3-pale-red padded10">
            Seleziona un giorno per vedere gli eventi in programma, <br> OPPURE <br> <div class="w3-btn showAll"> Clicca qui<br>per il programma completo </div>
        </div>
        
        
        
        

        <script>
            //localStorage.removeItem("istanzaPreferita");
            //alert(JSON.parse(localStorage.getItem("istanzaPreferita"))); //mostra array
            
            //INIT array PEFERITI
            if(localStorage.getItem("istanzaPreferita") == null) {
                var myIstanze= [];
                myIstanze[0] = 0;
                //mypref[idEvento] = "1";
                localStorage["istanzaPreferita"] = JSON.stringify(myIstanze);
                //alert("Nessuna ist preferito, array creato!");

            }
            
            //array con solo eventi dove flag=1
            var istanzePreferiteDaColorare =[];
            var contatoreIstanzePDC = 0;
            var i=0;
            var myIstanze =JSON.parse(localStorage.getItem("istanzaPreferita"));

            while(i< myIstanze.length){
                if(myIstanze[i]) {
                    istanzePreferiteDaColorare[contatoreIstanzePDC] = i;
                    contatoreIstanzePDC++;
                }
                i++;
            }
            
            
            
            
            //on document.READY()
            $(document).ready(function(){
                var j=0;
                var modalitaTutto=0;
                var giorno=0;
                
                //SINGOLO Giorno
                $(".dataBtn").click(function(){
                    $("#"+giorno).removeClass("w3-orange");
                    
                    $(".dataBtn").not(this).hide();
                    $(this).addClass("w3-orange");
                    $(this).prev("button").show();
                    $(this).next("button").show();
                    $("#caricamento").hide();
                    $('#wrapIstanze').empty();
                    
                    giorno = $(this).prop("id");
                    $('#wrapIstanze').append($('<div>').load('programmaGiorno.php?giorno=' + giorno));
                    
                    modalitaTutto=0;
                    
                    
                    j=0; // azzero contatore ogni volta che cambio modalità
                    $(".showAll").parent().show(); //mostro pulsante PROG COMPLETO
                });
                //alert(listaDate); sì, salva tutte le date
                
                
                function stampaProssimoGiorno(){
                    if(j<listaDate.length){
                        //$('#wrapIstanze').append("<h2 class='w3-orange'>"+listaDate[j]+"</h2>");
                        $('#wrapIstanze').append($('<div class="paginaIstanzeGiorno">').load('programmaGiorno.php?giorno='+listaDate[j]));
                        j++;
                   }
                    if(j==listaDate.length){
                        $("#caricamento").delay(3000).hide(0);
                   }
                    
                    
                    
                    /*var i=0;
                    while(i< istanzePreferiteDaColorare.length){
                        $("#ist"+istanzePreferiteDaColorare[i]).addClass("w3-green");
                        i++;
                    }*/
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
                    $("#"+giorno).removeClass("w3-orange");
                    $(".dataBtn").show();
                    $('#wrapIstanze').empty();
                    initWrapTutto();
                    modalitaTutto=1;
                    $(".showAll").parent().hide(); //nascondo tasto PROG COMPLETO
                });
                
                //aggiungo man mano che arrivo in fondo alla pag
                $(window).scroll(function() {
                   if($(window).scrollTop() + $(window).height() >= $(document).height() -10 && modalitaTutto) {
                       if(j<listaDate.length){ $("#caricamento").show(); } //senza if continua a stampare e nascondere in fondo alla pag.
                       stampaProssimoGiorno();
                   }
                });
                
                
                
                
                
                //alert(istanzePreferiteDaColorare);
                
                
                //if(JSON.parse(localStorage.getItem("istanzaPreferita"))[1] == 1) alert("pippo");
                
            });

        </script>
        
        
</body>

</html>