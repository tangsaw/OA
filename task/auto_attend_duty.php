<?php  
include_once( "inc/td_core.php" );
include_once( "inc/conn.php" );
include_once( "inc/utility.php" );
include_once( "inc/utility_all.php" ); 

$sqlstr="SELECT tj_oa.ud_attendduty.id,tj_oa.ud_attendduty.maxID,tj_oa.ud_attendduty.addTime FROM tj_oa.ud_attendduty order by tj_oa.ud_attendduty.id desc LIMIT 1";  
$cursor= exequery(TD::conn(),$sqlstr);
$ROW=mysql_fetch_array($cursor);
$lastMaxid=$ROW['maxID']; 

$i=0; 
$Server= "192.168.0.97";   
$conInfo=array( "UID"=>"tjerp", "PWD"=>"tjerp", "Database"=>"AccessData");  
$link=sqlsrv_connect($Server,$conInfo); 
if($link){    
	$sql = 'select * from oa_new where f_RecID>'.$lastMaxid;  
	$stmt = sqlsrv_query( $link, $sql );
	if( $stmt === false )    
    {    
        sqlsrv_close( $conn );    
        die( 'empty');    
    }    
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC))  
    { 
		$n=trimall($row['f_ConsumerNO']);
		$sqluser="select USER_ID from `user` where BYNAME='".$n."'";
		$cursor = exequery(TD::conn(),$sqluser);
		if (!($ROW_User = mysql_fetch_array( $cursor )))
		{
			$USER_ID=$ROW_User['USER_ID'];
			#$query = "insert into ATTEND_DUTY(USER_ID,REGISTER_TYPE,REGISTER_TIME,IS_MOBILE_DUTY) values (".$USER_ID.",'1',".$row['f_ReadDate'].",0)";
			echo $sqluser."<br />";
			#exequery(TD::conn(),$query);
                 $i++;	
		}
            
    }  
    sqlsrv_free_stmt( $stmt);  
    sqlsrv_close( $conn ); 
}
echo "成功更新".($i)."条记录！";


function trimall($str){
    $qian=array(" ","　","\t","\n","\r");
    return str_replace($qian, '', $str);   
}
?>  