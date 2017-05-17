    function showResultMenu(str) {
        if (str.length == 0) {
            document.getElementById("livesearchMenu").innerHTML = "";
            document.getElementById("livesearchMenu").style.border = "0px";
            return;
        }
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else { // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("livesearchMenu").innerHTML = this.responseText;
                document.getElementById("livesearchMenu").style.border = "1px solid #A5ACB2";
            }
        }
        xmlhttp.open("GET", "php/eventLivesearch.php?q=" + str, true);
        xmlhttp.send();
    }


    function closeSidebarOverlay() {
        if(statoMenu == 1){
            $("#overlay").hide();
            statoMenu=0;
        }
    }


    var livesearchMenu = '<div class="w3-row w3-dark-grey padded10">'+
                            '<div class="w3-third w3-center"><h5>Cerca:</h5></div>'+
                            '<div class="w3-twothird">'+
                                '<form>'+
                                    '<input type="text" class="w3-input" size="30" onkeyup="showResultMenu(this.value)">'+
                                    '<div id="livesearchMenu"></div>'+
                                '</form>'+
                            '</div>'+
                        '</div>';

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
        
                            livesearchMenu+
        
                            // contenuto menu
                            '<div class="w3-row padded10 w3-center">'+
                                //'<div class="w3-col l12 w3-deep-orange padded10"> HOME'+ '</div>'+
        
                                //programma
                                '<a href="programma.html">'+
                                    '<div class="w3-col l12 w3-purple padded10">'+
                                        '<h6 style="margin:0px;">PROGRAMMA 2017<h6>'+
                                    '</div>'+
                                '</a>'+
                                
                                //artisti
                                '<a href="artisti.html">'+
                                    '<div class="w3-col l12 s6 w3-orange padded10">'+
                                        '<h6 style="margin:0px;">Artisti<h6>'+
                                    '</div>'+
                                '</a>'+
        
                                //luoghi
                                '<a href="luoghi.html">'+
                                    '<div class="w3-col l12 s6 w3-blue padded10">'+
                                        '<h6 style="margin:0px;">Luoghi<h6>'+
                                    '</div>'+
                                '</a>'+
        
                                //info
                                '<a href="mockupInfo.html#-infoBiglietti">'+
                                    '<div class="w3-col l12 s6 w3-green padded10">'+
                                        '<h6 style="margin:0px;">Informazioni<h6>'+
                                    '</div>'+
                                '</a>'+
        
                                //preferiti
                                '<a href="programmaPreferiti.php">'+
                                    '<div class="w3-col l12 s6 w3-yellow padded10">'+
                                        '<h6 style="margin:0px;">Preferiti<h6>'+
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










