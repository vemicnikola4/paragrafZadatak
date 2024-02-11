<?php
require_once "navigacija.php";
require_once "connection.php";
if ( $_SERVER["REQUEST_METHOD"] == "GET"){
    $polisaId = $_GET['id_polise'];
    $nosilacPoliseId = $_GET['id_nosioca_osiguranja'];
    $tipOsiguranja = $_GET['tip_osiguranja'];

    if ( $tipOsiguranja == "grupno"){
        // $q = "SELECT * FROM `nosioci_osiguranja` 
        // WHERE `id` = $nosilacPoliseId";
        

        $q = "SELECT `no`.`id` AS `no_id` , `no`.`ime`,`no`.`prezime`,`no`.`broj_pasosa`, 
        `o`.`ime`,`o`.`prezime`,`o`.`broj_pasosa` FROM `nosioci_osiguranja` AS `no`
        LEFT JOIN `osiguranici` AS `o` ON `o`.`nosilac_osiguranja_id` = `no`.`id`
        WHERE `no`.id =$nosilacPoliseId";
        $res = $conn->query($q);
        $nosilac = $res -> fetch_all(MYSQLI_ASSOC);



    }
    
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
    <?php
        navigacija();
    ?>
</body>
</html>