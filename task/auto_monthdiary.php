<?
include_once("inc/utility_all.php");
include_once("inc/utility_file.php");
include_once("inc/utility_org.php");
$datetime=date("Ymd",strtotime("-1 day"));
$typeName=1;//�¶��ܽ�

if(date('d')==11)
{
	is_insertnotify();
	echo "�¶ȼƻ�ִ�����";
}


function is_nodiary(){
	global $typeName;
    $dt=date("Y-m-d",strtotime("-1 day"));
    $strTemp="";
    $sqlstr="SELECT * FROM ud_usernodiary Where  date_format(t_date,'%Y-%m')='".date('Y-m')."' and typeName=".$typeName." order by t_Date desc, DEPT_ID";
    $cursor= exequery(TD::conn(),$sqlstr);
    if(!empty($cursor)){
        $strTemp.="<p style=\"text-align: center;\">";
        $strTemp.="    <span style=\"font-size: 18px;\"><strong>".$dt." δ�ύ�¶��ܽ���Ա����</strong></span><br/>";
        $strTemp.="</p>";
        $strTemp.="<p>";
        $strTemp.="    <strong><br/></strong>";
        $strTemp.="</p>";
        $strTemp.="<table class=\"TableList\" width=\"95%\" align=\"center\" border=\"1\" style=\"border: 1px solid rgb(128, 128, 128);\">";
        $strTemp.="    <tbody>";
        $strTemp.="        <tr class=\"TableHeader firstRow\" style=\"color: rgb(56, 56, 56); font-weight: bold; font-size: 9pt; line-height: 40px; border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: rgb(221, 221, 221); background: rgb(255, 255, 255);\">";
        $strTemp.="            <td nowrap=\"\" align=\"center\" style=\"margin: 0px; padding: 0px; text-align: center; border-color: rgb(221, 221, 221); background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\" height=\"40\">";
        $strTemp.="                <span style=\"font-size: 16px;\">���</span>";
        $strTemp.="            </td>";
        $strTemp.="            <td nowrap=\"\" align=\"center\" style=\"margin: 0px; padding: 0px; text-align: center; border-color: rgb(221, 221, 221); background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\" height=\"40\">";
        $strTemp.="                <span style=\"font-size: 16px;\">����</span>";
        $strTemp.="            </td>";
        $strTemp.="            <td nowrap=\"\" align=\"center\" style=\"margin: 0px; padding: 0px; text-align: center; border-color: rgb(221, 221, 221); background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\" height=\"40\">";
        $strTemp.="                <span style=\"font-size: 16px;\">��˾</span>";
        $strTemp.="            </td>";
        $strTemp.="            <td nowrap=\"\" align=\"center\" style=\"margin: 0px; padding: 0px; text-align: center; border-color: rgb(221, 221, 221); background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\" height=\"40\">";
        $strTemp.="                <span style=\"font-size: 16px;\">����</span>";
        $strTemp.="            </td>";
        $strTemp.="            <td nowrap=\"\" align=\"center\" style=\"margin: 0px; padding: 0px; text-align: center; border-color: rgb(221, 221, 221); background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\" height=\"40\">";
        $strTemp.="                <span style=\"font-size: 16px;\">����</span>";
        $strTemp.="            </td>";
        $strTemp.="            <td nowrap=\"\" align=\"center\" style=\"margin: 0px; padding: 0px; text-align: center; border-color: rgb(221, 221, 221); background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;\" height=\"40\">";
        $strTemp.="                <span style=\"font-size: 16px;\">����</span>";
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
            $strTemp.="                <span style=\"font-size: 16px;\">".date('%y-%m',$t_Date)."</span>";
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
        $strTemp.="    <span style=\"font-size: 18px;\"><strong>δ�ύ�¶��ܽ���Ա</strong></span><br/>";
        $strTemp.="</p>";
	}
    return $strTemp;
}
function is_insertnotify()
{
	global $typeName;
    $dt=date("Y-m-d",strtotime("-1 day"));
	$sqlstr="INSERT INTO tj_oa.ud_usernodiary (tj_oa.ud_usernodiary.BYNAME,tj_oa.ud_usernodiary.T_Date,tj_oa.ud_usernodiary.AddDate,tj_oa.ud_usernodiary.typeName) (SELECT ud_usermonthdiary.USER_ID as BYNAME,'".$dt."' as t_date,now() AS AddDate,ud_usermonthdiary.typeName FROM ud_usermonthdiary where ud_usermonthdiary.t_date is null)";
	exequery(TD::conn(),$sqlstr);
	
    $nodiarycontent=mysql_real_escape_string(is_nodiary());
    $sqlstr="INSERT INTO notify(FROM_DEPT,FROM_ID,TO_ID,`SUBJECT`,SEND_TIME,BEGIN_DATE,ATTACHMENT_ID,ATTACHMENT_NAME,READERS,PRINT,PRIV_ID,USER_ID,TYPE_ID,TOP,TOP_DAYS,FORMAT,PUBLISH,AUDITER,SUBJECT_COLOR,DOWNLOAD,CONTENT,SUMMARY) VALUES (1,'admin','1,2,3,4,5,6,7,8,9,10,14,12,13,11,49,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,','".$dt." δ�ύ�¶��ܽ���Ա����',now(),(SELECT UNIX_TIMESTAMP('".$dt."')),'','','','1','','','05','0','0','0',1,'admin','','1','".$nodiarycontent."','".$dt."�գ�����û��д��־������������д��')";
    exequery(TD::conn(),$sqlstr);
	
	#$sqlstr="INSERT INTO sms_body(sms_body.FROM_ID,sms_body.SMS_TYPE,sms_body.CONTENT,sms_body.SEND_TIME,sms_body.REMIND_URL) VALUES ('admin','1',CONCAT('��鿴����֪ͨ�����⣺',(date_sub(curdate(),interval 1 day)),'������û��д��־������������д��'),(SELECT UNIX_TIMESTAMP(curdate())),CONCAT('1:notify/show/read_notify.php?NOTIFY_ID=',(select max(NOTIFY_ID) FROM notify)))";
	#exequery(TD::conn(),$sqlstr);
	
	#$sqlstr="INSERT INTO sms(sms.TO_ID,sms.REMIND_FLAG,sms.DELETE_FLAG,sms.BODY_ID,sms.REMIND_TIME,sms.MODULE_TYPE,sms.MODULE_ID) (SELECT ud_userdiary.USER_ID as TO_ID,'1' as REMIND_FLAG,'0' as DELETE_FLAG,(select max(sms_body.BODY_ID) FROM sms_body) as BODY_ID,(SELECT UNIX_TIMESTAMP(curdate())) AS REMIND_TIME,'1' AS MODULE_TYPE, (select max(NOTIFY_ID) FROM notify) AS MODULE_ID FROM ud_userdiary )";
	#exequery(TD::conn(),$sqlstr);

}


?>