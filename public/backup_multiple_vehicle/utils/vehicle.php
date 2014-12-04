<?php  
include_once("../config/config.php");
include_once("../config/functions.php");
include_once("../config/tables.php");
include_once("../classes/dbFactory.php");
if(isset($_REQUEST['vehicle_id']) && !empty($_REQUEST['vehicle_id']))
{
	$vehicle_id = $_REQUEST['vehicle_id'];
	
	$vno = $_REQUEST['vno'];
	
	$rs=mysql_query("select * from ".VMODEL." where make_id='".$vehicle_id."' and status ='1' ");

	$make='';
	if(mysql_num_rows($rs) > 0)
	{
		$make.= '<select id="vehicle_model'.$vno.'" name="vehicle_model" class="dropdown" onchange="getVehicleType(this.value,'.$vno.');"><option value="">-Select-</option>';
		while($row = mysql_fetch_array($rs)):
		$make.= '<option value="'.$row['id'].'">'.$row['model'].'</option>';
		endwhile;
		$make.="</select>";
		if($make <> '')
		{
			echo $make;	
		}
	}
	else{
		echo 0;
	}
}
if(isset($_REQUEST['vehicle_modelid']) && !empty($_REQUEST['vehicle_modelid']))
{
	$vehiclemodel_id = $_REQUEST['vehicle_modelid'];
	
	$vno = $_REQUEST['vno'];
	
	$rs=mysql_query("select * from ".VTYPE." where model_id='".$vehiclemodel_id."' and status ='1' ");

	$type='';
	if(mysql_num_rows($rs) > 0)
	{
		$type.= '<select id="vehicle_type'.$vno.'" name="vehicle_type" class="dropdown"><option value="">Select</option>';
		while($row = mysql_fetch_array($rs)):
			$type.= '<option value="'.$row['id'].'">'.$row['type_name'].'</option>';
		endwhile;
		$type.="</select>";
		if($type <> '')
		{
			echo $type;	
		}
	}
	else{
		echo 0;
	}
}

?>