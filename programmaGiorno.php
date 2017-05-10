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
    
    <?php
    function stampaIstanzeGiorno($giorno) {

        include 'php/configurazione.php';
        include 'php/connessione.php';
        include 'php/funzioniDataOra.php';
        
        $giorno= $giorno . "%"; // se metto % in stmt da errore (lo vede come placeholder di variabile)

        $sql = "SELECT E.nome, E.id, E.eta_min, E.eta_max, E.durata, E.ticket, eld.id_istanza, eld.data_ora, L.nome, tE.nome, E.speciale_ragazzi, eld.speciale FROM (((Evento AS E INNER JOIN tipologiaEvento AS tE ON E.tipologia=tE.id) INNER JOIN eventoLuogoData AS eld ON E.id=eld.id_evento) INNER JOIN Luogo AS L ON L.id=eld.id_luogo ) WHERE eld.data_ora LIKE ? ORDER BY data_ora, id_evento;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $giorno);
        $stmt->execute();
        $stmt->bind_result($nomeEvento, $id_evento, $eta_min, $eta_max, $durata, $ticket, $id_istanza, $data_ora, $dove, $tipo_evento, $speciale_ragazzi, $speciale);


        $daRitornare="";
        while($stmt->fetch()) {     

            $daRitornare.= stampaIstanza($nomeEvento, $id_evento, $eta_min, $eta_max, $durata, $ticket, soloData($data_ora), soloOra($data_ora), $id_istanza, $dove, $tipo_evento, $speciale_ragazzi, $speciale);
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


        $daRitornare.= "<a href='dettaglioEvento.php?evento=".$numeroEvento."'><div class='w3-row w3-hover-grey w3-padding'>" 
                        ."<div class='itemFasciaEta w3-center w3-blue w3-col s2 m1'>"
                            .$eta_min."-".$eta_max
                        ."</div>"
                        ."<div class='itemNomeEvento w3-col s7 m8'>"
                            ."<div class='w3-col m2 s4 w3-container'>"
                                .$orario
                            ."</div>"
                            ."<div class='w3-col s8 w3-container'>"
                                ."<b>" . $nomeEvento . "</b>"
                            ."</div>"
                            ."<div class='w3-col s12 w3-container'>"
                                . $dove
                            ."</div>"
                        ."</div>"
                        ."<div class='w3-col s3 w3-center hide360'>"
                            .stampaItemBadge($tipo_evento, $durata, $ticket, $speciale_ragazzi, $speciale)
                        ."</div>"
                    ."</div></a>";


        return $daRitornare;
    }
    
    function stampaItemBadge($tipo_evento, $durata, $ticket, $speciale_ragazzi, $speciale) {
        
        if($ticket){$ticketSN= '€';} else{$ticketSN= 'Free';}
        $str =  "";
        $str .= "<div class='w3-col s3 uppato itemBadge'>"
                    ."<img class='w3-image' src='img/tipologiaEvento/".$tipo_evento.".png' >"
                ."</div>"
                ."<div class='w3-col s3 w3-green itemBadge'><p>"
                    .$durata. "'</p>"
                ."</div>"
                ."<div class='w3-col s3 w3-yellow itemBadge'><p>"
                    .$ticketSN
                ."</p></div>";
        $str .= specialeRagazziItemBadge($speciale_ragazzi);
        $str .= specialeItemBadge($speciale);
        
        
        
        return $str;
        
        // IMPORTANTE ! nel PDF c'è riferimento a pagina -> badge collegamento o clic su istanza o niente? (clic per dettaglio evento)
        
    }
    
    function specialeRagazziItemBadge($speciale_ragazzi) {
        if($speciale_ragazzi){
            return "<div class='w3-col s3'>"
                        ."<div class='w3-purple inclinata itemBadge' style='width:80%; float:right;'> <p><b>T</b></p> </div> "
                    ."</div>";}
        return "";
    }
    
    function specialeItemBadge($speciale) {
        if($speciale){
            return "<div class='w3-col s3'>"
                        ."<div class='w3-red inclinata itemBadge' style='width:80%; float:right;'> <p><b>S</b></p> </div> "
                    ."</div>";}
        return "";
    }
    
    
    
    $giornoDaStampare = $_GET["giorno"];
    echo stampaIstanzeGiorno($giornoDaStampare);
    ?>
    
    
    
    
        
        
    </div>
</body>

</html>