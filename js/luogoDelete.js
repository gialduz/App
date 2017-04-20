$('.delBtn').click(function() {
    var daEliminare=$(this).closest("tr").find("td:nth-child(1)").text();

    var popupVerifica = confirm("Vuoi davvero cancellare il luogo: " + $(this).closest("tr").find("td:nth-child(4)").text() + "?");
    if (popupVerifica == true) {
        $.ajax({
            type: "POST",
            url: "../php/luogoDelete.php",
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