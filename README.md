# alioss
阿里云OSS鉴权示例

## 使用前请先开通阿里云OSS及访问控制，并设置相应权限。
自签名和STS鉴权模式阿里云设置步骤：

登录阿里云服务器管理控制台，开通访问控制RAM

自签名:用户管理新建用户，并授权AliyunOSSFullAccess权限, 记录AccessKey和secret

STS鉴权:在自签名基础上，用户管理授权  AliyunSTSAssumeRoleAccess 权限，角色管理新建角色 ，授权 AliyunOSSFullAccess权限

## 修改相应的KEY及SCRECT，地区ID，Endpoint等参数。
