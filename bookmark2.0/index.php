<?php
require_once('functions.php');

// DBに接続
$pdo = db_connect();

// DBからデータを全件取得
$stmt = $pdo->query('SELECT * FROM bookmarks ORDER BY id DESC');
$bookmarks = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ブックマークアプリ</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>ブックマークアプリ</h1>

    <h2>ブックマーク登録</h2>
    <form action="insert.php" method="POST">
        <label for="name">書籍名:</label>
        <input type="text" id="name" name="name" required>
        
        <label for="url">URL:</label>
        <input type="url" id="url" name="url" required>
        
        <label for="comment">コメント:</label>
        <textarea id="comment" name="comment"></textarea>
        
        <button type="submit">登録</button>
    </form>

    <h2>ブックマーク一覧</h2>
    <div class="bookmark-list">
        <?php foreach ($bookmarks as $bookmark): ?>
            <div class="bookmark-item">
                <h3><a href="<?= h($bookmark['url']) ?>" target="_blank"><?= h($bookmark['name']) ?></a></h3>
                <p><?= nl2br(h($bookmark['comment'])) ?></p>
                <div class="actions">
                    <a href="detail.php?id=<?= h($bookmark['id']) ?>">編集</a>
                    <a href="delete.php?id=<?= h($bookmark['id']) ?>" onclick="return confirm('本当に削除しますか？')">削除</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>