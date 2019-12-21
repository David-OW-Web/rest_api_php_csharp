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

// SQL-Select Stmt SELECT answer_id, answer_content, answer.created_at AS 'create_date', question.question_title, forum_user.username AS 'username' FROM answer INNER JOIN question ON answer.fk_question_id=question.question_id INNER JOIN forum_user ON answer.fk_user_id=forum_user.user_id;


if(isset($postData)) {
    $arr_answers = [];
    $pdo = new PDO("mysql:host=localhost;dbname=forum", "root", "");
    $stmt = $pdo->prepare("SELECT answer_id, fk_question_id , answer_content, answer.created_at AS 'create_date', question.question_title, forum_user.username AS 'username' FROM answer INNER JOIN question ON answer.fk_question_id=question.question_id INNER JOIN forum_user ON answer.fk_user_id=forum_user.user_id");
    $stmt->execute();
    foreach($stmt->fetchAll() as $answer) {
        $answer_json = new stdClass();
        $answer_json->id = (int)$answer['answer_id'];
        $answer_json->question_id = (int)$answer['fk_question_id'];
        $answer_json->content = $answer['answer_content'];
        $answer_json->created_at = $answer['create_date'];
        $answer_json->title = $answer['question_title'];
        $answer_json->username = $answer['username'];
        array_push($arr_answers, $answer_json);
    }

    $json = new stdClass();
    $json->answers = $arr_answers;
    header("Content-type: application/json");
    echo json_encode($json);
}