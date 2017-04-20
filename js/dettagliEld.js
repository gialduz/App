 function openTabModalita(idTab) {
     var i;
     var x = document.getElementsByClassName("tabs");
     for (i = 0; i < x.length; i++) {
         x[i].style.display = "none";
     }
     document.getElementById(idTab).style.display = "block";
 }
 var id_istanza = 0;
 var rigaVecchia = 0;
 var primaEsec = 0;
 $('.editIstanza').click(function () {
     id_istanza = $(this).attr('id').split('#')[1];
     var questoTS = timeStamps[id_istanza];
     var questaData = questoTS.split(' ')[0];
     var questaOra = questoTS.split(' ')[1];
     //alert('data:'+ questaData+' ora:'+questaOra);
     var g = questaData.split('-')[2];
     var m = questaData.split('-')[1];
     var a = questaData.split('-')[0];
     //alert('g:'+ g+' m:'+m+' a:'+a);
     var ora = questaOra.split(':')[0];
     var min = questaOra.split(':')[1];
     var sec = questaOra.split(':')[2];
     //alert('ora:'+ ora+' min:'+min+' sec:'+sec);
     $('#calendarioEdit').val(g + "/" + m + "/" + a);
     $("#editGiorno").val(g);
     $("#editMese").val(m);
     $('#editOra').val(ora);
     $('#editMinuto').val(min);
     $('#editLuogo').val(luogo[id_istanza]);
     $('#editSpeciale').prop('checked', false);
     if (speciale[id_istanza] == 1) {
         $('#editSpeciale').prop('checked', true);
     }
     openTabModalita('editTab');
     if (primaEsec != 0) {
         rigaVecchia.removeClass("w3-yellow");
     }
     primaEsec++;
     rigaVecchia = $(this).parent().parent().parent();
     $(this).parent().parent().parent().addClass("w3-yellow");
 });
 $('#editSubmit').click(function () {
     var popupVerifica = confirm("Vuoi davvero MODIFICARE questa data ?");
     if (popupVerifica == true) {
         //id_istanza viene creato prima? ->si
         var idLuogo = $("#editLuogo").val();
         var giorno = $("#editGiorno").val();
         var mese = $("#editMese").val();
         var orario = $("#editOra").val();
         var minuto = $("#editMinuto").val();
         var speciale = 0;
         if ($('#editSpeciale').is(":checked")) {
             speciale = 1;
         }
         $.ajax({
             type: "POST"
             , url: "dettagliEldUpdate.php"
             , data: {
                 idIstanza: id_istanza
                 , idLuogo: idLuogo
                 , giorno: giorno
                 , mese: mese
                 , orario: orario
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
 //DELETE
 $('.cancellaIstanza').click(function () {
     var popupVerifica = confirm('Vuoi davvero CANCELLARE questa data ?');
     if (popupVerifica == true) {
         $.ajax({
             type: "POST"
             , url: "../php/dettagliEldDelete.php"
             , data: {
                 idIstanza: $(this).attr("id")
             }
         }).done(function () {
             location.reload();
         });
     }
     else {
         location.reload();
     }
 });