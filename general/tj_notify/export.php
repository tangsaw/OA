<?
include_once("inc/auth.inc.php");
include_once("inc/header.inc.php");
include_once("inc/utility_all.php");
$CUR_DATE=date("Y-m-d",time());

$EXCEL_OUT=array(_("序号"),_("日期"),_("公司"),_("部门"),_("员工工号"),_("员工姓名"));

require_once ('inc/ExcelWriter.php');

$objExcel = new ExcelWriter();
$objExcel->setFileName(_("未提交工作日志统计结果".$CUR_DATE));
$objExcel->addHead($EXCEL_OUT);


if($USER_DEPT_QRY != "") {
    $CONDITION_STR_a.="and user_Dept='".$USER_DEPT_QRY."' ";
}
if($TYPE_QRY != "") {
    $CONDITION_STR_a.="and typename='".$TYPE_QRY."' ";
	if($TYPE_QRY=="0"){$tabeName="td_oa.ud_usernodiary";}
	elseif($TYPE_QRY=="1"){$tabeName="td_oa.ud_usernomonthdiary";}
	else{$tabeName="td_oa.ud_usernoquarterdiary";}
}
if($BEGIN_DATE_QRY != "") {
    $CONDITION_STR_a.="and t_Date>='".$BEGIN_DATE_QRY."' ";
}
if($END_DATE_QRY != "") {
    $CONDITION_STR_a.="and t_Date<='".$END_DATE_QRY."' ";
}
if($COPY_TO_ID_QRY != "") {
    $CONDITION_STR_a.="and USER_ID ='".$COPY_TO_ID_QRY."' ";
}
if($BEGIN_DATE_QRY == "" & $END_DATE_QRY == "" & $COPY_TO_ID_QRY == "") {
    $CONDITION_STR = " select * from td_oa.ud_usernodiary where 1 > 1 ";
    Message("没有输入查询条件，请重新输入！");
    Button_Back();
    exit;
}
else
{
	$CONDITION_STR = " select * from ".$tabeName." where 1=1 ".$CONDITION_STR_a;
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