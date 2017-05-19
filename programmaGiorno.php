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
    
    <script src="js/jquery.growl.js" type="text/javascript"></script>
    <link href="css/jquery.growl.css" rel="stylesheet" type="text/css" />

</head>

<body style="max-width:640px; margin:0 auto;">
    
    <?php
    function stampaIstanzeGiorno($giorno) {

        include 'php/configurazione.php';
        include 'php/connessione.php';
        include 'php/funzioniDataOra.php';
        
        $daRitornare.="<div class='w3-orange w3-center'><h2 style='margin:0'>".dataIta($giorno)."</h2></div>";
        //divisione grafica istanze
        $daRitornare.="<hr style='margin:0'>";
        
        $giorno= $giorno . "%"; // se metto % in stmt da errore (lo vede come placeholder di variabile)

        $sql = "SELECT E.nome, E.id, E.eta_min, E.eta_max, E.durata, E.ticket, eld.id_istanza, eld.data_ora, L.nome, tE.nome, E.speciale_ragazzi, eld.speciale FROM (((Evento AS E INNER JOIN tipologiaEvento AS tE ON E.tipologia=tE.id) INNER JOIN eventoLuogoData AS eld ON E.id=eld.id_evento) INNER JOIN Luogo AS L ON L.id=eld.id_luogo ) WHERE eld.data_ora LIKE ? ORDER BY data_ora, id_evento;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $giorno);
        $stmt->execute();
        $stmt->bind_result($nomeEvento, $id_evento, $eta_min, $eta_max, $durata, $ticket, $id_istanza, $data_ora, $dove, $tipo_evento, $speciale_ragazzi, $speciale);


        while($stmt->fetch()) {    
            
            

            $daRitornare.= stampaIstanza($nomeEvento, $id_evento, $eta_min, $eta_max, $durata, $ticket, soloData($data_ora), soloOra($data_ora), $id_istanza, $dove, $tipo_evento, $speciale_ragazzi, $speciale);
            
            $daRitornare.="<script>".
            '$("#ist'.$id_istanza.'").click(function(event) {
                // APRI EVENTO
                window.location.href = "dettaglioEvento.html?evento='.$id_evento.'";
            });'
                ."</script>";
            
            $daRitornare.="<script>".
            '$("#prefBtn'.$id_istanza.'").click(function(event) {
                // AGGIUNGI PREFERITO
                event.stopPropagation();
                $("#prefBtn'.$id_istanza.'").toggleClass("w3-text-red");
                var myIstanze = JSON.parse(localStorage.getItem("istanzaPreferita"));
                if(myIstanze['.$id_istanza.']) {
                    myIstanze['.$id_istanza.']= 0; $.growl.error({ title: "'.$nomeEvento.'", message: "Rimosso dai preferiti" });
                } else {
                    myIstanze['.$id_istanza.']= 1; $.growl.notice({ title: "'.$nomeEvento.'", message: "Aggiunto ai preferiti" });
                }
                localStorage["istanzaPreferita"] = JSON.stringify(myIstanze);
            });'
                ."</script>";
                        
            
            //ISTANZA PREFERITA
            $azione= '$("#prefBtn'.$id_istanza.'").addClass("w3-text-red");';
            $daRitornare.= "<script>
                        var myIstanze =JSON.parse(localStorage.getItem('istanzaPreferita'));
                        if(myIstanze[".$id_istanza."]){".$azione."}
                        </script>";
            
        }


        //rende badge alti uguali, una volta stampati     +onResize()
        $daRitornare .= "<script>
                            $('.itemBadge').each(function(){
                                $(this).height($(this).width());
                            });
                            $('.inclinata').each(function(){
                                $(this).height($(this).width()/4*5);
                            });
                            $( window ).resize(function() {
                                $('.itemBadge').each(function(){
                                    $(this).height($(this).width());
                                });
                                $('.inclinata').each(function(){
                                    $(this).height($(this).width()/4*5);
                                });
                            });


                        </script>";

        return $daRitornare;
    }

    // ITEM (ISTANZA)
    function stampaIstanza($nomeEvento, $numeroEvento, $eta_min, $eta_max, $durata, $ticket, $data, $orario, $id_istanza, $dove, $tipo_evento, $speciale_ragazzi, $speciale) {


        $daRitornare.= "<div id='ist".$id_istanza."' class='istanzaEvento w3-row w3-padding'>" 
                            ."<div class='w3-col s12'>"
                                ."<div class='w3-row'>"
                                    ."<div class='itemFasciaEta w3-center w3-blue w3-col s2'>"
                                        .$eta_min."-".$eta_max. "<br>anni"
                                    ."</div>"
                                    ."<div class='w3-col s8 padded10lr'>"
                                        ."<b>" . $nomeEvento . "</b>"
                                    ."</div>"
                                    ."<div id='prefBtn".$id_istanza."' class='w3-col s2 w3-center padded5' style='color:lightgrey'>"
                                        .'<i class="fa fa-heart fa-3x" aria-hidden="true" ></i>'
                                    ."</div>"
                                ."</div>"
                            ."</div>"
                            
                            ."<div class='w3-col s12'>"
                                ."<div class='w3-row'>"
                                    ."<div class='w3-col s2 w3-center'>"
                                        .$orario
                                    ."</div>"
                                    ."<div class='w3-col s8 padded10lr'>"
                                        . $dove
                                    ."</div>"
                                    ."<div class='w3-col s2 w3-center'>"
                                        .stampaItemBadge($tipo_evento, $durata, $ticket, $speciale_ragazzi, $speciale, $id_istanza)
                                    ."</div>"
                                ."</div>"
                            ."</div>"
                            
                        ."</div>";
        
        //se gratis -> verde
        if(!$ticket){$daRitornare.= "<script>$('#ist".$id_istanza."').addClass('w3-pale-green');</script>";}
        $daRitornare.="<hr style='margin:0; border-top:1px solid #999999'>";
                   


        return $daRitornare;
    }
    
    function stampaItemBadge($tipo_evento, $durata, $ticket, $speciale_ragazzi, $speciale, $id_istanza) {
        
        if($ticket){$ticketSN= '€';} else{$ticketSN= 'Free';}
        $str =  "<div class='w3-row'>";
        
        /*$str .= specialeRagazziItemBadge($speciale_ragazzi);
        $str .= specialeItemBadge($speciale);*/
        
        $str .= "<div class='w3-col s6 uppato itemBadge'>"
                    ."<img class='w3-image' src='img/tipologiaEvento/".$tipo_evento.".png' >"
                ."</div>"
                ."<div class='w3-col s6 w3-green itemBadge'>"
                    .$durata
                ."</div>";
        
        $str .=  "</div>";
        
        
        return $str;
        
        // IMPORTANTE ! nel PDF c'è riferimento a pagina -> badge collegamento o clic su istanza o niente? (clic per dettaglio evento)
        
    }
    
    function specialeRagazziItemBadge($speciale_ragazzi) {
        if($speciale_ragazzi){
            return "<div class='w3-col s4'>"
                        ."<div class='w3-purple inclinata itemBadge' style='width:80%; float:right;'> <p><b>T</b></p> </div> "
                    ."</div>";}
        return "<div class='w3-col s4'></div>";
    }
    
    function specialeItemBadge($speciale) {
        if($speciale){
            return "<div class='w3-col s4'>"
                        ."<div class='w3-red inclinata itemBadge' style='width:80%; float:right;'> <p><b>S</b></p> </div> "
                    ."</div>";}
        return "";
    }
    
    
    
    $giornoDaStampare = $_GET["giorno"];
    echo stampaIstanzeGiorno($giornoDaStampare);
    //echo $giornoDaStampare;
    ?>
    
    
    
    <script>
        






    </script>
        
        
    </div>
    
</body>

</html>