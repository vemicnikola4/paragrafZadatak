<?php
    require_once "navigacija.php";
    require_once "connection.php";
    require_once "validation.php";

    $ime=$prezime=$datumRodjenja=$brojPasosa=$odDatuma=$doDatuma=$tipOsiguranja = $brojTelefona = $email="";

    $imeErr=$prezimeErr=$datumRodjenjaErr=$brojPasosaErr=$odDatumaErr=$doDatumaErr=$tipOsiguranjaErr = $brojTelefonaErr = $emailErr="";

    // $imeOsiguranikErr=$prezimeOsiguranikErr=$datumRodjenjaOsiguranikErr=$brojPasosaOsiguranikErr=[];

    $osiguraniciErr = "";

    $allertMsg = "";

    if ( $_SERVER["REQUEST_METHOD"] == "POST"){
        $ime =$conn->real_escape_string($_POST['ime']);
        $prezime =$conn->real_escape_string($_POST['prezime']);
        $email =$conn->real_escape_string($_POST['email']);
        $datumRodjenja = $conn->real_escape_string($_POST['datum_rodjenja']);
        $odDatuma = $conn->real_escape_string($_POST['od_datuma']);
        $doDatuma = $conn->real_escape_string($_POST['do_datuma']);
        $brojPasosa = $conn->real_escape_string($_POST['broj_pasosa']);
        $brojTelefona = $conn->real_escape_string($_POST['broj_telefona']);
        $tipOsiguranja = $conn->real_escape_string($_POST['tip_osiguranja']);
        if ( $tipOsiguranja == 'grupno'){
            // $imeOsiguranik = $conn->real_escape_string($_POST['ime_osiguranik']);
            // $prezimeOsiguranik = $conn->real_escape_string($_POST['prezime_osiguranik']);
            // $brojPasosaOsiguranik = $conn->real_escape_string($_POST['broj_pasosa_osiguranik']);

            $imeOsiguranik = ($_POST['ime_osiguranik']);
            $prezimeOsiguranik = ($_POST['prezime_osiguranik']);
            $datumRodjenjaOsiguranik = ($_POST['datum_rodjenja_osiguranik']);
            $brojPasosaOsiguranik = ($_POST['broj_pasosa_osiguranik']);

            for ($i = 0; $i < count($imeOsiguranik);$i++){
                $err = nameValidation($imeOsiguranik[$i]);
                if ($err !== "" ){
                    if (!str_contains( $osiguraniciErr,$err)){
                        $osiguraniciErr .= $err ." . ";
                    }
                }
                $err = nameValidation($prezimeOsiguranik[$i]);
                if ($err !== "" ){
                    if (!str_contains( $osiguraniciErr,$err)){
                        $osiguraniciErr .= $err ." . ";
                    }
                }
                $err = dobValidation($datumRodjenjaOsiguranik[$i]);
                if ($err !== "" ){
                    if (!str_contains( $osiguraniciErr,$err)){
                        $osiguraniciErr .= $err ." . ";
                    }

                }
                $err = passportValidation($brojPasosaOsiguranik[$i]);
                if ($err !== "" ){
                    if (!str_contains( $osiguraniciErr,$err)){
                        $osiguraniciErr .= $err ." . ";
                    }
                }
            }
            if ($osiguraniciErr !== ""){
                $osiguraniciErr .= "Niste pravilno uneli podatke za osigurana lica";

            }
            

            $imeErr = nameValidation($ime);
            $prezimeErr = nameValidation($prezime);
            $emailErr = emailValidation($email,$conn);
            $datumRodjenjaErr= dobValidation($datumRodjenja);
            $brojPasosaErr= passportValidation($brojPasosa);

            
            if ( $doDatuma <= $odDatuma ){
                $odDatumaErr = "Datum početka osiguranja mora biti raniji od datuma kraja osiguranja";
            }

            $created_at = date('Y-m-d H:i:s');
            if ( $imeErr == "" && $prezimeErr =="" && $emailErr == "" && $datumRodjenjaErr == "" && $brojPasosaErr == ""  &&$osiguraniciErr == "" && $odDatumaErr == ""){
                
                //insert nosilac_osiguranja
                $q = "INSERT INTO  `nosioci_osiguranja`
                (`ime`,`prezime`,`broj_pasosa`,`datum_rodjenja`,`email`,`broj_telefona`)
                VALUES
                ('".$ime."','".$prezime."','".$brojPasosa."','".$datumRodjenja."','".$email."','".$brojTelefona."')";
                if ( $conn -> query($q)){
                    //kreiran novi korisnik vodi ga na index
                }else{
                    header("Location: error.php?".http_build_query(['m' => $conn->error])); //da bi mogao u url da prosledimo poruku sa razmacima
                }

                $q = "SELECT * FROM `nosioci_osiguranja` WHERE `broj_pasosa` = $brojPasosa ";
                $res = $conn -> query($q);


                if ( $res -> num_rows == 0 ){
                    $errMsg = "No user with this id in database";
                    var_dump($errMsg);

                }else{
                    $r = $res -> fetch_assoc();
                    $nosilac_polise_osiguranja_id = $r['id'];
                    
                }

                //insert polisa
                $q = "INSERT INTO  `polise`
                (`created_at`,`start_at`,`end_at`,`tip_osiguranja`,`nosilac_osiguranja_id`)
                VALUES
                ('".$created_at."','".$odDatuma."','".$doDatuma."','".$tipOsiguranja."',".$nosilac_polise_osiguranja_id.")";
                if ( $conn -> query($q)){

                }else{
                    header("Location: error.php?".http_build_query(['m' => $conn->error])); //da bi mogao u url da prosledimo poruku sa razmacima
                }

                //insert osiguranici
                for  ( $i = 0; $i < count($imeOsiguranik); $i++ ){
                    $q = "INSERT INTO  `osiguranici`
                    (`ime`,`prezime`,`broj_pasosa`,`datum_rodjenja`,`nosilac_osiguranja_id`)
                    VALUES
                    ('".$imeOsiguranik[$i]."','".$prezimeOsiguranik[$i]."','".$brojPasosaOsiguranik[$i]."','".$datumRodjenjaOsiguranik[$i]."',".$nosilac_polise_osiguranja_id.")";
                    if ( $conn -> query($q)){
                        //kreiran novi korisnik vodi ga na index
                    }else{
                        header("Location: error.php?".http_build_query(['m' => $conn->error])); //da bi mogao u url da prosledimo poruku sa razmacima
                    }
                }
                $allertMsg = "Uspešno dodato grupno osiguranje!";
                $allertType = "success";
                $ime=$prezime=$datumRodjenja=$brojPasosa=$odDatuma=$doDatuma=$tipOsiguranja = $brojTelefona = $email="";

                $imeErr=$prezimeErr=$datumRodjenjaErr=$brojPasosaErr=$odDatumaErr=$doDatumaErr=$tipOsiguranjaErr = $brojTelefonaErr = $emailErr="";

            }
            
        }elseif($tipOsiguranja == 'individualno'){
            $imeErr = nameValidation($ime);
            $prezimeErr = nameValidation($prezime);
            $$emailErr = emailValidation($email,$conn);
            $datumRodjenjaErr= dobValidation($datumRodjenja);
            $brojPasosaErr= passportValidation($brojPasosa);

            
            if ( $doDatuma <= $odDatuma ){
                $odDatumaErr = "Datum početka osiguranja mora biti raniji od datuma kraja osiguranja";
            }

            $created_at = date('Y-m-d H:i:s');
            if ( $imeErr == "" && $prezimeErr =="" && $emailErr == "" && $datumRodjenjaErr == "" && $brojPasosaErr == ""  && $odDatumaErr == ""){
                
                //insert nosilac_osiguranja
                $q = "INSERT INTO  `nosioci_osiguranja`
                (`ime`,`prezime`,`broj_pasosa`,`datum_rodjenja`,`email`,`broj_telefona`)
                VALUES
                ('".$ime."','".$prezime."','".$brojPasosa."','".$datumRodjenja."','".$email."','".$brojTelefona."')";
                if ( $conn -> query($q)){
                    //kreiran novi korisnik vodi ga na index
                }else{
                    header("Location: error.php?".http_build_query(['m' => $conn->error])); //da bi mogao u url da prosledimo poruku sa razmacima
                }

                $q = "SELECT * FROM `nosioci_osiguranja` WHERE `broj_pasosa` = $brojPasosa ";
                $res = $conn -> query($q);


                if ( $res -> num_rows == 0 ){
                    $errMsg = "No user with this id in database";
                    var_dump($errMsg);

                }else{
                    $r = $res -> fetch_assoc();
                    $nosilac_polise_osiguranja_id = $r['id'];
                    
                }

                //insert polisa
                $q = "INSERT INTO  `polise`
                (`created_at`,`start_at`,`end_at`,`tip_osiguranja`,`nosilac_osiguranja_id`)
                VALUES
                ('".$created_at."','".$odDatuma."','".$doDatuma."','".$tipOsiguranja."',".$nosilac_polise_osiguranja_id.")";
                if ( $conn -> query($q)){

                }else{
                    header("Location: error.php?".http_build_query(['m' => $conn->error])); //da bi mogao u url da prosledimo poruku sa razmacima
                }

                
                

            }else{
                $tipOsiguranjaErr = "Izabarite validno osiguranje!";
            }
            $allertMsg = "Uspešno dodato individualno osiguranje!";

            $allertType = "success";
            $ime=$prezime=$datumRodjenja=$brojPasosa=$odDatuma=$doDatuma=$tipOsiguranja = $brojTelefona = $email="";

            $imeErr=$prezimeErr=$datumRodjenjaErr=$brojPasosaErr=$odDatumaErr=$doDatumaErr=$tipOsiguranjaErr = $brojTelefonaErr = $emailErr="";

        }
        
        


        // var_dump($ime);
        // var_dump($prezime);
        // var_dump($datumRodjenja);
        // var_dump($odDatuma);
        // var_dump($doDatuma);
        // var_dump($brojPasosa);
        // var_dump($tipOsiguranja);
        // exit;
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
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        navigacija();
    ?>
    <div class="container">
        <div class="row justify-content-center ">
                <div class="col-md-6">
                <div class="alert alert-<?php echo $allertType; ?> mt-3" role="alert">
                    <?php echo $allertMsg; ?>
                </div>
                    <div class="card mt-3">
                        <div class="card-header pt-3">
                            <h6>
                                Podaci o nosiocu osiguranja
                            </h6>
                        </div>
                        <div class="card-body">
                            <form class="row g-3" id="formaZaOsiguranje" action="#" method="POST">
                                <div class="col-md-6">
                                    <label for="ime" class="form-label">Ime</label>
                                    <input type="text" class="form-control" id="nosilacOsiguranjaIme" value="<?php echo $ime; ?>" name="ime" required>
                                    <span class="text-danger">* <?php echo $imeErr; ?></span>

                                </div>
                                <div class="col-md-6">
                                    <label for="prezime" class="form-label">Prezime</label>
                                    <input type="text" class="form-control" id="nosilacOsiguranjaPrezime" value="<?php echo $prezime; ?>" name="prezime"  required>
                                    <span class="text-danger">* <?php echo $prezimeErr; ?></span>

                                </div>
                                <div class="col-md-6">
                                    <label for="datumRodjenja" class="form-label">Datume Rodjenja</label>
                                    <input type="date" class="form-control" id="inputAddress"  value="<?php echo $datumRodjenja; ?>" name="datum_rodjenja"  required>
                                    <span class="text-danger">* <?php echo $datumRodjenjaErr; ?></span>

                                </div>
                                <div class="col-md-6">
                                    <label for="brojPasosa" class="form-label">Broj Pasoša</label>
                                    <input type="text" class="form-control" id="brojPasosa"  value="<?php echo $brojPasosa; ?>" name="broj_pasosa"  required>
                                    <span class="text-danger">* <?php echo $brojPasosaErr; ?></span>

                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Broj Telefona</label>
                                    <input type="text" class="form-control"  value="<?php echo $brojTelefona; ?>" id="nosilacOsiguranjaTelefon" name="broj_telefona">

                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>*
                                    <input type="email" class="form-control" id="nosilacOsiguranjaEmail"  value="<?php echo $email; ?>" name="email"  required>
                                    <span class="text-danger">* <?php echo $emailErr; ?></span>

                                </div>
                                
                                <div class="col-md-6">
                                    <label for="odDatuma" class="form-label">Početak Trajanja Osiguranja</label>
                                    <input type="date" class="form-control" name="od_datuma" id="odDatuma" min="<?php echo date('Y-m-d')?>" value="<?php echo $odDatuma ;?>">
                                    <span class="text-danger">* <?php echo $odDatumaErr; ?></span>

                                </div>
                                <div class="col-md-6">
                                    <label for="doDatuma"  class="form-label">Završetak Trajanja Osiguranja</label>
                                    <input type="date" class="form-control" name="do_datuma" id="doDatuma" value="<?php echo $doDatuma ;?>" >
                                    <span class="text-danger">* <?php echo $doDatumaErr; ?></span>

                                </div>
                                <!-- <div class="col-md-6">
                                    <p class="text-bold" id="osiguraniDani">

                                    </p>
                                </div> -->
                                <div class="form-check">
                                    <input class="form-check-input " type="radio" name="tip_osiguranja" id="individualnoRadio" value="individualno" <?php if( $tipOsiguranja !== 'grupno'){ echo "checked";} ?> >
                                    <label class="form-check-label" for="exampleRadios1">
                                        Individualno
                                    </label>
                                    </div>
                                    <div class="form-check">
                                    <input class="form-check-input grupnoRadio" type="radio" name="tip_osiguranja" id="grupnoRadio" value="grupno" <?php if( $tipOsiguranja == 'grupno'){ echo "checked";} ?>>
                                    <label class="form-check-label" for="exampleRadios2">
                                        Grupno
                                    </label>
                                </div>
                                <div class="error text-danger fw-bold">
                                    <?php echo $osiguraniciErr;?>
                                </div>
                                <div id="osiguranici" class="osiguraniciDiv">
                                    <div class="card">
                                        <div class="card-header">
                                            Dodaj osiguranika
                                        </div>
                                        
                                        <div class="card-body" id="show_item">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="form-label" for="imeOsiguranik">Ime</label>*
                                                    <input type="text" name="ime_osiguranik[]" class="form-control" id="imeOsiguranik"  >
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label" for="prezimeOsiguranik">Prezime</label>*
                                                    <input type="text" class="form-control" name="prezime_osiguranik[]" id="prezimeOsiguranik"  >
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label" for="datumRodjenjaOsiguraik">Datum rodjenja</label>
                                                    <input type="date" class="form-control" name="datum_rodjenja_osiguranik[]" id="datumRodjenjaOsiguraik">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label" for="brojPasosaOsiguranik">Broj Pasosa</label>*
                                                    <input type="text" class="form-control" name="broj_pasosa_osiguranik[]" id="brojPasosaOsiguranik"  >
                                                </div>

                                                <div class="col-12 mt-2">
                                                    <button class="btn btn-success dodaj_btn" id="dodaj_os_btn" >Dodaj</button>
                                                </div>
                                            </div>
                                                
                                        </div>
                                    </div>
                                   
                                    
                                </div>
                                <div class="col-md-12 mt-2">
                                    <button type="submit" class="btn btn-primary">Sačuvaj</button>
                                </div>
                                <div class="col-md-3 mt-2">
                                    <a href="index.php" class="btn btn-warning">Resetuj</a>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<!-- <script type="text/javascript">
    
</script> -->
<script>
    var odDatuma;
    $('#odDatuma').on('change',function(){
        odDatuma = $(this).val();
        $('#doDatuma').prop('min',function(){
            return odDatuma;
        })
    })
   
    

    $(document).ready(function(){
    $(".dodaj_btn").click(function(e){
        e.preventDefault();
        $("#show_item").prepend(`<div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label" for="imeOsiguranik">Ime</label>*
                                        <input type="text" name="ime_osiguranik[]" class="form-control" id="imeOsiguranik">
                                    </div>
                                    <div class="col-md-4">
                                                    <label class="form-label" for="prezimeOsiguranik">Prezime</label>*
                                                    <input type="text" class="form-control" name="prezime_osiguranik[]" id="prezimeOsiguranik"  >
                                                </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="datumRodjenjaOsiguraik">Datum rodjenja</label>*
                                        <input type="date" class="form-control" name="datum_rodjenja_osiguranik[]" id="datumRodjenjaOsiguraik">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="brojPasosaOsiguranik">Broj Pasosa</label>*
                                        <input type="text" class="form-control" name="broj_pasosa_osiguranik[]" id="brojPasosaOsiguranik">
                                    </div>

                                    <div class="col-12 mt-2">
                                        <button class="btn btn-danger izbrisi_btn" >Izbriši</button>
                                    </div>
                                </div>`);
    })
    $(document).on('click','.izbrisi_btn',function(e){
        e.preventDefault();
        let row_item = $(this).parent().parent();
        $(row_item).remove();
    })
    $('#osiguranici').hide();
    $('#formaZaOsiguranje').change(function() {
    if ($('#grupnoRadio').prop('checked')) {
        $('#osiguranici').show();
    } else {
        $('#osiguranici').hide();
    }
});
});
</script>
</body>
</html>