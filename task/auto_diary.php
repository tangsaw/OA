<?
include_once("inc/utility_all.php");
include_once("inc/utility_file.php");
include_once("inc/utility_org.php");
$datetime=date("Ymd",strtotime("-1 day"));
if(is_holiday($datetime)==0) {
    is_insertnotify();

}elseif(is_holiday($datetime)==1){
    echo '休息日';
}


//返回 0 工作日 1 休息日 2 节假日
function is_holiday($datetime){

    $ch = curl_init();
    $url = 'http://apis.baidu.com/xiaogg/holiday/holiday?d='.$datetime;
    $header = array(
        'apikey:10bd2a414d2ba1052f37c7fd2a1aafad',
    );
    // 添加apikey到header
    curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // 执行HTTP请求
    curl_setopt($ch , CURLOPT_URL , $url);
    $res = curl_exec($ch);
    $res = json_decode($res['body'],true);
	return $res;
     
}
function is_nodiary(){
    $dt=date("Y-m-d",strtotime("-1 day"));
    $strTemp="";
    $sqlstr="SELECT * FROM ud_usernodiary Where t_date='".$dt."' order by t_Date desc, DEPT_ID desc";
    $cursor= exequery(TD::conn(),$sqlstr);
    $result=mysql_fetch_array($cursor);
    if(!empty($result)){
        $strTemp.="<p style=\"text-align: center;\">";
        $strTemp.="    <span style=\"font-size: 18px;\"><strong>".$dt." 未提交工作日志人员名单</strong></span><br/>";
        $strTemp.="</p>";
        $strTemp.="<p>";
        $strTemp.="    <strong><br/></strong>";
        $strTemp.="</p>";
        $strTemp.="<table class=\"TableList\" width=\"95%\" align=\"center\" border=\"1\" style=\"border: 1px solid rgb(128, 128, 128);\">";
        $strTemp.="    <tbody>";
        $strTemp.="        <tr class=\"TableHeader firstRow\" style=\"color: rgb(56, 56, 56); font-weight: bold; font-size: 9pt; line-height: 40px; border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: rgb(221, 221, 221); background: rgb(255, 255, 255);\">";
        $strTemp.="            <td nowrap=\"\" align=\"center\" style=\"margin: 0px; padding: 0px; text-align: center; border-color: rgb(221, 221, 221); background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\" height=\"40\">";
        $strTemp.="                <span style=\"font-size: 16px;\">序号</span>";
        $strTemp.="            </td>";
        $strTemp.="            <td nowrap=\"\" align=\"center\" style=\"margin: 0px; padding: 0px; text-align: center; border-color: rgb(221, 221, 221); background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\" height=\"40\">";
        $strTemp.="                <span style=\"font-size: 16px;\">日期</span>";
        $strTemp.="            </td>";
        $strTemp.="            <td nowrap=\"\" align=\"center\" style=\"margin: 0px; padding: 0px; text-align: center; border-color: rgb(221, 221, 221); background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\" height=\"40\">";
        $strTemp.="                <span style=\"font-size: 16px;\">公司</span>";
        $strTemp.="            </td>";
        $strTemp.="            <td nowrap=\"\" align=\"center\" style=\"margin: 0px; padding: 0px; text-align: center; border-color: rgb(221, 221, 221); background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\" height=\"40\">";
        $strTemp.="                <span style=\"font-size: 16px;\">部门</span>";
        $strTemp.="            </td>";
        $strTemp.="            <td nowrap=\"\" align=\"center\" style=\"margin: 0px; padding: 0px; text-align: center; border-color: rgb(221, 221, 221); background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\" height=\"40\">";
        $strTemp.="                <span style=\"font-size: 16px;\">工号</span>";
        $strTemp.="            </td>";
        $strTemp.="            <td nowrap=\"\" align=\"center\" style=\"margin: 0px; padding: 0px; text-align: center; border-color: rgb(221, 221, 221); background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\" height=\"40\">";
        $strTemp.="                <span style=\"font-size: 16px;\">姓名</span>";
        $strTemp.="            </td>";
        $strTemp.="        </tr>";
        $i=0;
        while($ROW=mysql_fetch_array($cursor)){
            $i=$i+1;
			if($i%2==0){$ta="TableLine1";}else{$ta="TableLine2";}
            $t_Date=$ROW["t_Date"];
            $user_Dept=$ROW["user_Dept"];
            $strTemp.="        <tr class=\"".$ta."\" style=\"color: rgb(56, 56, 56);\">";
            $strTemp.="            <td nowrap=\"\" align=\"center\" style=\"margin: 0px; padding: 3px; border-bottom-width: 1px; border-bottom-style: solid;\" height=\"30\">";
            $strTemp.="                <span style=\"font-size: 16px;\">".$i."</span>";
            $strTemp.="            </td>";
            $strTemp.="            <td nowrap=\"\" align=\"center\" style=\"margin: 0px; padding: 3px; border-bottom-width: 1px; border-bottom-style: solid;\" height=\"30\">";
            $strTemp.="                <span style=\"font-size: 16px;\">".$t_Date."</span>";
            $strTemp.="            </td>";
			$strTemp.="            <td nowrap=\"\" align=\"center\" style=\"margin: 0px; padding: 3px; border-bottom-width: 1px; border-bottom-style: solid;\" height=\"30\">";
            $strTemp.="                <span style=\"font-size: 16px;\">".$user_Dept."</span>";
            $strTemp.="            </td>";
            $strTemp.="            <td nowrap=\"\" align=\"center\" style=\"margin: 0px; padding: 3px; border-bottom-width: 1px; border-bottom-style: solid;\" height=\"30\">";
            $strTemp.="                <span style=\"font-size: 16px;\">".$ROW["DEPT_NAME"]."</span>";
            $strTemp.="            </td>";
            $strTemp.="            <td nowrap=\"\" align=\"center\" style=\"margin: 0px; padding: 3px; border-bottom-width: 1px; border-bottom-style: solid;\" height=\"30\">";
            $strTemp.="                <span style=\"font-size: 16px;\">".$ROW["BYNAME"]."</span>";
            $strTemp.="            </td>";
            $strTemp.="            <td nowrap=\"\" align=\"center\" style=\"margin: 0px; padding: 3px; border-bottom-width: 1px; border-bottom-style: solid;\" height=\"30\">";
            $strTemp.="                <span style=\"font-size: 16px;\">".$ROW["USER_NAME"]."</span>";
            $strTemp.="            </td>";
            $strTemp.="        </tr>";

        }
        $strTemp.="    </tbody>";
        $strTemp.="</table>";
    }
	else
	{
	    $strTemp.="<p style=\"text-align: center;\">";
        $strTemp.="    <span style=\"font-size: 18px;\"><strong>无未提交工作日志人员</strong></span><br/>";
        $strTemp.="</p>";
	}
    return $strTemp;
}
function is_insertnotify()
{
    $dt=date("Y-m-d",strtotime("-1 day"));
	$sqlstr="INSERT INTO tj_oa.ud_usernodiary (tj_oa.ud_usernodiary.BYNAME,tj_oa.ud_usernodiary.T_Date,tj_oa.ud_usernodiary.AddDate) (SELECT ud_userdiary.USER_ID as BYNAME,'".$dt."' as t_date,now() AS AddDate FROM ud_userdiary where ud_userdiary.t_date is null)";
	exequery(TD::conn(),$sqlstr);
	
    $nodiarycontent=mysql_real_escape_string(is_nodiary());
    $sqlstr="INSERT INTO notify(FROM_DEPT,FROM_ID,TO_ID,`SUBJECT`,SEND_TIME,BEGIN_DATE,ATTACHMENT_ID,ATTACHMENT_NAME,READERS,PRINT,PRIV_ID,USER_ID,TYPE_ID,TOP,TOP_DAYS,FORMAT,PUBLISH,AUDITER,SUBJECT_COLOR,DOWNLOAD,CONTENT,SUMMARY) VALUES (1,'admin','1,2,3,4,5,6,7,8,9,10,14,12,13,11,49,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,','".$dt." 未提交工作日志人员名单',now(),(SELECT UNIX_TIMESTAMP('".$dt."')),'','','','1','','','05','0','0','0',1,'admin','','1','".$nodiarycontent."','".$dt."日，您还没有写日志，请您尽快填写。')";
    exequery(TD::conn(),$sqlstr);
	
	#$sqlstr="INSERT INTO sms_body(sms_body.FROM_ID,sms_body.SMS_TYPE,sms_body.CONTENT,sms_body.SEND_TIME,sms_body.REMIND_URL) VALUES ('admin','1',CONCAT('请查看公告通知！标题：',(date_sub(curdate(),interval 1 day)),'，您还没有写日志，请您尽快填写。'),(SELECT UNIX_TIMESTAMP(curdate())),CONCAT('1:notify/show/read_notify.php?NOTIFY_ID=',(select max(NOTIFY_ID) FROM notify)))";
	#exequery(TD::conn(),$sqlstr);
	
	#$sqlstr="INSERT INTO sms(sms.TO_ID,sms.REMIND_FLAG,sms.DELETE_FLAG,sms.BODY_ID,sms.REMIND_TIME,sms.MODULE_TYPE,sms.MODULE_ID) (SELECT ud_userdiary.USER_ID as TO_ID,'1' as REMIND_FLAG,'0' as DELETE_FLAG,(select max(sms_body.BODY_ID) FROM sms_body) as BODY_ID,(SELECT UNIX_TIMESTAMP(curdate())) AS REMIND_TIME,'1' AS MODULE_TYPE, (select max(NOTIFY_ID) FROM notify) AS MODULE_ID FROM ud_userdiary )";
	#exequery(TD::conn(),$sqlstr);

}


?>