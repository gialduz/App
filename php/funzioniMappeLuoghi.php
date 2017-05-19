<?php
// LUOGHI E MAPPE
    function stampaElencoLuoghi() {
        include 'configurazione.php';
        include 'connessione.php';
        $sql = "SELECT L.id, L.lettera, L.colore, L.nome, L.tipo_via, L.via, L.numero_civico FROM Luogo AS L WHERE 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($id, $lettera, $colore, $nome, $tipo_via, $via, $numero_civico);
        
        $daRitornare="<div style='padding-top:25px; padding-bottom:25px;'>";
        while($stmt->fetch()) {
            $daRitornare.=  "<a href='dettaglioLuogo.html?q=".$id."'>"
                            ."<div class='w3-row w3-hover-light-grey'>"
                                ."<div class='w3-col w3-".$colore." w3-text-white w3-center' style='width:30px; height:100%;'> <h5 class='noPad'><b>" .$lettera. "</b></h5></div>"
                                ."<div class='w3-rest w3-container'>"."<h5 class='noPad'>" .$nome. "<small>, " .$tipo_via." " .$via. " ";
            if($numero_civico!=0) {$daRitornare.= $numero_civico;} //Stampa civico se non è 0 (o di default, non assegnato o non VIA)
            $daRitornare.=        "</small> </h5></div>"
                            ."</div>" 
                            . "</a>"
                            ."<hr style='margin:2px 0 2px 0'>";
        }
        $daRitornare.="</div>";
        return $daRitornare;
    }

    function stampaMappaLuoghi() {
        require 'php/configurazione.php';
        require 'php/connessione.php';
        $sql = "SELECT L.id, L.lettera, L.colore, L.nome, L.latitudine, L.longitudine FROM Luogo AS L WHERE 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($id, $lettera, $colore, $nome, $latitudine, $longitudine);
        
        //ALTEZZA MASSIMA MAPPA -> sotto soglia altezza=larghezza
        $maxMapHeight= '"400px"';
        
        $daRitornare="";
        //INIT MAP()
        $daRitornare.= '<div id="mapContainer" style="max-width:640px; margin: 0 auto;"> <div id="map"></div> </div>
                        <script>
                        var map;
                        function initMap() {
                            var posMap={lat: 45.158428, lng: 10.794230}
                            map = new google.maps.Map(document.getElementById("map"), {
                                center: posMap,
                                zoom: 14
                            });';
        while($stmt->fetch()) {
                            //MARKER
            $daRitornare .= 'pos={lat: '.$latitudine .', lng: '.$longitudine.'};'
                            .'var markers = [];
                            var lastInfowindow = 0;
                            markers['.$id.'] = new google.maps.Marker({
                                position: pos,
                                map: map,
                                title: "'.$nome.'",
                                label: {
                                    text: "'.$lettera.'",
                                    color: "white",
                                    fontWeight: "600"
                                },
                                icon: "img/label/'.$colore.'.jpg"
                            });';
            
                            //InfoWindow
            $infoBtn = "<a href='dettaglioLuogo.html?q=".$id."'>"."<i class='fa fa-info-circle fa-2x w3-text-blue w3-hover-text-purple' aria-hidden='true'></i></a>";
            $infoContent = "<h4 class='noPad'>".$infoBtn.$nome."</h4>";
            
            $daRitornare .= '(function(marker) {
                                var infoContent = "'.$infoContent.'";
                                    // add click event
                                    google.maps.event.addListener(marker, "click", function() {
                                        
                                        if(lastInfowindow){lastInfowindow.close();}
                                        infowindow = new google.maps.InfoWindow({
                                            content: infoContent
                                        });
                                        
                                        // chiude ultimo aperto
                                        lastInfowindow= infowindow;
                                        infowindow.open(map, marker);
                                    });
                                })
                                (markers['.$id.']);'; //funzione senza nome, lancia codice sopra - FINE InfoWindow
        }
        
        $daRitornare.= '$(window).resize(function() {
                            altezzaMappa = $("#mapContainer").css("width");
                            if(altezzaMappa > '.$maxMapHeight.') {altezzaMappa= '.$maxMapHeight.';}
                            $("#map").css("height", altezzaMappa)
                            google.maps.event.trigger(map, "resize");
                            map.setCenter(posMap);
                        });
                        var altezzaMappa = $("#mapContainer").css("width");
                        if(altezzaMappa > '.$maxMapHeight.') {altezzaMappa= '.$maxMapHeight.';}
                        $("#map").css("height", altezzaMappa)'; //funzioni gestione resize, setto map height come container width
        
        $daRitornare.= '}</script>' . '<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBn8vMQeMyI3ORo43l8YIRPO2uBYk5kdJc&callback=initMap"> </script>';
        
        $stmt->close();
        return $daRitornare;
    }
    
    function stampaMappaEvento($numeroEvento) {
        require 'configurazione.php';
        require 'connessione.php';
        $sql = "SELECT L.lettera, L.colore, L.nome, L.latitudine, L.longitudine, L.id FROM (Luogo AS L INNER JOIN Evento AS E ON E.luogo=L.id) WHERE E.id= ? ORDER BY L.id";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $numeroEvento);
        $stmt->execute();
        $stmt->bind_result($lettera, $colore, $nome, $latitudine, $longitudine, $id_luogo);
 
        $daRitornare="";
        //Creo div per mappa
        // INIT map
        $daRitornare.= '<div class="padded10" ><div id="map" class="w3-row" style="display:none"></div></div>
                        <style>
                        #map{height:300px}
                        @media (max-width: 480px) {#map{height:200px;}}
                        </style>
                        
                        <script>                        
                        var map;
                        var lastInfowindow = 0;
                        function initMap() {
                            var pos={lat: 45.158428, lng: 10.794230}
                            map = new google.maps.Map(document.getElementById("map"), {
                                center: pos,
                                zoom: 17
                            });';
        
        $ultimoLuogo="primo giro";
                // MARKERs
        while($stmt->fetch()) {
            if($ultimoLuogo != $id_luogo){  //verifica per stampare il luogo solo una volta
                $daRitornare .= 'pos={lat: '.$latitudine .', lng: '.$longitudine.'};    var posMarker= pos;'
                                .'var marker = new google.maps.Marker({
                                    position: pos,
                                    map: map,
                                    title: "'.$nome.'",
                                    label: {
                                        text: "'.$lettera.'",
                                        color: "white",
                                        fontWeight: "600"
                                    },
                                    icon: "img/label/'.$colore.'.jpg"
                                });';
                //InfoWindow
                $infoBtn = "<a href='dettaglioLuogo.html?q=".$id_luogo."'>"."<i class='fa fa-info-circle fa-2x w3-text-blue w3-hover-text-purple' aria-hidden='true'></i></a>";
                $infoContent = "<h4 class='noPad'>".$infoBtn.$nome."</h4>";
                $daRitornare .= '(function (marker) {
                                    var infoContent = "'.$infoContent.'";
                                        // add click event
                                        google.maps.event.addListener(marker, "click", function() {

                                            if(lastInfowindow){lastInfowindow.close();}
                                            infowindow = new google.maps.InfoWindow({
                                                content: infoContent
                                            });

                                            // chiude ultimo aperto
                                            lastInfowindow= infowindow;
                                            infowindow.open(map, marker);
                                        });
                                    })
                                    (marker);'; //funzione senza nome, lancia codice sopra       
            }
            $ultimoLuogo= $id_luogo;
        }
        $daRitornare.='map.setCenter(posMarker);';
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