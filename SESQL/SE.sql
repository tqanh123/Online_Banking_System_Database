CREATE TABLE Acc_types (
  Acctype_ID INT AUTO_INCREMENT PRIMARY KEY,
  Account_Number INT NOT NULL,
  Name VARCHAR(255) NOT NULL,
  Description long text NOT NULL,
  Rate DECIMAL(10, 2) NOT NULL,
  FOREIGN KEY (Account_Number) REFERENCES BankAccounts(Account_Number)
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
  Profile_pic VARCHAR(255) NOT NULL
);

Create Table Admins (
  Admin_ID INT AUTO_INCREMENT PRIMARY KEY,
  Name VARCHAR(255) NOT NULL,
  Email VARCHAR(255) NOT NULL,
  Phone INT NOT NULL,
  Profile_Pic VARCHAR(255) NOT NULL
);

CREATE TABLE BankAccounts (
  Account_Number INT AUTO_INCREMENT PRIMARY KEY,
  Customer_ID INT NOT NULL,
  Acc_Status VARCHAR(255) NOT NULL,
  Acc_Amount VARCHAR(255) NOT NULL,
  Password VARCHAR(255) NOT NULL,  
  Customer_ID INT NOT NULL,
  Created_At timestamp(6),
  FOREIGN KEY (Customer_ID) REFERENCES Customers(Customer_ID)
)

CREATE TABLE Notifications (
  Notification_ID INT AUTO_INCREMENT NOT NULL,
  Notification_Details TEXT NOT NULL,
  Created_At timestamp(6)
)

CREATE TABLE Card (
    Card_ID INT AUTO_INCREMENT PRIMARY KEY,
    Card_Type VARCHAR(50),
    Status VARCHAR(255)
);

CREATE TABLE `Transaction` (
    Transaction_ID INT AUTO_INCREMENT PRIMARY KEY,
    Customer_ID INT NOT NULL,
    Amount DECIMAL(10, 2) NOT NULL,
    Transaction_Type VARCHAR(50) NOT NULL,
    FOREIGN KEY (Customer_ID) REFERENCES Customers(Customer_ID)
);

CREATE TABLE CustomersCard (
    Customer_ID INT NOT NULL,
    Card_ID INT NOT NULL,
    PRIMARY KEY (Customer_ID, Card_ID),
    FOREIGN KEY (Customer_ID) REFERENCES Customers(Customer_ID),
    FOREIGN KEY (Card_ID) REFERENCES Card(Card_ID)
);

CREATE TABLE CustomersNotifications (
    Customer_ID INT NOT NULL,
    Notification_ID INT NOT NULL,
    PRIMARY KEY (Customer_ID, Notification_ID),
    FOREIGN KEY (Customer_ID) REFERENCES Customers(Customer_ID),
    FOREIGN KEY (Notification_ID) REFERENCES Notifications(Notification_ID)
);
