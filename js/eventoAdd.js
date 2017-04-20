

$('#addSubmit').click(function () {
    
    
    var valoriArray= $('#addForm').serializeArray();
    var arrayName=[];
    var arrayValue=[];


    $.each(valoriArray, function(i, formField){
        /*$("#results").append(formField.name + ":" + formField.value + " ");*/
        arrayName[i]=formField.name;
        arrayValue[i]=formField.value;
    });
    
    var popupVerifica = confirm("Vuoi davvero AGGIUNGERE l'evento: " + arrayValue[0] + "?");
    
    if (popupVerifica == true) {
        $.ajax({
            type: "POST",
            url: "../php/eventoAdd.php",
            data: { arrayValue: arrayValue }
        }).done(function() {
             //ricarica AJAX
            location.reload();
        });    
    } else {
        //ricarica AJAX
        location.reload();
    }
});
