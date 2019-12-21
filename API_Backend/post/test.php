<?php
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');
}

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

$postData = file_get_contents("php://input");

if(isset($postData)) {
    $arr_books = [];
    $request = json_decode($postData);
    $data = new stdClass();
    $title = $request->title;
    $title = $_POST['title'];
    $message = "";
    if($title == "Titel") {
        $message = "Title cant have the value Titel... POST request worked";
    }
    $json = new stdClass();
    $json->message = $message;
    $json->title = $title;
    header("Content-Type: application/json");
    echo json_encode($json);
}