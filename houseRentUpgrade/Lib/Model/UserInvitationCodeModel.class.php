<?php  
class UserInvitationCodeModel extends Model{  
  
    //自动验证  
    protected $_validate=array(  
            //每个字段的详细验证内容  
            array("userId","require","用户编号不能为空"), 
            );  
      
    //自动填充  
    protected $_auto=array(  
            array("createTime","dateTime",3,'callback'),  
            array("codeEffectTime","getCodeEffectTime",3,'callback'),  
            );  
    
     //添加激活码
     function genInvitationCode()
     {
     	return md5(''.userId.time());
     }
      
     //当前系统时间
     function dateTime()
     {  
     	return date("Y-m-d H:i:s");  
	 }  
        
     //邀请码有效期截止时间,默认情况是3天
     function getCodeEffectTime($days=3)
     {
     	return date('Y-m-d H:i:s', time()+86400*$days);
     }
     
     //指定用户创建邀请码
     function createInvitationCode($userId)
     {
     	$invitationCode = $this->genInvitationCode();
     	$data = array(
     			'userId'=>$userId,
     			'invitationCode'=>$invitationCode,
     	);
     	if($this->create($data))
     	{
     		if($this->add())
     		{
     			return $invitationCode;	
     		}
     	}
     	return null;
     }
     
     //检测用户的邀请码是否有效
     function checkInvitaionCode($userId,$invitationCode)
     {
     	$date = date('Y-m-d H:i:s');
     	$querySQL = "select id from user_invitaion_code where userId={$userId} and invitationCode='{$invitationCode}' and  codeEffectTime >='{$date}'";
     	$result = $this->query($querySQL);
     	if(sizeof($result)==1)
     	{
     		return true;
     	}
     	return false;
     }
}  