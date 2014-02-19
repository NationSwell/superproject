import java.io.IOException;
import com.google.gdata.client.spreadsheet.CellQuery;
import com.google.gdata.client.spreadsheet.FeedURLFactory;
import com.google.gdata.client.spreadsheet.SpreadsheetService;
import com.google.gdata.data.spreadsheet.CellEntry;
import com.google.gdata.data.spreadsheet.CellFeed;
import com.google.gdata.data.spreadsheet.SpreadsheetEntry;
import com.google.gdata.data.spreadsheet.SpreadsheetFeed;
import com.google.gdata.data.spreadsheet.WorksheetEntry;
import com.google.gdata.util.AuthenticationException;
import com.google.gdata.util.ServiceException;

public class SpreadUtil{
  private static final FeedURLFactory urlFactory = FeedURLFactory.getDefault();

  private SpreadsheetService service;


  // ==========================================================================
  // CONNECT to Google Spreadsheet API

  /** Opens a connection to Google spreadsheet API. */
  public void connect() {
    SpreadsheetService newService = new SpreadsheetService("Mailfeed test");
    // Google account login and passwords to access your spreadsheet.
    // Password is in plain text. For sure there are better ways to do that
    // so the passwords does not have to be in the code, but the simplest.
    String email = "EMAIL";
    String password = "PASSWORD";
    try {
      newService.setUserCredentials(email, password);
    } catch (AuthenticationException e) {
      throw new RuntimeException("Cannot authenticate, invalid user/password", e);
    }
    this.service = newService;
  }


  // ==========================================================================
  // iterate Mail Data

  /**
   * Iterates through the cell feed to find the last row and returns it.
   */
  private int iterateMailData() {
    CellFeed cellFeed = getCellFeed();
    int rowIndex=0;
    for (CellEntry entry : cellFeed.getEntries()) {
      rowIndex++;
    }
    return rowIndex;
  }


  // ==========================================================================
  // Set Mail Value

  /**
   * Finds the last row (extend the sheet if it's too short) and inserts the timestamp in
   * column 1 with the new subscriber's email address in column 2.
   * @param date timestamp
   * @param email email address of the new subscriber 
   */
  public void setMailValue(String date, String email) {
    int row = iterateMailData();
	extendSheetIfTooShort(row);
    CellFeed cellFeed = getCellFeedForUpdate(row, row, 1, 2);
    updateCell(cellFeed.getEntries().get(0), date);
    updateCell(cellFeed.getEntries().get(1), email);
  }


  // ==========================================================================
  // Access a worksheet in CELL mode

  /**
   * Returns CellFeed connected to predefined, existing spreadsheet and a
   * sheet inside it.
   * Provided CellFeed will include only non empty cells.
   * This method is convenient for reading, but not always so good for updating
   * (you do not see all cells).
   */
  private CellFeed getCellFeed() {
    try {
      return service.getFeed(findWorksheet().getCellFeedUrl(), CellFeed.class);
    } catch (ServiceException e) {
      throw new RuntimeException("Service error when loading data", e);
    } catch (IOException e) {
      throw new RuntimeException("Connection with server broken", e);
    }
  }

  /**
   * Returns CellFeed for update connected to predefined, existing spreadsheet
   * and a sheet inside it.
   * Provided CellFeed will include all existing cells within given row and
   * column range. Note that sheet can be smaller than specified ranges, then
   * provided CellFeed will only include ranges up to the sheet size.
   * This method is convenient for updating, but not always so good for reading
   * (you can have a lot of empty cells).
   * @param minRow Min row number (inclusive) - 1,2,...
   * @param maxRow Max row number (inclusive) - 1,2,...
   * @param minCol Min column number (inclusive) - 1,2,...
   * @param maxCol Max column number (inclusive) - 1,2,...
   */
  private CellFeed getCellFeedForUpdate(int minRow, int maxRow, int minCol, int maxCol) {
    CellQuery cellQuery;
    try {
      cellQuery = new CellQuery(findWorksheet().getCellFeedUrl());
      cellQuery.setMinimumCol(minCol);
      cellQuery.setMaximumCol(maxCol);
      cellQuery.setMinimumRow(minRow);
      cellQuery.setMaximumRow(maxRow);
      cellQuery.setReturnEmpty(true);
      return service.query(cellQuery, CellFeed.class);
    } catch (ServiceException e) {
      throw new RuntimeException("Service error when getting data to edit", e);
    } catch (IOException e) {
      throw new RuntimeException("Connection with server broken", e);
    }
  }

  private WorksheetEntry findWorksheet() throws IOException, ServiceException {
    // Spreadsheet KEY is an unique identifier of a spreadsheet document.
    // The KEY is part of spreadsheet document URL. To find it, just open the
    // spreadsheet document in your browser and take the 'key' param value.
    // For example:
    // URL=https://docs.google.com/spreadsheet/ccc?key=0AuhY-asdcrtr123bc#gid=1
    //    => KEY=0AuhY-asdcrtr123bc
    //       (the real keys are usually much longer)
    //
    // Other approach to find spreadsheetKey could be to list all spreadsheets
    // documents that belong the user and the select one by name. It would require
    // more code and in particular one more call to API. Then it would stop working
    // as soon as you name another spreadsheet documents with the same name.
    // Thus, I think it is not worth the effort.
    //
    String spreadsheetKey = "0AjO8DBcXuoKUdE5sR3JRR0l5UkR3bER2OGdXb2ZOdHc";

    // Worksheet name is the name of a sheet inside the spreadsheet document.
    // It is a name given by the user as seen in the spreadsheet. In particular
    // it does not have to be unique, but this is the simplest way I found to
    // identify a sheet.
    // Note that this work only if your worksheet has unique name (within
    // the spreadsheet document, not globally).
    //
    // Other approach to find a worksheet is to use worksheet position (1,2, ...)
    // but I find it less convenient.
    //
    String worksheetName = "Form Responses";

    SpreadsheetFeed feed = service.getFeed(
        urlFactory.getSpreadsheetsFeedUrl(),
        SpreadsheetFeed.class);
    for (SpreadsheetEntry se : feed.getEntries()) {
      if (se.getSpreadsheetLink().getHref().endsWith(spreadsheetKey)) {
        for (WorksheetEntry we : se.getWorksheets()) {
          if (we.getTitle().getPlainText().equalsIgnoreCase(worksheetName)) {
            return we;
          }
        }
      } 
    }
    throw new RuntimeException("Cannot find worksheet=" + worksheetName);
  }

  /** Adds more rows to the sheet if it is too short. */
  private void extendSheetIfTooShort(int minRows) {
    try {
      WorksheetEntry ws = findWorksheet();
      if (ws.getRowCount() < minRows) {
        ws.setRowCount(minRows);
        ws.getRowCount();
        ws.update();
      }
    } catch (ServiceException e) {
      throw new RuntimeException("Service error when extending worksheet", e);
    } catch (IOException e) {
      throw new RuntimeException("Connection error when extending worksheet", e);
    }
  }

  /** Updates cell value. */
  private void updateCell(CellEntry entry, String newValue) {
    entry.changeInputValueLocal(newValue);
    try {
      // Commit changes - send changes to Google spreadsheet API
      entry.update();
    } catch (ServiceException e) {
      throw new RuntimeException("Service error when updating data", e);
    } catch (IOException e) {
      throw new RuntimeException("Connection error when updating data", e);
    }
  }
}
