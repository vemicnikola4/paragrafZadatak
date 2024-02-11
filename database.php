<?php
require_once "connection.php";
//fajl za kreiranje tabela


$sql .= "CREATE TABLE IF NOT EXISTS `nosioci_osiguranja`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT, 
    `ime` VARCHAR(255) NOT NULL,
    `prezime` VARCHAR(255) NOT NULL,
    `broj_pasosa` varchar(6) NOT NULL,
    `datum_rodjenja` DATE NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `broj_telefona` VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
)ENGINE=InnoDB;
";
$sql = "CREATE TABLE IF NOT EXISTS `polise`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT, 
    `created_at` DATE,
    `updated_at` DATE DEFAULT NULL,
    `start_at` DATE NOT NULL,
    `end_at` DATE NOT NULL,
    `tip_osiguranja` VARCHAR (255),
    `nosilac_osiguranja_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY(`nosilac_osiguranja_id`) REFERENCES `nosioci_osiguranja` (`id`)
    ON UPDATE CASCADE ON DELETE NO CASCADE,
)ENGINE=InnoDB;
";
$sql .= "CREATE TABLE IF NOT EXISTS `osiguranici`(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT, 
    `ime` VARCHAR(255) NOT NULL,
    `prezime` VARCHAR(255) NOT NULL,
    `broj_pasosa` varchar(6) NOT NULL,
    `datum_rodjenja` DATE NOT NULL,
    `nosilac_osiguranja_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY(`nosilac_osiguranja_id`) REFERENCES `nosioci_osiguranja`(`id`)
    ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=InnoDB;
";



if($conn->multi_query($sql)){
    echo "<p>Tables created successfully!</p>";
}else{
    header("Location: error.php?m=errorQuery");
}
header("Location: index.php");
?>