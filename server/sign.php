<?php
$AccessKeyId="YOUR KEY";
$AccessKeySecret="YOUR KEY SECRET";

$content=$_REQUEST['content'];
$sign=base64_encode(hash_hmac('sha1',$content,$AccessKeySecret,true)); 
echo "OSS " . $AccessKeyId . ":" . $sign;
// file_put_contents("/var/www/alioss/server/a.txt",print_r($_REQUEST,TRUE),FILE_APPEND);
