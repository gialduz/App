<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    
    <title>Artisti - Segni d'Infanzia</title>
    
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/stile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
    <script src="js/jquery.js"></script>

</head>

<body style="max-width:640px; margin:0 auto;">
    <script src="js/menuOverlay.js"></script>
    <script src="js/menuBar.js"></script>
    
    <div id="corpo">
        <div id="spazioBarra"></div>
    
    
    
        
        

      <!-- The Grid -->
        <div class="w3-row w3-pale-yellow">
            
            <?php
                include 'php/mieFunzioni.php';
                $id_artista= $_GET["id"];
                function stampaDettaglioArtista($id_artista) {
                    include 'php/configurazione.php';
                    include 'php/connessione.php';
                    $sql=   "SELECT P.id, P.nome, P.cognome, P.alt_name, P.titolo, P.biografia, P.foto FROM Persona AS P WHERE P.id= ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $id_artista);
                    $stmt->execute();
                    $stmt->bind_result($id, $nome, $cognome, $alt_name, $titolo, $biografia, $foto);        
                    $stmt->fetch();
                    //HEADER
                    $daRitornare= '<div class="w3-container w3-orange w3-text-white"><h2>'.$nome.' '.$cognome.' <small>'.$alt_name.'</small></h2></div>';
                    
                    $daRitornare.= '
                    <!-- Left Column -->
                    <div id="paddingContenutoTranneHeader" class="padded10">
                        <div class="w3-third">

                            <div class="w3-text-grey w3-center">
                                <div class="w3-display-container">
                                    <img src="img/'.$foto.'" style="width:100%" alt="Foto non presente">
                                </div>
                                <div class="padded10">
                                    <h5>Eventi correlati:</h5>'
                                    .stampaEventiCorrelati($id_artista).
                                '</div>
                            </div><br>

                        <!-- End Left Column -->
                        </div>';
                        $daRitornare.= '<!-- Right Column -->
                        <div class="w3-twothird">

                            <div class="w3-container">
                                <h2 class="w3-text-grey noPad">Biografia</h2>
                                <p>'.$biografia.'</p>
                            </div>

                        <!-- End Right Column -->
                        </div>
                    </div>';
                    
                    

                    
                    $conn->close();
                    return $daRitornare;
                }
                
                function stampaEventiCorrelati($id_artista) {
                    include 'php/configurazione.php';
                    include 'php/connessione.php';
                    $sql=   "SELECT DISTINCT E.id, E.nome FROM (Evento AS E INNER JOIN eventoPersona AS ep ON E.id=ep.id_evento) WHERE ep.id_persona= ? ORDER BY E.id";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $id_artista);
                    $stmt->execute();
                    $stmt->store_result(); //nescessario per num_rows
                    $stmt->bind_result($id, $nome); 
                    if($stmt->num_rows) {
                        while($stmt->fetch())   { $daRitornare.= '<a href="dettaglioEvento.php?evento='.$id.'"><div class="w3-text-blue"><p>#'.$id.' '.$nome.'</p></div></a>'; }
                    } else { $daRitornare= "Nessun evento"; }
                    
                    $conn->close();
                    return $daRitornare;
                }
            
                //echo stampaEventiCorrelati($id_artista);
                //echo "<br><hr><br>";
                echo stampaDettaglioArtista($id_artista);
                ?>

      <!-- End Grid -->
      </div>
        
        
    </div>
    
</body>

</html>