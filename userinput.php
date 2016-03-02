
<?php
   
   $conn = mysqli_connect('localhost','root', '' ,'stock_predictor');
   $URL_historical= "http://ichart.yahoo.com/table.csv?s=";
		//request URL for current information
	$requestURL_current = "http://download.finance.yahoo.com/d/quotes.csv?s=";
		//request URL for decsription
	$requestURL_desc = "https://www.google.com/finance?q=";
	/*this is for reading the current value
	$URL =$requestURL_current."IBM"."&f=snl1x";
			//get CSV file
			$data=file_get_contents($URL);
			$rows = explode("\n",$data);
			print_r(array_values($rows));
			$s = array();
			foreach($rows as $row) {
				$s[] = str_getcsv($row);
				print_r(array_values($s));
			}*/
	// 		
	
	$startDate=2015;
	$startDate_ = explode("/", $startDate);
	//parse end date
	$endDate=2016;
	$endDate_ = explode("/", $endDate);
	// we have to use ticker instead of IBM
	$URL2=$URL_historical."IBM"."&c=".$startDate_[0];
	
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
		
		$i++;   // incrementing i
	//SQL query
	$sql = "INSERT INTO stock_info_table (org_ID,open_Value,close_Value,intra_Top,intra_Down,Date,stock_Volume ) VALUES (1111,'$output_array[1]','$output_array[4]','$output_array[2]','$output_array[3]','$output_array[0]','$output_array[5]' )";
      
	 mysqli_query($conn ,$sql);
    }
	//closing the connection
	mysqli_close($conn);
 ?>