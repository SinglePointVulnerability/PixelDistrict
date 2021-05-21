<?php

function fiSeThTableColours($i) {
            // change the background of the first three rows to highlight first, second, and third place
    switch($i){
        case 1:
            $strFiSeTh = ' tblChampFirst';
            return $strFiSeTh;
            break;
        case 2:
            $strFiSeTh = ' tblChampSecond';
            return $strFiSeTh;
            break;
        case 3:
            $strFiSeTh = ' tblChampThird';
            return $strFiSeTh;
            break;
        default:
            $strFiSeTh = '';
            return $strFiSeTh;
            break;
    }    
}
?>