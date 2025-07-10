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
    // IDでデータを1件取得
    $stmt = $pdo->prepare('SELECT * FROM bookmarks WHERE id = :id');
    $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
    $stmt->execute();
    $bookmark = $stmt->fetch();

    // データが見つからなければ一覧へ
    if (!$bookmark) {
        exit('指定されたデータが見つかりません。');
    }
} catch (PDOException $e) {
    exit('データベースエラー: ' . $e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ブックマーク編集</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>ブックマーク編集</h1>
    <form action="update.php" method="POST">
        <input type="hidden" name="id" value="<?= h($bookmark['id']) ?>">
        
        <label for="name">書籍名:</label>
        <input type="text" id="name" name="name" value="<?= h($bookmark['name']) ?>" required>
        
        <label for="url">URL:</label>
        <input type="url" id="url" name="url" value="<?= h($bookmark['url']) ?>" required>
        
        <label for="comment">コメント:</label>
        <textarea id="comment" name="comment"><?= h($bookmark['comment']) ?></textarea>
        
        <button type="submit">更新</button>
    </form>
    <p><a href="index.php">一覧に戻る</a></p>
</body>
</html>