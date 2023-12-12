Create Table Bank (
    Branch_ID INT IDENTITY (1,1) PRIMARY KEY,
    Address Varchar(255),
    Branch_City VARCHAR(50),
    Branch_Name VARCHAR(255),
);

Create Table Admin (
    Admin_ID INT IDENTITY (1,1) PRIMARY KEY,
    Account_ID INT,
    Branch_ID INT,
    Name Varchar(255),
    FOREIGN KEY (Branch_ID) REFERENCES Bank(Branch_ID),
    FOREIGN KEY (Account_ID) REFERENCES Account(Account_ID),
);

CREATE TABLE Customer (
    Customer_ID INT IDENTITY(1,1) PRIMARY KEY,
    Account_ID INT,
    Name VARCHAR(255),
    Address VARCHAR(255),
    Date_of_Birth DATE,
    Gender VARCHAR(10),
    Phone VARCHAR(15),
    Email VARCHAR(255),
    FOREIGN KEY (Account_ID) REFERENCES Account(Account_ID),
);

CREATE TABLE Loan (
    Loan_ID INT IDENTITY (1,1) PRIMARY KEY,
    Customer_ID INT,
    Admin_ID INT,
    Loan_Type VARCHAR(50),
    Loan_Amount DECIMAL(10, 2),
    Interest_Rate DECIMAL(5, 2),
    Term INT,
    Status VARCHAR(255),
    FOREIGN KEY (Admin_ID) REFERENCES Admin(Admin_ID),
);

CREATE TABLE Card (
    Card_ID INT IDENTITY (1,1) PRIMARY KEY,
    Admin_ID INT,
    Customer_ID INT,
    Card_Type VARCHAR(50),
    Status VARCHAR(255),
    FOREIGN KEY (Admin_ID) REFERENCES Admin(Admin_ID),
);

CREATE TABLE Account (
    Account_ID INT IDENTITY (1,1) PRIMARY KEY,
    Account_Type VARCHAR(50),
    Balance DECIMAL(10, 2),
    Opening_Date DATE,
    Status VARCHAR(255),
); 

CREATE TABLE Credit (
    Credit_ID INT IDENTITY(1,1) PRIMARY KEY,
    Admin_ID INT,
    Customer_ID INT,
    Credit_Type VARCHAR(50),
    Credit_Amount DECIMAL(10, 2),
    Credit_Total DECIMAL(10, 2),
    Credit_Desc VARCHAR(255),
    Status VARCHAR(255),
    FOREIGN KEY (Admin_ID) REFERENCES Admin(Admin_ID),
);

CREATE TABLE [Transaction] (
    Transaction_ID INT IDENTITY(1,1) PRIMARY KEY,
    Customer_ID INT,
    Amount DECIMAL(10, 2),
    Transaction_Type VARCHAR(50),
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID),
);

CREATE TABLE Deposit (
    Deposit_ID INT IDENTITY(1,1) PRIMARY KEY,
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

