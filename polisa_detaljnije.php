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
        $q = "SELECT * FROM `nosioci_osiguranja` 
        WHERE `id` = $nosilacPoliseId LIMIT 1";

        $res = $conn->query($q);
        $nPolise = $res->fetch_assoc();

        $q =  "SELECT * FROM `osiguranici` 
        WHERE `nosilac_osiguranja_id` = $nosilacPoliseId";
        $res = $conn->query($q);
        $osiguranici = $res -> fetch_all(MYSQLI_ASSOC);

    }else{
        $q = "SELECT * FROM `nosioci_osiguranja` 
        WHERE `id` = $nosilacPoliseId LIMIT 1";

        $res = $conn->query($q);
        $nPolise = $res->fetch_assoc();
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
    <div class="container-md-xxl">
        <div class="row justify-content-center ">
                <div class="col-10">
                    <div class="card mt-3">
                        <div class="card-header pt-3">
                            <h6>
                                Nosilac Polise
                            </h6>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Ime i prezime</th>
                                        <th scope="col">Broj Pasoša</th>
                                        <th scope="col">Datum Rodjenja</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Broj Telefona</th>
                                                                          
                                    </tr>
                                    <tr>
                                        <th scope="col"><?php echo $nPolise['ime'] ." ".$nPolise['prezime'] ?></th>
                                        <th scope="col"><?php echo $nPolise['broj_pasosa']; ?></th>
                                        <th scope="col"><?php echo $nPolise['datum_rodjenja']; ?></th>
                                        <th scope="col"><?php echo $nPolise['email']; ?></th>
                                        <th scope="col"><?php echo $nPolise['broj_telefona']; ?></th>
                                                                        
                                    </tr>
                                </thead>
                               
                                <?php if ( $tipOsiguranja == "grupno"){

                                ?>
                                <table>
                                    <h6>Osigurana Lica</h6>
                                    <thead>
                                        <th scope="col">Ime i prezime</th>
                                        <th scope="col">Broj Pasoša</th>
                                        <th scope="col">Datum Rodjenja</th>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        foreach($osiguranici as $osiguranik){
                                            
                                       
                                    ?>
                                    <tr>
                                        <td><?php echo $osiguranik['ime'] ." ".$nPolise['prezime'] ?></td>
                                        <td><?php echo $osiguranik['broj_pasosa']?></td>
                                        <td><?php echo $osiguranik['datum_rodjenja']?></td>                                    
                                    </tr>
                                        
                                   
                                    <?php
                                        }
                                    ?>
                                </tbody>
                                </table>
                                <?php
                                }
                                ?>
                                
                            </table>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</body>
</html>