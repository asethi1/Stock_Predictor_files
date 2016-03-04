
<?php
   
   $conn = mysqli_connect('localhost','root', '' ,'stock_predictor');
   $URL_historical= "http://ichart.yahoo.com/table.csv?s=";
		
	
	$startDate=date("Y/m/d");
	$startDate_ = explode("/", $startDate);
	//parse end date
	$endDate=$startDate_[0]-1;
	$startDate_[2]=$startDate_[2]-1;
	
	$URL2=$URL_historical."BAC"."&a="."0".$startDate_[2]."&b=".$startDate_[1]."&c=".$endDate."&d="."0".$startDate_[2]."&e=".$startDate_[1]."&f=".$startDate_[0];
	
	// getting file from 
    $data=file_get_contents($URL2);
			
	$rows = explode("\n",$data);
			
	$s = array();
	foreach($rows as $row) {
				$s[] = str_getcsv($row);
		}
			
	$i=0;
		
	foreach( $s as $key)
    {
		// inserting only 100 values ... make it for 1 year that is 365
		if($i==366)
			{
				break;
			}
	// ignore the first line of CSV as that is giving field names
		if($i==0)
			{
				$i++;
				continue;
			}
		$output_array = [];     // This is where your output will be stored.
		foreach ($key as $k => $v){
			array_push($output_array, $v);
		}
		if($output_array[0]=="0000-00-00")
		{
		break;
		}
		$i++;   // incrementing i
	//SQL query
	$sql = "INSERT INTO stock_info_table (org_ID,open_Value,close_Value,intra_Top,intra_Down,Date,stock_Volume ) VALUES (1005,'$output_array[1]','$output_array[4]','$output_array[2]','$output_array[3]','$output_array[0]','$output_array[5]' )";
      
	 mysqli_query($conn ,$sql);
    }
	//closing the connection
	mysqli_close($conn);
 ?>