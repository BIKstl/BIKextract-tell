<?php
/*
@BIKstl
https://t.me/BIKstl
*/
define('API_KEY', 'Token');
function Poker($method, $datas = [])
{
    $url = 'https://api.telegram.org/bot' . API_KEY . '/' . $method;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);
    $res = curl_exec($ch);
    if (curl_error($ch)) {
        var_dump(curl_error($ch));
    } else {
        return json_decode($res);
    }
}
function sendM($chat_id, $text, $msg_id)
{
    Poker('sendMessage', [
        'chat_id' => $chat_id,
        'text' => $text,
        'reply_to_message_id' => $msg_id
    ]);
}
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$text = $message->text;
$msg_id = $message->message_id;
$chat_id = $message->chat->id;
if ($text == '/start') {
    sendM($chat_id, "❤️ سلام لطفا فایل مورد نظر را جهت برسی ارسال یا فوروارد کنید ❤️\n📢 کانال ما : @BIKstl", $msg_id);
} else {
    if (!isset($text)) {
        if (!is_null($message->sticker->file_id)) {
            $id = $message->sticker->file_id;
        } elseif (!is_null($message->photo[count($message->photo) - 1]->file_id)) {
            $id = $message->photo[count($message->photo) - 1]->file_id;
        } elseif (!is_null($message->audio->file_id)) {
            $id = $message->audio->file_id;
        } elseif (!is_null($message->voice->file_id)) {
            $id = $message->voice->file_id;
        } elseif (!is_null($message->video->file_id)) {
            $id = $message->video->file_id;
        } elseif (!is_null($message->document->file_id)) {
            $id = $message->document->file_id;
        } elseif (is_null($message->video_note->file_id)) {
            $id = $message->video->file_id;
        }
        $get = Poker('getFile', ['file_id' => $id]);
        if ($get->result->file_size < 200000) {
            $patch = $get->result->file_path;
            $url = 'https://api.telegram.org/file/bot' . API_KEY . '/' . $patch;
            $api = json_decode(file_get_contents('https://yourdomin.com/api.php?url=' . $url));
            $msg = $api->message;
            sendM($chat_id, "$msg\n📢 کانال ما : @BIKstl", $msg_id);
        } else {
            sendM($chat_id, "حجم فایل حداکثر میتواند 20 مگابایت باشد\n📢 کانال ما : @BIKstl", $msg_id);
        }
    }
}
if (file_exists('error_log')) {
    unlink('error_log');
}
/*
@BIKstl
https://t.me/BIKstl
*/
?>