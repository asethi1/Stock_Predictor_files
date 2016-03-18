package com.sethi.data;

import java.sql.Connection;
import java.sql.DriverManager;

public class DBConnection  {
	
	public static Connection getConnection() throws Exception{
		Class.forName("com.mysql.jdbc.Driver");
		Connection con=DriverManager.getConnection("jdbc:mysql://localhost:3306/stock_predictor","root","root");
		return con;
	}

}
