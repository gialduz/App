<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    
    <title>Dettaglio Luogo - Segni d'Infanzia</title>

</head>

<body style="max-width:640px; margin:0 auto;">
    
    <div id="corpo">

      <!-- The Grid -->
        <div class="w3-row w3-pale-blue">
            
            <?php
                include 'php/mieFunzioni.php';
                $id_luogo= $_GET["q"];
                function stampaDettaglioLuogo($id_luogo) {
                    include 'php/configurazione.php';
                    include 'php/connessione.php';
                    $sql=   "SELECT L.id, L.nome, L.latitudine, L.longitudine, L.descrizione, L.foto FROM Luogo AS L WHERE L.id= ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $id_luogo);
                    $stmt->execute();
                    $stmt->bind_result($id, $nome, $latitudine, $longitudine, $descrizione, $foto);        
                    $stmt->fetch();
                    //HEADER
                    $daRitornare= '<div class="w3-container w3-blue"><h2>'.$nome.'</h2></div>';
                    
                    $daRitornare.= '
                    <!-- Left Column -->
                    <div id="paddingContenutoTranneHeader" class="padded10">
                        <div class="w3-third">

                            <div class="w3-text-grey">
                                <div class="w3-display-container">
                                    <img src="'.$foto.'" style="width:100%" alt="Nessuna immagine del luogo">
                                </div>
                                <div class="padded10 w3-white w3-center">
                                    <a href="http://maps.apple.com/?q='.$nome.'&daddr='.$latitudine.', '.$longitudine.'&dirflg=w" target="_blank">
                                        <button class="w3-button w3-green w3-hover-orange w3-round-xxlarge">
                                            Portami qui! <i class="fa fa-location-arrow" aria-hidden="true"></i>
                                        </button>
                                    </a>
                                    <hr>
                                    <h5>Eventi correlati:</h5>'
                                    .stampaEventiCorrelati($id_luogo).
                                '</div>
                            </div><br>
                        <!-- End Left Column -->
                        </div>';

                        $daRitornare.= '<!-- Right Column -->
                        <div class="w3-twothird w3-container">

                            <div class="">
                                <h4 class="w3-text-grey noPad"> Descrizione luogo:</h4>
                                <p>'.$descrizione.'</p>
                            </div>

                        <!-- End Right Column -->
                        </div>
                    </div>';
                    
                    $conn->close();
                    return $daRitornare;
                }
                
                function stampaEventiCorrelati($id_luogo) {
                    include 'php/configurazione.php';
                    include 'php/connessione.php';
                    $sql=   "SELECT DISTINCT E.id, E.nome FROM Evento AS E WHERE E.luogo= ? ORDER BY E.id";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $id_luogo);
                    $stmt->execute();
                    $stmt->store_result(); //nescessario per num_rows
                    $stmt->bind_result($id, $nome); 
                    if($stmt->num_rows) {
                        while($stmt->fetch())   { $daRitornare.= '<a href="dettaglioEvento.html?evento='.$id.'"><div class="w3-text-blue"><p>[#'.$id.'] '.$nome.'</p></div></a>'; }
                    } else { $daRitornare= "Nessun evento"; }
                    
                    $conn->close();
                    return $daRitornare;
                }
            
                //echo stampaEventiCorrelati($id_luogo);
                //echo "<br><hr><br>";
                echo stampaDettaglioLuogo($id_luogo);
                ?>

      <!-- End Grid -->
      </div>
    
    
    </div>
</body>

</html>