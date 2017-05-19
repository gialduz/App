<?php
require 'funzioniDataOra.php';
require 'funzioniMappeLuoghi.php';

//DETTAGLIO SINGOLO EVENTO
    function stampaEvento($numeroEvento) {
        require 'configurazione.php';// richiamo il file di configurazione
        require 'connessione.php';// richiamo lo script responsabile della connessione a MySQL
        return   stampaTitolo($numeroEvento, $conn)
                .stampaFoto($numeroEvento, $conn)
                //.stampaAggiungiPreferito()
                ."<div class='w3-pale-red' style='padding: 15px 20px 15px 20px;'>".stampaPersona($numeroEvento, $conn)
                .stampaTesto($numeroEvento, $conn)
                .stampaDove($numeroEvento, $conn)
                .stampaMappaEvento($numeroEvento)
                ."<hr>".stampaBadgeQuando2($numeroEvento)
                ."<hr>".stampaBadge($numeroEvento, $conn)."<hr>"
                ."<a href='mockupInfo.html#-infoBiglietti'> <div class='w3-container w3-purple w3-card-8 w3-round w3-center'><h4><b>"."Prenota evento"."</b></h4>"."</div></a><hr>"
                .stampaBadgeSponsor($numeroEvento)
                ."</div>";
    }
        
    

