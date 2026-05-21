<?php
require_once '../datebase/db_connect.php';

// POSTデータ
$id = $_POST['id'];
$title = $_POST['title'];
$content = $_POST['content'];
$task_date = $_POST['task_date'] ?? '';
$time_h = $_POST['time_h'] ?? '';
$time_m = $_POST['time_m'] ?? '';
$task_time = $time_h.":".$time_m;
$priority = $_POST['priority'];
$status = $_POST['status'];
$sort = $_POST['sort'];
$form = $_POST['form'];

if ($task_date !== '') {
    // 時間が未入力なら 00:00 に設定
    $task_time = $task_time !== '' ? $task_time : '00:00';
    $task_datetime = $task_date . ' ' . $task_time . ':00'; // "YYYY-MM-DD HH:MM:SS"
} else {
    $task_datetime = null; // 日付が未入力ならNULL
}

try {
    // idを検索
    $stmt = $pdo->prepare("
        UPDATE tasks
        SET title = :title,
            content = :content,
            task_datetime = :task_datetime,
            status = :status,
            priority = :priority
        WHERE id = :id
    "); 
    $stmt->execute([
        ':id' => $id,
        ':title' => $title,
        ':content' => $content,
        ':task_datetime' => $task_datetime,
        ':status' => $status,
        ':priority' => $priority
    ]);


    // if ($user) {
    //     $user_id = $user['id']; // 既存ユーザー
    //     echo "既存ユーザーID: $user_id<br>";
    // } else {
    //     // ユーザーが存在しなければ新規作成
    //     $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    //     $stmt->execute([
    //         ':name' => "テスト",
    //         ':email' => $email,
    //         ':password' => "123"
    //     ]);
    //     $user_id = $pdo->lastInsertId();
    //     echo "新規ユーザー作成ID: $user_id<br>";
    // }

    // タスク登録
    // $sql = "INSERT INTO tasks (user_id, task, content, task_datetime, priority) 
    //         VALUES (:user_id, :task, :content, :task_datetime, :priority)";
    // $stmt = $pdo->prepare($sql);
    // $stmt->execute([
    //     // ':user_id' => $user_id,
    //     ':task' => $task,
    //     ':content' => $content,
    //     ':task_datetime' => $task_datetime,
    //     ':priority' => $priority
    // ]);
    if ($form === 'display') {
        header('Location: ../Views/index.php?page=display&status=complete');
    } else if($form === 'list') {
        header('Location: ../Views/index.php?page=list_tasks&status=complete');
    }
    exit;
} catch (PDOException $e) {
    echo "エラー: " . $e->getMessage();
}
?>