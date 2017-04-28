/*

//<!-- Side navigation -->
    var sideMenu = ''+
    '<link href="https://fonts.googleapis.com/css?family=Cookie" rel="stylesheet">'+
    '<nav id="sideMenu" class="w3-sidebar w3-bar-block" style="width:320px;">'+
        '<div class="w3-dark-grey w3-row">'+
            '<div class="w3-half">'+
                '<a href="javascript:void(0)" onclick="closeSidebar()" class="w3-button">'+
                    '<i class="fa fa-close fa-2x" aria-hidden="true"></i>'+
                '</a>'+
            '</div>'+
            '<div class="w3-half">'+
                '<h2 style="margin:0;">Menu</h2>'+
            '</div>'+
        '</div>'+
        '<a class="w3-bar-item w3-button w3-deep-orange" href="home.html"><h2 class="noPad"><i class="fa fa-home" aria-hidden="true"></i> Home</h2></a>'+
        '<a class="w3-bar-item w3-button w3-leftbar w3-border-purple w3-hover-border-black" href="programma.php">Programma</a>'+
        '<a class="w3-bar-item w3-button w3-leftbar w3-border-orange w3-hover-border-black" href="artisti.php">Artisti</a>'+
        '<a class="w3-bar-item w3-button w3-leftbar w3-border-blue w3-hover-border-black" href="luoghi.php">Luoghi</a>'+
        '<a class="w3-bar-item w3-button w3-leftbar w3-border-green w3-hover-border-black" href="mockupInfo.html#-infoBiglietti">Biglietteria</a>'+
        '<a class="w3-bar-item w3-button" href="mockupInfo.html#-trasporti">Spostarsi a Mantova</a>'+
        '<a class="w3-bar-item w3-button" href="mockupInfo.html#-vittoAlloggio">Vitto e Alloggio</a>'+

    '</nav>'; //chiudo nav
   
        
    
 // <!-- //fine BARRA MENU e SIDENAV -->

        document.write(sideMenu);
        $("#sideMenu").hide();




    $(document).ready(function (){
        

        $("#corpo").click(function ()
        {
            closeSidebar();
        });

    });

    */
    function closeSidebarOverlay() {
        if(statoMenu == 1){
            $("#overlay").hide();
            statoMenu=0;
        }
    }



// H: 80+ 480 +80 = 640 min centrato
    var menuOverlay= "<div id='overlay' >"+
                        "<div id='menuContent' style='width:320px; height:80vh; background:#001433; margin:0 auto; margin-top:10vh;'>"+
        
                            //header menu
                            '<div class="w3-row dark-blue">'+
                                '<div class="w3-col s9 w3-center"> <h2>MENU</h2>'+ '</div>'+
                                '<div class="w3-col s3">'+
                                    '<a href="javascript:void(0)" onclick="closeSidebarOverlay();" class="w3-button w3-right">'+
                                        '<i class="fa fa-close fa-4x" aria-hidden="true"></i>'+
                                    '</a>'+
                                '</div>'+
                            '</div>'+
        
                            // contenuto menu
                            '<div class="w3-row">'+
                                //'<div class="w3-col l12 w3-deep-orange padded10"> HOME'+ '</div>'+
                                //programma
                                '<div class="w3-col l12 w3-purple padded10">'+
                                    '<a href="programma.php"'+
                                        '<h6>Programma<h6>'+
                                    '</a>'+
                                '</div>'+
                                //artisti
                                '<div class="w3-col l12 w3-orange padded10">'+
                                    '<a href="artisti.php"'+
                                        '<h6>Artisti<h6>'+
                                    '</a>'+
                                '</div>'+
                                //luoghi
                                '<div class="w3-col l12 w3-blue padded10">'+
                                    '<a href="luoghi.php"'+
                                        '<h6>Luoghi<h6>'+
                                    '</a>'+
                                '</div>'+
                                //info
                                '<div class="w3-col l12 w3-green padded10">'+
                                    '<a href="mockupInfo.html"'+
                                        '<h6>Informazioni<h6>'+
                                    '</a>'+
                                '</div>'+
        
                            '</div>'+
        
        
        
                        "</div>"+
                    "</div>";



    $("#corpo").append(menuOverlay);
    $("#overlay").hide(); //stampo e nascondo
    var statoMenu=0; //stato 0 = nascosto










