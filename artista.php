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

    <script src="js/menu.js"></script>
    
    
    
    <!-- Page Container -->
    <div class="w3-content w3-margin-top">
        
        

      <!-- The Grid -->
        <div class="w3-row-padding">
            
            <?php
                include 'php/mieFunzioni.php';
                $id_artista= $_GET["id"];
                function stampaDettaglioArtista($id_artista) {
                    include 'php/configurazione.php';
                    include 'php/connessione.php';
                    $sql=   "SELECT P.id, P.nome, P.cognome, P.alt_name, P.titolo FROM Persona AS P WHERE P.id= ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $id_artista);
                    $stmt->execute();
                    $stmt->bind_result($id, $nome, $cognome, $alt_name, $titolo);        
                    $stmt->fetch();

                    $daRitornare= '<div class="w3-blue w3-center"><h2>'.$nome.' '.$cognome.' <small>'.$alt_name.'</small></h2></div>';
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
                    $stmt->bind_result($id, $nome); 
                    while($stmt->fetch()){$daRitornare.= '<div class="w3-red"><p>#'.$id.' '.$nome.'</p></div>';}
                    
                    $conn->close();
                    return $daRitornare;
                }
            
                echo stampaEventiCorrelati($id_artista);
                echo "<br><hr><br>";
                echo stampaDettaglioArtista($id_artista);
                ?>
            

            <!-- Left Column -->
            <div class="w3-third">

                <div class="w3-white w3-text-grey w3-card-4">
                    <div class="w3-display-container">
                        <img src="../img/img_avatar3.png" style="width:100%" alt="QuiVaAvatar">
                    </div>
                    <div class="w3-container">
                        <h5>Eventi correlati:</h5>
                        <p>[123] ColoriAmo</p>
                        <p>[45] In viaggio con William</p>

                    </div>
                </div><br>

            <!-- End Left Column -->
            </div>

            <!-- Right Column -->
            <div class="w3-twothird">

                <div class="w3-container w3-card-2 w3-white w3-margin-bottom">
                    <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-suitcase fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>Bio</h2>
                    <div class="w3-container">
                        <p>Lorem ipsum dolor sit amet. Praesentium magnam consectetur vel in deserunt aspernatur est reprehenderit sunt hic. Nulla tempora soluta ea et odio, unde doloremque repellendus iure, iste.</p>
                        <p>Consectetur adipisicing elit. Praesentium magnam consectetur vel in deserunt aspernatur est reprehenderit sunt hic. Nulla tempora soluta ea et odio, unde doloremque repellendus iure, iste.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. </p><br>
                        <hr>
                    </div>
                </div>

                <div class="w3-container w3-card-2 w3-white">
                    <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-certificate fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>Bibliografia</h2>
                <div class="w3-container">
                    <h5 class="w3-opacity"><b>W3Schools.com</b></h5>
                    <h6 class="w3-text-teal"><i class="fa fa-calendar fa-fw w3-margin-right"></i>Forever</h6>
                    <p>Web Development! All I need to know in one place</p>
                    <hr>
                </div>
                <div class="w3-container">
                    <h5 class="w3-opacity"><b>London Business School</b></h5>
                    <h6 class="w3-text-teal"><i class="fa fa-calendar fa-fw w3-margin-right"></i>2013 - 2015</h6>
                    <p>Master Degree</p>
                    <hr>
                </div>
                <div class="w3-container">
                    <h5 class="w3-opacity"><b>School of Coding</b></h5>
                    <h6 class="w3-text-teal"><i class="fa fa-calendar fa-fw w3-margin-right"></i>2010 - 2013</h6>
                    <p>Bachelor Degree</p>
                    <br>
                </div>
              </div>

            <!-- End Right Column -->
        </div>

      <!-- End Grid -->
      </div>

      <!-- End Page Container -->
    </div>
        
        
    
    
</body>

</html>