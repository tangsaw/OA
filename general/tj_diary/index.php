<?
include_once("inc/auth.inc.php");
include_once("inc/utility_all.php");
include_once("inc/utility_file.php");
include_once("inc/utility_org.php");
include_once("inc/header.inc.php");
if($TYPE_NAME=="add")
{
	$user_Id=rtrim($Add_TO_ID, ",");
	if(!empty($user_Id))
	{
		$sql="SELECT * FROM tj_oa.ud_userdiary LEFT JOIN TD_OA.`user` ON TD_OA.`user`.BYNAME = tj_oa.ud_userdiary.BYNAME where TD_OA.`user`.USER_ID in (".$user_Id.") and tj_oa.ud_userdiary.User_Dept='".$Add_USER_DEPT."' and tj_oa.ud_userdiary.typeName=".$Add_TYPE;
		$cursor= exequery(TD::conn(),$sql);
		$result=mysql_num_rows($cursor);
		if($result>0)
		{
			echo "<script>alert('添加的人员中有重复人员，添加没有成功！')</script>";
		}
		else
		{
			$sqladd="INSERT INTO `tj_oa`.`ud_userdiary` (`BYNAME`,`User_Dept`,`isClass`,`typeName`) (select `BYNAME`,'".$Add_USER_DEPT."' as User_Dept,".$Add_CLASS." as isClass,".$Add_TYPE." as typeName  from `user` where USER_ID in (".$user_Id.")) ";
			exequery(TD::conn(),$sqladd);
			echo "<script>alert('添加人员成功！')</script>";
		}
	}
	else
	{
		echo "<script>alert('请选择需添加的人员。')</script>";	
	}

}
if($TYPE_NAME=="del")
{
	$sql = "delete from `tj_oa`.`ud_userdiary` where tj_oa.ud_userdiary.ID=".$USERID;
	exequery(TD::conn(),$sql);
	echo "<script>alert('删除人员成功！')</script>";	
}
?>
<script src="<?=MYOA_JS_SERVER?>/static/js/module.js?v=<?=MYOA_SYS_VERSION?>"></script>
<script src="/module/DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/inc/js_lang.php"></script>
<script type="text/javascript" src="<?=MYOA_JS_SERVER?>/static/js/attach.js"></script>
<br>

<form enctype="multipart/form-data" action="index.php"  method="post" name="form2">
<table border="0" width="95%" align="center" cellspacing="0" cellpadding="3" class="big" >
  <tr>
      <td>
          <?=_("公司：")?>
          <select name="Add_USER_DEPT" class="BigSelect">
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
          <select name="Add_TYPE" class="BigSelect">
              <option value="0" <?if($Add_TYPE=="0") echo "selected";?>><?=_("工作日志")?></option>
              <option value="1" <?if($Add_TYPE=="1") echo "selected";?>><?=_("月工作总结")?></option>
              <option value="2" <?if($Add_TYPE=="2") echo "selected";?>><?=_("季度工作总结")?></option>
              <option value="3" <?if($Add_TYPE=="3") echo "selected";?>><?=_("年度工作总结")?></option>
          </select>
      </td>
      <td>
          <?=_("员工类型：")?>
          <select name="Add_CLASS" class="BigSelect">
              <option value="0" <?if($Add_CLASS=="0") echo "selected";?>><?=_("普通员工")?></option>
              <option value="1" <?if($Add_CLASS=="1") echo "selected";?>><?=_("中层领导")?></option>
              <option value="2" <?if($Add_CLASS=="2") echo "selected";?>><?=_("高层领导")?></option>

          </select>
      </td>
      <td ><?=_("人员：")?>
	  <textarea cols="40" name="Add_TO_NAME" rows="2" class="BigStatic" wrap="yes" readonly=""><?=$Add_TO_NAME?></textarea>
          <a href="javascript:;" class="orgAdd" onClick="SelectUser('96','','Add_TO_ID', 'Add_TO_NAME')"><?=_("添加")?></a>
		  <a href="javascript:;" onClick="ClearUser('Add_TO_ID', 'Add_TO_NAME')">清空</a>
          <input type="hidden" name="Add_TO_ID" value="<?=$Add_TO_ID?>">
		  <input type="hidden" name="TYPE_NAME" value="add">
      </td>
      <td>
          <input type="submit" value="<?=_("添加人员")?>" class="BigButton" >
      </td>
  </tr>
