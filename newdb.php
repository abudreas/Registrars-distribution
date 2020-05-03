<?php
 try {
    include __DIR__.'/include/databaseconnection.php';

$sql ="CREATE TABLE `myformv2`.`registrartable` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` TEXT NOT NULL,
    `resid` TEXT NOT NULL,
    `tele` TEXT NOT NULL,
    `shift` INT NOT NULL,
    `shift1` TEXT  NULL,
    `shift2` TEXT  NULL,
    `shift3` TEXT  NULL,
    `shift4` TEXT  NULL,
    `shift5` TEXT  NULL,
    `shift6` TEXT  NULL,
    `shift7` TEXT  NULL,
    `app1` TEXT NOT NULL,
    `app2` TEXT NOT  NULL,
    `app3` TEXT NOT  NULL,
    `date` DATETIME  NULL,
    `password` INT NOT  NULL,
    `edit date` DATETIME  NULL,
    PRIMARY KEY (`id`))";

    
$pdo->exec($sql);
$sql ="CREATE TABLE `myformv2`.`hospitaltable` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` TEXT NOT NULL,
    `city` INT NOT NULL,
    `capacity` INT NOT NULL, 
    `tier` int  NULL,
    `available` BOOLEAN NOT NULL,
    
    PRIMARY KEY (`id`))";
    $pdo->exec($sql);
echo '<p>data base succesfully created</p>';

} catch (PDOException $e) {
    $title = 'An error has occurred';

    $output = 'DAtabase error: ' . $e->getMessage() . ' in ' .
        $e->getFile() . ':' . $e->getLine();
}
echo $output ?? "";