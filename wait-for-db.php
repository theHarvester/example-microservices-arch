<?php

do {
    sleep(1);

    $dsn = "mysql:host=database;dbname=pets;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    try {
        $pdo = new PDO($dsn, 'root', 'secret', $options);
        $databaseStarted = true;
    } catch (PDOException $e) {
        $databaseStarted = false;
    }
} while (!$databaseStarted);