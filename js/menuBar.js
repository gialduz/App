//<!-- Side navigation -->
    

    function openSidebarOverlay() {
        setTimeout(function(){ 
            if(statoMenu == 0){
                //$('#overlay').css('display','block')      deve funzionare QUESTO
                $("#overlay").show();
                statoMenu=1;
            }
        }, 50); //ritardo serve ad aspettare closeMenu onclick #corpo, poi apre menu
    }
    
    
    //<!-- BARRA MENU collassato -->
    var titoloMenu = "Segni d'Infanzia";
    var font= "font-family: 'Cookie', sans; ";
    var menuBar = ''+
    '<style> .spazioFissoResponsive{width:150px;} #menuBox, #homeBox{width:100px;} </style>'+
    '<style> @media (max-width: 640px) { .spazioFissoResponsive, #homeBox{width:75px;} </style>'+
    '<style> @media (max-width: 480px) { .spazioFissoResponsive{width:0px;} </style>'+
    '<style> @media (max-width: 320px) { .spazioFissoResponsive{width:0px;} #menuBox, #logoBox{width:75px} </style>'+
    //MenuBar    
    '<div id="menuBar" class="w3-dark-grey w3-row" style="height:75px; position:fixed; width:100%; max-width:640px; z-index:99">'+
        '<div id="menuBox" style="height:100%; float:left" class="w3-button w3-dark-grey w3-hover-dark-grey w3-text-white w3-large" onclick="openSidebarOverlay()">'+
            '<i class="fa fa-bars fa-3x" aria-hidden="true"></i>'+
        '</div>'+
        '<div class="spazioFissoResponsive" style="height:100%; float:left;"> </div>'+
        '<div id="logoBox" class="w3-center" style="height:100%; float:left">'+
            '<img src="img/logo.png" style="height:100%;">'+
        '</div>'+
        '<a href="home.html">   <div id="homeBox" style="height:100%; float:right" class="w3-button w3-dark-grey w3-hover-dark-grey w3-text-white w3-hover-text-orange w3-large">'+
            '<i class="fa fa-home fa-3x" aria-hidden="true" style="float:right;"></i>'+
        '</div>     </a>'+
    '</div>';
 // <!-- //fine BARRA MENU e SIDENAV -->
    //document.write("<div id='overlay' onclick='$(this).hide()'></div>");
    document.write(menuBar);















