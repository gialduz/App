<?php

    function stampaArtista($id, $nome, $cognome, $alt_name, $foto) {
                $daRitornare= "<a href='artista.html?id=".$id."'>"
                    ."<div class='w3-row w3-pale-blue w3-hover-grey'>"
                        ."<div class='w3-col s2 w3-center'>"
                                .'<div class="imgQuadrataArtista w3-circle" style="background-image: url('.$foto.');"></div>'
                        ."</div>"
                        ."<div class='w3-col s10'>"
                                .$nome." ".$cognome." <i style='color:grey'>".$alt_name."</i>"
                        ."</div>"
                    ."</div>"
                    ."</a>";
                return $daRitornare;
            }

    

    include 'configurazione.php';
    include 'connessione.php';
    //get the q parameter from URL
    $q="%".$_GET["q"]."%";

    $sql=   "SELECT P.id, P.nome, P.cognome, P.alt_name, P.foto FROM Persona AS P WHERE (P.tipologia= 1 AND ((P.nome LIKE ?) OR (P.cognome LIKE ?) OR (P.alt_name LIKE ?))) ORDER BY P.cognome";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $q, $q, $q);
    $stmt->execute();
    $stmt->bind_result($id, $nome, $cognome, $alt_name, $foto);
    $daRitornare= "";
    while($stmt->fetch()){
        $daRitornare .=  stampaArtista($id, $nome, $cognome, $alt_name, $foto);
    }
    
    if($daRitornare == ""){$daRitornare= "<div class='padded10 w3-center w3-pale-blue'><i>Nessun risultato...</i></div>";}
    echo $daRitornare;

    $conn->close();

?>