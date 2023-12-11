Create Table Bank (
    Code INT PRIMARY KEY,
    Address Varchar(255),
);

CREATE TABLE Branch (
    Branch_no INT PRIMARY KEY,
    Code INT,
    Branch_City VARCHAR(50),
    Branch_Name VARCHAR(255),
    FOREIGN KEY (Code) REFERENCES Bank(Code),  
);

Create Table Admin (
    Admin_ID INT IDENTITY (1,1) PRIMARY KEY,
    Name Varchar(255),
    Branch_no INT,
    FOREIGN KEY (Branch_no) REFERENCES Branch(Branch_no)
);

CREATE TABLE Loan (
    Loan_ID INT IDENTITY (1,1) PRIMARY KEY,
    Admin_ID INT,
    Loan_Type VARCHAR(50),
    Loan_Amount DECIMAL(10, 2),
    Interest_Rate DECIMAL(5, 2),
    Term INT,
    Status VARCHAR(255),
    FOREIGN KEY (Admin_ID) REFERENCES Admin(Admin_ID)
);

CREATE TABLE Card (
    Card_ID INT IDENTITY (1,1) PRIMARY KEY,
    Admin_ID INT,
    Card_Type VARCHAR(50),
    Address VARCHAR(255),
    Status VARCHAR(255),
    FOREIGN KEY (Admin_ID) REFERENCES Admin(Admin_ID)
);

CREATE TABLE Account (
    Account_ID INT IDENTITY (1,1) PRIMARY KEY,
    Admin_ID INT,
    Account_Type VARCHAR(50),
    Balance DECIMAL(10, 2),
    Opening_Date DATE,
    Customer_ID INT,
    Status VARCHAR(255),
    FOREIGN KEY (Admin_ID) REFERENCES Admin(Admin_ID),
); 

CREATE TABLE Credit (
    Credit_ID INT IDENTITY(1,1) PRIMARY KEY,
    Admin_ID INT,
    Credit_Type VARCHAR(50),
    Credit_Amount DECIMAL(10, 2),
    Credit_Total DECIMAL(10, 2),
    Credit_Desc VARCHAR(255),
    Status VARCHAR(255),
    FOREIGN KEY (Admin_ID) REFERENCES Admin(Admin_ID)
);


CREATE TABLE Customer (
    Customer_ID INT IDENTITY(1,1) PRIMARY KEY,
    Card_ID INT,
    Loan_ID INT,
    Credit_ID INT,
    Account_ID INT,
    Name VARCHAR(255),
    Branch_Name VARCHAR(255),
    Address VARCHAR(255),
    Date_of_Birth DATE,
    Gender VARCHAR(10),
    Phone VARCHAR(15),
    Email VARCHAR(255),
    FOREIGN KEY (Card_ID) REFERENCES Card(Card_ID),
    FOREIGN KEY (Loan_ID) REFERENCES Loan(Loan_ID),
    FOREIGN KEY (Credit_ID) REFERENCES Credit(Credit_ID),
    FOREIGN KEY (Account_ID) REFERENCES Account(Account_ID),
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
