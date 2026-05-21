<?php
require_once '../datebase/db_connect.php';

$id = $_POST['id'];
$priority = $_POST['priority'];
$sort = $_POST['sort']; 
$form = $_POST['form'];

echo $form;
try {
    $sql = "UPDATE tasks SET priority = :priority WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':priority', $priority);
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