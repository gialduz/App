<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    
</head>

<body style="max-width:640px; margin:0 auto;">
     
    
    <div id="corpo" class="w3-row">
        <?php
            
        header('Access-Control-Allow-Origin: *');

            function stampaProduzione() {
                include 'php/configurazione.php';
                include 'php/connessione.php';
                $sql=   "SELECT P.id, P.alt_name, P.link, P.foto_mini FROM (Persona AS P INNER JOIN tipologiaPersona AS tP ON P.tipologia=tP.id) WHERE tP.nome= 'produzione' ORDER BY P.alt_name";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $stmt->bind_result($id, $alt_name, $link, $foto_mini);
                $daRitornare= "<div class='w3-col l12'><h3 class='w3-purple noPad padded10'>Produzione:</h3></div>";

                while($stmt->fetch()){
                    $daRitornare .= stampaIconaSponsor($id, $alt_name, $link, $foto_mini);
                }
                
                $conn->close();
                return $daRitornare;
            }
            
        
            function stampaSponsors() {
                include 'php/configurazione.php';
                include 'php/connessione.php';
                $sql=   "SELECT P.id, P.alt_name, P.link, P.foto_mini FROM (Persona AS P INNER JOIN tipologiaPersona AS tP ON P.tipologia=tP.id) WHERE tP.nome= 'sponsor' ORDER BY P.alt_name";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $stmt->bind_result($id, $alt_name, $link, $foto_mini);
                $daRitornare= "<div class='w3-col l12'><h3 class='w3-orange noPad padded10'>Sponsor:</h3></div>";

                while($stmt->fetch()){
                    $daRitornare .= stampaIconaSponsor($id, $alt_name, $link, $foto_mini);
                }
                
                $conn->close();
                return $daRitornare;
            }
        
        
            
        
            function stampaPatrocini() {
                include 'php/configurazione.php';
                include 'php/connessione.php';
                $sql=   "SELECT P.id, P.alt_name, P.link, P.foto_mini FROM (Persona AS P INNER JOIN tipologiaPersona AS tP ON P.tipologia=tP.id) WHERE tP.nome= 'patrocinio' ORDER BY P.alt_name";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $stmt->bind_result($id, $alt_name, $link, $foto_mini);
                $daRitornare= ""."<div class='w3-col l12'><h3 class='w3-blue noPad padded10'>Patrocini:</h3></div>";
                
                while($stmt->fetch()){
                    $daRitornare .= stampaIconaSponsor($id, $alt_name, $link, $foto_mini);
                    
                }
                
                $conn->close();
                return $daRitornare;
            }

        
        
            function stampaIconaSponsor($id, $alt_name, $link, $foto) {
                
                $daRitornare.= "<div id='".$id."'>"
                        ."<div class='w3-col s4 w3-center padded5'>"
                                //.'<div class="imgQuadrataArtista w3-circle" style="background-image: url('.$foto.');"></div>'
                                .'<img class="w3-image" src="http://testr.altervista.org/filezdellapp/'.$foto.'">'
                                ."<h5>".$alt_name."</h5>"
                        ."</div>"
                    ."</div>";
                //aggiungo link
                $daRitornare.= "<script> $('#".$id."').click(function(){  window.open(encodeURI('".$link."'), '_system'); }) </script>";
                return $daRitornare;
            }
        
        
        
        
        
        
        
            echo stampaProduzione();
            echo stampaSponsors();
            echo stampaPatrocini();
            ?>
    </div>
    
    
    
        
        
</body>

</html>