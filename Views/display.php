<!-- 今日のタスク・日付 -->
<p id="title">
    今日のタスク&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <?php            
        $date = new DateTime(); // 現在日時
        $w = ['日','月','火','水','木','金','土']; // 日本語曜日
        $dayOfWeek = $w[$date->format('w')]; // 0(日)～6(土)
        echo $date->format('Y年m月d日') . "($dayOfWeek)";
    ?>
</p>
<!-- 並び変え -->
<form id="sortForm" method="GET">
    <label for="sort">並び替え:</label>
    <select name="sort" id="sort" onchange="this.form.submit()">
        <option value="time" <?= ($_GET['sort'] ?? '')=='time' ? 'selected':'' ?>>期限順</option>
        <option value="priority" <?= ($_GET['sort'] ?? '')=='priority' ? 'selected':'' ?>>優先度順</option>
        <option value="status" <?= ($_GET['sort'] ?? '')=='status' ? 'selected':'' ?>>ステータス順</option>  
    </select>
</form>

<!-- タスクの表示 -->
<div id="display">
    <?php 
        require_once '../datebase/db_connect.php';

        try {
            $today = date('Y-m-d');
            $options = ['未着手', '進行中', '完了'];
            $prioritys = ['高', '中', '低', '-']; 
            $sort = $_GET['sort'] ?? 'time';
            

            // 並び替え用SQL
            switch($sort) {
                case 'priority':
                    $orderSQL = "ORDER BY FIELD(priority, '高','中','低','-'), task_datetime ASC";
                    break;
                case 'status':
                    $orderSQL = "ORDER BY FIELD(status, '未着手','進行中','完了'), task_datetime ASC";
                    break;
                case 'time':
                    $orderSQL = "ORDER BY CASE WHEN TIME(task_datetime) = '00:00:00' THEN 1 ELSE 0 END ASC, task_datetime ASC";
                    break;
                default:
                    $orderSQL = "ORDER BY task_datetime ASC";
            }

            // ソート付きでタスク取得
            $sql = "SELECT * FROM tasks WHERE DATE(task_datetime) = :today $orderSQL";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['today' => $today]);
            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            //  タスク表示
            foreach ($tasks as $task) {
                echo "<div class='taskDisplay'>";
                echo "<div class='task_head'>";
                echo "<div class='task_name'>".$task['title']."</div>";
                echo "<div class='info_box'>";
                
                // 期日表示
                $dt = new DateTime($task['task_datetime']);
                echo "<div class='task_time'>期限：";
                echo $dt->format('H:i') === '00:00' ? "本日中&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>" : $dt->format('H:i')."まで</div>";

                // 優先度フォーム
                echo "<form action='../function/priority_edit.php' method='POST'>";
                echo "<input type='hidden' name='id' value='" . $task['id'] . "'>";
                echo "<input type='hidden' name='sort' value='". $sort ."'>";
                echo "<input type='hidden' name='form' value='display'>";
                echo "<label for='priority'>優先度：</label>";
                echo "<select name='priority' onchange='this.form.submit()'>";
                foreach ($prioritys as $priority) {
                    $selected = ($task['priority'] == $priority) ? ' selected' : '';
                    echo "<option value='$priority'$selected>$priority</option>";
                }
                echo "</select></form>";

                // ステータスフォーム
                echo "<form action='../function/status_edit.php' method='POST'>";
                echo "<input type='hidden' name='id' value='" . $task['id'] . "'>";
                echo "<input type='hidden' name='sort' value='". $sort ."'>";
                echo "<input type='hidden' name='form' value='display'>";
                echo "<label for='status'>ステータス：</label>";
                echo "<select name='status' onchange='this.form.submit()'>";
                foreach ($options as $option) {
                    $selected = ($task['status'] == $option) ? ' selected' : '';
                    echo "<option value='$option'$selected>$option</option>";
                }
                echo "</select></form>";

                echo "</div></div><hr class='hr'>";
                // 内容
                echo "<div class='task_main'>".nl2br(htmlspecialchars($task['content']))."</div>";

                // 編集・削除
                echo "<div class='task_footer'>";
                echo "<button class='task_edit' 
                        data-sort='". $sort."'
                        data-id='" . $task['id'] . "' 
                        data-title='" . htmlspecialchars($task['title']) . "'
                        data-content='" . htmlspecialchars($task['content']) . "'
                        data-taskdate='" . htmlspecialchars($dt->format('Y-m-d')) . "'
                        data-timeh='" . htmlspecialchars($dt->format('H')) . "'
                        data-timem='" . htmlspecialchars($dt->format('i')) . "'
                        data-status='" . htmlspecialchars($task['status']) . "'
                        data-priority='" . htmlspecialchars($task['priority']) . "'
                        type='button'>
                        詳細編集
                    </button>";
                echo "<form action='../function/task_delete.php' method='POST'>";
                echo "<input type='hidden' name='id' value='" . $task['id'] . "'>";
                echo "<input type='hidden' name='form' value='display'>";
                echo "<button class='task_delete' type='submit'>削除</button>";
                echo "</form></div></div>";
            }


        } catch (PDOException $e) {
            echo "エラー: " . $e->getMessage();
        }
    ?> 
    <!-- モーダル -->
    <?php require_once '../function/time_edit.php'; ?>
    <div id="modal" class="modal hidden">
        <div id="modal_data">
            <span id="closeModal">✖</span>

            <form id="editForm" method="POST" action="../function/update.php">
                <input type="hidden" name="id" id="modal_id">
                <input type="hidden" name="sort" value="<?php echo $sort; ?>">
                <input type='hidden' name='form' value='display'>
                <!-- タスク名 -->
                <div>
                    <label class="character">タスク名</label><span class="colon">：</span>
                </div>
                <textarea type="text" name="title" id="modal_task" required></textarea>
                
                <!-- 内容 -->
                <div>
                    <label class="character">内容</label><span class="colon">：</span>
                </div>
                <textarea name="content" id="modal_content"></textarea>

                <div id="datetime">

                    <!-- 期限 -->
                    <div>
                        <label class="character">期限</label><span class="colon">：</span>
                        <input type="date" name="task_date" id="modal_task_date">
                    </div>

                    <!-- 時間 -->
                    <div>
                        <label class="character">時間</label><span class="colon">：</span>
                        <select name="time_h" id="modal_time_h">
                            <option value="">ー</option>
                            <?php getHourOptions(); ?>
                        </select>

                        <select name="time_m" id="modal_time_m">
                            <option value="">ー</option>
                            <?php getMinutesOptions(); ?>
                        </select>
                    </div>
                </div>

                <!-- 優先度 -->
                <div>
                    <label class="character">優先度</label><span class="colon">：</span>
                    <select name="priority" id="modal_priority">
                        <option value="高">高</option>
                        <option value="中">中</option>
                        <option value="低">低</option>
                        <option value="-">-</option>
                    </select>
                </div>

                <!-- ステータス -->
                <div>
                    <label class="character">ステータス</label><span class="colon">：</span>
                    <select name="status" id="modal_status">
                        <option value="未着手">未着手</option>
                        <option value="進行中">進行中</option>
                        <option value="完了">完了</option>
                    </select>
                </div>

                <button type="submit" id="keep_btn">保存</button>
            </form>
        </div>
    </div>
</div>
