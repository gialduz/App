<?php
// LUOGHI E MAPPE
    function stampaElencoLuoghi() {
        include 'configurazione.php';
        include 'connessione.php';
        $sql = "SELECT L.lettera, L.colore, L.nome, L.tipo_via, L.via, L.numero_civico FROM Luogo AS L WHERE 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($lettera, $colore, $nome, $tipo_via, $via, $numero_civico);
        
        $daRitornare="";
        while($stmt->fetch()) {
            $daRitornare.=  "<div class='w3-row w3-border'>"
                                ."<div class='w3-col w3-".$colore." w3-center' style='width:50px'> <h4>" .$lettera. "</h4></div>"
                                ."<div class='w3-rest w3-container'>"."<h4>" .$nome. "<small>, " .$tipo_via." " .$via. " ";
            if($numero_civico!=0) {$daRitornare.= $numero_civico;}             
            $daRitornare.=        "</small> </h4></div>"
                            ."</div>" . "";
        }
        
        return $daRitornare;
    }

    function stampaMappaLuoghi() {
        require 'php/configurazione.php';
        require 'php/connessione.php';
        $sql = "SELECT L.lettera, L.colore, L.nome, L.latitudine, L.longitudine FROM Luogo AS L WHERE 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($lettera, $colore, $nome, $latitudine, $longitudine);
        
        $daRitornare="";
        $daRitornare.= '<div id="map" style="height:650px;"></div>
                        <script>
                        var map;
                        function initMap() {
                            var pos={lat: 45.158428, lng: 10.794230}
                            map = new google.maps.Map(document.getElementById("map"), {
                                center: pos,
                                zoom: 14
                            });';
        while($stmt->fetch()) {
            $daRitornare .= 'pos={lat: '.$latitudine .', lng: '.$longitudine.'};'
                            .'var marker = new google.maps.Marker({
                                position: pos,
                                map: map,
                                title: "'.$nome.'",
                                label: "'. $lettera.'",
                                icon: "img/label/'.$colore.'.jpg"
                            });';
        }
        
        $daRitornare.= '}</script>' . '<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBn8vMQeMyI3ORo43l8YIRPO2uBYk5kdJc&callback=initMap"> </script>';
        
        $stmt->close();
        return $daRitornare;
    }
    
    function stampaMappaEvento($numeroEvento) {
        require 'configurazione.php';
        require 'connessione.php';
        $sql = "SELECT L.lettera, L.colore, L.nome, L.latitudine, L.longitudine, L.id FROM (Luogo AS L INNER JOIN eventoLuogoData AS eld ON eld.id_luogo=L.id) WHERE eld.id_evento= ? ORDER BY L.id";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $numeroEvento);
        $stmt->execute();
        $stmt->bind_result($lettera, $colore, $nome, $latitudine, $longitudine, $id_luogo);
 
        $daRitornare="";
        //Creo div per mappa
        // INIT map
        $daRitornare.= '<div id="map" class="w3-row" style="height:500px; display:none"></div>
                        <script>                        
                        var map;
                        function initMap() {
                            var pos={lat: 45.158428, lng: 10.794230}
                            map = new google.maps.Map(document.getElementById("map"), {
                                center: pos,
                                zoom: 16
                            });';
        
        $ultimoLuogo="primo giro";
                        // MARKERs
        while($stmt->fetch()) {
            if($ultimoLuogo != $id_luogo){  //verifica per stampare il luogo solo una volta
                $daRitornare .= 'pos={lat: '.$latitudine .', lng: '.$longitudine.'};'
                                .'var marker = new google.maps.Marker({
                                    position: pos,
                                    map: map,
                                    title: "'.$nome.'",
                                    label: "'.$lettera.'",
                                    icon: "img/label/'.$colore.'.jpg"
                                });';
            }
            $ultimoLuogo= $id_luogo;
        }
        
                        //FINE INIT map
        $daRitornare.= '}</script>' . '<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBn8vMQeMyI3ORo43l8YIRPO2uBYk5kdJc"> </script>';
        
        //Mostra mappa al click di elementi con classe 'mostraMappa'
        $daRitornare.= '<script>
            $(".mostraMappa").click(function(){
                $("#map").empty();
                $("#map").slideToggle();
                setTimeout(function() {initMap()}, 500);
            });
            </script>';
        $stmt->close();
        return $daRitornare;
    }
    ?>