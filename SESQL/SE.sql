Create Table Bank (
    Branch_ID INT AUTO_INCREMENT PRIMARY KEY,
    Address Varchar(255) NOT NULL,
    Branch_City VARCHAR(255) NOT NULL,
    Branch_Name VARCHAR(255) NOT NULL
);

CREATE TABLE Acc_types (
  Acctype_ID INT AUTO_INCREMENT PRIMARY KEY,
  Account_Number INT NOT NULL,
  Name VARCHAR(255) NOT NULL,
  Description long text NOT NULL,
  Rate DECIMAL(10, 2) NOT NULL,
  FOREIGN KEY (Account_Number) REFERENCES BankAccounts(Account_Number)
)

CREATE TABLE BankAccounts (
  Account_Number INT AUTO_INCREMENT PRIMARY KEY,
  Customer_ID INT NOT NULL,
  Admin_ID INT NOT NULL,
  Acc_Name VARCHAR(255) NOT NULL,
  Acc_Status VARCHAR(255) NOT NULL,
  Acc_Amount VARCHAR(255) NOT NULL,
  Password VARCHAR(255) NOT NULL,  
  Customer_ID INT NOT NULL,
  Created_At timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  FOREIGN KEY (Customer_ID) REFERENCES Customers(Customer_ID)
  FOREIGN KEY (Admin_ID) REFERENCES Admins(Admin_ID)
)

CREATE TABLE Customers (
  Customer_ID INT AUTO_INCREMENT PRIMARY KEY,
  Cus_Name VARCHAR(255) NOT NULL,
  National VARCHAR(255) NOT NULL,
  Phone INT NOT NULL,
  Date_of_Birth DATE NOT NULL,
  Gender VARCHAR(10) NOT NULL,
  Address VARCHAR(255) NOT NULL,
  Email VARCHAR(255) NOT NULL,
  Profile_pic VARCHAR(255) NOT NULL,
)  

Create Table Admins (
  Admin_ID INT AUTO_INCREMENT PRIMARY KEY,
  Branch_ID INT NOT NULL,
  Name VARCHAR(255) NOT NULL,
  Email VARCHAR(255) NOT NULL,
  Phone INT NOT NULL,
  Profile_Pic VARCHAR(255) NOT NULL
  FOREIGN KEY (Branch_ID) REFERENCES Bank(Branch_ID),
);

CREATE TABLE Loan (
    Loan_ID INT AUTO_INCREMENT PRIMARY KEY,
    Admin_ID INT,
    Loan_Type VARCHAR(50),
    Loan_Amount DECIMAL(10, 2),
    Interest_Rate DECIMAL(5, 2),
    Term INT,
    Status VARCHAR(255),
    FOREIGN KEY (Admin_ID) REFERENCES Admin(Admin_ID),
);

CREATE TABLE Card (
    Card_ID INT AUTO_INCREMENT PRIMARY KEY,
    Admin_ID INT,
    Card_Type VARCHAR(50),
    Status VARCHAR(255),
    FOREIGN KEY (Admin_ID) REFERENCES Admin(Admin_ID),
);

CREATE TABLE Credit (
    Credit_ID INT AUTO_INCREMENT PRIMARY KEY,
    Admin_ID INT,
    Credit_Type VARCHAR(50),
    Credit_Amount DECIMAL(10, 2),
    Credit_Total DECIMAL(10, 2),
    Credit_Desc VARCHAR(255),
    Status VARCHAR(255),
    FOREIGN KEY (Admin_ID) REFERENCES Admin(Admin_ID),
);

CREATE TABLE `Transaction` (
    Transaction_ID INT AUTO_INCREMENT PRIMARY KEY,
    Customer_ID INT,
    Amount DECIMAL(10, 2),
    Transaction_Type VARCHAR(50),
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID)
);

CREATE TABLE Deposit (
    Deposit_ID INT AUTO_INCREMENT PRIMARY KEY,
    Customer_ID INT,
    Deposit_Amount DECIMAL(10, 2),
    Interest_Rate DECIMAL(5, 2),
    Term INT,
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID)
);

CREATE TABLE CustomerLoan (
    Customer_ID INT,
    Loan_ID INT,
    PRIMARY KEY (Customer_ID, Loan_ID),
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID),
    FOREIGN KEY (Loan_ID) REFERENCES Loan(Loan_ID)
);

CREATE TABLE CustomerCard (
    Customer_ID INT,
    Card_ID INT,
    PRIMARY KEY (Customer_ID, Card_ID),
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID),
    FOREIGN KEY (Card_ID) REFERENCES Card(Card_ID)
);

CREATE TABLE CustomerCredit (
    Customer_ID INT,
    Credit_ID INT,
    PRIMARY KEY (Customer_ID, Credit_ID),
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID),
    FOREIGN KEY (Credit_ID) REFERENCES Credit(Credit_ID)
);

