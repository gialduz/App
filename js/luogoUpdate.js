var arrayTabella= getTableData($("#tabellaLuoghi")); // matrice tabella


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
    $("#editLettera").val(arrayTabella[row][1]);
    $("#editColore").val(arrayTabella[row][2]);
    $('#editNome').val(arrayTabella[row][3]);
    $("#editLatitudine").val(parseFloat(arrayTabella[row][4]));
    $('#editLongitudine').val(parseFloat(arrayTabella[row][5]));
    $('#editCitta').val(arrayTabella[row][6]);
    $('#editTipoVia').val(arrayTabella[row][7]); 
    $('#editVia').val(arrayTabella[row][8]);
    $('#editNumeroCivico').val(parseInt(arrayTabella[row][9]));    

    
    $("#editBox").show(500);
    
});


$('#editSubmit').click(function () {
    var popupVerifica = confirm("Vuoi davvero MODIFICARE il luogo: " + arrayTabella[row][3] + "?");
    
    
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
            url: "../php/luogoUpdate.php",
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

