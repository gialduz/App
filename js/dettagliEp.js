function openTabModalita(idTab) {
    var i;
    var x = document.getElementsByClassName("tabs");
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }
    document.getElementById(idTab).style.display = "block";
}
$('.editIstanzaPersona').click(function () {
    id_istanzaEP = $(this).attr('id').split('#')[1];
    $('#editPersonaEP').val(persona[id_istanzaEP]);
    $('#editRapportoEP').val(tRapporto[id_istanzaEP]);
    openTabModalita('editTabEP');
    if (primaEsec != 0) {
        rigaVecchia.removeClass("w3-yellow");
    }
    primaEsec++;
    rigaVecchia = $(this).parent().parent().parent();
    $(this).parent().parent().parent().addClass("w3-yellow");
});

$('#editSubmitEP').click(function () {
    var popupVerifica = confirm("Vuoi davvero MODIFICARE questa persona dell'evento ?");
    if (popupVerifica == true) {
        //id_istanza viene creato prima? ->si
        var idPersonaEP = $("#editPersonaEP").val();
        var idRapportoEP = $("#editRapportoEP").val();
        /*var nuovoTipoEdit = 0;

        if (idRapportoEP == 'aggiungiRapporto') {
            var nuovoTipoEdit = $("#editTipoRapporto").val();
            $.ajax({//crea nuovo tipo rapporto
                type: "POST"
                , url: "../php/tipologiaEpAdd.php"
                , data: {
                    nuovoTipo: nuovoTipoEdit
                }
            });
            alert("Aggiunto nuovo rapporto Evento-Persona: " + nuovoTipo); //Senza alert chiamate a db falliscono e tiene ultimo nuovoTipo inviato
        }*/


        $.ajax({
            type: "POST"
            , url: "dettagliEpUpdate.php"
            , data: {
                idIstanzaEP: id_istanzaEP
                , idPersonaEP: idPersonaEP
                , idRapportoEP: idRapportoEP
            }
        }).done(function () {
            //ricarica AJAX
            location.reload();
        });
    }
    else {
        //ricarica AJAX
        location.reload();
    }
});


$('.cancellaIstanzaPersona').click(function () {
    var popupVerifica = confirm("Vuoi davvero CANCELLARE questa persona dall'evento ?");
    if (popupVerifica == true) {
        $.ajax({
            type: "POST"
            , url: "../php/dettagliEpDelete.php"
            , data: {
                idIstanzaEP: $(this).attr("id")
            }
        }).done(function () {
            location.reload();
        });
    }
    else {
        location.reload();
    }
});