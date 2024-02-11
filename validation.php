<?php

function emailValidation($u, $conn){
    
    $query = "SELECT * FROM `nosioci_osiguranja` WHERE `email` = '".$u."' ";
    $result = $conn->query($query);
    $regex = '/^[^0-9][_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
    if ( empty( $u )){
        return "Email ne sme biti prazan!";
    }elseif(!preg_match( $regex,$u)){ //regularni izrazi. NA pocetku i na kraju su delimiteri. prvi parametar je neki sablon
        return "Nevalidan format";
    }elseif(strlen($u) < 5 || strlen( $u ) > 25 ){
        return "Email mora biti izmedju 5 i 25 karaktera!";
    }elseif($result->num_rows > 0){
        return "Email adresa već postoji. Probajte drugu email adresu";
    }else{
        return "";
    }
}

function nameValidation($n)
{
    $n = str_replace(' ', '', $n);
    if (empty($n))
    {
        return "Polje ime i prezime ne sme biti prazno";
    }
    elseif (strlen($n) > 50)
    {
        return "Polje ime i prezime ne sme sadržati više od 50 karaktera";
    }
    elseif (preg_match("/^[a-zA-ZŠšĐđŽžČčĆć]+$/", $n) == false)
    {
        return "Polje ime i prezime sme sadržati samo slova";
    }
    else
    {
        return "";
    }
}
function dobValidation($date){
    if ( empty($date) ){
        return "";
    }
    if ( $date < '1900-01-01'){
        return "Datum nije validan";
    }else{
        return "";
    }
}
function passportValidation($passport){
    $passport= str_replace(' ', '', $passport);
    if (!preg_match('/^[0-9]*$/', $passport) || strlen($passport) !== 6) {
        return "Polje pasoš mora da sadrži tačno 6 karaktera 0-9";
    } else {
        return "";
    }
}
function phoneNValidation( $broj ){
    $broj= str_replace(' ', '', $broj);
    if (!preg_match('/^[0-9]*$/',$broj) || strlen($broj) <= 5 || strlen($broj) >= 12 ) {
        return "Polje sme da sadrži izmedju 5 i 11 karatktera 0-9";
    } else {
        return "";
    }

}
function tipOsiguranja($tipOsiguranja){
    if ($tipOsiguranja == 'grupno' || $tipOsiguranja == 'individualno'){
        return "";
    }else{
        return "Izaberi validan tip osiguranja";
    }
}
?>