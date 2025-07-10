<?php
require_once('functions.php');

// POSTデータがなければindex.phpにリダイレクト
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// バリデーション
if (!isset($_POST['name']) || $_POST['name'] === '' || !isset($_POST['url']) || $_POST['url'] === '') {
     exit('必須項目が入力されていません。');
}

// POSTデータを変数に格納
$id = $_POST['id'];
$name = $_POST['name'];
$url = $_POST['url'];
$comment = $_POST['comment'] ?? '';

// DB接続
$pdo = db_connect();

try {
    // UPDATE文のプリペアドステートメント
    $sql = 'UPDATE bookmarks SET name = :name, url = :url, comment = :comment WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':url', $url, PDO::PARAM_STR);
    $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // 更新後はindex.phpへリダイレクト
    header('Location: index.php');
    exit;

} catch (PDOException $e) {
    exit('データベースエラー: ' . $e->getMessage());
}