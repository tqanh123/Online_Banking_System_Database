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

CREATE TABLE Notifications (
  Notification_id INT AUTO_INCREMENT NOT NULL,
  Notification_details TEXT NOT NULL,
  Created_At timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
)

CREATE TABLE Card (
    Card_ID INT AUTO_INCREMENT PRIMARY KEY,
    Admin_ID INT,
    Card_Type VARCHAR(50),
    Status VARCHAR(255),
    FOREIGN KEY (Admin_ID) REFERENCES Admin(Admin_ID),
);

CREATE TABLE `Transaction` (
    Transaction_ID INT AUTO_INCREMENT PRIMARY KEY,
    Customer_ID INT NOT NULL,
    Amount DECIMAL(10, 2) NOT NULL,
    Transaction_Type VARCHAR(50) NOT NULL,
    FOREIGN KEY (Customer_ID) REFERENCES Customers(Customer_ID)
);



