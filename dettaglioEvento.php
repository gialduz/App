<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
</head>

<body style="max-width:640px; margin:0 auto;">
    
    <div id="corpo">
        
        <?php

    include 'php/mieFunzioni.php';

    require 'php/configurazione.php';// richiamo il file di configurazione
    require 'php/connessione.php';// richiamo lo script responsabile della connessione a MySQL
    if (isset($_GET['evento']))
    {
        $numeroEvento = $_GET['evento'];
    }

    
    
    //RICORDA DI NON STAMPARE MAI 2 MAPPE NELLA STESSA PAGINA
    echo stampaEvento($numeroEvento);
    $conn->close();
    ?>
            <script>
                $(".badge").addClass("w3-card-2");
                
                
                var idEvento= window.location.href.split('evento=')[1];
                
                
                
                
                function salvaPreferito() {
                   
                    //localStorage.removeItem("preferito");

                    if(localStorage.getItem("preferito") == null) {
                        var mypref= [];
                        mypref[0] = "0";
                        mypref[idEvento] = "1";
                        $("#btnPreferito").addClass("w3-red");
                        localStorage["preferito"] = JSON.stringify(mypref);
                        //alert("Nessun preferito, array creato!");
                        
                    } //crea storage se null
                    else{
                        var mypref = JSON.parse(localStorage.getItem("preferito"));
                        if(mypref[idEvento] != "1") {
                            mypref[idEvento] = "1";
                            $("#btnPreferito").addClass("w3-red");
                        }
                        else {mypref[idEvento] = "0";
                            $("#btnPreferito").removeClass("w3-red");
                        }
                        
                        localStorage["preferito"] = JSON.stringify(mypref);
                    }
                    //alert(JSON.parse(localStorage.getItem("preferito"))); //mostra array
                }
                
                if(JSON.parse(localStorage.getItem("preferito"))[idEvento] == "1") $("#btnPreferito").addClass("w3-red");
                
                
                
            </script>
    </div>
</body>

</html>