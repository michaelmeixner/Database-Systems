import java.sql.*;
public class DBExample {
    public static void main(String[] args) {
        try {
            Class.forName("com.mysql.cj.jdbc.Driver").newInstance();
        } catch(ClassNotFoundException cnfe) {
            System.out.println("No connection to database.");
            System.exit(0);
        } catch(InstantiationException ie) {
        } catch(IllegalAccessException iae) {}
        Connection conn = null;
        try {
            conn = DriverManager.getConnection("jdbc:mysql://192.168.56.101/csci1130?user=webUser&password=SuperSecurePasswordHere");
            System.out.println("Connected to " + conn.getCatalog());
            Statement statement = conn.createStatement();
            ResultSet resultSet = statement.executeQuery("SELECT id, last_name, first_name FROM students");
            while(resultSet.next()) { // .next returns boolean to tell you if you're at after last yet
                int id = resultSet.getInt(1);
                String lastName = resultSet.getString(2);
                String firstName = resultSet.getString(3);
                System.out.println("Student: " + id + " " + firstName + " " + lastName);
            }
            resultSet.close();
            statement.close();

        } catch (SQLException sqle) {
            System.err.println("SQLException: " + sqle.getMessage());
            System.err.println("SQLState: " + sqle.getSQLState());
            System.err.println("VendorError: " + sqle.getErrorCode());
        } finally {
            try {
                conn.close();
            } catch(Exception e) {}
        }
    }
}