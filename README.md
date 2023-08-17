# Invoice Management Web Application

This is a web application developed in PHP using the VS Code IDE. The purpose of this application is to allow users to manage and interact with invoices retrieved from a MySQL database using PDO. The application provides various functionalities for browsing, filtering, creating, editing, deleting, and viewing invoices.

## Features

1. **Browse Invoice List:**
   - Users can view a list of invoices retrieved from the MySQL database.
   
2. **Filter by Status:**
   - Users can filter the invoice list based on the invoice status (e.g., draft, pending, paid).
   
3. **Create New Invoice:**
   - Users can create a new invoice by providing the necessary information.
   - Input data is sanitized and validated to ensure data integrity.
   
4. **Edit Invoice:**
   - Users can edit an existing invoice's details, such as updating the invoice amount or status.
   
5. **Delete Invoice:**
   - Users have the option to delete an existing invoice from the system.
   
6. **View Invoice:**
   - Users can view the details of an invoice only if the invoice file was uploaded.
   
## Technologies Used

- **Programming Language:** PHP
- **IDE:** Visual Studio Code
- **Database:** MySQL
- **Database Access:** PDO (PHP Data Objects)
- **Data Validation:** Input data is sanitized and validated to prevent malicious input.

## Installation and Setup

1. Clone or download the repository to your local machine.
   
2. Set up a MySQL database and import the necessary tables using the sql file included.

3. Update the database connection settings within the data.php in the application to match your MySQL configuration.

4. Launch the application using a local development server such as Laragon.



