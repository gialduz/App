<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    
    <title>Sponsor - Segni d'Infanzia</title>
    
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/stile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="js/jquery.js"></script>
    
</head>

<body style="max-width:640px; margin:0 auto;">
    <script src="js/menuOverlay.js"></script>
    <script src="js/menuBar.js"></script>
    <div id="spazioBarra"></div>
     
    
    <div id="corpo" class="w3-row">
        <?php

            function stampaProduzione() {
                include 'php/configurazione.php';
                include 'php/connessione.php';
                $sql=   "SELECT P.alt_name, P.link, P.foto_mini FROM (Persona AS P INNER JOIN tipologiaPersona AS tP ON P.tipologia=tP.id) WHERE tP.nome= 'produzione' ORDER BY P.alt_name";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $stmt->bind_result($alt_name, $link, $foto_mini);
                $daRitornare= "<div class='w3-col l12'><h3 class='w3-purple noPad padded10'>Produzione:</h3></div>";

                while($stmt->fetch()){
                    $daRitornare .= stampaIconaSponsor($alt_name, $link, $foto_mini);
                }
                
                $conn->close();
                return $daRitornare;
            }
            
        
            function stampaSponsors() {
                include 'php/configurazione.php';
                include 'php/connessione.php';
                $sql=   "SELECT P.alt_name, P.link, P.foto_mini FROM (Persona AS P INNER JOIN tipologiaPersona AS tP ON P.tipologia=tP.id) WHERE tP.nome= 'sponsor' ORDER BY P.alt_name";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $stmt->bind_result($alt_name, $link, $foto_mini);
                $daRitornare= "<div class='w3-col l12'><h3 class='w3-orange noPad padded10'>Sponsor:</h3></div>";

                while($stmt->fetch()){
                    $daRitornare .= stampaIconaSponsor($alt_name, $link, $foto_mini);
                }
                
                $conn->close();
                return $daRitornare;
            }
        
        
            
        
            function stampaPatrocini() {
                include 'php/configurazione.php';
                include 'php/connessione.php';
                $sql=   "SELECT P.alt_name, P.link, P.foto_mini FROM (Persona AS P INNER JOIN tipologiaPersona AS tP ON P.tipologia=tP.id) WHERE tP.nome= 'patrocinio' ORDER BY P.alt_name";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $stmt->bind_result($alt_name, $link, $foto_mini);
                $daRitornare= ""."<div class='w3-col l12'><h3 class='w3-blue noPad padded10'>Patrocini:</h3></div>";

                while($stmt->fetch()){
                    $daRitornare .= stampaIconaSponsor($alt_name, $link, $foto_mini);
                }
                
                $conn->close();
                return $daRitornare;
            }

        
        
            function stampaIconaSponsor($alt_name, $link, $foto) {
                $daRitornare= "<a href='".$link."' target='_blank'>"
                        ."<div class='w3-col s4 m3 w3-center padded5'>"
                                //.'<div class="imgQuadrataArtista w3-circle" style="background-image: url('.$foto.');"></div>'
                                .'<img class="w3-image" src="'.$foto.'">'
                                ."<h5>".$alt_name."</h5>"
                        ."</div>"
                    ."</a>";
                return $daRitornare;
            }
        
        
        
        
        
        
        
            echo stampaProduzione();
            echo stampaSponsors();
            echo stampaPatrocini();
            ?>
    </div>
    
    
    
        
        
</body>

</html>