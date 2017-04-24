<?php

    function stampaArtista($id, $nome, $cognome, $alt_name) {
        $daRitornare= "<a href='artista.php?id=".$id."'>"
            ."<div class='w3-row padded10 w3-hover-orange w3-pale-blue'>"
                ."<div class='w3-col l12 w3-center'> <b>- </b>".$nome." ".$cognome." <i style='color:grey'>".$alt_name."</i> </div>"
            ."</div>" ."<hr style='padding:0; margin:0;'>"
            ."</a>";
        return $daRitornare;
    }

    

    include 'configurazione.php';
    include 'connessione.php';
    //get the q parameter from URL
    $q="%".$_GET["q"]."%";

    $sql=   "SELECT P.id, P.nome, P.cognome, P.alt_name FROM Persona AS P WHERE (P.tipologia= 1 AND ((P.nome LIKE ?) OR (P.cognome LIKE ?) OR (P.alt_name LIKE ?))) ORDER BY P.cognome";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $q, $q, $q);
    $stmt->execute();
    $stmt->bind_result($id, $nome, $cognome, $alt_name);
    $daRitornare= "";
    while($stmt->fetch()){
        $daRitornare .=  stampaArtista($id, $nome, $cognome, $alt_name);
    }
    
    if($daRitornare == ""){$daRitornare= "<div class='padded10 w3-center w3-pale-blue'><i>Nessun risultato...</i></div>";}
    echo $daRitornare;

    $conn->close();

?>