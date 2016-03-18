package com.sethi.data;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.util.ArrayList;

public class DataLoader {
	
	public static String total_org_IDs_Query="select org_ID,count(org_ID) from stock_info_table group by org_ID;"; 
	
	public static String past10DaysData_Query="select open_Value,close_value,stock_Volume from stock_info_past10days_table order by Date desc;"; 

	public static ArrayList<String> open_Value_Array=new ArrayList<String>();
	public static ArrayList<String> close_Value_Array=new ArrayList<String>();
	
	/*
	* Array containing stock_Volume from recent to old dates.
	*/
	public static ArrayList<Integer> stock_Volume_Array=new ArrayList<Integer>();
	
	
	public static Boolean isIncreasingTrend=true;
	
	
	public static void main(String[] args) throws Exception {
	
			System.out.println("inside main");
			getPast10DaysData();
			calculateAverage();
			compareVolume();
			
		}
		
		
	public static void getPast10DaysData() throws Exception{
		
		Connection con=DBConnection.getConnection();
		PreparedStatement ps=con.prepareStatement(past10DaysData_Query);
		ResultSet rs=ps.executeQuery();	
		
		while (rs.next()) {
		    String open_value = rs.getString(1);
		    String close_value=rs.getString(2);
		    String stock_volume=rs.getString(3);
		    open_Value_Array.add(open_value);
		    close_Value_Array.add(close_value);
		    stock_Volume_Array.add(Integer.parseInt(stock_volume));
		   // System.out.println(open_value + " : "+ close_value);
		
		}//end of while loop
		System.out.println("array size :"+open_Value_Array.size());
		System.out.println("array 2 size :"+close_Value_Array.size());
	} // end of function..
	
	
	public static void calculateAverage() throws Exception{
		String average_openValue;
		String average_closeValue;
		Double sum1 = 0.00;
		Double sum2 = 0.00;
		
		for(String openval:open_Value_Array){
			sum1=Double.valueOf(openval)+sum1;
		}
		
		for(String closeval:close_Value_Array){
			sum2=Double.valueOf(closeval)+sum2;
		}
		
/*		
*  If overall openVal are less than overall closeval, that means you are closing on higher values. means Profit..... 		
*  Check sum1 < sum2   --> means profit.
*/		
		System.out.println("open_Value Total is: "+sum1+" close_Value Total is:"+sum2);
	}
	
	
	/*
	* check overall stock_Volume VS Price trend here. If price & Volume both going up MEANS many people putting money into Stock, 
	* Otherwise IF Volume is going up & price is going down MEANS many people taking money out of Stock.
	*/
	
	public static void compareVolume() throws Exception{
		Integer recent , recent1 , recent2 , recent3;
		int counter=0;
		recent=stock_Volume_Array.get(0);
		recent1=stock_Volume_Array.get(1);
		recent2=stock_Volume_Array.get(2);
		recent3=stock_Volume_Array.get(3);
		System.out.println("recent : "+recent+ "recent 1 : "+ recent1 + "recent 2 :"+ recent2 + "recent 3 :"+recent3);
		
		if( recent > recent1) counter++;
		if( recent1>recent2) counter++;
		if(recent2>recent3) counter++;
		if( counter < 2){
			isIncreasingTrend=false;
		}
		counter=0;
		
		/*
		* Comparing each Volume term with its next volume. Check to see if there is an increase in volume trading or not.
		*/
		for(int i=0;i<stock_Volume_Array.size()-1;i++){
			//comparing i'th term with i+1 term here..
			if(stock_Volume_Array.get(i) > stock_Volume_Array.get(i+1)){
				counter++;
			}
		} // end of loop
		if(counter<7) isIncreasingTrend=false;
		
		System.out.println("isIncreasingTrend for volume is : "+isIncreasingTrend);
	}
	
	

	
	
}
