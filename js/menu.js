//<!-- Side navigation -->
    var sideMenu = '<link href="https://fonts.googleapis.com/css?family=Cookie" rel="stylesheet">'+
    '<nav id="sideMenu" class="w3-sidebar w3-bar-block w3-card" style="width:360px;">'+
        '<div class="w3-dark-grey">'+
            '<a href="javascript:void(0)" onclick="closeSidebar()" class="w3-button w3-display-topright"> <i class="fa fa-close fa-lg" aria-hidden="true"></i> </a>'+
            '<div class="w3-center">'+
                '<h2 style="margin:0;">Menu</h2>'+
            '</div>'+
        '</div>'+
        '<a class="w3-bar-item w3-button w3-leftbar w3-border-purple" href="programma.php">Programma</a>'+
        '<a class="w3-bar-item w3-button w3-leftbar w3-border-orange" href="artisti.php">Artisti</a>'+
        '<a class="w3-bar-item w3-button w3-leftbar w3-border-blue" href="luoghi.php">Luoghi</a>'+
        '<a class="w3-bar-item w3-button w3-leftbar w3-border-green" href="mockupInfo.html#-infoBiglietti">Biglietteria</a>'+
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
    var stile= "font-family: 'Cookie', sans; ";
    var menuBar = '<div id="menuBar" class="w3-dark-grey w3-row">'+
        '<div class="w3-col s1">'+
            '<button class="w3-button w3-dark-grey w3-hover-purple w3-xlarge" onclick="openSidebar()"> <i class="fa fa-bars fa-lg" aria-hidden="true"></i> </button>'+
        '</div>'+
        '<div id="tastoHome" class="w3-col m1 s2 w3-right">'+
            '<a href="home.html"> <button class="w3-button w3-circle w3-deep-orange w3-xlarge" style="padding:2px 4px 2px 4px; margin: 5px 0px 5px 0px"> <i class="fa fa-home fa-lg" aria-hidden="true"></i> </button></a>'+
        '</div>'+
        '<div class="w3-col s8 m10 w3-center">'+
            '<h3 style="'+stile+'"><img src="img/logo.png" class="hide480" style="max-height:30px">'+titoloMenu+'</h3>'+
        '</div>'+
    '</div>';
 // <!-- //fine BARRA MENU e SIDENAV -->
    document.write(sideMenu + menuBar);
    closeSidebar();

