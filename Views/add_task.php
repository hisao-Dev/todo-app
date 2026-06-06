<?php require_once '../function/time_edit.php'; ?>

<div>
    <p id="title">タスクの新規作成</p>
</div>
<div id="menu_item">
    <form action="../function/create.php" method="POST">
        <!-- タスク名 -->
        <label for="title">タスク名：<span>(必須)</span></label>
        <input type="text" id="task" name="title" maxlength="30" required><br>

        <!-- 内容 -->
        <label for="content">内容：</label>
        <textarea id="content" name="content" rows="4" cols="50"></textarea><br>

        <div id="unit">
            <!-- 日付時刻 -->
            <div id="unit_1">
                <label for="task_date">期限：</label>
                <input type="date" id="task_date" name="task_date"><br>

                <label for="task_time_">時間：</label>
                <select name="task_time_h">
                <?php
                echo "<option value='--'>ー</option>";
                getHourOptions();
                ?>
                </select>
                <select name="task_time_m">
                <?php
                echo "<option value='--'>ー</option>";
                getMinutesOptions();
                ?>
                </select><br>
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
              <input type="submit" value="新規作成">
            </div>
        </div>
    </form>
    <?php
        $message = '';
        if (isset($_GET['status']) && $_GET['status'] === 'success') {
            $message = 'タスクの作成が完了しました';
        }
        if ($message) {
            echo "<p>".$message."</p>";
        }
    ?>
</div>