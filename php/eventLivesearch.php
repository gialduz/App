<?php

    function stampaEventoResult($id, $nome) {
        $daRitornare= "<a href='dettaglioEvento.php?evento=".$id."'>"
            ."<div class='w3-row padded10 w3-hover-grey w3-pale-yellow'>"
                ."<div class='w3-col l12 w3-center'> [".$id."] <b>".$nome."</b></div>"
            ."</div>" ."<hr style='padding:0; margin:0;'>"
            ."</a>";
        return $daRitornare;
    }

    

    include 'configurazione.php';
    include 'connessione.php';
    //get the q parameter from URL
    $q="%".$_GET["q"]."%";

    $sql=   "SELECT E.id, E.nome FROM Evento AS E WHERE (E.nome LIKE ?) ORDER BY E.id";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $q);
    $stmt->execute();
    $stmt->bind_result($id, $nome);
    $daRitornare= "";
    while($stmt->fetch()){
        $daRitornare .=  stampaEventoResult($id, $nome);
    }
    
    if($daRitornare == ""){$daRitornare= "<div class='padded10 w3-center w3-pale-red'><i>Nessun risultato...</i></div>";}
    echo $daRitornare;

    $conn->close();

?>