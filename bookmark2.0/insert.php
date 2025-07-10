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

$name = $_POST['name'];
$url = $_POST['url'];
$comment = $_POST['comment'] ?? ''; // コメントは任意

// DB接続
$pdo = db_connect();

try {
    // SQLインジェクション対策として、プリペアドステートメントを使用
    $sql = 'INSERT INTO bookmarks(name, url, comment) VALUES(:name, :url, :comment)';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':url', $url, PDO::PARAM_STR);
    $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
    $stmt->execute();

    // 登録後はindex.phpへリダイレクト
    header('Location: index.php');
    exit;

} catch (PDOException $e) {
    exit('データベースエラー: ' . $e->getMessage());
}