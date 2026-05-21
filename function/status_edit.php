<?php
require_once '../datebase/db_connect.php';

$id = $_POST['id'];
$status = $_POST['status'];
$sort = $_POST['sort']; 
$form = $_POST['form'];

try {
    $sql = "UPDATE tasks SET status = :status WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':status', $status);
    $stmt->bindValue(':id', $id);

    $stmt->execute();
    if ($form === 'display') {
        header("Location: ../Views/index.php?page=display&sort=$sort");
    } else if($form === 'list') {
        header("Location: ../Views/index.php?page=list_tasks");
    }
    exit;
} catch (PDOException $e) {
    echo "エラー: " . $e->getMessage();
}

?>