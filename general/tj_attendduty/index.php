<?
include_once("inc/auth.inc.php");
include_once("inc/utility_all.php");
include_once("inc/utility_file.php");
include_once("inc/utility_org.php");
include_once("inc/header.inc.php");
if($COPY_TO_NAME=="")
{
	$COPY_TO_NAME=$_SESSION["LOGIN_USER_NAME"];
}
if($BEGIN_DATE=="")
{
	$BEGIN_DATE=date("Y-m-d",strtotime("-1 day"));
}
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
            <?=_("查询日期：")?><input type="text" name="BEGIN_DATE" size="10" maxlength="10" id="start_time" class="BigInput" value="<?=$BEGIN_DATE?>" onClick="WdatePicker()">
      </td>
      <td ><?=_("人员：")?>
          <input type="text" name="COPY_TO_NAME" size="10" class="BigStatic" readonly value="<?=$COPY_TO_NAME?>">
          <!--a href="javascript:;" class="orgAdd" onClick="SelectUserSingle('96','','COPY_TO_ID', 'COPY_TO_NAME')"><?=_("添加")?></a-->
          <input type="hidden" name="COPY_TO_ID" value="<?=$COPY_TO_ID?>">
      </td>
      <td>
          <input type="submit" value="<?=_("查询")?>" class="BigButton" >
      </td>
  </tr>
</table>
</form>
<br>
<br>
<table class="TableList" width="95%" align="center">
    <tr class="TableHeader">
        <td nowrap align="center" width="5%"><?=_("序号")?></td>
        <td nowrap align="center" width="15%"><?=_("工号")?></td>
        <td nowrap align="center" width="20%"><?=_("姓名")?></td>
        <td nowrap align="center" ><?=_("打卡时间")?></td>

    </tr>
    <?
	$dt=date("Y-m-d",strtotime("-1 day"));
    if($BEGIN_DATE != "") {
        $CONDITION_STR="where CONVERT(varchar(12),f_ReadDate,23 )='".$BEGIN_DATE."' ";
    }
	else
	{
		$CONDITION_STR="where CONVERT(varchar(12),f_ReadDate,23 )='".$dt."' ";
	}
	if($COPY_TO_NAME != "") {
        $CONDITION_STR.=" and f_ConsumerName ='".$COPY_TO_NAME."' ";
    }
	else
	{
		$CONDITION_STR.=" and f_ConsumerName ='".$_SESSION["LOGIN_USER_NAME"]."' ";
	}
	$Server= "192.168.0.97";   
	$conInfo=array( "UID"=>"tjerp", "PWD"=>"tjerp", "Database"=>"AccessData");  
	$link=sqlsrv_connect($Server,$conInfo); 
	if($link){   
	$sql = "SELECT [f_RecID],[f_ConsumerName],[f_ConsumerNO],[f_CardNO],CONVERT(varchar(20),f_ReadDate, 120 ) as f_ReadDate  FROM [AccessData].[dbo].[oa_new] ".$CONDITION_STR."  order by f_RecID desc" ;  
	#echo $sql;
	$stmt = sqlsrv_query( $link, $sql );
    //============================ 显示查询结果 =======================================
    
	
    $WORK_PLAN_COUNT=0;
    while($ROW = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) 
    {
        $WORK_PLAN_COUNT++;
        if($WORK_PLAN_COUNT%2==1)
          $TableLine="TableLine1";
        else
          $TableLine="TableLine2";
?>
    <tr class="<?=$TableLine?>">
        <td align="center"><?=$WORK_PLAN_COUNT?></td>
        <td align="center"><?=$ROW["f_ConsumerNO"]?></td>
        <td align="center"><?=$ROW["f_ConsumerName"]?></td>
        <td align="center"><?=$ROW["f_ReadDate"]?></td>

    </tr>
<?
    }
	    sqlsrv_free_stmt( $stmt);  
        sqlsrv_close( $conn ); 
}
?>
</table>

