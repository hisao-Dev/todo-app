<?php
require_once '../datebase/db_connect.php';

// POSTデータ
$title = $_POST['title'];
$content = $_POST['content'];
$task_date = $_POST['task_date'] ?? '';
$task_time_h = $_POST['task_time_h'] ?? '';
$task_time_m = $_POST['task_time_m'] ?? '';
$task_time = $task_time_h.":".$task_time_m;

if (mb_strlen($title, 'UTF-8') > 30) {
    die("エラー：タスク名は50文字以内で入力してください。");
}

if ($task_date !== '') {
    // 時間が未入力なら 00:00 に設定
    $task_time = $task_time !== '' ? $task_time : '00:00';
    $task_datetime = $task_date . ' ' . $task_time . ':00'; // "YYYY-MM-DD HH:MM:SS"
} else {
    $task_datetime = null; // 日付が未入力ならNULL
}
// フォームから送信された priority を整数で受け取る
$priority = isset($_POST['priority']) && $_POST['priority'] !== '' ? $_POST['priority'] : 0;

try {
    // 既存ユーザーを検索
    $email = "test";
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $user_id = $user['id']; // 既存ユーザー
        echo "既存ユーザーID: $user_id<br>";
    } else {
        // ユーザーが存在しなければ新規作成
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute([
            ':name' => "テスト",
            ':email' => $email,
            ':password' => "123"
        ]);
        $user_id = $pdo->lastInsertId();
        echo "新規ユーザー作成ID: $user_id<br>";
    }

    // タスク登録
    $sql = "INSERT INTO tasks (user_id, title, content, task_datetime, priority) 
            VALUES (:user_id, :title, :content, :task_datetime, :priority)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':user_id' => $user_id,
        ':title' => $title,
        ':content' => $content,
        ':task_datetime' => $task_datetime,
        ':priority' => $priority
    ]);

    header('Location: ../Views/index.php?page=add_task&status=success');
    exit;
} catch (PDOException $e) {
    echo "エラー: " . $e->getMessage();
}
?>