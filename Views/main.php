<div id="main">
    <div id="left">
        <nav id="menu">
            <ul>
                <li><メニュー></li>
                <li><a href="index.php?page=display">今日のタスク</a></li>
                <li><a href="index.php?page=add_task">新規入力</a></li>
                <li><a href="index.php?page=list_tasks">タスク一覧表</a></li>
                <li><a href="index.php?page=calendar">カレンダー</a></li>
            </ul>
            <?php 
            $message = '';
            if (isset($_GET['status']) && $_GET['status'] === 'delete') {
                $message = '削除しました';
            }
            if (isset($_GET['status']) && $_GET['status'] === 'complete') {
                $message = '編集が完了しました';
            }
            if ($message) {
                echo "<p id='message'>".$message."</p>";
            }
            ?>
        </nav>
    </div>
    <div id="right">
        <div id="outer">
            <?php
                switch ($page) {
                    case 'display':
                        require_once 'display.php';
                        break;
                    case 'add_task':
                        require_once 'add_task.php';
                        break;
                    case 'list_tasks':
                        require_once 'list_tasks.php';
                        break;
                    case 'calendar':
                        require_once 'calendar.php';
                        break;
                    case 'edit_task':
                        require_once 'edit_task.php';
                        break;
                    default:
                        echo "<p>ようこそ！メニューから選択してください。</p>";
                }
            ?>
        </div>
    </div>
</div>