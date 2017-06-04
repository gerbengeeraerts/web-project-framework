<?php

$KlantDAO = new KlantDAO();

$app->get('/klant/?', function() use ($KlantDAO){
    header("Content-Type: application/json");
    echo json_encode($KlantDAO->selectAllKlanten(), JSON_NUMERIC_CHECK);
    exit();
});

$app->get('/klant/:zoekterm/?', function($zoekterm) use ($KlantDAO){
    header("Content-Type: application/json");
    echo json_encode($KlantDAO->searchKlant($zoekterm), JSON_NUMERIC_CHECK);
    exit();
});

$app->get('/instellingen/?', function() use ($KlantDAO){
    header("Content-Type: application/json");
    echo json_encode($KlantDAO->selectInstellingen(), JSON_NUMERIC_CHECK);
    exit();
});


?>
