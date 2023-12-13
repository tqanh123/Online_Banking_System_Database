Create Table Bank (
    Branch_ID INT AUTO_INCREMENT PRIMARY KEY,
    Address Varchar(255),
    Branch_City VARCHAR(50),
    Branch_Name VARCHAR(255)
);

Create Table `Admin` (
    Admin_ID INT AUTO_INCREMENT PRIMARY KEY,
    Branch_ID INT,
    Name Varchar(255),
    FOREIGN KEY (Branch_ID) REFERENCES Bank(Branch_ID)
);

CREATE TABLE Customer (
    Customer_ID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255),
    Address VARCHAR(255),
    Date_of_Birth DATE,
    Gender VARCHAR(10),
    Phone VARCHAR(15),
    Email VARCHAR(255)
);

CREATE TABLE Loan (
    Loan_ID INT AUTO_INCREMENT PRIMARY KEY,
    Customer_ID INT,
    Admin_ID INT,
    Loan_Type VARCHAR(50),
    Loan_Amount DECIMAL(10, 2),
    Interest_Rate DECIMAL(5, 2),
    Term INT,
    Status VARCHAR(255),
    FOREIGN KEY (Admin_ID) REFERENCES Admin(Admin_ID),
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID)
);

CREATE TABLE Card (
    Card_ID INT AUTO_INCREMENT PRIMARY KEY,
    Admin_ID INT,
    Customer_ID INT,
    Card_Type VARCHAR(50),
    Status VARCHAR(255),
    FOREIGN KEY (Admin_ID) REFERENCES Admin(Admin_ID),
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID) 
);

CREATE TABLE Account (
    Account_ID INT AUTO_INCREMENT PRIMARY KEY,
    Admin_ID INT,
    Account_Type VARCHAR(50),
    Balance DECIMAL(10, 2),
    Opening_Date DATE,
    Customer_ID INT,
    Status VARCHAR(255),
    FOREIGN KEY (Admin_ID) REFERENCES Admin(Admin_ID),
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID)
); 

CREATE TABLE Credit (
    Credit_ID INT AUTO_INCREMENT PRIMARY KEY,
    Admin_ID INT,
    Customer_ID INT,
    Credit_Type VARCHAR(50),
    Credit_Amount DECIMAL(10, 2),
    Credit_Total DECIMAL(10, 2),
    Credit_Desc VARCHAR(255),
    Status VARCHAR(255),
    FOREIGN KEY (Admin_ID) REFERENCES Admin(Admin_ID),
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID)
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
