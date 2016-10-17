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
      <td>
          <?=_("公司：")?>
          <select name="USER_DEPT" class="BigSelect">
              <?
              $query = "SELECT DISTINCT(DEPT_NAME), DEPT_NO from department where dept_parent = 0 order by DEPT_NO ASC ";
              $cursor= exequery(TD::conn(),$query);
              while($ROW=mysql_fetch_array($cursor))
              {
                  $DEPT_NAME=$ROW["DEPT_NAME"];
                  ?>
                  <option value="<?=$DEPT_NAME?>" <?if($USER_DEPT==$DEPT_NAME) echo "selected";?>><?=$DEPT_NAME?></option>
                  <?
              }
              ?>
          </select>
      </td>
      <td>
          <?=_("类型：")?>
          <select name="TYPE" class="BigSelect">
              <option value="0" <?if($TYPE=="0") echo "selected";?>><?=_("工作日志")?></option>
              <option value="1" <?if($TYPE=="1") echo "selected";?>><?=_("月工作总结")?></option>
              <option value="2" <?if($TYPE=="2") echo "selected";?>><?=_("季度工作总结")?></option>
              <option value="3" <?if($TYPE=="3") echo "selected";?>><?=_("年度工作总结")?></option>
          </select>
      </td>
      <td>
            <?=_("开始日期：")?><input type="text" name="BEGIN_DATE" size="10" maxlength="10" id="start_time" class="BigInput" value="<?=$BEGIN_DATE?>" onClick="WdatePicker()">
            ~<?=_("结束日期：")?><input type="text" name="END_DATE" size="10" maxlength="10" class="BigInput" value="<?=$END_DATE?>" onClick="WdatePicker({minDate:'#F{$dp.$D(\'start_time\')}'})">
      </td>
      <td ><?=_("人员：")?>
          <input type="text" name="COPY_TO_NAME" size="10" class="BigStatic" readonly value="<?=$COPY_TO_NAME?>">
          <a href="javascript:;" class="orgAdd" onClick="SelectUserSingle('96','','COPY_TO_ID', 'COPY_TO_NAME')"><?=_("添加")?></a>
          <input type="hidden" name="COPY_TO_ID" value="<?=$COPY_TO_ID?>">
      </td>
      <td>
          <input type="submit" value="<?=_("查询")?>" class="BigButton" >
          <input type="button"  value="<?=_("导出")?>" class="BigButton" onClick="exportReport()" title="<?=_("导出统计结果")?>">
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
        <td nowrap align="center" width="20%"><?=_("公司")?></td>
        <td nowrap align="center" width="20%"><?=_("部门")?></td>
        <td nowrap align="center" width="20%"><?=_("工号")?></td>
        <td nowrap align="center" width="20%"><?=_("姓名")?></td>
    </tr>
    <?
    //============================ 显示查询结果 =======================================
    
    if($USER_DEPT != "") {
        $CONDITION_STR_a.="and user_Dept='".$USER_DEPT."' ";
    }
    if($TYPE != "") {
        $CONDITION_STR_a.="and typename='".$TYPE."' ";
		if($TYPE=="0"){$tabeName="td_oa.ud_usernodiary";}
		elseif($TYPE=="1"){$tabeName="td_oa.ud_usernomonthdiary";}
		else{$tabeName="td_oa.ud_usernoquarterdiary";}
    }
    if($BEGIN_DATE != "") {
        $CONDITION_STR_a.="and t_Date>='".$BEGIN_DATE."' ";
    }
    if($END_DATE != "") {
        $CONDITION_STR_a.="and t_Date<='".$END_DATE."' ";
    }
    if($COPY_TO_ID != "") {
        $CONDITION_STR_a.="and USER_ID ='".$COPY_TO_ID."' ";
    }
    if($BEGIN_DATE == "" & $END_DATE == "" & $COPY_TO_ID == "") {
        $CONDITION_STR = " select * from td_oa.ud_usernodiary where 1 > 1 ";
        echo "<font color='red'>&nbsp;&nbsp;请输入查询条件,日期与人员至少输入一项！</font>";
    }
	else
	{$CONDITION_STR = " select * from ".$tabeName." where 1=1 ".$CONDITION_STR_a;}
    $query = $CONDITION_STR." order by t_Date desc, DEPT_ID asc";
    $cursor= exequery(TD::conn(),$query);
    $WORK_PLAN_COUNT=0;
    while($ROW=mysql_fetch_array($cursor))
    {
        $WORK_PLAN_COUNT++;
        $SRL_NO=$WORK_PLAN_COUNT;
        $DATE=$ROW["t_Date"];
        $USER_DEPT=$ROW["user_Dept"];
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
        <td align="center"><?=$USER_DEPT?></td>
        <td align="center"><?=$DEPTNAME?></td>
        <td align="center"><?=$EMPNO?></td>
        <td align="center"><?=$EMPNAME?></td>
    </tr>
<?
    }
?>
</table>
<script>
    function exportReport() {
        if (form1.BEGIN_DATE.value == ""
            && form1.END_DATE.value == ""
            && form1.COPY_TO_ID.value == "") {
            alert("请输入导出条件！");
            return;
        }
        location.href='export.php?BEGIN_DATE_QRY='+form1.BEGIN_DATE.value
            +"&END_DATE_QRY="+form1.END_DATE.value
            +"&COPY_TO_ID_QRY="+form1.COPY_TO_ID.value
            +"&TYPE_QRY="+form1.TYPE.value
            +"&USER_DEPT_QRY="+form1.USER_DEPT.value;
    }

</script>
