<?php
try {
    require __DIR__ . '/include/databaseconnection.php';

    $sql[] = "CREATE TABLE `". $dbName."`.`registrartable` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` TEXT NOT NULL,
    `resid` INT NOT NULL,
    `tele` TEXT NOT NULL,
    `shift` INT NOT NULL,
    `city` INT NOT NULL DEFAULT '0',
    `password` INT NOT NULL,
    PRIMARY KEY (`id`))";

    $sql[] = "CREATE TABLE `". $dbName."`.`hospitaltable` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` TEXT NOT NULL,
    `city` INT NOT NULL,
    `state` INT NOT NULL,
    `capacity` INT NOT NULL,
    `tier` int  NULL,
    `available` BOOLEAN NOT NULL,

    PRIMARY KEY (`id`))";

    $sql[] = "CREATE TABLE `" . $dbName . "`.`admins` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` TEXT NOT NULL,
    `tele` text NOT NULL,
     `tier` int  NULL,
     `password` int  NULL,
    PRIMARY KEY (`id`))";
    $sql[] = "CREATE TABLE `" . $dbName . "`.`cities` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `name` TEXT NOT NULL,
        `number` INT NOT NULL,
         `stateID` int  NULL,
        PRIMARY KEY (`id`))";
   
    $sql[] = "CREATE TABLE `" . $dbName . "`.`previousshifts` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `regID` INT NOT NULL,
                `shiftNumber` INT NOT NULL,
                 `hospital` int  NULL,
                PRIMARY KEY (`id`))";
    $sql[] = "CREATE TABLE `" . $dbName . "`.`statetable` (
                    `id` INT NOT NULL AUTO_INCREMENT,
                    `name` TEXT NOT NULL,

                    PRIMARY KEY (`id`))";
                    $sql[] = "CREATE TABLE `" . $dbName . "`.`result` (
                        `id` INT NOT NULL AUTO_INCREMENT,
                        `save` TEXT NOT NULL,
                        `publish` TEXT NOT NULL,
                        PRIMARY KEY (`id`))";
                $sql[] = "CREATE TABLE `" . $dbName . "`.`application` (
                    `id` INT NOT NULL AUTO_INCREMENT,
                    `regID` INT NOT NULL,
                    `app1` INT NOT NULL,
    `app2` INT NOT  NULL,
    `app3` INT NOT  NULL,
    `date` DATETIME  NULL,
    
    `edit date` DATETIME  NULL  DEFAULT '0',
                    PRIMARY KEY (`id`))";
                    
    foreach ($sql as $stmnt) {
        $pdo->exec($stmnt);
    }

    echo '<p>data base succesfully connected</p>';

} catch (PDOException $e) {
    $title = 'An error has occurred';

    $output = 'DAtabase error: ' . $e->getMessage() . ' in ' .
    $e->getFile() . ':' . $e->getLine();
}
echo $output ?? "";
