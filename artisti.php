<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <title>Artisti - Segni d'Infanzia</title>
</head>

<body style="max-width:640px; margin:0 auto;">
    
    
    
    <div id="corpo">
        
        
        <div class="w3-container w3-orange w3-text-white w3-center"><h2>Artisti</h2></div>
        <div class="w3-row w3-blue padded10">
            <div class="w3-col s4"><h5><b>Cerca:</b></h5></div>
            <div class="w3-col s8">
                <form>
                    <input type="text" class="w3-input w3-round" onkeyup="showResult(this.value)">
                    <div id="livesearch"></div>
                </form>
            </div>
        </div>        
        
        <div class="w3-container w3-pale-yellow"><h5>Elenco artisti completo:</h5>
            <?php
            
            header('Access-Control-Allow-Origin: *');
            
            include 'php/mieFunzioni.php';

            function stampaElencoArtisti() {
                include 'php/configurazione.php';
                include 'php/connessione.php';
                $sql=   "SELECT P.id, P.nome, P.cognome, P.alt_name, P.foto_mini FROM Persona AS P WHERE P.tipologia= 1 ORDER BY P.cognome";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $stmt->bind_result($id, $nome, $cognome, $alt_name, $foto_mini);
                $daRitornare= "";

                while($stmt->fetch()){
                    $daRitornare .= stampaArtista($id, $nome, $cognome, $alt_name, $foto_mini);
                }
                
                $conn->close();
                return $daRitornare;
            }
            function stampaArtista($id, $nome, $cognome, $alt_name, $foto) {
                $foto= "http://testr.altervista.org/filezdellapp/".$foto;
                
                $daRitornare= "<a href='artista.html?id=".$id."'>"
                    ."<div class='w3-row w3-hover-grey'>"
                        ."<div class='w3-col s2 w3-center'>"
                                .'<div class="imgQuadrataArtista w3-circle" style="background-image: url('.$foto.');"></div>'
                        ."</div>"
                        ."<div class='w3-col s10'>"
                                .$cognome." ".$nome. "<i style='color:grey'>".$alt_name."</i>"
                        ."</div>"
                    ."</div>"
                    ."</a>";
                return $daRitornare;
            }

            echo stampaElencoArtisti();
            ?>

            <script>
                function showResult(str) {
                    if (str.length == 0) {
                        document.getElementById("livesearch").innerHTML = "";
                        document.getElementById("livesearch").style.border = "0px";
                        return;
                    }
                    if (window.XMLHttpRequest) {
                        // code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                    }
                    else { // code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("livesearch").innerHTML = this.responseText;
                            document.getElementById("livesearch").style.border = "1px solid #A5ACB2";
                        }
                    }
                    xmlhttp.open("GET", "http://testr.altervista.org/filezdellapp/php/livesearch.php?q=" + str, true);
                    xmlhttp.send();
                }
            </script>
        </div>
    </div>
</body>

</html>