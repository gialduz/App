
    
        
        
        
<div class="w3-container w3-orange w3-center">
    <h2>Lista Eventi</h2>
</div>
<br>

<?php
    require 'php/configurazione.php';
    require 'php/connessione.php';

    $stmt = $conn->prepare("SELECT E.id, E.nome, E.eta_min, E.eta_max, E.durata, tE.nome, L.nome FROM ( (Evento AS E INNER JOIN tipologiaEvento AS tE ON E.tipologia=tE.id) INNER JOIN Luogo AS L ON E.luogo=L.id) WHERE 1 ORDER BY E.eta_min, E.eta_max, E.nome");
    $stmt->execute();
    $stmt->bind_result($id_evento, $nomeEvento, $eta_min, $eta_max, $durata, $tipoEvento, $luogo);

    while($stmt->fetch()) {
       $daRitornare.= stampaEventoInLista($id_evento, $nomeEvento, $eta_min, $eta_max, $durata, $tipoEvento, $luogo)
                        ."<hr style='margin:2px 0 2px 0; border-top:1px solid #999999'>" ;
    }
    

    echo $daRitornare;





    function stampaEventoInLista($id_evento, $nomeEvento, $eta_min, $eta_max, $durata, $tipoEvento, $luogo) { // BADGES
        
        $daRitornare.= "<a href='dettaglioEvento.html?evento=".$id_evento."'"
                            ."<div id='evLista".$id_evento."' class='w3-row'>"
                                ."<div class='itemFasciaEta w3-center w3-blue w3-col s2'>"
                                    .$eta_min."-".$eta_max. "<br>anni"
                                ."</div>"
                                ."<div class='w3-col s8 padded10lr'>"
                                    ."<b>" . $nomeEvento . "</b><br>"
                                    ."<i>" . $luogo . "</i>"
                                ."</div>"
                                ."<div class='w3-col s2 padded5' style='padding-top:0'>"
                                    ."<div class='w3-row'>"
                                        ."<div class='w3-col s6'>"
                                            ."<img class='w3-image' src='img/tipologiaEvento/".$tipoEvento.".png' >"
                                        ."</div>"
                                        ."<div class='w3-col s6'>"
                                            ."<div class='itemBadge w3-green w3-center'>"
                                                .$durata
                                            ."</div>"
                                        ."</div>"
                                    ."</div>"
                                ."</div>"
                            ."</div>"
                        ."</a>";
        
        return  $daRitornare;

    }


?>


<script>
    $('.itemBadge').each(function(){
        $(this).height($(this).width());
    });
    $( window ).resize(function() {
        $('.itemBadge').each(function(){
            $(this).height($(this).width());
        });
    });


</script>