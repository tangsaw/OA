<?
include_once("inc/auth.inc.php");
include_once("inc/utility_all.php");
include_once("inc/utility_file.php");
include_once("inc/utility_org.php");
include_once("inc/header.inc.php");
?>
<script src="<?=MYOA_JS_SERVER?>/static/js/module.js?v=<?=MYOA_SYS_VERSION?>"></script>
<script src="/module/DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/inc/js_lang.php"></script>
<script type="text/javascript" src="<?=MYOA_JS_SERVER?>/static/js/attach.js"></script>
<br>
<br>
<form enctype="multipart/form-data" action="index.php"  method="post" name="form1">
<table border="0" width="95%" align="center" cellspacing="0" cellpadding="3" class="big" >
  <tr>
      <td nowrap class="TableData" widht="20%" nowrap>  <?=_("开始日期：")?><input type="text" name="BEGIN_DATE" size="10" maxlength="10" id="start_time" class="BigInput" value="<?=$BEGIN_DATE?>" onClick="WdatePicker()"></td>
      <td class="TableData" widht="20%" nowrap><?=_("结束日期：")?><input type="text" name="END_DATE" size="10" maxlength="10" class="BigInput" value="<?=$END_DATE?>" onClick="WdatePicker({minDate:'#F{$dp.$D(\'start_time\')}'})"></td>
      <td nowrap class="TableData" widht="20%" nowrap><?=_("人员：")?>
          <input type="hidden" name="COPY_TO_ID" value="<?=$COPY_TO_ID?>">
          <input type="text" name="COPY_TO_NAME" size="20" class="BigStatic" readonly value="<?=$COPY_TO_NAME?>">
          <a href="javascript:;" class="orgAdd" onClick="SelectUserSingle('96','','COPY_TO_ID', 'COPY_TO_NAME')"><?=_("添加")?></a>
      </td>
      <td nowrap>
          <input type="submit" value="<?=_("查询")?>" class="BigButton" align="left">
      </td>
  </tr>
</table>
</form>
<br>
<br>
<table class="TableList" width="95%" align="center">
    <tr class="TableHeader">
        <td nowrap align="center" width="5%"><?=_("序号")?></td>
        <td nowrap align="center" width="15%"><?=_("日期")?></td>
        <td nowrap align="center" width="30%"><?=_("部门")?></td>
        <td nowrap align="center" width="25%"><?=_("工号")?></td>
        <td nowrap align="center" width="25%"><?=_("姓名")?></td>
    </tr>
    <?
    //============================ 显示查询结果 =======================================
    $CONDITION_STR = " select * from td_oa.ud_usernodiary where 1=1 ";
    if($BEGIN_DATE != "") {
        $CONDITION_STR.="and ADDDATE>='".$BEGIN_DATE."' ";
    }
    if($END_DATE != "") {
        $CONDITION_STR.="and ADDDATE<='".$END_DATE."' ";
    }
    if($COPY_TO_ID != "") {
        $CONDITION_STR.="and USER_ID ='".$COPY_TO_ID."' ";
    }
    if($BEGIN_DATE == "" & $END_DATE == "" & $COPY_TO_ID == "") {
        $CONDITION_STR = " select * from td_oa.ud_usernodiary where 1 > 1 ";
    }
    $query = $CONDITION_STR." order by t_Date desc, DEPT_ID desc";
    $cursor= exequery(TD::conn(),$query);
    $WORK_PLAN_COUNT=0;
    while($ROW=mysql_fetch_array($cursor))
    {
        $WORK_PLAN_COUNT++;
        $SRL_NO=$WORK_PLAN_COUNT;
        $DATE=$ROW["t_Date"];
        $DEPTNAME=$ROW["DEPT_NAME"];
        $EMPNO=$ROW["BYNAME"];
        $EMPNAME=$ROW["USER_NAME"];

        if($WORK_PLAN_COUNT%2==1)
          $TableLine="TableLine1";
        else
          $TableLine="TableLine2";

?>
    <tr class="<?=$TableLine?>">
        <td align="center"><?=$SRL_NO?></td>
        <td align="center"><?=$DATE?></td>
        <td align="center"><?=$DEPTNAME?></td>
        <td align="center"><?=$EMPNO?></td>
        <td align="center"><?=$EMPNAME?></td>
    </tr>
<?
    }
?>
</table>
