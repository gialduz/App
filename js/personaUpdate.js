var arrayTabella= getTableData($("#tabellaPersona")); // matrice tabella


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
    
    
    $("#editId").val(parseInt(arrayTabella[row][0]));
    $("#editNome").val(arrayTabella[row][1]);
    $("#editCognome").val(arrayTabella[row][2]);
    $('#editAltName').val(arrayTabella[row][3]);
    $("#editTitolo").val(arrayTabella[row][4]);
    var tipoIdPers = arrayTabella[row][5].split('#')[1];//[1] alla fine perche crea un array con le 2 parti.. io tengo la seconda
    $("#editTipo").val(tipoIdPers);

    
    $("#editBox").show(500);
    
});


$('#editSubmit').click(function () {
    var popupVerifica = confirm("Vuoi davvero MODIFICARE la persona con id: " + arrayTabella[row][0] + "?");
    
    
    var valoriArray= $('#editForm').serializeArray();
    var arrayName=[];
    var arrayValue=[];

    
    $.each(valoriArray, function(i, formField){
        //$("#results").append(formField.name + ":" + formField.value + " ");
        arrayName[i]=formField.name;
        arrayValue[i]=formField.value;
    });
    
    if (popupVerifica == true) {
        $.ajax({
            type: "POST",
            url: "../php/personaUpdate.php",
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

