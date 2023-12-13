INSERT INTO Bank (Address, Branch_City, Branch_Name) 
VALUES 
('123 Main Street, 'Ho Chi Minh', 'Branch A'),
('456 Oak Avenue', 'Ha Noi', 'Branch B'),
('789 Pine Road', 'Da Nang', 'Branch C'),
('101 Maple Lane', 'Tam Ky', 'Branch D'),
('202 Cedar Boulevard', 'Thu Duc', 'Branch E');

INSERT INTO Account (Account_Type, Balance, Opening_Date, Status) 
Values
('Savings', 5000.00, '2022-01-01', 'Approved'),
('Checking', 10000.00, '2022-02-15', 'Pending'),
('Savings', 7500.00, '2022-03-10', 'Approved'),
('Checking', 12000.00, '2022-04-22', 'Rejected'),
('Savings', 9000.00, '2022-05-05', 'Approved'); 

INSERT INTO Admin (Account_ID, Branch_ID, Name)
 VALUES 
(6, 1, 'Admin 1'),
(7, 2, 'Admin 2'),
(8, 3, 'Admin 3'),
(9, 4, 'Admin 4'),
(10, 5, 'Admin 5'); 

INSERT INTO Customer (Account_ID, Name, Address, Date_of_Birth, Gender, Phone, Email) 
VALUES 
(1, 'Trinh Quang Anh', '123 Oak Street', '1990-05-15', 'Male', '1234567890', 'quanganh@gmail.com'),
(2, 'Nguyen Thanh Khiem', '456 Pine Avenue', '1985-08-22', 'Male', '9876543210', 'thanhkhiem@gmail.com'),
(3, 'Nguyen Huu Khanh', '789 Maple Road', '1978-12-10', 'Female', '5551234567', 'huukhanh@gmail.com'),
(4, 'Hoang Cong Anh Khoa', '101 Cedar Lane', '1995-03-27', 'Female', '3339998888', 'anhkhoa@gmail.com'),
(5, 'Ta Thanh Vu', '202 Birch Boulevard', '1980-11-05', 'Male', '7778889999', 'thanhvu@gmail.com');

INSERT INTO Loan (Customer_ID, Admin_ID, Loan_Type, Loan_Amount, Interest_Rate, Term, Status)
VALUES 
(1, 1, 'Home Loan', 50000.00, 4.5, 120, 'Approved'),
(2, 2, 'Auto Loan', 25000.00, 3.8, 60, 'Pending'),
(3, 3, 'Personal Loan', 10000.00, 6.2, 36, 'Approved'),
(4, 4, 'Education Loan', 30000.00, 5.0, 84, 'Rejected'),
(5, 5, 'Business Loan', 75000.00, 4.8, 120, 'Pending');

INSERT INTO Card (Admin_ID, Customer_ID, Card_Type, Status) 
VALUES
(1, 1, 'Credit Card', 'Approved'),
(2, 2, 'Debit Card', 'Approved'),
(3, 3, 'Credit Card', 'Rejected'),
(4, 4, 'Debit Card', 'Pending'),
(5, 5, 'Credit Card', 'Approved');

INSERT INTO Credit (Admin_ID, Customer_ID, Credit_Type, Credit_Amount, Credit_Total, Credit_Desc, Status) 
VALUES 
(1, 1, 'Personal Loan', 10000.00, 12000.00, 'Emergency expense', 'Approved'),
(2, 2, 'Credit Card', 5000.00, 5000.00, 'Shopping spree', 'Pending'),
(3, 3, 'Auto Loan', 20000.00, 20000.00, 'Car purchase', 'Approved'),
(4, 4, 'Home Loan', 80000.00, 80000.00, 'Home mortgage', 'Rejected'),
(5, 5, 'Personal Loan', 15000.00, 15000.00, 'Travel expenses', 'Pending');

INSERT INTO [Transaction] (Customer_ID, Amount, Transaction_Type) 
VALUES
(1, 500.00, 'Purchase'),
(2, 1000.00, 'Withdrawal'),
(3, 200.00, 'Deposit'),
(4, 1500.00, 'Transfer'),
(5, 300.00, 'Withdrawal');

INSERT INTO Deposit (Customer_ID, Deposit_Amount, Interest_Rate, Term) 
VALUES 
(1, 2000.00, 3.5, 12),
(2, 5000.00, 4.0, 24),
(3, 3000.00, 3.8, 18),
(4, 7000.00, 4.2, 36),
(5, 4000.00, 3.7, 24);