// componenti dettaglio evento
    function stampaTitolo($numeroEvento, $conn) { // stampa "speciale ragazzi" in rosso sotto al titolo
        
        $stmt = $conn->prepare("SELECT E.nome FROM Evento AS E WHERE E.id = ?");
        $stmt->bind_param("i", $numeroEvento);
        $stmt->execute();
        $stmt->bind_result($nome);
        $stmt->fetch();
        $stmt->close();
        
        
        return "<div class='w3-container w3-purple w3-text-white'><h2><span style='margin-right:5px;'>" . $nome. "</span>" . verificaSpecialeRagazzi($numeroEvento, $conn)."</h2></div>" ;

    }

    function verificaSpecialeRagazzi($numeroEvento, $conn) { // stampa "speciale ragazzi" in rosso [RICHIAMATO IN stampaTitolo]
        $stmt = $conn->prepare("SELECT E.speciale_ragazzi FROM Evento AS E WHERE E.id = ?");
        $stmt->bind_param("i", $numeroEvento);
        $stmt->execute();
        $stmt->bind_result($speciale_ragazzi);
        $stmt->fetch();
        $stmt->close();
        if ($speciale_ragazzi){return "<span style='padding-top:10px'><i class='w3-white w3-text-purple w3-cell w3-large w3-round padded5'>Teen Special</i></span>";}
    }


    function stampaFoto($numeroEvento, $conn) {
        
        $stmt = $conn->prepare("SELECT E.foto_mini FROM Evento AS E WHERE E.id = ?");
        $stmt->bind_param("i", $numeroEvento);
        $stmt->execute();
        $stmt->bind_result($foto);
        $stmt->fetch();
        $stmt->close();
        
        
        return "<img alt='' class='w3-image' src='".$foto."'>" ;

    }



    function stampaAggiungiPreferito() { // salva preferito in JS in pagina dettaglioEvento.php
        
        return "<button id='btnPreferito' class='w3-padding w3-right w3-button' onclick='salvaPreferito()'> <i class='fa fa-heart-o' aria-hidden='true'></i> </button>" ;

    }
    

    function stampaPersona($numeroEvento, $conn) { // COLLABORA, REGIA, MUSICA, PRODOTTO DA, etc
        
        $stmt = $conn->prepare("SELECT tep.nome, P.alt_name, P.nome, P.cognome, P.id FROM (((eventoPersona AS ep INNER JOIN tipologiaEventoPersona AS tep ON tep.id = ep.tipologia) INNER JOIN Evento AS E ON E.id = ep.id_evento) INNER JOIN Persona AS P ON P.id = ep.id_persona) WHERE E.id = ? ORDER BY ep.tipologia");
        $stmt->bind_param("i", $numeroEvento);
        $stmt->execute();
        $stmt->bind_result($nome_tipo_rapporto, $alt_name, $nome, $cognome, $id);
        
        $daRitornare="";
        
        $ultimaTipologia = "babbi l'orsetto";
        while($stmt->fetch()) {
            
            if($nome_tipo_rapporto == "sponsor"){$daRitornare.= "";}
            else{
            
                if( $nome_tipo_rapporto == $ultimaTipologia ){
                    $daRitornare.= ", ". stampaNome($id, $conn);
                }else{
                    if($ultimaTipologia != "babbi l'orsetto"){$daRitornare.= "<br>";}
                    $daRitornare.= "<span class='cappato'>" . $nome_tipo_rapporto . ":</span> ";
                    $daRitornare.= stampaNome($id);
                }
            }
            $ultimaTipologia = $nome_tipo_rapporto;            
        }
        return $daRitornare;
    }

    function stampaNome($id_persona) { // COLLABORA, REGIA, MUSICA, PRODOTTO DA, etc
        include 'configurazione.php';
        include 'connessione.php';
        $stmt = $conn->prepare("SELECT P.nome, P.cognome, P.alt_name AS nick, P.tipologia FROM Persona AS P WHERE P.id = ?");
        $stmt->bind_param("i", $id_persona);
        $stmt->execute();
        $stmt->bind_result($nome, $cognome, $alt_name, $tipologia);
        $stmt->fetch();

        if($alt_name != "" && $tipologia != 1){
            return "<a href='artista.html?id=".$id_persona."' class='w3-text-purple'>". $alt_name . "</a>";
        }else{
            if($alt_name != ""){
            return "<a href='artista.html?id=".$id_persona."' class='w3-text-blue'>". $nome . " " . $cognome. " (".$alt_name.")". "</a>";
            }
            return "<a href='artista.html?id=".$id_persona."' class='w3-text-blue'>".$nome . " " . $cognome. "</a>";
        }
    }  
    
    function stampaTesto($numeroEvento, $conn) { // TESTI ITA-ENG
        $stmt = $conn->prepare("SELECT E.descrizione_ita AS itaTxt, E.descrizione_eng AS engTxt FROM Evento AS E WHERE E.id = ?");
        $stmt->bind_param("i", $numeroEvento);
        $stmt->execute();
        $stmt->bind_result($ita, $eng);
        $stmt->fetch();
        
        return  "<div class='l12 w3-justify'>"
                    ."<p>" . $ita . "</p>"
                ."</div>"
                ."<div class='l12 w3-center padded5 w3-leftbar w3-light-blue w3-border-blue'>"
                    ."<p>" . $eng . "</p>"
                ."</div>";
        $stmt->close();
    }
    
    function stampaDove($numeroEvento, $conn) { // LUOGO E DATE EVENTO(i)
        
        $stmt = $conn->prepare("SELECT L.id, L.nome FROM ((Evento AS E INNER JOIN eventoLuogoData AS eld ON E.id = eld.id_evento) INNER JOIN Luogo AS L ON L.id = E.luogo) WHERE E.id = ?");
        $stmt->bind_param("i", $numeroEvento);
        $stmt->execute();
        $stmt->bind_result($id, $nome);
        $stmt->fetch();
        
        return  "<div class='w3-row'>"
                    ."<div class='w3-col w3-text-purple s9 cappato w3-round w3-center'>"
                        ."<a href='dettaglioLuogo.html?q=".$id."'><h4><b>" .$nome. "</b><h4></a>"
                    ."</div>"
                    ."<div class='w3-col s3 '>"
                        ."<h6><button class='w3-button w3-block dark-green w3-hover-green w3-round mostraMappa'><i class='fa fa-map-marker' aria-hidden='true'></i> Map</button></h6>"
                    ."</div>"
                ."</div>";
        $stmt->close();
    }

    function stampaQuando($numeroEvento, $conn) { // COLLABORA, REGIA, MUSICA, PRODOTTO DA, etc
        
        $stmt = $conn->prepare("SELECT eld.data, eld.orario FROM eventoLuogoData AS eld WHERE eld.id_evento = ?");
        $stmt->bind_param("i", $numeroEvento);
        $stmt->execute();
        $stmt->bind_result($data, $orario);
        
        $daRitornare="";
        $daRitornare.=   "<div class='l12 w3-deep-orange'>";
        $daRitornare.=       "<p> Date evento: </p>";
        while($stmt->fetch()) {
            $daRitornare.= "<div class='w3-center'><b>" . dataIta($data) . " - " . tagliaSec($orario) . "</b></div>";
        }
        
        $daRitornare.= "</div>";
        return $daRitornare;
    }

    function stampaBadgeQuando($numeroEvento) {
        require 'php/configurazione.php';
        require 'php/connessione.php';
        $stmt = $conn->prepare("SELECT eld.data_ora, eld.speciale FROM eventoLuogoData AS eld WHERE eld.id_evento = ? ORDER BY eld.data_ora");
        $stmt->bind_param("i", $numeroEvento);
        $stmt->execute();
        $stmt->bind_result($data_ora, $speciale);
        
        $daRitornare= "" ."<div class='w3-center w3-row'>";        
        $ultimoGiornoNumero= 0;
        $stellaRossa= "<div class='fa fa-star-o w3-red w3-text-white' aria-hidden='true' style='padding:1px;'></div>";
        
        while($stmt->fetch()) {
            $daRitornare.= "<div class='badgeContainer'>"; //apro bCont
            if($ultimoGiornoNumero != soloGiorno(soloData($data_ora))){

            $daRitornare.='<div class="badge w3-food-salmon">'
                            ."<h1>" . soloGiorno(soloData($data_ora)) . "</h1>" 
                            . "<p>". substr (giornoIta(date('l', strtotime($data_ora))), 0,3) ."</p>"
                        .'</div>';
            if($speciale){$daRitornare.= "<span class='abra'>".$stellaRossa." ".tagliaSec(soloOra($data_ora)).'</span>';}
            else{$daRitornare.= "<span class='abra'>". tagliaSec(soloOra($data_ora)) . "</span>";}
            
            } else {
                if($speciale){$daRitornare.= "<span class='abra'>".$stellaRossa." ".tagliaSec(soloOra($data_ora)).'</span>';}
                else{$daRitornare.= "<span class='abra'>". tagliaSec(soloOra($data_ora)) . "</span>";}
                

            }
            
            $daRitornare.="</div>"; //chiudo bCont
            $daRitornare.= "<i style='width:10px; float:left'>&nbsp;</i>"; //spazio 10px orizzontale
            $ultimoGiornoNumero= soloGiorno(soloData($data_ora));            
        }
        return $daRitornare. "</div><br>";
    }

    function stampaBadgeQuando2($numeroEvento) {
        require 'php/configurazione.php';
        require 'php/connessione.php';
        $stmt = $conn->prepare("SELECT eld.data_ora, eld.speciale FROM eventoLuogoData AS eld WHERE eld.id_evento = ? ORDER BY eld.data_ora");
        $stmt->bind_param("i", $numeroEvento);
        $stmt->execute();
        $stmt->bind_result($data_ora, $speciale);
        
        $giorni=array();
        $i=0;
        $ultimoGiornoNumero= 0;
        
        while($stmt->fetch()) {
            
            if($ultimoGiornoNumero != soloGiorno(soloData($data_ora))){
                $giorni[$i]= soloData($data_ora);
                $i++;
            }            
            $ultimoGiornoNumero= soloGiorno(soloData($data_ora));  
        }
        $i=0;
        
        $daRitornare.= "<div class='w3-row'>";
        while($giorni[$i]) {
                        //$daRitornare.= $giorni[$i] ."<br>";  

            $daRitornare.= stampaBadgeQuandoGiorno($numeroEvento, $giorni[$i]);  

            $i++;
        }
        $daRitornare.= "</div>";
        
        return $daRitornare;
    }

    function stampaBadgeQuandoGiorno($numeroEvento, $giorno) {
        require 'php/configurazione.php';
        require 'php/connessione.php';
        $stellaRossa= "<div class='fa fa-star-o w3-red w3-text-white' aria-hidden='true' style='padding:1px;'></div>";
        $dataSQL= $giorno."%";
        
        $stmt = $conn->prepare("SELECT eld.data_ora, eld.speciale FROM eventoLuogoData AS eld WHERE (eld.id_evento = ? AND eld.data_ora LIKE ?) ORDER BY eld.data_ora");
        $stmt->bind_param("is", $numeroEvento, $dataSQL);
        $stmt->execute();
        $stmt->bind_result($data_ora, $speciale);
        
        $daRitornare.= "<div class='w3-col m2 s3'>";
        $daRitornare.='<div class="badge w3-food-salmon">'
                            ."<h1>" . soloGiorno($giorno) . "</h1>" 
                            . "<p>". substr (giornoIta(date('l', strtotime($giorno))), 0,3) ."</p>"
                        .'</div>';
        
        $daRitornare.=      "<div class='badgeCaption'>";
        
        while($stmt->fetch()) {
            if(!$speciale) $daRitornare.= "<span>" .soloOra($data_ora). "</span><br>";
            else $daRitornare.= "<span class='w3-text-red'>".soloOra($data_ora)." ".$stellaRossa."</span><br>";
        }
        $daRitornare.=      "</div>";

        $daRitornare.= "</div>";

        
        return $daRitornare;
    }


    function stampaBadge($numeroEvento) { // BADGES
        require 'php/configurazione.php';
        require 'php/connessione.php';

        $sql = "SELECT E.eta_min, E.eta_max, E.ticket, E.durata, te.nome AS tipo, L.lettera, L.colore AS doveLettera FROM (((Evento AS E INNER JOIN eventoLuogoData AS eld ON E.id = eld.id_evento) INNER JOIN Luogo AS L ON L.id = E.luogo) INNER JOIN tipologiaEvento AS te ON E.tipologia = te.id) WHERE E.id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $numeroEvento);
        $stmt->execute();
        $stmt->bind_result($eta_min, $eta_max, $ticket, $durata, $tipo_evento, $lettera, $colore);
        $stmt->fetch();
        if($ticket){$ticketSN= '€';} else{$ticketSN= 'Free';}
         
        
        return  "<div class='w3-row'>"
                    ."<div class='w3-col m2 s3' style='margin-bottom:16px'>"
                        ."<div class='badge w3-blue'><h6><b>". $eta_min."-". $eta_max ."</b></h6></div>"
                        ."<div class='badgeCaption'><span> et&agrave; </span></div>"
                    ."</div>"
                    //."<i class='spazioBadge'>&nbsp;</i>" //spazio 10px orizzontale
                    ."<div class='w3-col m2 s3' style='margin-bottom:16px'>"
                        ."<div class='badge w3-text-white w3-".$colore."'><h4><b>". $lettera ."</b></h4></div>"
                        ."<div class='badgeCaption'><span> luogo </span></div>"
                    ."</div>"
                    //."<i class='spazioBadge'>&nbsp;</i>" //spazio 10px orizzontale
                    ."<div class='w3-col m2 s3' style='margin-bottom:16px'>"
                        ."<div class='badge w3-yellow'><h6><b>". $ticketSN ."</b></h6></div>"
                        ."<div class='badgeCaption'><span> ticket </span></div>"
                    ."</div>"
                    //."<i class='spazioBadge'>&nbsp;</i>" //spazio 10px orizzontale
                    ."<div class='w3-col m2 s3' style='margin-bottom:16px'>"
                        ."<div class='badge w3-dark-grey'><h6><b>". $durata ."'</b></h6></div>"
                        ."<div class='badgeCaption'><span> minuti </span></div>"
                    ."</div>"
                    //."<i class='spazioBadge'>&nbsp;</i>" //spazio 10px orizzontale
                    ."<div class='w3-col m2 s3' style='margin-bottom:16px'>"
                        ."<div class='badge'><img src='img/tipologiaEvento/".$tipo_evento.".png' class='resp'></div>"
                        ."<div class='badgeCaption'><span>".$tipo_evento."</span></div>"
                    ."</div>"
                    /*."<div class='unquinto w3-purple'>"
                        ."<p>Durata: ". $durata ." </p>"
                    ."</div>"
                    ."<div class='unquinto w3-cyan'>"
                        ."<p class='uppato'>" . $tipo_evento ." </p>"
                    ."</div>"*/
                 ."</div>";

    }

    function stampaBadgeSponsor($numeroEvento) { // BADGES
        require 'php/configurazione.php';
        require 'php/connessione.php';

        $sql = "SELECT P.alt_name, P.foto FROM ((eventoPersona AS ep INNER JOIN (Persona AS P INNER JOIN tipologiaPersona AS tp ON P.tipologia= tp.id) ON ep.id_persona= P.id) INNER JOIN tipologiaEventoPersona AS tep ON ep.tipologia= tep.id) WHERE (ep.id_evento = ? AND tep.nome= 'sponsor')";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $numeroEvento);
        $stmt->execute();
        $stmt->bind_result($alt_name, $foto);
        
        $daRitornare= "<div class='w3-row'>";
        $primoGiro=1;
        while($stmt->fetch()){
                if($primoGiro){$daRitornare.= "<div id='headSponsor'><h3>Sponsor</h3></div>"; $primoGiro=0;}

              /*$daRitornare.= "<div class='badgeContainer w3-center'>"
                                .'<div class="imgQuadrataArtista" style="background-image: url('.$foto.');"></div>'
                                //."<span>".$alt_name."</span>"
                            ."</div>"
                            ."<i class='spazioBadge'>&nbsp;</i>"; //spazio 10px orizzontale;*/
            
            
            
            $daRitornare.= "<div class='w3-col m2 s3'>"
                        ."<div class='badge'><img src='".$foto."' class='resp'></div>"
                        ."<div class='badgeCaption'><span>".$alt_name."</span></div>"
                    ."</div>";
                            
        }
        if($stmt->num_rows() == 0){$daRitornare.= "<script>$('#headSponsor').hide();</script>";}
        $daRitornare.= "</div>";
        return $daRitornare;
    }




    function stampaBadgeTest($numeroEvento, $conn) { // BADGES
        
        $sql = "SELECT E.eta_min, E.eta_max, E.ticket, E.durata, te.nome AS tipo, L.lettera AS doveLettera FROM (((Evento AS E INNER JOIN eventoLuogoData AS eld ON E.id = eld.id_evento) INNER JOIN Luogo AS L ON L.id = E.luogo) INNER JOIN tipologiaEvento AS te ON E.tipologia = te.id) WHERE E.id = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $numeroEvento);
        $stmt->execute();
        $stmt->bind_result($eta_min, $eta_max, $ticket, $durata, $tipo_evento, $lettera);
        $stmt->fetch();
        
        return  "<div class='w3-center w3-row'>"
                    ."<div class='unquinto w3-blue'>"
                        ."<p> Et&agrave;: ". $eta_min." - ". $eta_max ." </p>"
                    ."</div>"
                    ."<div class='unquinto w3-orange'>"
                        ."<p>Luogo: ". $lettera ." </p>"
                    ."</div>"
                    ."<div class='unquinto w3-green'>"
                        ."<p>Ticket: ". $ticket ." </p>"
                    ."</div>"
                    ."<div class='unquinto w3-purple'>"
                        ."<p>Durata: ". $durata ." </p>"
                    ."</div>"
                    ."<div class='unquinto w3-cyan'>"
                        ."<p class='uppato'>" . $tipo_evento ." </p>"
                    ."</div>"
                 ."</div>";

    }


