$('.delBtn').click(function() {
    var daEliminare=parseInt($(this).closest("tr").find("td:nth-child(1)").text()); //non sempre va -> basta rifare! 

    var popupVerifica = confirm("Vuoi davvero CANCELLARE la persona: " + $(this).closest("tr").find("td:nth-child(1)").text() + "?");
    //alert(daEliminare);
    if (popupVerifica == true) {
        $.ajax({
            type: "POST",
            url: "../php/personaDelete.php",
            data: { daCancellare: daEliminare }
        }).done(function() {
             //ricarica AJAX
            location.reload();
        });    
    } else {
        //ricarica AJAX
            location.reload();
    }

});