<?php
require_once('functions.php');

// GETでIDが渡されていなければ一覧へリダイレクト
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = $_GET['id'];

// DB接続
$pdo = db_connect();

try {
    // DELETE文のプリペアドステートメント
    $stmt = $pdo->prepare('DELETE FROM bookmarks WHERE id = :id');
    $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
    $stmt->execute();

    // 削除後はindex.phpへリダイレクト
    header('Location: index.php');
    exit;

} catch (PDOException $e) {
    exit('データベースエラー: ' . $e->getMessage());
}