// STAMPA LISTA EVENTI
//stampa completa
    function stampaListaIstanzeEvento() {
        
        include 'configurazione.php';
        include 'connessione.php';
        
        $sql = "SELECT E.id, eld.data_ora, eld.id_istanza FROM Evento AS E INNER JOIN eventoLuogoData AS eld ON E.id = eld.id_evento ORDER BY data_ora, id;";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($id, $data_ora, $id_istanza);

            
        $daRitornare="";
        $ultimaData = "pagliaccio baraldi";
        while($stmt->fetch()) {               
            if($ultimaData != dataIta($data_ora)) {
                $daRitornare.=  "<h2 style='margin:0;' class='w3-orange w3-center cappato giornoTutti giorno"
                    .soloData($data_ora)."'>" . dataIta($data_ora) . "</h2>"
                    ."<div class='w3-row w3-padding giornoTutti giorno".soloData($data_ora)."'>Et&agrave;</div>";
            }

            $daRitornare.= stampaIstanzaEvento($id, soloData($data_ora), soloOra($data_ora), $id_istanza);
            $ultimaData = dataIta($data_ora);
        }
        
        
        //rende badge alti uguali, una volta stampati     +onResize()
        $daRitornare .= "<script>
                            $('.itemBadge').each(function(){
                                $(this).height($(this).width());
                            });
                            $( window ).resize(function() {
                                $('.itemBadge').each(function(){
                                    $(this).height($(this).width());
                                    
                                });
                            });
                            

                        </script>";
        
        return $daRitornare;
    }

    // ITEM (ISTANZA)
    function stampaIstanzaEvento($numeroEvento, $data, $orario, $id_istanza) {
        
        include 'configurazione.php';
        include 'connessione.php';
        
        $stmt = $conn->prepare("SELECT E.id, E.eta_min, E.eta_max, E.nome, eld.data_ora, L.nome AS dove, eld.speciale FROM ((Evento AS E INNER JOIN eventoLuogoData AS eld ON E.id = eld.id_evento) INNER JOIN Luogo AS L ON L.id = E.luogo) WHERE eld.id_istanza = ?");
        $stmt->bind_param("i", $id_istanza);
        $stmt->execute();
        $stmt->bind_result($id, $eta_min, $eta_max, $nome_evento, $data_ora, $dove, $speciale);
        $stmt->fetch();
        
        $daRitornare.= "<a href='dettaglioEvento.html?evento=".$numeroEvento."'><div class='w3-row w3-hover-grey w3-padding giornoTutti giorno" .$data. "'>" 
                        ."<div class='itemFasciaEta w3-center w3-blue w3-col s2 m1'>"
                            .$eta_min."-".$eta_max
                        ."</div>"
                        ."<div class='itemNomeEvento w3-col s7 m8'>"
                            ."<div class='w3-col m2 s4 w3-container'>"
                                .$orario
                            ."</div>"
                            ."<div class='w3-col s8 w3-container'>"
                                ."<b>" . $nome_evento . "</b>"
                            ."</div>"
                            ."<div class='w3-col s12 w3-container'>"
                                . $dove
                            ."</div>"
                        ."</div>"
                        ."<div class='w3-col s3 w3-center'>"
                            .stampaItemBadge($id_istanza)
                        ."</div>"
                    ."</div></a>";
        
        
        $stmt->close();
        return $daRitornare;
    }

    function stampaItemBadge($id_istanza) {
        
        include 'configurazione.php';
        include 'connessione.php';
        $sql = "SELECT E.id, E.durata, E.ticket, E.speciale_ragazzi, te.nome AS tipo_evento FROM ((Evento AS E INNER JOIN tipologiaEvento AS te ON E.tipologia = te.id) INNER JOIN eventoLuogoData AS eld ON eld.id_evento = E.id) WHERE eld.id_istanza = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_istanza);
        $stmt->execute();
        $stmt->bind_result($id_evento, $durata, $ticket, $speciale_ragazzi, $tipo_evento);
        $stmt->fetch();
        
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
        $str .= specialeRagazziItemBadge($id_evento);
        $str .= specialeItemBadge($id_istanza);
        
        
        
        return $str;
        
        // IMPORTANTE ! nel PDF c'è riferimento a pagina -> badge collegamento o clic su istanza o niente? (clic per dettaglio evento)
        
    }

//stampa singolo componente di un ITEM
    function specialeRagazziItemBadge($numeroEvento) {
        include 'configurazione.php';
        include 'connessione.php';
        $sql = "SELECT E.speciale_ragazzi AS spec FROM Evento AS E WHERE E.id = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $numeroEvento);
        $stmt->execute();
        $stmt->bind_result($speciale_ragazzi);
        $stmt->fetch();
        
        
        if($speciale_ragazzi){return "<div class='w3-col s3'>"
                                    ."<div class='w3-purple inclinata itemBadge' style='width:80%; float:right;'> <p><b>T</b></p> </div> "
                                ."</div>";}
        return "";
    }
    
    function specialeItemBadge($id_istanza) {
        include 'configurazione.php';
        include 'connessione.php';
        $sql=   "SELECT eld.speciale AS speciale FROM eventoLuogoData AS eld WHERE eld.id_istanza = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_istanza);
        $stmt->execute();
        $stmt->bind_result($speciale);
        $stmt->fetch();
        if($speciale){return "<div class='w3-col s3'>"
                                    ."<div class='w3-red inclinata itemBadge' style='width:80%; float:right;'> <p><b>S</b></p> </div> "
                                ."</div>";}
        return "";
    }


    





?>