</table>
</form>
<br/><br/>
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
      <td ><?=_("人员：")?>
	  
          <input type="text" name="COPY_TO_NAME" size="10" class="BigStatic" readonly value="<?=$COPY_TO_NAME?>">
          <a href="javascript:;" class="orgAdd" onClick="SelectUserSingle('96','','COPY_TO_ID', 'COPY_TO_NAME')"><?=_("添加")?></a>
          <input type="hidden" name="COPY_TO_ID" value="<?=$COPY_TO_ID?>">
		  <input type="hidden" name="TYPE_NAME" value="view">
      </td>
      <td>
          <input type="submit" value="<?=_("查询")?>" class="BigButton" >
      </td>
  </tr>
</table>
</form>
<br>
<table class="TableList" width="95%" align="center">
    <tr class="TableHeader">
        <td nowrap align="center" width="5%"><?=_("序号")?></td>
        <td nowrap align="center" width="20%"><?=_("公司")?></td>
        <td nowrap align="center" width="20%"><?=_("类型")?></td>
        <td nowrap align="center" width="15%"><?=_("工号")?></td>
        <td nowrap align="center" width="20%"><?=_("姓名")?></td>
		<td nowrap align="center" width="20%"><?=_("操作")?></td>
    </tr>
    <?
    //============================ 显示查询结果 =======================================

	if($USER_DEPT != "") {
		$CONDITION_STR_a.=" where user_Dept='".$USER_DEPT."' ";
	}
	else
	{
		$CONDITION_STR_a.=" where user_Dept='唐锯' ";
	}

	if($TYPE != "") {
		$CONDITION_STR_a.="and typename='".$TYPE."'  ";
	}

    if($COPY_TO_ID != "") {
        $CONDITION_STR_a.="and USER_ID ='".$COPY_TO_ID."'  ";
    }
	$CONDITION_STR = " select * from ud_userdiary ".$CONDITION_STR_a;
    $query = $CONDITION_STR." order by typename desc, DEPT_ID asc";
	#echo $query ;
    $cursor= exequery(TD::conn(),$query);
    $WORK_PLAN_COUNT=0;
    while($ROW=mysql_fetch_array($cursor))
    {
        $WORK_PLAN_COUNT++;
        $SRL_NO=$WORK_PLAN_COUNT;
        $DATE=$ROW["t_Date"];
        $USER_DEPT=$ROW["User_Dept"];
        $typename=$ROW["typename"];
        $EMPNO=$ROW["BYNAME"];
        $EMPNAME=$ROW["USER_NAME"];
		$id=$ROW["ID"];
		
		if($typename==0)
		{$tname="日志";}
		elseif($typename==1)
		{$tname="月度";}
		else
		{$tname="季度";}
	
        if($WORK_PLAN_COUNT%2==1)
          $TableLine="TableLine1";
        else
          $TableLine="TableLine2";

?>
    <tr class="<?=$TableLine?>">
        <td align="center"><?=$id?></td>
		<td align="center"><?=$USER_DEPT?></td>
        <td align="center"><?=$tname?></td>
        <td align="center"><?=$EMPNO?></td>
        <td align="center"><?=$EMPNAME?></td>
        <td align="center"><a href="?TYPE_NAME=del&USERID=<?=$id?>" onclick="javascript:if (confirm('确定删除吗？')) { return true;}else{return false;};" >删除</a></td>
    </tr>
<?
    }
?>
</table>


