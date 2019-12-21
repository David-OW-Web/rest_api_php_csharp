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
    $request = json_decode($postData);
    $arr_questions = [];
    $pdo = new PDO("mysql:host=localhost;dbname=forum", "root", "");
    /* $stmt = $pdo->prepare("SELECT question_id, question_content, created_at, question_title, category.cat_title AS 'category',
    user.username AS 'username', status.description AS 'status' FROM question INNER JOIN category ON question.fk_cat_id=categor.cat_id INNER JOIN
    user ON question.fk_user_id=user.user_id INNER JOIN question_status ON question.fk_status_id=question_status.status_id"); */
    $stmt = $pdo->prepare("SELECT question_id, question_content, question.created_at AS 'create_date', question_title, category.cat_title AS 'category', 
    forum_user.username AS 'username', question_status.description AS 'status' FROM question INNER JOIN category ON question.fk_cat_id=category.cat_id INNER JOIN
    forum_user ON question.fk_user_id=forum_user.user_id INNER JOIN question_status ON question.fk_status_id=question_status.status_id");
    $stmt->execute();
    foreach($stmt->fetchAll() as $question) {
        $question_json = new stdClass();
        $question_json->id = (int)$question['question_id'];
        $question_json->title = $question['question_title'];
        $question_json->content = $question['question_content'];
        $question_json->created_at = $question['create_date'];
        $question_json->category = $question['category'];
        $question_json->username = $question['username'];
        $question_json->status = $question['status'];
        array_push($arr_questions, $question_json);
    }
    $json = new stdClass();
    $json->questions = $arr_questions;
    header("Content-type: application/json");
    echo json_encode($json);
}