/*
 * Creates a new SpreadUtil object to append a new subscriber to
 *  the newsletter subscriber spreadsheet.
 *  
 *  args[0] = the new subscriber's email
 */

/**
 * @author Taylor Johnson
 *
 */

import java.util.Date;


public class Spreadsheet {

	public static void main(String[] args) {

		SpreadUtil util = new SpreadUtil();
		util.connect();
		util.setMailValue(new Date().toString(), args[0]);
		System.out.println("You are now subcribed!");
	}
}
