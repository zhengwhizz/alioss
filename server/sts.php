<?php
$AccessKeyId="YOUR KEY";
$AccessKeySecret="YOUR KEY SECRET";
// 角色资源描述符，在RAM的控制台的资源详情页上可以获取
$roleArn = "acs:ram::1790501090734282:role/osstest";
define("REGION_ID", "cn-shanghai");
define("ENDPOINT", "sts.cn-shanghai.aliyuncs.com");


/*
 * 在您使用STS SDK前，请仔细阅读RAM使用指南中的角色管理部分，并阅读STS API文档
 *
 */
include_once 'aliyun-php-sdk-core/Config.php';
 


// 只允许子用户使用角色
DefaultProfile::addEndpoint(REGION_ID, REGION_ID, "Sts", ENDPOINT);
#### RAM 子用户key \ secret  拥有 AliyunOSSFullAccess AliyunSTSAssumeRoleAccess 两项权限 
$iClientProfile = DefaultProfile::getProfile(REGION_ID, $AccessKeyId, $AccessKeySecret);
$client = new DefaultAcsClient($iClientProfile);

// 在扮演角色(AssumeRole)时，可以附加一个授权策略，进一步限制角色的权限；
// 详情请参考《RAM使用指南》
// 此授权策略表示读取所有OSS的只读权限
$policy=<<<POLICY
{
  "Statement": [
    {
      "Action": [
        "oss:Get*",
        "oss:List*"
      ],
      "Effect": "Allow",
      "Resource": "*"
    }
  ],
  "Version": "1"
}
POLICY;
$request = new Sts\Request\V20150401\AssumeRoleRequest();
// RoleSessionName即临时身份的会话名称，用于区分不同的临时身份
// 您可以使用您的客户的ID作为会话名称
$request->setRoleSessionName("abc");
$request->setRoleArn($roleArn);
// $request->setPolicy($policy);
$request->setDurationSeconds(3600);
try {
    $response = $client->getAcsResponse($request);
    
    $ret=array(
        "StatusCode"=>200,
        "AccessKeyId"=>$response->Credentials->AccessKeyId,
        "AccessKeySecret"=>$response->Credentials->AccessKeySecret,
        "Expiration"=>$response->Credentials->Expiration,
        "SecurityToken"=>$response->Credentials->SecurityToken
    );

    // file_put_contents("/var/www/alioss/server/b.txt",print_r($_REQUEST,TRUE),FILE_APPEND); 
    
    echo json_encode($ret);exit;

} catch(ServerException $e) {
    print "Error: " . $e->getErrorCode() . " <br>Message: " . $e->getMessage() . "\n";
} catch(ClientException $e) {
    print "Error: " . $e->getErrorCode() . " <br>Message: " . $e->getMessage() . "\n";
}
 