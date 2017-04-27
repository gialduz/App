<?php
require 'funzioniDataOra.php';
require 'funzioniMappeLuoghi.php';

//DETTAGLIO SINGOLO EVENTO
    function stampaEvento($numeroEvento) {
        require 'configurazione.php';// richiamo il file di configurazione
        require 'connessione.php';// richiamo lo script responsabile della connessione a MySQL
        return   stampaTitolo($numeroEvento, $conn)
                ."<div class='w3-pale-red w3-container'>".stampaPersona($numeroEvento, $conn)
                .stampaTesto($numeroEvento, $conn)
                .stampaDove($numeroEvento, $conn)
                .stampaMappaEvento($numeroEvento)
                .stampaBadgeQuando($numeroEvento)
                .stampaBadge($numeroEvento, $conn)."</div>";
    }

    function stampaEventoFoto($numeroEvento) { // per web meglio riga -> sopra titolo?
        return "<div class='w3-row'>"

            . "<div class='w3-threequarter'>"
                .stampaEvento($numeroEvento)
            . "</div>"
            . "<div class='w3-quarter w3-black'>"
                    ."F<br>O<br>T<br>A<br>Z<br>Z<br>A<br><br>M<br>O<br>L<br>T<br>O<br><br>S<br>T<br>R<br>E<br>T<br>T<br>A"
            . "</div>"
        . "</div>";
    }
        
    

