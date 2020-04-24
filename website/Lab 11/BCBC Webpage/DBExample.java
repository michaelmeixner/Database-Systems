import java.sql.*;

public class DBExample {
    public static final void main(String[] args) {
        try {
            Class.forName("com.mysql.cj.jdbc.Driver").newInstance();
        } catch (ClassNotFoundException cnfe) {
            System.out.println("The class com.mysql.cj.jdbc.Driver could not be found.");
            System.exit(0);
        } catch (InstantiationException ie) {
        } catch (IllegalAccessException iae) {

        }

        // connect to database
        Connection conn = null;
        try {
            conn = DriverManager.getConnection(
                    "jdbc:mysql://bcbcdb.c9z8jd1ll1pz.us-east-2.rds.amazonaws.com/innodb?user=admin&password=x-s!d-v0te-x&serverTimezone=UTC");
            System.out.println("Connected to " + conn.getCatalog());

            Statement statement = conn.createStatement();
            ResultSet resultSet = statement.executeQuery("SELECT * FROM Users");
            while (resultSet.next()) {
                int userID = resultSet.getInt(1);
                String emailAddress = resultSet.getString(2);
                String fullName = resultSet.getString(6);
                System.out.println(userID + " " + emailAddress + " " + fullName);
            }

        } catch (SQLException sqle) {
            System.out.println("SQLException: " + sqle.getMessage());
            System.out.println("SQLState: " + sqle.getSQLState());
            System.out.println("VendorError: " + sqle.getErrorCode());
        } finally {
            try {
                conn.close();
            } catch (Exception e) {
            }
        }
    }
}