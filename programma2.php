<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    
</head>

<body style="max-width:640px; margin:0 auto;">
        
        <div id="overlayFilter" style="display:none;">
            <div id="filterBoxContainer" style="position:relative; height:100%; width:100%">
                <div id="filterBox" class="padded10" style="max-height:640px; max-width:480px; margin:0 auto; margin-top:10px; background-color: #333333;">
                    <h2 class="w3-orange">Filtri <i id="closeOverlayFilter" class="fa fa-close w3-xxlarge w3-right" aria-hidden="true"></i></h2>
                    
                    
                    <div class="w3-row">
                        <div class="w3-col s12"><h4 style="margin:0; color:white;">Tipo di evento:</h4></div>
                        <div class="w3-col s3">
                            <img id="filtraTipoEventoGG1" src="img/tipologiaEvento/spettacolo.png" class="badge75resp "><br>
                            <span class="w3-text-white" style="font-size:9px;">Spettacolo</span>
                        </div>
                        <div class="w3-col s3">
                            <img id="filtraTipoEventoGG2" src="img/tipologiaEvento/laboratorio.png" class="badge75resp "><br>
                            <span class="w3-text-white" style="font-size:9px;">Laboratorio</span>
                        </div>
                        <div class="w3-col s3">
                            <img id="filtraTipoEventoGG3" src="img/tipologiaEvento/formazione.png" class="badge75resp "><br>
                            <span class="w3-text-white" style="font-size:9px;">Formazione</span>
                        </div>
                        <div class="w3-col s3">
                            <img id="filtraTipoEventoGG4" src="img/tipologiaEvento/film2.png" class="badge75resp "><br>
                            <span class="w3-text-white" style="font-size:9px;">Film</span>
                        </div>
                    </div>
                    
                    <hr style="margin: 1px 0 5px 0;">
                    
                    <div class="w3-row"><h4 class="w3-text-white">Filtra solo eventi:</h4></div>
                    <div class="w3-row-padding">
                        
                        <div class="w3-col s4 w3-center"><div id="filtraFamiglia" class="w3-round padded10" style="background-color:black; color:white;">Famiglie</div></div>
                        <div class="w3-col s4 w3-center"><div id="filtraScuola" class="w3-round padded10" style="background-color:black; color:white;">Scuole</div></div>
                        <div class="w3-col s4 w3-center"><div id="filtraGratuito" class="w3-round padded10" style="background-color:black; color:white;">Gratuiti</div></div>
                        
                    </div>
                    <hr style="margin: 5px 0 10px 0;">
                    
                    <div class="w3-row">
                        <div class="w3-col s12"><h4 style="margin:0; color:white;">Et&agrave;:</h4></div>
                        <form id="etaForm">
                
                            <div class="w3-col s12">
                                <input id="filtraEta" type="number" name="filtraEta" value="0" min="0" class="w3-input w3-border">
                            </div>
                            
                            
                        </form>
                    </div>
                    <hr style="margin: 1px 0 10px 0;">
                    
                    <div class="w3-row">
                        <div class="w3-col s12"><h4 style="margin:0; color:white;">Luogo:</h4></div>
                        <select id="filtraLuogo" name="filtraLuogo" class="w3-select">
                            <option value='0'> - </option>
                            <?php
                            include 'php/mieFunzioni.php';
                            require 'php/configurazione.php';// richiamo il file di configurazione
                            require 'php/connessione.php';// richiamo lo script responsabile della connessione a MySQL
                            
                            $stmt = $conn->prepare("SELECT id, nome, lettera FROM Luogo WHERE 1");
                            $stmt->execute();
                            $stmt->bind_result($id, $nome, $lettera);

                            while($stmt->fetch()){
                                echo "<option value=".$id.">[".$lettera."]  ".$nome. "</option>";
                            }
                            $stmt->close();
                            ?>
                        </select>
                    </div>
                    <hr style="margin: 1px 0 10px 0;">
                    
                    <div class="w3-row-padding">
                        <div class="w3-col s4"><input class="resetFiltri w3-input w3-red" type="button" value="Reset"></div>
                        <div class="w3-col s8"><input class="w3-input w3-blue" id="filtraSubmit" type="button" value="Applica filtro"></div>
                    </div>
                    
                    
                </div>
            </div>
        </div>
        
        
        <div class="w3-container w3-purple w3-text-white w3-center">
            <h3>Programma <small><span class="showFilterBtn w3-right padded5 w3-dark-grey w3-round">Filtra per:</span></small></h3>
        </div>
    
        <div id="infoFiltroAttivo" class="w3-container w3-white w3-text-purple w3-center" style="display:none;">
            <h6>Sono attivi dei filtri di ricerca <span class="resetFiltri w3-purple padded5 w3-round">Cancella filtri</span></h6>
        </div>
        
        
        <script> var listaDate =[]; var iData=0; </script>
        
        <div id='rigaBtn' class="w3-row w3-center padded10tb">

        
        <?php

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
                    modalitaTutto=0;
                    
                    $("#"+giorno).removeClass("w3-orange");
                    
                    $(".dataBtn").not(this).hide();
                    $(this).addClass("w3-orange");
                    $(this).prev("button").show();
                    $(this).next("button").show();
                    $("#caricamento").hide();
                    $('#wrapIstanze').empty();
                    
                    giorno = $(this).prop("id");
                    var myTipoEvento =JSON.parse(localStorage.getItem("tipoEvento"));
                    
                    $('#wrapIstanze').append($('<div>').load('programmaGiorno.php?giorno='+giorno+"&eta="+ localStorage["eta"]+"&famiglia="+ localStorage["famiglia"]+"&scuola="+ localStorage["scuola"]+"&gratuito="+ localStorage["gratuito"]+"&luogo="+ localStorage["luogo"]+"&tipoevento="+ myTipoEvento));
                    
                    
                    
                    
                    j=0; // azzero contatore ogni volta che cambio modalità
                    $(".showAll").parent().show(); //mostro pulsante PROG COMPLETO
                });
                //alert(listaDate); sì, salva tutte le date
                
                
                function stampaProssimoGiorno(){
                    if(j<listaDate.length){
                        //$('#wrapIstanze').append("<h2 class='w3-orange'>"+listaDate[j]+"</h2>");
                        $('#wrapIstanze').append($('<div class="paginaIstanzeGiorno">').load('programmaGiorno.php?giorno='+listaDate[j]+"&eta="+ localStorage["eta"]+"&famiglia="+ localStorage["famiglia"]+"&scuola="+ localStorage["scuola"]+"&gratuito="+ localStorage["gratuito"]+"&luogo="+ localStorage["luogo"]+"&tipoevento="+ myTipoEvento));
                        j++;
                   }
                    if(j==listaDate.length){
                        $("#caricamento").delay(500).hide(0);
                   }
                    
                    
                }
                
                function initWrapTutto(){
                    if($(window).height() >= $("body").height() -100 && modalitaTutto) {
                        stampaProssimoGiorno();
                        
                        setTimeout(function(){ initWrapTutto(); }, 100);
                        //delay premette corretto calcolo distanze/altezze -testato con 50 va, con 100 non disturba
                        
                    };
                }
                
                
                //MOSTRA TUTTO
                $(".showAll").click(function(){
                    modalitaTutto=1;
                    $("#"+giorno).removeClass("w3-orange");
                    $(".dataBtn").show();
                    $('#wrapIstanze').empty();
                    initWrapTutto();
                    $(".showAll").parent().hide(); //nascondo tasto PROG COMPLETO
                });
                
                //aggiungo man mano che arrivo in fondo alla pag
                $(window).scroll(function() {
                   if($(window).scrollTop() + $(window).height() >= $(document).height() -30 && modalitaTutto) {
                       if(j<listaDate.length){ $("#caricamento").show(); } //senza if continua a stampare e nascondere in fondo alla pag.
                       stampaProssimoGiorno();
                   }
                });
                
                
                
                
                
                //alert(istanzePreferiteDaColorare);
                
                
                //if(JSON.parse(localStorage.getItem("istanzaPreferita"))[1] == 1) alert("pippo");
                
                
                
                /////// FILTRI età, luogo, gratuiti, tipoEvento
                $(".showFilterBtn").click(function(){
                     $("#overlayFilter").show();
                    //COLORA pulsanti Filtri tipoEvento
                    myTipoEvento =JSON.parse(localStorage.getItem("tipoEvento"));
                    //alert("apri filtro "+myTipoEvento);
                    for(var i=1; i<=4; i++) {
                        //$("#filtraTipoEventoGG"+i).removeClass("boxTipoEventoFiltroSelected");
                        $("#filtraTipoEventoGG"+i).removeClass("biancoenero");
                        
                        if(myTipoEvento[i] == i){
                            //$("#filtraTipoEventoGG"+i).addClass("boxTipoEventoFiltroSelected");
                        } else {
                            $("#filtraTipoEventoGG"+i).addClass("biancoenero");
                        }
                    }
                    
                    //COLORA famiglia, scuola, gratis
                    $("#filtraFamiglia").removeClass("w3-purple");
                    $("#filtraScuola").removeClass("w3-blue");
                    $("#filtraGratuito").removeClass("w3-green");
                    
                    if(localStorage["famiglia"] == 1) {$("#filtraFamiglia").addClass("w3-purple");}
                    if(localStorage["scuola"] == 1) {$("#filtraScuola").addClass("w3-blue");}
                    if(localStorage["gratuito"] == 1) {$("#filtraGratuito").addClass("w3-green");}
                    if(localStorage["eta"]) {$("#filtraEta").val(localStorage["eta"]);}
                    if(localStorage["luogo"]) {$("#filtraLuogo").val(localStorage["luogo"]);}
                    
                });
                $("#closeOverlayFilter").click(function(){
                     $("#overlayFilter").hide();
                    
                });
                
                //GESTIONE PREFERITI PROSSIMO ANNO
                //localStorage["quandoHoCancellato"] = 2016;
                
                /*if(localStorage.getItem("quandoHoCancellato") == 2016){
                            localStorage.removeItem("tipoEvento");
                            localStorage["quandoHoCancellato"] = 2017;
                }*/

                
                //INIT array Filtri
                if(localStorage.getItem("tipoEvento") == null) {
                    alert("pippo");
                    var myTipoEvento= [];
                    myTipoEvento[0] = 0; myTipoEvento[1] = 0; myTipoEvento[2] = 0; myTipoEvento[3] = 0; myTipoEvento[4] = 0;
                    localStorage["tipoEvento"] = JSON.stringify(myTipoEvento);
                }
                if(localStorage.getItem("famiglia") == null) {
                    localStorage["famiglia"] = 0;
                }
                if(localStorage.getItem("scuola") == null) {
                    localStorage["scuola"] = 0;
                }
                if(localStorage.getItem("gratuito") == null) {
                    localStorage["gratuito"] = 0;
                }
                if(localStorage.getItem("eta") == null) {
                    localStorage["eta"] = 0;
                }
                if(localStorage.getItem("luogo") == null) {
                    localStorage["luogo"] = 0;
                }
                
                    
                var myTipoEvento =JSON.parse(localStorage.getItem("tipoEvento"));
                
                //stampa "filtri attivi" se non sono come init
                if( !(myTipoEvento[0] == 0 && myTipoEvento[1] == 0 && myTipoEvento[2] == 0 && myTipoEvento[3] == 0 && myTipoEvento[4] == 0 && localStorage["famiglia"] == 0 && localStorage["scuola"] == 0 && localStorage["gratuito"] == 0 && localStorage["eta"] == 0 && localStorage["luogo"] == 0) ) $("#infoFiltroAttivo").show();
                
                //badge tipoEvento cambiano classe onToggle
                $(".badge75resp").click(function(){
                    
                    //myTipoEvento =JSON.parse(localStorage.getItem("tipoEvento"));
                    
                    //$(this).toggleClass("boxTipoEventoFiltroSelected");
                    $(this).toggleClass("biancoenero");
                    
                    //$(this).toggleClass("biancoenero");
                    var te= ($(this).attr('id').split("GG")[1]);
                    if(myTipoEvento[te] == te){
                        myTipoEvento[te] = 0;
                    } else {
                        myTipoEvento[te] = te;
                    }
                    
                    //alert("filtrosession: "+myTipoEvento);
                });
                
                //famiglia
                $("#filtraFamiglia").click(function(){
                    $(this).toggleClass("w3-purple");
                });
                //scuola
                $("#filtraScuola").click(function(){
                    $(this).toggleClass("w3-blue");
                });
                //gratis
                $("#filtraGratuito").click(function(){
                    $(this).toggleClass("w3-green");
                });
                
                //submit
                $("#filtraSubmit").click(function(){
                    //alert("presubmit: "+myTipoEvento);
                    localStorage["tipoEvento"] = JSON.stringify(myTipoEvento);
                    $("#overlayFilter").hide();
                    localStorage["eta"] = $("#filtraEta").val();
                    localStorage["luogo"] = $("#filtraLuogo").val();
                    
                    if($("#filtraFamiglia").hasClass("w3-purple")) {localStorage["famiglia"] = 1;} else {localStorage["famiglia"] = 0;}
                    if($("#filtraScuola").hasClass("w3-blue")) {localStorage["scuola"] = 1;} else {localStorage["scuola"] = 0;}
                    if($("#filtraGratuito").hasClass("w3-green")) {localStorage["gratuito"] = 1;} else {localStorage["gratuito"] = 0;}
                    
                    window.location.reload("programma.html");
                });
                
                
                $(".resetFiltri").click(function(){
                    var myTipoEvento= [];
                    myTipoEvento[0] = 0; myTipoEvento[1] = 0; myTipoEvento[2] = 0; myTipoEvento[3] = 0; myTipoEvento[4] = 0;
                    localStorage["tipoEvento"] = JSON.stringify(myTipoEvento);
                    localStorage["famiglia"] = 0;
                    localStorage["scuola"] = 0;
                    localStorage["gratuito"] = 0;
                    localStorage["eta"] = 0;
                    localStorage["luogo"] = 0;
                    
                    $("#overlayFilter").hide();
                    window.location.reload("programma.html");
                });
                
            });

        </script>
        
        
</body>

</html>