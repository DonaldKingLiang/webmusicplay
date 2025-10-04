<?php
try {
    // 連接到位於 admin 資料夾內的資料庫
    $db = new PDO('sqlite:admin/database.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 從資料庫查詢所有歌曲
    $result = $db->query("SELECT title, artist, path FROM songs ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

    // 重新組合陣列，以符合前端 JavaScript 的格式需求
    $playlist = [];
    foreach ($result as $row) {
        $playlist[] = [
            'title' => $row['title'],
            'artist' => $row['artist'],
            'src' => $row['path'] // 'src' 對應到資料庫的 'path' 欄位
        ];
    }
    
    // 設定回應標頭為 JSON
    header('Content-Type: application/json');
    // 輸出 JSON 格式的播放列表
    echo json_encode($playlist);

} catch (PDOException $e) {
    // 如果出錯，回傳錯誤訊息
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode(['error' => '無法連接資料庫: ' . $e->getMessage()]);
}
?>