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
        
        
        <div class="w3-container w3-orange w3-text-white w3-center"><h2>Artisti</h2></div>
        <div class="w3-row w3-blue padded5">
            <div class="w3-third">Cerca Artista:</div>
            <div class="w3-twothird">
                <form>
                    <input type="text" class="w3-input" size="30" onkeyup="showResult(this.value)">
                    <div id="livesearch"></div>
                </form>
            </div>
        </div>
        <?php
    include 'php/mieFunzioni.php';
    
    function stampaElencoArtisti() {
        include 'php/configurazione.php';
        include 'php/connessione.php';
        $sql=   "SELECT P.id, P.nome, P.cognome, P.alt_name FROM Persona AS P WHERE P.tipologia= 1 ORDER BY P.cognome";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($id, $nome, $cognome, $alt_name);
        $daRitornare= "";
        
        while($stmt->fetch()){
            $daRitornare .= stampaArtista($id, $nome, $cognome, $alt_name);
        }
        
        
        
        $conn->close();
        return $daRitornare;
    }
    function stampaArtista($id, $nome, $cognome, $alt_name) {
        $daRitornare= "<a href='artista.php?id=".$id."'>"
            ."<div class='w3-row padded10 w3-hover-grey'>"
                ."<div class='w3-col l12 w3-center'> ".$nome." ".$cognome." <i style='color:grey'>".$alt_name."</i> </div>"
            ."</div>" ."<hr style='padding:0; margin:0;'>"
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
                xmlhttp.open("GET", "php/livesearch.php?q=" + str, true);
                xmlhttp.send();
            }
        </script>
    </div>
</body>

</html>