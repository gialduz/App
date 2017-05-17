<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    
    <title>Programma - Segni d'Infanzia</title>
    
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/stile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
    <script src="js/hammer.js"></script>
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
        
        
        
        $giornoSQL= $giorno . "%"; // se metto % in stmt da errore (lo vede come placeholder di variabile)
        
        
        $listaIstanzeStringa=$_POST['arrayIstanze'];
        
        //$listaIstanzeStringa = array(1, 38);
        
        $listaIstanzeStringa = json_encode($listaIstanzeStringa);
        $listaIstanzeStringa = str_replace("[","", $listaIstanzeStringa);
        $listaIstanzeStringa = str_replace("]","", $listaIstanzeStringa);
        $listaIstanzeStringa = str_replace(",",", ", $listaIstanzeStringa);

        $sql = "SELECT E.nome, E.id, E.eta_min, E.eta_max, E.durata, E.ticket, eld.id_istanza, eld.data_ora, L.nome, tE.nome, E.speciale_ragazzi, eld.speciale FROM (((Evento AS E INNER JOIN tipologiaEvento AS tE ON E.tipologia=tE.id) INNER JOIN eventoLuogoData AS eld ON E.id=eld.id_evento) INNER JOIN Luogo AS L ON L.id=eld.id_luogo ) WHERE (eld.data_ora LIKE ? AND id_istanza IN ( ".$listaIstanzeStringa." )) ORDER BY data_ora, id_evento;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $giornoSQL);

        $stmt->execute();
        $stmt->bind_result($nomeEvento, $id_evento, $eta_min, $eta_max, $durata, $ticket, $id_istanza, $data_ora, $dove, $tipo_evento, $speciale_ragazzi, $speciale);

        $primoGiro=1;
        while($stmt->fetch()) { 
            if($primoGiro){
                $daRitornare.="<div class='w3-orange w3-center'><h2>".dataIta($giorno)."</h2></div>";
                $primoGiro=0;
            }

            $daRitornare.= stampaIstanza($nomeEvento, $id_evento, $eta_min, $eta_max, $durata, $ticket, soloData($data_ora), soloOra($data_ora), $id_istanza, $dove, $tipo_evento, $speciale_ragazzi, $speciale);
            
            //gestione TAP e HOLD
            $daRitornare.="<script>".
            'var myElement = document.getElementById("ist'.$id_istanza.'");
            var mc = new Hammer(myElement);
            mc.add( new Hammer.Press({ time: 500 }) );
            mc.on("tap", function(ev) {
                // TAP
                //vai a dettaglio evento
                window.location.href = "dettaglioEvento.html?evento='.$id_evento.'";
            })
            .on("press", function(ev) {
                // HOLD
                //togglePreferito
                $("#ist'.$id_istanza.'").toggleClass("w3-pale-blue");
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
            $azione= "$('#ist".$id_istanza."').addClass('w3-pale-blue');";
            $daRitornare.= "<script>
                        var myIstanze =JSON.parse(localStorage.getItem('istanzaPreferita'));
                        if(myIstanze[".$id_istanza."]){".$azione."}
                        </script>";
            
        }


        return $daRitornare;
    }

    // ITEM (ISTANZA)
    function stampaIstanza($nomeEvento, $numeroEvento, $eta_min, $eta_max, $durata, $ticket, $data, $orario, $id_istanza, $dove, $tipo_evento, $speciale_ragazzi, $speciale) {


        $daRitornare.= "<div id='ist".$id_istanza."' class='istanzaEvento w3-row w3-padding'>" 
                            ."<div class='itemInfoBox w3-col s10'>"
                                ."<div class='itemFasciaEta w3-center w3-blue w3-col s2'>"
                                    .$eta_min."-".$eta_max
                                ."</div>"
                                ."<div class='w3-col s10 w3-container'>"
                                    ."<b>" . $nomeEvento . "</b>"
                                ."</div>"
                                
                                ."<div class='w3-col s2 w3-center'>"
                                    .$orario
                                ."</div>"
                                ."<div class='w3-col s10 w3-container'>"
                                    . $dove
                                ."</div>"
                            ."</div>"
                            ."<div class='itemBadgeBox w3-col s2'>"
                                ."<div class='w3-col s12 w3-center'>"
                                    .stampaItemBadge($tipo_evento)
                                ."</div>"
                            ."</div>"
                            
                        ."</div>";
        
        
                   


        return $daRitornare;
    }
    
    function stampaItemBadge($tipo_evento) {
        
        
        $str .= "<img class='w3-image' src='img/tipologiaEvento/".$tipo_evento.".png' style='max-height:40px;'>";
        
        return $str;
        
        // IMPORTANTE ! nel PDF c'è riferimento a pagina -> badge collegamento o clic su istanza o niente? (clic per dettaglio evento)
        
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