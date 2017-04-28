
    function closeSidebarOverlay() {
        if(statoMenu == 1){
            $("#overlay").hide();
            statoMenu=0;
        }
    }



// H: 80+ 480 +80 = 640 min centrato
    var menuOverlay= "<div id='overlay' >"+
                        "<div id='menuContent' style=''>"+
        
                            //header menu
                            '<div class="w3-row w3-dark-grey">'+
                                '<div class="w3-col s9 w3-center"> <h1><b>Men&ugrave;</b></h1>'+ '</div>'+
                                '<div class="w3-col s3">'+
                                    '<a href="javascript:void(0)" onclick="closeSidebarOverlay();" class="w3-button w3-dark-grey w3-hover-dark-grey w3-hover-text-orange w3-right">'+
                                        '<i class="fa fa-close fa-4x" aria-hidden="true"></i>'+
                                    '</a>'+
                                '</div>'+
                            '</div>'+
        
                            // contenuto menu
                            '<div class="w3-row padded10">'+
                                //'<div class="w3-col l12 w3-deep-orange padded10"> HOME'+ '</div>'+
        
                                //programma
                                '<a href="programma.php">'+
                                    '<div class="w3-col l12 w3-purple padded10">'+
                                        '<h6 style="margin:0px;">Programma<h6>'+
                                    '</div>'+
                                '</a>'+
                                
                                //artisti
                                '<a href="artisti.php">'+
                                    '<div class="w3-col l12 w3-orange padded10">'+
                                        '<h6 style="margin:0px;">Artisti<h6>'+
                                    '</div>'+
                                '</a>'+
        
                                //luoghi
                                '<a href="luoghi.php">'+
                                    '<div class="w3-col l12 w3-blue padded10">'+
                                        '<h6 style="margin:0px;">Luoghi<h6>'+
                                    '</div>'+
                                '</a>'+
        
                                //info
                                '<a href="mockupInfo.html">'+
                                    '<div class="w3-col l12 w3-green padded10">'+
                                        '<h6 style="margin:0px;">Informazioni<h6>'+
                                    '</div>'+
                                '</a>'+
        
                            '</div>'+
        
        
        
                        "</div>"+
                    "</div>";



    $("body").append(menuOverlay);
    $("#overlay").hide(); //stampo e nascondo
    var statoMenu=0; //stato 0 = nascosto

    $(window).click(function() {
        //Hide the menus if visible
        closeSidebarOverlay();
    });

    $('#menuContent').click(function(event){
        event.stopPropagation();
    });










