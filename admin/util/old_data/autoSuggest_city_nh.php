<?php
include("../../config/config.php");

if($_POST['tid'] != "")
{
    // retrive data
	$sq = "SELECT * FROM master_city WHERE country_id = '73' AND city_name LIKE '".$_POST['tid']."%' ORDER BY city_name DESC";
	
	$res = mysql_query($sq);
	if(mysql_num_rows($res) > 0)
	{
		while($res_us = mysql_fetch_assoc($res))
		{
			if($res_us['city_name'] != ""){
			$cityname = stripslashes($res_us['city_name']);
			}
			$result .= "<div style='cursor:pointer;background-color: #F2F2F2;margin:2px;'><span onmousedown='selectDiv1(this.innerHTML,".$res_us['city_id'].")'>".$cityname."</span></div>";
		}
		echo $result;
	}
	else
	{
		echo "<span style='text-align: center;'><i>No Result</i></span>";
	}
}
?>
