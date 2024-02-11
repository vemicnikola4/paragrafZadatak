<?php
require_once "connection.php";
require_once "navigacija.php";

$q = "SELECT   `no`.`id` AS `no_id` , `no`.`ime`,`no`.`prezime`,`p`.`id`,`p`.`created_at`,`p`.`start_at`,`p`.`end_at`,`p`.`tip_osiguranja` FROM `nosioci_osiguranja` AS `no`
LEFT JOIN `polise` AS `p` ON `p`.`nosilac_osiguranja_id`=`no`.`id`";

$res = $conn->query($q);
$polise = $res -> fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
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
                                POlise osiguranja
                            </h6>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Id polise</th>
                                        <th scope="col">Datum Aktivacije</th>
                                        <th scope="col">Početka Važenja</th>
                                        <th scope="col">Krajnji datum važenja polise</th>
                                        <th scope="col">Nosilac Polise</th>
                                        <th scope="col">Tip polise</th>
                                        <th scope="col">Akcija</th>                                   
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        foreach($polise as $polisa){
                                            
                                        // var_dump($row);
                                    ?>
                                    <tr>
                                        <td><?php echo $polisa['id']?></td>
                                        <td><?php echo $polisa['created_at']?></td>
                                        <td><?php echo $polisa['start_at']?></td>
                                        <td><?php echo $polisa['end_at']?></td>
                                        <td><?php echo $polisa['ime'] ." ". $polisa['prezime'];?></td>
                                        <td><?php echo $polisa['tip_osiguranja'];?></td>
                                        <td>
                                            <a href="polisa_detaljnije.php?id_polise=<?php echo $polisa['id'];?>&id_nosioca_osiguranja=<?php  echo $polisa['no_id'];?>&tip_osiguranja=<?php echo $polisa['tip_osiguranja'];?>" class="btn btn-success">detaljnije</a>
                                        </td>
                                    
                                    </tr>
                                        
                                   
                                    <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </div>
    </div>
        
                
    
</body>
</html>