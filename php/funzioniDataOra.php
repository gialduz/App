<?php


function dataIta($dataBrutta){

    return  giornoIta(date('l', strtotime($dataBrutta))) . " " 
            . date('j', strtotime($dataBrutta)) . " "
            . substr(meseIta(date('n', strtotime($dataBrutta))), 0,3) /*. " "
            . date('Y', strtotime($dataBrutta))*/;
}

function tagliaSec($ora){ return substr( $ora, 0, 5 );}
function soloOra($data){ return substr( $data, 11, 5 );}
function soloData($data){ return substr( $data, 0, 10 );}
function soloGiorno($data){ return substr( $data, 8, 10 );}



// BTN filtro per data
function dataFiltroBtn($d){
    $daRitornare=""."<b>";
    $daRitornare.= substr(giornoIta(date('l', strtotime($d))), 0, 3 ) ." ";
    $daRitornare.=date('j', strtotime($d)) . " "."</b>";
    $daRitornare.=substr( meseIta(date('n', strtotime($d))), 0, 3 );
    return $daRitornare;
}





function giornoIta($giornoEng) {

    switch ($giornoEng) {
    case "Monday":
        return "Luned&igrave;";
        break;
    case "Tuesday":
        return "Marted&igrave;";
        break;
    case "Wednesday":
        return "Mercoled&igrave;";
        break;
    case "Thursday":
        return "Gioved&igrave;";
        break;
    case "Friday":
        return "Venerd&igrave;";
        break;
    case "Saturday":
        return "Sabato";
        break;
    case "Sunday":
        return "Domenica";
        break;

    default:
        return $giornoEng;
        break;
    }

}

function meseIta($numeroMese) {

    switch ($numeroMese) {
    case 1:
        return "Gennaio";
        break;
    case 2:
        return "Febbraio";
        break;
    case 3:
        return "Marzo";
        break;
    case 4:
        return "Aprile";
        break;
    case 5:
        return "Maggio";
        break;
    case 6:
        return "Giugno";
        break;
    case 7:
        return "Luglio";
        break;
    case 8:
        return "Agosto";
        break;
    case 9:
        return "Settembre";
        break;
    case 10:
        return "Ottobre";
        break;
    case 11:
        return "Novembre";
        break;
    case 12:
        return "Dicembre";
        break;


    default:
        return $numeroMese;
        break;
    }

}
?>