CREATE TABLE Customers (
  Customer_ID INT AUTO_INCREMENT PRIMARY KEY,
  Cus_Name VARCHAR(255) NOT NULL,
  Password VARCHAR(255) NOT NULL,  
  National VARCHAR(255) NOT NULL,
  Phone INT NOT NULL,
  Date_of_Birth DATE NOT NULL,
  Gender VARCHAR(10) NOT NULL,
  Address VARCHAR(255) NOT NULL,
  Email VARCHAR(255) NOT NULL,
  Profile_pic VARCHAR(255) NOT NULL
);

Create Table Admins (
  Admin_ID INT AUTO_INCREMENT PRIMARY KEY,
  Name VARCHAR(255) NOT NULL,
  Email VARCHAR(255) NOT NULL,
  Password VARCHAR(255) NOT NULL,  
  Phone INT NOT NULL,
  Profile_Pic VARCHAR(255) NOT NULL
);

CREATE TABLE BankAccounts (
  Account_Number INT AUTO_INCREMENT PRIMARY KEY,
  Acc_Name VARCHAR(255) NOT NULL,
  Customer_ID INT NOT NULL,
  Acc_Status VARCHAR(255) NOT NULL,
  Acc_Amount VARCHAR(255) NOT NULL,
  Created_At timestamp,
  Acctype_ID INT,
  FOREIGN KEY (Acctype_ID) REFERENCES Acc_types(Acctype_ID),
  FOREIGN KEY (Customer_ID) REFERENCES Customers(Customer_ID)
);

CREATE TABLE Acc_types (
  Acctype_ID INT AUTO_INCREMENT PRIMARY KEY,
  Name VARCHAR(255) NOT NULL,
  Description text NOT NULL,
  Rate DECIMAL(10, 2) NOT NULL
);

CREATE TABLE Loans (
  Loan_ID INT AUTO_INCREMENT PRIMARY KEY,
  Customer_ID INT NOT NULL,
  Loan_Amount DECIMAL(10, 2) NOT NULL,
  Loan_Term INT NOT NULL,
  Start_Date DATE NOT NULL,
  Status VARCHAR(20) NOT NULL,
  Installment INT,
  FOREIGN KEY Customer_ID REFERENCES Customers(Customer_ID),
);

CREATE TABLE LoanTypes (
  LoanType_ID INT AUTO_INCREMENT PRIMARY KEY,
  Loan_ID INT NOT NULL,
  Name VARCHAR(50) NOT NULL,
  Description VARCHAR(255),
  Rate DECIMAL(4, 2) NOT NULL,
  Installment_Period VARCHAR(10) DEFAULT 'Month',
  FOREIGN KEY Loan_ID REFERENCES Loans(Loan_ID)
);

CREATE TABLE Notifications (
  Notification_ID INT AUTO_INCREMENT PRIMARY KEY,
  Notification_Details TEXT NOT NULL,
  Created_At timestamp
);

CREATE TABLE `Transactions` (
    Transaction_ID INT AUTO_INCREMENT PRIMARY KEY,
    Customer_ID INT NOT NULL,
    Amount DECIMAL(10, 2) NOT NULL,
    Transaction_Type VARCHAR(50) NOT NULL,
    Created_At timestamp, 
    FOREIGN KEY (Customer_ID) REFERENCES Customers(Customer_ID)
);

CREATE TABLE CustomerLoans (
  CustomerLoan_ID INT AUTO_INCREMENT PRIMARY KEY,
  Customer_ID INT,
  Loan_ID INT,
  FOREIGN KEY (Customer_ID) REFERENCES Customers(Customer_ID),
  FOREIGN KEY (Loan_ID) REFERENCES Loans(Loan_ID)
);

CREATE TABLE CustomersNotifications (
    CustomersNotifications INT AUTO_INCREMENT PRIMARY KEY,
    Customer_ID INT NOT NULL,
    Notification_ID INT NOT NULL,
    FOREIGN KEY (Customer_ID) REFERENCES Customers(Customer_ID),
    FOREIGN KEY (Notification_ID) REFERENCES Notifications(Notification_ID)
);
