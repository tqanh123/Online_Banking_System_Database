INSERT INTO Customer (Name, Branch_Name, Address, Date_of_Birth, Gender, Phone, Email)
VALUES
('Thanh Khiem', 'Main Branch', '123 Le Loi, Da Nang', '2003-11-14', 'Male', '123-456-7890', 'thanhkhiem@gmail.com'),
('Quang Anh', 'South Branch', '456 Pham Van Dong, Ho Chi Minh', '2003-08-22', 'Female', '987-654-3210', 'quanganh@gmail.com'),
('Huu Khanh', 'North Branch', '789 Ho Xuan Huong, Ha Noi', '2003-04-05', 'Male', '555-123-4567', 'huukhanh@gmail.com'),
('Anh Khoa', 'East Branch', '12 Ly Thuong Kiet, Da Lat', '2003-11-30', 'Female', '333-888-9999', 'anhkhoa@gmail.com'),
('Minh Tri', 'West Branch', '555 Hung Vuong, Cao Bang', '2003-07-10', 'Male', '777-444-2222', 'minhtri@gmail.com');

INSERT INTO Account (Account_Number, Account_Type, Balance, Opening_Date, Customer_ID)
VALUES
(1, 'Savings', 5000.00, '2023-01-15', 1),
(2, 'Checking', 2500.50, '2023-05-20', 2),
(3, 'Savings', 10000.75, '2023-03-10', 3),
(4, 'Checking', 750.25, '2023-11-30', 4),
(5, 'Savings', 12000.00, '2023-07-05', 5);

INSERT INTO Credit (Credit_Type, Credit_Amount, Credit_Total, Credit_Desc, Account_Number)
VALUES
('Credit Card', 1500.00, 1500.00, 'Initial Credit Card Limit', 1),
('Loan', 10000.00, 10000.00, 'Home Improvement Loan', 2),
('Credit Card', 500.00, 500.00, 'Additional Credit Card Limit', 3),
('Loan', 8000.00, 8000.00, 'Car Loan', 4),
('Credit Card', 2000.00, 2000.00, 'Special Promotion Limit Increase', 5);

INSERT INTO Card (Card_Number, Card_Type, Address, Account_Number)
VALUES
('1234567890123456', 'Debit', '456 Tan Lap, Da Nang', 1),
('9876543210987654', 'Credit', '789 Song Hanh, Ho Chi Minh', 2),
('5555222233334444', 'Debit', '321 Tran Phu, Ha Noi', 3),
('1111222233334444', 'Credit', '654 Nguyen Hue, Da Lat', 4),
('7777666655554444', 'Debit', '888 Phan Chau Trinh, Cao Bang', 5);

INSERT INTO Debit (Debit_Type, Total_Amount, Debit_Total, Debit_Desc, Account_Number)
VALUES
('Withdrawal', 100.00, 100.00, 'ATM Withdrawal', 1),
('Purchase', 50.25, 50.25, 'Online Shopping', 2),
('Withdrawal', 200.50, 200.50, 'Branch Withdrawal', 3),
('Purchase', 75.75, 75.75, 'Grocery Shopping', 4),
('Withdrawal', 30.00, 30.00, 'ATM Withdrawal', 5);

INSERT INTO Branch (Branch_Code, Branch_City, Branch_Name, Account_Number)
VALUES
(101, 'Cityville', 'Main Branch', 1),
(102, 'Townsville', 'South Branch', 2),
(103, 'Villagetown', 'North Branch', 3),
(104, 'Hamletville', 'East Branch', 4),
(105, 'Countryside', 'West Branch', 5);

INSERT INTO [Transaction] (Account_Number, Card_Number, Amount, Transaction_Type)
VALUES
(1, '1234567890123456', 50.00, 'Purchase'),
(2, '9876543210987654', 25.75, 'Withdrawal'),
(3, '5555222233334444', 100.50, 'Purchase'),
(4, '1111222233334444', 75.25, 'Withdrawal'),
(5, '7777666655554444', 30.00, 'Purchase');

INSERT INTO Deposit (Account_Number, Deposit_Amount, Interest_Rate, Term)
VALUES
(1, 2000.00, 0.03, 12),
(2, 5000.50, 0.02, 24),
(3, 10000.75, 0.025, 18),
(4, 1500.25, 0.035, 36),
(5, 8000.00, 0.028, 24);

INSERT INTO Loan (Loan_Type, Loan_Amount, Interest_Rate, Term, Account_Number)
VALUES
('Home Loan', 150000.00, 0.04, 240, 1),
('Car Loan', 25000.50, 0.035, 60, 2),
('Personal Loan', 10000.75, 0.03, 36, 3),
('Education Loan', 5000.25, 0.025, 24, 4),
('Business Loan', 75000.00, 0.045, 120, 5);