// componenti dettaglio evento
    function stampaTitolo($numeroEvento, $conn) { // stampa "speciale ragazzi" in rosso sotto al titolo
        
        $stmt = $conn->prepare("SELECT E.nome FROM Evento AS E WHERE E.id = ?");
        $stmt->bind_param("i", $numeroEvento);
        $stmt->execute();
        $stmt->bind_result($nome);
        $stmt->fetch();
        $stmt->close();
        
        return "<div class='w3-container w3-purple'><h2>" . $nome . "</h2></div>" . verificaSpecialeRagazzi($numeroEvento, $conn);

    }

    function verificaSpecialeRagazzi($numeroEvento, $conn) { // stampa "speciale ragazzi" in rosso [RICHIAMATO IN stampaTitolo]
        $stmt = $conn->prepare("SELECT E.speciale_ragazzi FROM Evento AS E WHERE E.id = ?");
        $stmt->bind_param("i", $numeroEvento);
        $stmt->execute();
        $stmt->bind_result($speciale_ragazzi);
        $stmt->fetch();
        $stmt->close();
        if ($speciale_ragazzi){return "<h3 style='color:red;'> SPECIALE RAGAZZI </h3>";}
    }

    function stampaPersona($numeroEvento, $conn) { // COLLABORA, REGIA, MUSICA, PRODOTTO DA, etc
        
        $stmt = $conn->prepare("SELECT tep.nome, P.alt_name, P.nome, P.cognome, P.id FROM (((eventoPersona AS ep INNER JOIN tipologiaEventoPersona AS tep ON tep.id = ep.tipologia) INNER JOIN Evento AS E ON E.id = ep.id_evento) INNER JOIN Persona AS P ON P.id = ep.id_persona) WHERE E.id = ? ORDER BY ep.tipologia");
        $stmt->bind_param("i", $numeroEvento);
        $stmt->execute();
        $stmt->bind_result($nome_tipo_rapporto, $alt_name, $nome, $cognome, $id);
        
        $daRitornare="";
        
        $ultimaTipologia = "babbi l'orsetto";
        while($stmt->fetch()) {
            
            
            if( $nome_tipo_rapporto == $ultimaTipologia ){
                $daRitornare.= ", ". stampaNome($id, $conn);
            }else{
                if($ultimaTipologia != "babbi l'orsetto"){$daRitornare.= "<br>";}
                $daRitornare.= "<span class='cappato'>" . $nome_tipo_rapporto . ":</span> ";
                $daRitornare.= stampaNome($id);
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
            return "<a href='artista.php?id=".$id_persona."' class='w3-text-purple'>". $alt_name . "</a>";
        }else{
            if($alt_name != ""){
            return "<a href='artista.php?id=".$id_persona."' class='w3-text-green'>". $nome . " " . $cognome. " (".$alt_name.")". "</a>";
            }
            return "<a href='artista.php?id=".$id_persona."' class='w3-text-green'>".$nome . " " . $cognome. "</a>";
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
        
        $stmt = $conn->prepare("SELECT L.id, L.nome FROM ((Evento AS E INNER JOIN eventoLuogoData AS eld ON E.id = eld.id_evento) INNER JOIN Luogo AS L ON L.id = eld.id_luogo) WHERE E.id = ?");
        $stmt->bind_param("i", $numeroEvento);
        $stmt->execute();
        $stmt->bind_result($id, $nome);
        $stmt->fetch();
        
        return  "<div class='w3-row'>"
                    ."<div class='w3-col s9 cappato'>"
                        ."<a href='dettaglioLuogo.php?q=".$id."'><h4><b>" .$nome. "</b><h4><a>"
                    ."</div>"
                    ."<div class='w3-col s3 '>"
                        ."<h5><button class='w3-button w3-block dark-green w3-hover-green w3-round-large mostraMappa'><i class='fa fa-map-marker' aria-hidden='true'></i> Maps</button></h5>"
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
        $stmt = $conn->prepare("SELECT eld.data_ora FROM eventoLuogoData AS eld WHERE eld.id_evento = ?");
        $stmt->bind_param("i", $numeroEvento);
        $stmt->execute();
        $stmt->bind_result($data_ora);
        
        $daRitornare="";        
        $ultimoGiornoNumero= 0;
        while($stmt->fetch()) {
            if($ultimoGiornoNumero != soloGiorno(soloData($data_ora))){
                $daRitornare.= ""
                    ."<div class='badgeContainer'>"
                        .'<div class="badge w3-food-salmon">'
                            ."<h1>" . soloGiorno(soloData($data_ora)) . "</h1>" 
                            . "<p>". substr (giornoIta(date('l', strtotime($data_ora))), 0,3) ."</p>"
                        .'</div>'
                        . "<span>". tagliaSec(soloOra($data_ora)) . "</span>"
                    ."</div>";

                $daRitornare.= "<i style='width:10px; float:left'>&nbsp;</i>"; //spazio 10px orizzontale
            } else {
                $daRitornare.= '<script>$("span").last().append("<br>'.tagliaSec(soloOra($data_ora)).'");</script>';
                
            }
            $ultimoGiornoNumero= soloGiorno(soloData($data_ora));            
        }
        return $daRitornare;
    }


    function stampaBadge($numeroEvento) { // BADGES
        require 'php/configurazione.php';
        require 'php/connessione.php';

        $sql = "SELECT E.eta_min, E.eta_max, E.ticket, E.durata, te.nome AS tipo, L.lettera, L.colore AS doveLettera FROM (((Evento AS E INNER JOIN eventoLuogoData AS eld ON E.id = eld.id_evento) INNER JOIN Luogo AS L ON L.id = eld.id_luogo) INNER JOIN tipologiaEvento AS te ON E.tipologia = te.id) WHERE E.id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $numeroEvento);
        $stmt->execute();
        $stmt->bind_result($eta_min, $eta_max, $ticket, $durata, $tipo_evento, $lettera, $colore);
        $stmt->fetch();
         if($ticket){$ticketSN= '€';} else{$ticketSN= 'Free';}
         
        
        return  "<div class='w3-center w3-row'>"
                    ."<div class='badgeContainer'>"
                        ."<div class='badge w3-blue'><h6><b>". $eta_min."-". $eta_max ."</b></h6></div>"
                        ."<span> et&agrave; </span>"
                    ."</div>"
                    ."<i class='spazioBadge'>&nbsp;</i>" //spazio 10px orizzontale
                    ."<div class='badgeContainer'>"
                        ."<div class='badge w3-".$colore."'><h6><b>". $lettera ."</b></h6></div>"
                        ."<span> luogo </span>"
                    ."</div>"
                    ."<i class='spazioBadge'>&nbsp;</i>" //spazio 10px orizzontale
                    ."<div class='badgeContainer'>"
                        ."<div class='badge w3-yellow'><h6><b>". $ticketSN ."</b></h6></div>"
                        ."<span> ticket </span>"
                    ."</div>"
                    ."<i class='spazioBadge'>&nbsp;</i>" //spazio 10px orizzontale
                    ."<div class='badgeContainer'>"
                        ."<div class='badge w3-dark-grey'><h6><b>". $durata ."'</b></h6></div>"
                        ."<span> minuti </span>"
                    ."</div>"
                    ."<i class='spazioBadge'>&nbsp;</i>" //spazio 10px orizzontale
                    ."<div class='badgeContainer'>"
                        ."<div class='badge w3-cyan'><img src='img/tipologiaEvento/".$tipo_evento.".png' class='resp'></div>"
                        ."<span>".$tipo_evento."</span>"
                    ."</div>"
                    /*."<div class='unquinto w3-purple'>"
                        ."<p>Durata: ". $durata ." </p>"
                    ."</div>"
                    ."<div class='unquinto w3-cyan'>"
                        ."<p class='uppato'>" . $tipo_evento ." </p>"
                    ."</div>"*/
                 ."</div>";

    }




    function stampaBadgeTest($numeroEvento, $conn) { // BADGES
        
        $sql = "SELECT E.eta_min, E.eta_max, E.ticket, E.durata, te.nome AS tipo, L.lettera AS doveLettera FROM (((Evento AS E INNER JOIN eventoLuogoData AS eld ON E.id = eld.id_evento) INNER JOIN Luogo AS L ON L.id = eld.id_luogo) INNER JOIN tipologiaEvento AS te ON E.tipologia = te.id) WHERE E.id = ?";
        
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
        
        $sql = "SELECT E.id, eld.data_ora FROM Evento AS E INNER JOIN eventoLuogoData AS eld ON E.id = eld.id_evento "./* WHERE eld.data_ora LIKE '2016%'*/ "ORDER BY data_ora, id;";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($id, $data_ora);

            
        $daRitornare="";
        $ultimaData = "pagliaccio baraldi";
        while($stmt->fetch()) {               
            if($ultimaData != dataIta($data_ora)) {
                $daRitornare.=  "<h2 style='margin:0;' class='w3-orange w3-center cappato giornoTutti giorno"
                    .soloData($data_ora)."'>" . dataIta($data_ora) . "</h2>"
                    ."<div class='w3-row w3-padding giornoTutti giorno".soloData($data_ora)."'>Et&agrave;</div>";
            }

            $daRitornare.= stampaIstanzaEvento($id, soloData($data_ora));
            $ultimaData = dataIta($data_ora);
        }
        
        return $daRitornare;
    }

    // ITEM (ISTANZA)
    function stampaIstanzaEvento($numeroEvento, $data) {
        
        include 'configurazione.php';
        include 'connessione.php';
        
        $stmt = $conn->prepare("SELECT E.id, E.eta_min, E.eta_max, E.nome, eld.data_ora, L.nome AS dove, eld.speciale FROM ((Evento AS E INNER JOIN eventoLuogoData AS eld ON E.id = eld.id_evento) INNER JOIN Luogo AS L ON L.id = eld.id_luogo) WHERE E.id = ?");
        $stmt->bind_param("i", $numeroEvento);
        $stmt->execute();
        $stmt->bind_result($id, $eta_min, $eta_max, $nome_evento, $data_ora, $dove, $speciale);
        $stmt->fetch();
        
        $daRitornare.= "<a href='dettaglioEvento.php?evento=".$numeroEvento."'><div class='w3-row w3-hover-grey w3-padding giornoTutti giorno" .$data. "'>" 
                        ."<div class='itemFasciaEta w3-center w3-blue w3-col s2 m1'>"
                            .$eta_min."-".$eta_max
                        ."</div>"
                        ."<div class='itemNomeEvento w3-col s7 m8'>"
                            ."<div class='w3-col m2 s4 w3-container'>"
                                .soloOra($data_ora)
                            ."</div>"
                            ."<div class='w3-col s8 w3-container'>"
                                ."<b>" . $nome_evento . "</b>"
                            ."</div>"
                            ."<div class='w3-col s12 w3-container'>"
                                . $dove
                            ."</div>"
                        ."</div>"
                        ."<div class='w3-col s3 w3-center hide480'>"
                            .stampaItemBadge($id)
                        ."</div>"
                    ."</div></a>";
        $stmt->close();
        return $daRitornare;
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
                                    ."<div class='w3-purple inclinata' style='width:80%; float:right;'> <b>T</b> </div> "
                                ."</div>";}
        return "";
    }
    
    function specialeItemBadge($numeroEvento) {
        include 'configurazione.php';
        include 'connessione.php';
        $sql=   "SELECT eld.speciale AS speciale FROM eventoLuogoData AS eld WHERE eld.id_evento = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $numeroEvento);
        $stmt->execute();
        $stmt->bind_result($speciale);
        $stmt->fetch();
        if($speciale){return "<div class='w3-col s3'>"
                                    ."<div class='w3-red inclinata' style='width:80%; float:right;'> <b>S</b> </div> "
                                ."</div>";}
        return "";
    }


    function stampaItemBadge($numeroEvento) {
        
        include 'configurazione.php';
        include 'connessione.php';
        $sql = "SELECT E.durata, E.ticket, E.speciale_ragazzi, te.nome AS tipo_evento FROM (Evento AS E INNER JOIN tipologiaEvento AS te ON E.tipologia = te.id) WHERE E.id = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $numeroEvento);
        $stmt->execute();
        $stmt->bind_result($durata, $ticket, $speciale_ragazzi, $tipo_evento);
        $stmt->fetch();
        
        $str =  "";
        $str .= "<div class='w3-col s3 w3-orange uppato'>"
                    .substr( $tipo_evento, 0, 3 )
                ."</div>"
                ."<div class='w3-col s3 w3-green'>"
                    .$durata. "'"
                ."</div>"
                ."<div class='w3-col s3 w3-blue'>"
                    ."€".$ticket
                ."</div>";
        $str .= specialeRagazziItemBadge($numeroEvento);
        $str .= specialeItemBadge($numeroEvento);
        
        return $str;
        
        // IMPORTANTE ! nel PDF c'è riferimento a pagina -> badge collegamento o clic su istanza o niente? (clic per dettaglio evento)
        
    }





?>