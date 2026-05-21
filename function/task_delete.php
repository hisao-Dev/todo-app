<?php
require_once '../datebase/db_connect.php';

$id = $_POST['id'];
$form = $_POST['form'];

try {
    $sql = "DELETE FROM tasks WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':id', $id);

    $stmt->execute();
    if ($form === 'display') {
        header('Location: ../Views/index.php?page=display&status=delete');
    } else if($form === 'list') {
        header('Location: ../Views/index.php?page=list_tasks&status=delete');
    }

    exit;
} catch (PDOException $e) {
    echo "エラー: " . $e->getMessage();
}

?>
