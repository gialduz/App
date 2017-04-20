
arrayTabella= getTableData($("#tabellaEventi")); // matrice tabella


var row = 0;
var primaEsec = 0;
var vecchiaRigaHtml ="";
var vecchiaRigaObj ="";

$('.editBtn').click(function () {
    
    $('html, body').animate({
        scrollTop: $(this).closest('tr').offset().top
    }, 500);
    
    if(primaEsec!=0){
        vecchiaRigaObj.css("background-color", "white");
    }
    primaEsec++;

    vecchiaRigaObj=$(this).closest('tr');
    
    $(this).closest('tr').css("background-color", "yellow");
    
    row = $(this).closest('tr').index();
    $("#idEdit").val(parseInt(arrayTabella[row][0]));
    $("#nomeEdit").val(arrayTabella[row][1]);
    $("#durataEdit").val(parseInt(arrayTabella[row][2]));
    var tipoId = arrayTabella[row][3].split('#')[1];//[1] alla fine perche crea un array con le 2 parti.. io tengo la seconda
    $('#tipoEdit').val(tipoId);
    $("#minEdit").val(parseInt(arrayTabella[row][4]));
    $('#maxEdit').val(parseInt(arrayTabella[row][5]));
    $('#ticketEdit').val(parseInt(arrayTabella[row][6]));
    $('#stEdit').val(parseInt(arrayTabella[row][7]));    
    
    $("#editBox").show(500);

});


$('#editSubmit').click(function () {
    var popupVerifica = confirm("Vuoi davvero MODIFICARE l'evento: " + arrayTabella[row][1] + "?");
    
    
    var valoriArray= $('#editForm').serializeArray();
    var arrayName=[];
    var arrayValue=[];

    
    $.each(valoriArray, function(i, formField){
        arrayName[i]=formField.name;
        arrayValue[i]=formField.value;
    });
    
    
    if (popupVerifica == true) {
        $.ajax({
            type: "POST",
            url: "../php/eventoUpdate.php",
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





$('#closeUpd').click(function () {
    $("#editBox").hide(500);
});



function getTableData(table) {
    var data = [];
    table.find('tr').each(function (rowIndex, r) {
        var cols = [];
        $(this).find('th,td').each(function (colIndex, c) {
            cols.push(c.textContent);
        });
        data.push(cols);
    });
    return data;
}

