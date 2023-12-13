Create Table Bank (
    Branch_ID INT(20) AUTO_INCREMENT PRIMARY KEY,
    Address Varchar(255) NOT NULL,
    Branch_City VARCHAR(50) NOT NULL,
    Branch_Name VARCHAR(255) NOT NULL
);

CREATE TABLE Acc_types (
  Acctype_ID INT(20) AUTO_INCREMENT PRIMARY KEY,
  Account_Number INT(20) NOT NULL,
  Name VARCHAR(50) NOT NULL,
  Description long text NOT NULL,
  Rate Decimal(10, 2) NOT NULL,
  FOREIGN KEY (Account_Number) REFERENCES BankAccounts(Account_Number)
)

CREATE TABLE BankAccounts (
  Account_Number INT(20) AUTO_INCREMENT PRIMARY KEY,
  Acc_Name VARCHAR(50) NOT NULL,
  Acc_Status VARCHAR(200) NOT NULL,
  Acc_Amount VARCHAR(200) NOT NULL,
  Customer_ID INT(20) NOT NULL,
  Created_At timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  FOREIGN KEY (Customer_ID) REFERENCES Customers(Customer_ID)
)

CREATE TABLE Customers (
  Customer_ID INT(2O) AUTO_INCREMENT PRIMARY KEY,
  Cus_Name VARCHAR(200) NOT NULL,
  National VARCHAR(200) NOT NULL,
  Phone INT(15) NOT NULL,
  Date_of_Birth DATE NOT NULL,
  Gender VARCHAR(10) NOT NULL,
  Address VARCHAR(200) NOT NULL,
  Email VARCHAR(200) NOT NULL,
  Password VARCHAR(200) NOT NULL,
  Profile_pic VARCHAR(200) NOT NULL,
)  

Create Table Admin (
    Admin_ID INT IDENTITY (1,1) PRIMARY KEY,
    Account_ID INT,
    Branch_ID INT,
    Name Varchar(255),
    FOREIGN KEY (Branch_ID) REFERENCES Bank(Branch_ID),
    FOREIGN KEY (Account_ID) REFERENCES Account(Account_ID),
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

