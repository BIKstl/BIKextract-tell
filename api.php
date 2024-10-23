<?php
/*
@BIKstl
https://t.me/BIKstl
*/
error_reporting(0);
header('Content-Type: application/json;');
if (isset($_GET['url'])) {
    $cu = curl_init();
    curl_setopt($cu, CURLOPT_URL, 'https://online.drweb.com/result/?lng=en');
    curl_setopt($cu, CURLOPT_POST, true);
    curl_setopt($cu, CURLOPT_POSTFIELDS, ['url' => $_GET['url'], 'submit' => 'Submit']);
    curl_setopt($cu, CURLOPT_COOKIEFILE, 'DrWeb.txt');
    curl_setopt($cu, CURLOPT_COOKIEJAR, 'DrWeb.txt');
    curl_setopt($cu, CURLOPT_RETURNTRANSFER, true);
    $respone = curl_exec($cu);
    curl_close($cu);
    preg_match('#<img align="right" src="(.*?)" width="193" height="58" alt="" border="0"/>#', $respone, $msg);
    if ($msg[1] == 'https://st.drweb.com/pix/online/clean_en.gif') {
        $show = ['ok' => true, 'message' => 'Clean ✅'];
    } elseif ($msg[1] == './Dr.Web Online Check Result_files/error_en.gif') {
        $show = ['ok' => true , 'channel' => '@BIKstl' , 'message' => 'Something went wronge ⁉️'];
    } else {
        $show = ['ok' => false, 'channel' => '@BIKstl' , 'message' => 'Destructive ❌'];
    }
    unlink('DrWeb.txt');
} else {
    $show = ['ok' => true, 'channel' => '@BIKstl' , 'message' => 'Where is url?!'];
}
echo json_encode($show, JSON_PRETTY_PRINT);
/*
@BIKstl
https://t.me/BIKstl
*/