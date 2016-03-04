
<?php
   
   $conn = mysqli_connect('localhost','root', '' ,'stock_predictor');
   $URL_historical= "http://ichart.yahoo.com/table.csv?s=";
		//request URL for current information
	$requestURL_current = "http://download.finance.yahoo.com/d/quotes.csv?s=";
		//request URL for decsription
	$requestURL_desc = "https://www.google.com/finance?q=";
//this is for reading the current value
	$URL =$requestURL_current."IBM"."&f=vobaghc1p2l1";
			//get CSV file
			$data=file_get_contents($URL);
			$rows = explode("\n",$data);
			//print_r(array_values($rows));
			$s = array();
			foreach($rows as $row) {
				$s[] = str_getcsv($row);
			}
				//print_r(array_values($s));
	
	foreach( $s as $key){
		$output_array = [];     // This is where your output will be stored.
		foreach ($key as $k => $v){
			array_push($output_array, $v);
		}
	print_r(array_values($output_array));
	$stock_date=date("Y-m-d");
	date_default_timezone_set("America/New_York");
	$stock_time=date("h:i:sa");
	//echo $stock_date;   price-change,percent_change        '$output_array[6]','$output_array[7]'
	$sql = "INSERT INTO stock_current_table (org_ID,current_Value,open_Value,stock_bid,stock_ask,price_change,percent_change,intra_Top,intra_Down,Date,stock_Volume,stock_time) VALUES (1001,'$output_array[8]','$output_array[1]','$output_array[2]','$output_array[3]','$output_array[6]','$output_array[7]','$output_array[5]','$output_array[4]','$stock_date','$output_array[0]','$stock_time' )";
      
	 	mysqli_query($conn ,$sql);
    }
	//closing the connection
	mysqli_close($conn);
	
 ?>