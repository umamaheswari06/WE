 
import java.sql.*;

public class Ex8 {
    public static void main(String[] args) {

        String jdbcURL = "jdbc:mysql://localhost:3306/bank";
        String dbUser = "root";
        String dbPassword = "";

        try {
            // Load MySQL JDBC Driver
            Class.forName("com.mysql.cj.jdbc.Driver");

            // Try-with-resources → automatically closes connection, statement, resultset
            try (
                Connection connection = DriverManager.getConnection(jdbcURL, dbUser, dbPassword);
                Statement statement = connection.createStatement();
                ResultSet result = statement.executeQuery("SELECT * FROM transactions");
            ) {
                while (result.next()) {
                    System.out.println(
                        result.getInt(1) + "  " +
                        result.getString(2) + "  " +
                        result.getDouble(3)
                    );
                }
            }

        } catch (ClassNotFoundException e) {
            System.out.println("ERROR: MySQL Driver not found!");
        } catch (SQLException e) {
            System.out.println("SQL ERROR: " + e.getMessage());
        }
    }
}
