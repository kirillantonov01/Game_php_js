<?php

require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;

$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

$app->get('/', function ($request, $response) {
    return $response->withRedirect('./index.html', 301);
});


$app->get('/games', function ($request, $response) {
    $gamesInfo = json_encode(listGames()); 
    $response->getBody()->write($gamesInfo);
    return $response;
});

$app->get('/games/{id}', function ($request, $response, array $args) {
    $Gameid = $args['id'];
    $responseBody = json_encode(turnsById($Gameid));
    $response->getBody()->write($responseBody);
    return $response;
});

$app->post('/games', function ($request, $response) {
    $string = json_decode($request->getBody());
    $info = explode("|", $string);
    $gamesInfo = explode("+", $info[1]); // 0 - name, 1 - size, 2 - date, 3 - time, 4 - human_mark, 5 - winner
    $turns = explode("+", $info[0]); 
    insertInfo($gamesInfo, $turns);
    $response->write('Бд заполнена');
    return $response;
});

$app->run();

function openDatabase()
{
    if (!file_exists("./../db/gamedb.db")) {
        $db = new \SQLite3('./../db/gamedb.db');

        $gamesInfoTable = "CREATE TABLE gamesInfo(
    idGame INTEGER PRIMARY KEY,
    gameData DATE,
    gameTime TIME,
    playerName TEXT,
    sizeBoard INTEGER,
    result TEXT
)";
        $db->exec($gamesInfoTable);


        $stepsInfoTable = "CREATE TABLE stepsInfo(
    idGame INTEGER,
    playerMark TEXT,
    step TEXT
)";
        $db->exec($stepsInfoTable);
    } else {
        $db = new \SQLite3('./../db/gamedb.db');
    }
    return $db;
}

function getGameId($db)
{
    $query = "SELECT idGame 
    FROM gamesInfo 
    ORDER BY idGame DESC LIMIT 1";
    $result = $db->querySingle($query);
    if (is_null($result))
        return 1;
    return $result + 1;
}

function insertInfo($gamesInfo, $turns) {
    $db = openDatabase();
    $id = getGameId($db);
    $data = $gamesInfo[2];
    $time = $gamesInfo[3];
    $name = $gamesInfo[0];
    $size = $gamesInfo[1];
    $mark = $gamesInfo[4];
    if ($gamesInfo[5] == "PC") {
        $result = "ПОРАЖЕНИЕ";
    } else if ($gamesInfo[5] == "Draw"){
        $result = "НИЧЬЯ";
    } else { 
        $result = "ПОБЕДА";
    }
    $db->exec("INSERT INTO gamesInfo (
        idGame,
        gameData, 
        gameTime, 
        playerName, 
        sizeBoard, 
        result
        ) VALUES (
        '$id', 
        '$data', 
        '$time', 
        '$name', 
        '$size', 
        '$result')");
    for($i = 0; $i < count($turns); $i++) {
        $db->exec("INSERT INTO stepsInfo (
            idGame, 
            playerMark, 
            step
            ) VALUES (
            '$id', 
            '$mark', 
            '$turns[$i]')");
    }
}

function listGames()
{
    $db = openDatabase();
    $result = $db->query("SELECT * FROM gamesInfo");
    $gamesInfo = "";
    while ($row = $result->fetchArray()) {
        for ($i = 0; $i < 6; $i++) {
            $gamesInfo .= $row[$i] . "|";
        }
        $gamesInfo .= ";";
    }
    return $gamesInfo;
}


function gameById($id)
{
    $db = openDatabase();
    $result = $db->query("SELECT * FROM gamesInfo WHERE idGame = '$id'");
    $gamesInfo = "";
    while ($row = $result->fetchArray()) {
        for ($i = 0; $i < 6; $i++) {
            $gamesInfo .= $row[$i] . "|";
        }
        $gamesInfo .= ";";
    }
}

function turnsById($id)
{
    $db = openDatabase();
    $result = $db->query("SELECT PlayerMark, step FROM stepsInfo WHERE idGame = '$id'");
    $turnsInfo = "";
    while ($row = $result->fetchArray()) {
        for ($i = 0; $i < 2; $i++) {
            $turnsInfo .= $row[$i] . "|";
        }
        $turnsInfo .= ";";
    }
    return $turnsInfo;
}

