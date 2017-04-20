$(document).ready(function () {
    
    $(".chiudiMenu").click(function(){
            //resetEditForm() pericoloso! non cancella id_istanza memorizzato!
            resetAddForm();
            resetAddEPForm();
            openTabModalita();
        });
    $('#addSubmit').click(function () {
        var popupVerifica = confirm("Vuoi davvero AGGIUNGERE questa data ?");
        if (popupVerifica == true) {
            var idEvento = $("#selectEvento").val();
            var idLuogo = $("#addLuogo").val();
            var giorno = $("#addGiorno").val();
            var mese = $("#addMese").val();
            var ora = $("#addOra").val();
            var minuto = $("#addMinuto").val();
            var speciale = 0;
            if ($('#addSpeciale').is(":checked")) {
                speciale = 1;
            }
            $.ajax({
                type: "POST"
                , url: "../php/dettagliEldAdd.php"
                , data: {
                    idLuogo: idLuogo
                    , idEvento: idEvento
                    , giorno: giorno
                    , mese: mese
                    , ora: ora
                    , minuto: minuto
                    , speciale: speciale
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
    $('#addSubmitEP').click(function () {
        var popupVerifica = confirm("Vuoi davvero AGGIUNGERE questa persona all'evento ?");
        if (popupVerifica == true) {
            var idEvento = $("#selectEvento").val();
            var idPersona = $("#addPersonaEP").val();
            var idTipo = $("#addRapportoEP").val();
            var nuovoTipo = 0;
            
            if (idTipo == 'aggiungiRapporto') {
                var nuovoTipo = $("#addTipoRapporto").val();
                $.ajax({//crea nuovo tipo rapporto
                    type: "POST"
                    , url: "../php/tipologiaEpAdd.php"
                    , data: {
                        nuovoTipo: nuovoTipo
                    }
                });
                alert("Aggiunto nuovo rapporto Evento-Persona: " + nuovoTipo); //Senza alert chiamate a db falliscono e tiene ultimo nuovoTipo inviato
            }
            
            $.ajax({//aggiunge istanza
                type: "POST"
                , url: "../php/dettagliEpAdd.php"
                , data: {
                    idEvento: idEvento
                    , idPersona: idPersona
                    , idTipo: idTipo
                }
            }).done(function () {
                //ricarica AJAX
                //alert("abra");
                location.reload();
            });
        }
        else {
            //ricarica AJAX
            location.reload();
        }
    });
    
    
    
    $("#addBtn").click(function () {
        openTabModalita('addTab');
    });
    $("#addBtnEP").click(function () {
        openTabModalita('addTabEP');
    });
    
    
    //GESTIONE SELECT EVENTO 
    if($("#selectEvento").val() != 0) {
        $("#wrapEventoLuogoData").load("dettagliEld.php", {'eventoDaPassare': $("#selectEvento").val()});
        $("#wrapEventoPersona").load("dettagliEp.php", {'eventoDaPassare': $("#selectEvento").val()});
    }
    $( "#sceltaEvento" ).change(function() {
            $("#wrapEventoLuogoData").load("dettagliEld.php", {'eventoDaPassare': $("#selectEvento").val()});
            $("#wrapEventoPersona").load("dettagliEp.php", {'eventoDaPassare': $("#selectEvento").val()});
            //onChange chiamo pagina evento
        });
    // /GESTIONE SELECT EVENTO
    
    
    //Mostra e nasconde input aggiunta nuova categoria
    if($("#addRapportoEP").val()!='aggiungiRapporto') {$("#addTipoRapporto").hide();} //CAMPO AGGIUNTIVO addTipoRapporto
    $("#addRapportoEP").change(function() {
            if($("#addRapportoEP").val() == 'aggiungiRapporto'){$("#addTipoRapporto").show();}else{$("#addTipoRapporto").hide();}
        });
    
    
    if($("#editRapportoEP").val()!='aggiungiRapporto') {$("#editTipoRapporto").hide();} //CAMPO AGGIUNTIVO addTipoRapporto
    $("#editRapportoEP").change(function() {
            if($("#editRapportoEP").val() == 'aggiungiRapporto'){$("#editTipoRapporto").show();}else{$("#editTipoRapporto").hide();}
        });
    
    
    function resetAddForm() {
            //openTabModalita('');
            
            $('#addCalendario').val("");
            $("#addGiorno").val("");
            $("#addMese").val("");
            $('#addOra').val("0");
            $('#addMinuto').val("0");
            $('#addLuogo').val("0");
            $('#addSpeciale').prop('checked', false);
        }
    function resetEditForm() {
            //openTabModalita('');
            
            $('#calendarioEdit').val("");
            $("#editGiorno").val("");
            $("#editMese").val("");
            $('#editOra').val("0");
            $('#editMinuto').val("0");
            $('#editLuogo').val("0");
            $('#editSpeciale').prop('checked', false);
        }
    function resetAddEPForm() {
            //openTabModalita('');
            
            $('#addPersonaEP').val("0");
            $("#addRapportoEP").val("0");
        }
    
    function openTabModalita(idTab) {
            var i;
            var x = document.getElementsByClassName("tabs");
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            document.getElementById(idTab).style.display = "block";
        }

});