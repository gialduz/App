
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
                            header('Access-Control-Allow-Origin: *');
                            
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
                    
                    <div class="w3-row w3-container">
                        <div class="w3-col s4"><input class="resetFiltri w3-input w3-red" type="button" value="Reset"></div>
                        <div class="w3-col s8"><input class="w3-input w3-blue" id="filtraSubmit" type="button" value="Applica filtro"></div>
                    </div>
                    
                    
                </div>
            </div>
        </div>
        
        
        
<div class="w3-container w3-orange w3-center">
    <h3>Lista Eventi <small><span class="showFilterBtn w3-right padded5 w3-dark-grey w3-round">Filtra per:</span></small></h3>
</div>

<div id="infoFiltroAttivo" class="w3-container w3-white w3-text-orange w3-center" style="display:none;">
    <h6>Sono attivi dei filtri di ricerca </h6> <span class="resetFiltri w3-orange padded10 w3-round">Cancella filtri <i class="fa fa-times" aria-hidden="true"></i> </span>
</div>

<br>

<?php
    require 'php/configurazione.php';
    require 'php/connessione.php';

    /*$stmt = $conn->prepare("SELECT E.id, E.nome, E.eta_min, E.eta_max, E.durata, tE.nome, L.nome FROM ( (Evento AS E INNER JOIN tipologiaEvento AS tE ON E.tipologia=tE.id) INNER JOIN Luogo AS L ON E.luogo=L.id) WHERE 1 ORDER BY E.eta_min, E.eta_max, E.nome");
    $stmt->execute();
    $stmt->bind_result($id_evento, $nomeEvento, $eta_min, $eta_max, $durata, $tipoEvento, $luogo);*/



    $select = "SELECT E.id, E.nome, E.eta_min, E.eta_max, E.durata, tE.nome, L.nome, E.ticket";
    $from= "FROM ( (Evento AS E INNER JOIN tipologiaEvento AS tE ON E.tipologia=tE.id) INNER JOIN Luogo AS L ON E.luogo=L.id)";
    $where= "WHERE (1)";

    //check filtri attivi
    $etaDaCercare= $_GET["eta"];
    $famiglia=$_GET["famiglia"];
    $scuola=$_GET["scuola"];
    $gratuito=$_GET["gratuito"];
    $luogo=$_GET["luogo"];
    $tipoEvento = $_GET["tipoevento"];


    if($etaDaCercare) {$where.= "AND (E.eta_min <= ".$etaDaCercare." AND E.eta_max >= ".$etaDaCercare.")";}
    if($famiglia) {$where.= "AND (E.famiglia = 1)";}
    if($scuola) {$where.= "AND (E.scuola = 1)";}
    if($gratuito) {$where.= "AND (E.ticket = 0)";}
    if($luogo!=0) {$where.= "AND (E.luogo = ".$luogo.")";}
    if($tipoEvento == '0,0,0,0,0') $tipoEvento = '0,1,2,3,4';


    $where.= "AND (E.tipologia IN (".$tipoEvento.") )";


    $sql= $select." ".$from." ".$where." ORDER BY E.eta_min, E.eta_max, E.nome";
    $stmt = $conn->prepare($sql); 
    $stmt->execute();
    $stmt->bind_result($id_evento, $nomeEvento, $eta_min, $eta_max, $durata, $tipoEvento, $luogo, $ticket);







    while($stmt->fetch()) {
       $daRitornare.= stampaEventoInLista($id_evento, $nomeEvento, $eta_min, $eta_max, $durata, $tipoEvento, $luogo, $ticket)
                        ."<hr style='margin:0; border-top:1px solid #999999'>" ;
    }
    

    echo $daRitornare;





    function stampaEventoInLista($id_evento, $nomeEvento, $eta_min, $eta_max, $durata, $tipoEvento, $luogo, $ticket) { // BADGES
        
        $daRitornare.= "<a href='dettaglioEvento.html?evento=".$id_evento."'>"
                            ."<div id='evLista".$id_evento."' class='w3-row padded5'>"
                                ."<div class='itemFasciaEta w3-center w3-blue w3-col s2'>"
                                    .$eta_min."-".$eta_max. "<br>anni"
                                ."</div>"
                                ."<div class='w3-col s8 padded10lr'>"
                                    ."<b>" . $nomeEvento . "</b><br>"
                                    ."<i>" . $luogo . "</i>"
                                ."</div>"
                                ."<div class='w3-col s2 ' style='padding-top:0'>"
                                    ."<div class='w3-row'>"
                                        ."<div class='w3-col s7 m6'>"
                                            ."<img class='w3-image' src='img/tipologiaEvento/".$tipoEvento.".png' >"
                                        ."</div>"
                                        ."<div class='w3-col s7 m6'>"
                                            ."<div class='itemBadge w3-green w3-center'>"
                                                .$durata
                                            ."</div>"
                                        ."</div>"
                                    ."</div>"
                                ."</div>"
                            ."</div>"
                        ."</a>";
        if(!$ticket){$daRitornare.= "<script>$('#evLista".$id_evento."').addClass('w3-pale-green');</script>";}
        $daRitornare.= "<script>$('#evLista".$id_evento."').click(function(){ sessionStorage['ultimoEvento'] = ".$id_evento."; });</script>";
        
        return  $daRitornare;

    }


?>


<script>
    $('.itemBadge').each(function(){
        $(this).height($(this).width());
    });
    $( window ).resize(function() {
        $('.itemBadge').each(function(){
            $(this).height($(this).width());
        });
    });
    
    
    //on document.READY()
            $(document).ready(function(){
                
                
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
                
                            //localStorage.removeItem("tipoEvento");

                
                //INIT array Filtri
                if(localStorage.getItem("tipoEvento") == null) {
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
                    
                    sessionStorage.clear();
                    sessionStorage["ultimaPagina"]= "eventi";
                    window.location.reload("listaEventi.php?"+"eta="+ localStorage["eta"]+"&famiglia="+ localStorage["famiglia"]+"&scuola="+ localStorage["scuola"]+"&gratuito="+ localStorage["gratuito"]+"&luogo="+ localStorage["luogo"]+"&tipoevento="+ JSON.parse(localStorage.getItem("tipoEvento")));
                    //alert("famiglia: " + localStorage["famiglia"] + "scuola: " + localStorage["scuola"] + "gratuito: " + localStorage["gratuito"]);
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
                    sessionStorage.clear();
                    sessionStorage["ultimaPagina"]= "eventi";
                    window.location.reload("listaEventi.php?"+"eta="+ localStorage["eta"]+"&famiglia="+ localStorage["famiglia"]+"&scuola="+ localStorage["scuola"]+"&gratuito="+ localStorage["gratuito"]+"&luogo="+ localStorage["luogo"]+"&tipoevento="+ JSON.parse(localStorage.getItem("tipoEvento")));
                });
                
                
                
                
                
            });


</script>