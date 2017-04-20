<?php
require 'funzioniDataOra.php';
require 'funzioniMappeLuoghi.php';

//DETTAGLIO SINGOLO EVENTO
    function stampaEvento($numeroEvento) {
        require 'configurazione.php';// richiamo il file di configurazione
        require 'connessione.php';// richiamo lo script responsabile della connessione a MySQL
        return   "<div class='w3-container'>".stampaTitolo($numeroEvento, $conn)
                .stampaPersona($numeroEvento, $conn)
                .stampaTesto($numeroEvento, $conn)
                .stampaDove($numeroEvento, $conn)
                .stampaMappaEvento($numeroEvento)
                .stampaQuando($numeroEvento, $conn)
                .stampaBadge($numeroEvento, $conn)."</div>";
    }

    function stampaEventoFoto($numeroEvento, $conn) {
        return "<div class='w3-row'>"

            . "<div class='w3-threequarter'>"
                .stampaEventoTest($numeroEvento, $conn)
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
        
        return "<div class='w3-center w3-blue'><h1>" . $nome . "</h1></div>" . verificaSpecialeRagazzi($numeroEvento, $conn);

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
                $daRitornare.= "<b class='cappato'>" . $nome_tipo_rapporto . ":</b> ";
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
            return $alt_name;
        }else{
            if($alt_name != ""){return $nome . " " . $cognome. " (".$alt_name.")";}
            return $nome . " " . $cognome;
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
                ."<div class='l12 w3-center w3-yellow w3-card-4' style='padding:1px;'>"
                    ."<p>" . $eng . "</p>"
                ."</div>";
        $stmt->close();
    }
    
    function stampaDove($numeroEvento, $conn) { // LUOGO E DATE EVENTO(i)
        
        $stmt = $conn->prepare("SELECT L.nome AS dove FROM ((Evento AS E INNER JOIN eventoLuogoData AS eld ON E.id = eld.id_evento) INNER JOIN Luogo AS L ON L.id = eld.id_luogo) WHERE E.id = ?");
        $stmt->bind_param("i", $numeroEvento);
        $stmt->execute();
        $stmt->bind_result($dove);
        $stmt->fetch();
        
        return  "<div class='w3-row'>"
                    ."<div class='w3-col s9'>"
                        ."<h2> Luogo: " . $dove . "<h2>"
                    ."</div>"
                    ."<div class='w3-col s3 '>"
                        ."<h3><button class='w3-button w3-block w3-ripple w3-dark-grey w3-hover-grey w3-round-large mostraMappa'>Mostra Mappa</button></h3>"
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
    
    function stampaBadge($numeroEvento, $conn) { // BADGES
        
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
        
        $sql = "SELECT E.id, eld.data_ora FROM Evento AS E INNER JOIN eventoLuogoData AS eld ON E.id = eld.id_evento ORDER BY data_ora, id;";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($id, $data_ora);

            
        $daRitornare="";
        $ultimaData = "pagliaccio baraldi";
        while($stmt->fetch()) {               
            if($ultimaData != dataIta($data_ora)) {
                $daRitornare.= "". "<h2 class='w3-orange w3-center cappato giornoTutti giorno".soloData($data_ora)."'>" . dataIta($data_ora) . "</h2>" ;
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
                        ."<div class='itemFasciaEta w3-center w3-blue'>"
                            .$eta_min." - ".$eta_max
                        ."</div>"
                        ."<div class='itemNomeEvento w3-half'>"
                            .soloOra($data_ora)
                            ." <b>" . $nome_evento . "</b>"
                            ." - " . $dove
                        ."</div>"
                        ."<div class='itemBadge w3-quarter w3-center'>"
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
        
        
        if($speciale_ragazzi){return "<div class='unQuarto'>"
                                    ."<div class='w3-purple inclinata' style='width:80%;'> <b>T</b> </div> "
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
        if($speciale){return "<div class='unQuarto'>"
                                    ."<div class='w3-red inclinata' style='width:80%;'> <b>S</b> </div> "
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
        
        $str =  "<div class='unQuarto w3-blue'>"
                    ."€".$ticket
                ."</div>"
                ."<div class='unQuarto w3-green'>"
                    .$durata. "'"
                ."</div>"
                ."<div class='unQuarto w3-orange uppato'>"
                    .substr( $tipo_evento, 0, 3 )
                ."</div>";
        $str .= specialeRagazziItemBadge($numeroEvento);
        $str .= specialeItemBadge($numeroEvento);
        
        return $str;
        
        // IMPORTANTE ! nel PDF c'è riferimento a pagina -> badge collegamento o clic su istanza o niente? (clic per dettaglio evento)
        
    }





?>