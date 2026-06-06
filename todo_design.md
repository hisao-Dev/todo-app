**1. 画面を決める（見た目）**
・左画面にメニュー
  表示画面
  新規入力(タスクを追加)画面
  一覧表画面
  カレンダー画面

・右画面の種類(左画面メニューで切り替え)
  今日のタスク内容画面(デフォルト)
  新規入力画面(追加)
  一覧表画面(編集・削除)
  検索画面(編集・削除)
  カレンダー画面(表示・タスクの有無)

・今日のタスク内容画面の内容
  タスク名、内容、期日の表示
  タスクの編集
  完了/未完了
  削除

・カレンダー 年、月、日、曜日と件数表示 件数をクリックでその日のタスクを表示

**2. 何ができるか決める（機能）**
・タスクを追加する
・タスクの完了/未完了の切り替え
・タスクの削除
・タスクの編集
・カレンダー機能(カレンダーの表示、タスクの有無)

**3. データをどうするか決める(保存するもの)**
・タスクID
・タスク名
・内容
・タスク実行の日付
・タスク実行の時間
・完了/未完了状態
・作成日
・更新日

**4. データベース(テーブル設計)**
・tasksテーブル
| 内容               | カラム名      |
|:-----------------: |:-------------:|
| タスクID           | id            |
| ユーザーID         | user_id       |
| タスク名           | task          |
| 内容               | content       |
| 日付時刻           | task_datetime |
| 未完了/保留/完了   | status        |
| 優先度             | priority      |
| 作成日             | created_date  |
| 更新日             | updated_date  |


**5. 技術を決める**
HTML/CSS → 見た目
JavaScript → 画面の動き
PHP → データを保存する

ブラウザでの表示の仕方
XAMPP
・Apache
・MySQL
http://localhost/todo-app/index.php

・キャッシュのクリア
Windows: Ctrl + F5
Mac: Cmd + Shift + R

phpMyAdmin
ユーザー名：todo-app
ホスト名：localhost
パスワード：asdf2469?
http://localhost/phpmyadmin/

git add .
git commit -m "変更内容"
git push

$_GET['page]で作成
index.php?page=add_task
switch $page
case 'add_task':

