<?
include_once("inc/auth.inc.php");
include_once("inc/header.inc.php");
include_once("inc/utility_all.php");
$CUR_DATE=date("Y-m-d",time());

$EXCEL_OUT=array(_("���"),_("����"),_("��˾"),_("����"),_("Ա������"),_("Ա������"));

require_once ('inc/ExcelWriter.php');

$objExcel = new ExcelWriter();
$objExcel->setFileName(_("δ�ύ������־ͳ�ƽ��".$CUR_DATE));
$objExcel->addHead($EXCEL_OUT);


$CONDITION_STR = " select * from td_oa.ud_usernodiary where 1=1 ";
if($USER_DEPT_QRY != "") {
    $CONDITION_STR.="and user_Dept='".$USER_DEPT_QRY."' ";
}
if($TYPE_QRY != "") {
    //$CONDITION_STR.="and type='".$TYPE_QRY."' ";
}
if($BEGIN_DATE_QRY != "") {
    $CONDITION_STR.="and t_Date>='".$BEGIN_DATE_QRY."' ";
}
if($END_DATE_QRY != "") {
    $CONDITION_STR.="and t_Date<='".$END_DATE_QRY."' ";
}
if($COPY_TO_ID_QRY != "") {
    $CONDITION_STR.="and USER_ID ='".$COPY_TO_ID_QRY."' ";
}
if($BEGIN_DATE_QRY == "" & $END_DATE_QRY == "" & $COPY_TO_ID_QRY == "") {
    $CONDITION_STR = " select * from td_oa.ud_usernodiary where 1 > 1 ";
    Message("û�������ѯ���������������룡");
    Button_Back();
    exit;
}
$query = $CONDITION_STR." order by t_Date desc, DEPT_ID asc";
$cursor = exequery(TD::conn(),$query);
$WORK_PLAN_COUNT=0;
while($ROW=mysql_fetch_array($cursor))
{
    $WORK_PLAN_COUNT++;
    $SRL_NO=$WORK_PLAN_COUNT;
    $DATE=$ROW["t_Date"];
    $COMPANY=$ROW["user_Dept"];
    $DEPTNAME=$ROW["DEPT_NAME"];
    $EMPNO=$ROW["BYNAME"];
    $EMPNAME=$ROW["USER_NAME"];

    
   $EXCEL_OUT="$SRL_NO,$DATE,$COMPANY,$DEPTNAME,$EMPNO,$EMPNAME";
   $objExcel->addRow($EXCEL_OUT);
}

$objExcel->Save();
?>