<?php

// XSS対策関数
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// DB接続関数
function db_connect() {
    // --- さくらサーバー・AMPP共通設定 ---
    $db_host = 'mysql_host'; // AMPPなら 'localhost', さくらサーバーなら指定されたホスト名
    $db_name = 'your_db_name';   // あなたのデータベース名
    $db_user = 'your_db_user';   // あなたのユーザー名
    $db_pass = 'your_db_pass';   // あなたのパスワード
    // ------------------------------------
    
    $dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4";

    try {
        $pdo = new PDO($dsn, $db_user, $db_pass);
        // エラー発生時に例外をスローするように設定
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // フェッチモードを連想配列形式に設定
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    } catch (PDOException $e) {
        // 接続エラーの場合はエラーメッセージを表示して終了
        exit('データベースに接続できませんでした。' . $e->getMessage());
    }
}