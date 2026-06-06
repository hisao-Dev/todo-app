<?php require_once '../datebase/db_connect.php';

$id = $_POST['id'];
$sort = $_POST['sort']; 

var_dump($id,$sort);
try {
    $sql = "SELECT * FROM tasks WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':id', $id);

    $stmt->execute();
    exit;
} catch (PDOException $e) {
    echo "エラー: " . $e->getMessage();
}
var_dump($tasks = $stmt->fetchAll(PDO::FETCH_ASSOC));
?>
<p id="title">
    編集画面&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <?php            
        $date = new DateTime(); // 現在日時
        $w = ['日','月','火','水','木','金','土']; // 日本語曜日
        $dayOfWeek = $w[$date->format('w')]; // 0(日)～6(土)
        echo $date->format('Y年m月d日') . "($dayOfWeek)";
    ?>
</p>
<div id="edit_item">
    <form action="../function/create.php" method="POST">
        <!-- タスク名 -->
        <label for="task">タイトル：</label>
        <input type="text" id="task" name="task" required><br>

        <!-- 内容 -->
        <label for="content">内容：</label>
        <textarea id="content" name="content" rows="4" cols="50"></textarea><br>

        <div id="unit">
            <!-- 日付時刻 -->
            <div id="unit_1">
                <label for="task_date">期限：</label>
                <input type="date" id="task_date" name="task_date"><br>

                <label for="task_time">時間（任意）：</label>
                <input type="time" id="task_time" name="task_time"><br>
            </div>

            <!-- 優先度 -->
            <div id="unit_2">
                <label for="priority">優先度：</label>
                <select id="priority" name="priority">
                    <option value="-">設定しない</option>
                    <option value="高">高</option>
                    <option value="中">中</option>
                    <option value="低">低</option>
                </select><br>
            </div>

            <!-- 送信ボタン-->
            <div>
              <input type="submit" value="編集完了">
            </div>
        </div>
    </form>
    <?php
        $message = '';
        if (isset($_GET['status']) && $_GET['status'] === 'success') {
            $message = 'タスクの編集が完了しました';
        }
        if ($message) {
            echo "<p>".$message."</p>";
        }
    ?>
</div>