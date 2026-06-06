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