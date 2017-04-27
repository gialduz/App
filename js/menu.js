//<!-- Side navigation -->
    var sideMenu = '<link href="https://fonts.googleapis.com/css?family=Cookie" rel="stylesheet">'+
    '<nav id="sideMenu" class="w3-sidebar w3-bar-block w3-bottombar w3-rightbar" style="width:360px;">'+
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

    '</nav>';
    function openSidebar() {
        $("#sideMenu").show();
    }
    function closeSidebar() {
        $("#sideMenu").hide();
    }
    
    //<!-- BARRA MENU collassato -->
    var titoloMenu = "Segni d'Infanzia";
    var font= "font-family: 'Cookie', sans; ";
    var menuBar = ''+
    '<style> .spazioFissoResponsive{width:150px;} #menuBox, #homeBox{width:100px;} </style>'+
    '<style> @media (max-width: 640px) { .spazioFissoResponsive, #homeBox{width:75px;} </style>'+
    '<style> @media (max-width: 480px) { .spazioFissoResponsive{width:0px;} </style>'+
    '<style> @media (max-width: 320px) { .spazioFissoResponsive{width:0px;} #menuBox, #logoBox{width:75px} </style>'+
    '<div id="menuBar" class="w3-dark-grey w3-row" style="height:75px;">'+
        '<div id="menuBox" style="height:100%; float:left" class="w3-button w3-grey w3-hover-orange w3-large" onclick="openSidebar()">'+
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
    document.write(sideMenu + menuBar);
    closeSidebar();

