DROP DATABASE IF EXISTS acacs;
CREATE DATABASE acacs;
USE acacs;

CREATE TABLE Site (
    SiteID  INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    ShortName   varchar(50) NOT NULL,
    Phone   varchar(20) NOT NULL,
    StreetAddress   varchar(250) NOT NULL,
    City    varchar(50) NOT NULL,
    State   varchar(20) NOT NULL,
    Zipcode varchar(20) NOT NULL
);

CREATE TABLE User (
    Username    varchar(50) NOT NULL PRIMARY KEY,
    SiteID  INTEGER NOT NULL,
    Password    varchar(50) NOT NULL,
    FirstName   varchar(50) NOT NULL,
    LastName    varchar(50) NOT NULL,
    FOREIGN KEY(SiteID) REFERENCES Site(SiteID)
);

CREATE TABLE SoupKitchen (
    ServiceID   INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    SiteID  INTEGER NOT NULL,
    FacilityName    varchar(250) NOT NULL,
    HoursOfOperation    varchar(50) NOT NULL,
    SeatsCapacity   INTEGER NOT NULL,
    SeatsAvailable  INTEGER NOT NULL,
    FOREIGN KEY(SiteID) REFERENCES Site(SiteID) ON DELETE CASCADE
);

CREATE TABLE SoupKitchenConditionForUse (
    ServiceID   INTEGER NOT NULL,
    ConditionForUse varchar(250) NOT NULL,
    FOREIGN KEY(ServiceID) REFERENCES SoupKitchen(ServiceID) ON DELETE CASCADE,
    PRIMARY KEY(ServiceID,ConditionForUse)
);

CREATE TABLE FoodPantry (
    ServiceID   INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    SiteID  INTEGER NOT NULL,
    FacilityName    varchar(250) NOT NULL,
    HoursOfOperation    varchar(50) NOT NULL,
    FOREIGN KEY(SiteID) REFERENCES Site(SiteID) ON DELETE CASCADE
);

CREATE TABLE FoodPantryConditionForUse (
    ServiceID   INTEGER NOT NULL,
    ConditionForUse varchar(250) NOT NULL,
    FOREIGN KEY(ServiceID) REFERENCES FoodPantry(ServiceID) ON DELETE CASCADE,
    PRIMARY KEY(ServiceID,ConditionForUse)
);

CREATE TABLE Shelter (
    ServiceID   INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    SiteID  INTEGER NOT NULL,
    FacilityName    varchar(250) NOT NULL,
    HoursOfOperation    varchar(50) NOT NULL,
    MaleBunkAvailable   INTEGER NOT NULL,
    FemaleBunkAvailable INTEGER NOT NULL,
    MixedBunkAvailable  INTEGER NOT NULL,
    FamilyRoomAvailable INTEGER NOT NULL,
    FOREIGN KEY(SiteID) REFERENCES Site(SiteID) ON DELETE CASCADE
);

CREATE TABLE ShelterConditionForUse (
    ServiceID   INTEGER NOT NULL,
    ConditionForUse varchar(250) NOT NULL,
    FOREIGN KEY(ServiceID) REFERENCES Shelter(ServiceID) ON DELETE CASCADE,
    PRIMARY KEY(ServiceID,ConditionForUse)
);

CREATE TABLE FoodBank (
    ServiceID   INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    SiteID  INTEGER NOT NULL,
    FacilityName varchar(250) NOT NULL,
    FOREIGN KEY(SiteID) REFERENCES Site(SiteID) ON DELETE CASCADE
);

CREATE TABLE Item (
    ItemID  INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    ServiceID   INTEGER NOT NULL,
    ItemName    varchar(50) NOT NULL,
    NumberOfUnits   INTEGER NOT NULL,
    ExpirationDate  date NOT NULL,
    StorageType varchar(50) NOT NULL,
    Category    varchar(50) NOT NULL,
    Subcategory varchar(50) NOT NULL,
    FOREIGN KEY(ServiceID) REFERENCES FoodBank(ServiceID) ON DELETE CASCADE
);

CREATE TABLE Request (
    RequestID   INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    Username    varchar(50) NOT NULL,
    TimeStamp   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    ServiceID   INTEGER NOT NULL,
    ItemID  INTEGER NOT NULL,
    ItemQuantity    INTEGER NOT NULL,
    ItemProvided    INTEGER NOT NULL,
    Status  varchar(50) NOT NULL,

    FOREIGN KEY(Username) REFERENCES User(Username) ON DELETE CASCADE,
    FOREIGN KEY(ServiceID) REFERENCES FoodBank(ServiceID) ON DELETE CASCADE,
    FOREIGN KEY(ItemID) REFERENCES Item(ItemID) ON DELETE CASCADE
);

CREATE TABLE Client (
    ClientID    INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    FirstName   varchar(50) NOT NULL,
    LastName    varchar(50) NOT NULL,
    IDNumber    varchar(20) NOT NULL,
    IDDescription   varchar(250) NOT NULL,
    IsHeadOfHousehold   boolean NOT NULL DEFAULT 0,
    Phone   varchar(20) NOT NULL,
    UNIQUE (FirstName, LastName, IDNumber)
);

CREATE TABLE WaitlistEntry (
    ServiceID   INTEGER NOT NULL,
    ClientID    INTEGER NOT NULL,
    OrderIndex  INTEGER NOT NULL,
    PRIMARY KEY(ServiceID, ClientID),
    FOREIGN KEY(ServiceID) REFERENCES Shelter(ServiceID) ON DELETE CASCADE,
    FOREIGN KEY(ClientID) REFERENCES Client(ClientID) ON DELETE CASCADE
);

CREATE TABLE FieldModifiedLogEntry (
    ClientID    INTEGER NOT NULL,
    TimeStamp   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    Description varchar(250) NOT NULL,
    PRIMARY KEY(ClientID,TimeStamp,Description),
    FOREIGN KEY(ClientID) REFERENCES Client(ClientID) ON DELETE CASCADE
);

CREATE TABLE ServiceUsageLogEntry (
    ClientID    INTEGER NOT NULL,
    TimeStamp   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    ServiceType varchar(250) NOT NULL,
    ExtraNotes  varchar(250),
    PRIMARY KEY(ClientID,TimeStamp, ServiceType),
    FOREIGN KEY(ClientID) REFERENCES Client(ClientID) ON DELETE CASCADE
);

-- Insert into Site
INSERT INTO Site VALUES(1, 'site1', '858-876-9976', '123 lane ave', 'San Diego', 'CA', '92130');
INSERT INTO Site VALUES(2, 'site2', '858-777-1256', '5432 Mulholland Dr', 'Los Angeles', 'CA', '90210');
INSERT INTO Site VALUES(3, 'site3', '281-330-8004', '4124 pennyhouse lane', 'Los Angeles', 'CA', '90124');

-- Insert into User
INSERT INTO User VALUES('emp1', 1, 'gatech123', 'Site1', 'Employee1');
INSERT INTO User VALUES('emp2', 2, 'gatech123', 'Site2', 'Employee2');
INSERT INTO User VALUES('emp3', 3, 'gatech123', 'Site3', 'Employee3');
INSERT INTO User VALUES('vol1', 1, 'gatech123', 'Site1', 'Volunteer1');
INSERT INTO User VALUES('vol2', 2, 'gatech123', 'Site2', 'Volunteer2');
INSERT INTO User VALUES('vol3', 3, 'gatech123', 'Site3', 'Volunteer3');

-- Insert into Client
INSERT INTO Client VALUES (1, 'Joe', 'Client1', '10000001', 'Driver Licence', 0, '111-222-0001');
INSERT INTO Client VALUES (2, 'Joe', 'Client2', '10000002', 'Driver Licence', 1, '111-222-0002');
INSERT INTO Client VALUES (3, 'Joe', 'Client3', '10000003', 'Driver Licence', 0, '111-222-0003');
INSERT INTO Client VALUES (4, 'Joe', 'Client4', '10000004', 'Driver Licence', 0, '111-222-0004');
INSERT INTO Client VALUES (5, 'Joe', 'Client5', '10000005', 'Driver Licence', 1, '111-222-0005');
INSERT INTO Client VALUES (6, 'Joe', 'Client6', '10000006', 'Driver Licence', 0, '111-222-0006');
INSERT INTO Client VALUES (7, 'Jane', 'Client7', '10000007', 'Driver Licence', 0, '111-222-0007');
INSERT INTO Client VALUES (8, 'Jane', 'Client8', '10000008', 'Driver Licence', 1, '111-222-0008');
INSERT INTO Client VALUES (9, 'Jane', 'Client9', '10000009', 'Driver Licence', 0, '111-222-0009');
INSERT INTO Client VALUES (10, 'Jane', 'Client10', '10000010', 'Driver Licence', 0, '111-222-0010');
INSERT INTO Client VALUES (11, 'Jane', 'Client11', '10000011', 'Driver Licence', 1, '111-222-0011');
INSERT INTO Client VALUES (12, 'Jane', 'Client12', '10000012', 'Driver Licence', 0, '111-222-0012');

-- Insert int Services

-- Insert into FoodPantry
INSERT INTO FoodPantry VALUES(100001, 1, 'pantry1', 'Wednesdays 2-6 PM');
INSERT INTO FoodPantry VALUES(100002, 3, 'pantry3', 'Fridays 2-6 PM');

-- Insert into FoodPantryConditionForUse
INSERT INTO FoodPantryConditionForUse VALUES(100001, 'Social Security Card');
INSERT INTO FoodPantryConditionForUse VALUES(100001, 'Proof of Income');
INSERT INTO FoodPantryConditionForUse VALUES(100002, 'Birth Certificate');
INSERT INTO FoodPantryConditionForUse VALUES(100002, 'Proof of Income');

-- Insert into Soup Kitchens
INSERT INTO SoupKitchen VALUES(300001, 2, 'soup2', 'Wednesdays 1:00PM - 2:00PM', 30, 25);
INSERT INTO SoupKitchen VALUES(300002, 3, 'soup3', 'Fridays 5:00PM - 6:00PM', 50, 35);

-- Insert into SoupKitchenConditionForUse
INSERT INTO SoupKitchenConditionForUse VALUES(300001, 'Drivers License');
INSERT INTO SoupKitchenConditionForUse VALUES(300002, 'Birth Certificate');

-- Insert into Shelter
INSERT INTO Shelter VALUES(200001, 2, 'shelter2', '7pm-7am every day', 4, 4, 4, 0);
INSERT INTO Shelter VALUES(200002, 3, 'shelter3', '5pm-9am every day', 4, 4, 4, 0);

-- Insert into ShelterConditionForUse
INSERT INTO ShelterConditionForUse VALUES(200001, 'Social Security Card');
INSERT INTO ShelterConditionForUse VALUES(200001, 'Proof of Income');
INSERT INTO ShelterConditionForUse VALUES(200001, 'Birth Certificate');
INSERT INTO ShelterConditionForUse VALUES(200002, 'Social Security Card');

-- Insert into FoodBank
INSERT INTO FoodBank VALUES(400001, 1, "bank1");
INSERT INTO FoodBank VALUES(400002, 2, "bank2");
INSERT INTO FoodBank VALUES(400003, 3, "bank3");

-- Insert into WaitlistEntry
INSERT INTO WaitlistEntry VALUES(200001,1,1);
INSERT INTO WaitlistEntry VALUES(200001,2,2);
INSERT INTO WaitlistEntry VALUES(200001,3,3);
INSERT INTO WaitlistEntry VALUES(200001,4,4);
INSERT INTO WaitlistEntry VALUES(200002,11,1);

-- Insert into ServiceUsageLogEntry
INSERT INTO ServiceUsageLogEntry VALUES(1, NULL, 'Used FoodPantry At site1', 'Provide a meal.');
INSERT INTO ServiceUsageLogEntry VALUES(1, NULL, 'Used FoodPantry At site3', 'Provide a meal.');
INSERT INTO ServiceUsageLogEntry VALUES(2, NULL, 'Used FoodPantry At site1', 'Provide two meals.');
INSERT INTO ServiceUsageLogEntry VALUES(2, NULL, 'Used FoodPantry At site3', 'Provide two meals.');
INSERT INTO ServiceUsageLogEntry VALUES(3, NULL, 'Used FoodPantry At site1', 'Provide two meals and a juice.');
INSERT INTO ServiceUsageLogEntry VALUES(3, NULL, 'Used FoodPantry At site3', 'Provide two meals and a juice.');
INSERT INTO ServiceUsageLogEntry VALUES(4, NULL, 'Used FoodPantry At site1', 'Provide two meals.');
INSERT INTO ServiceUsageLogEntry VALUES(4, NULL, 'Used FoodPantry At site3', 'Provide two meals.');
INSERT INTO ServiceUsageLogEntry VALUES(5, NULL, 'Used SoupKitchen At site2', 'Provide a meal.');
INSERT INTO ServiceUsageLogEntry VALUES(5, NULL, 'Used SoupKitchen At site3', 'Provide a meal.');
INSERT INTO ServiceUsageLogEntry VALUES(6, NULL, 'Used SoupKitchen At site2', 'Provide a meal.');
INSERT INTO ServiceUsageLogEntry VALUES(6, NULL, 'Used SoupKitchen At site3', 'Provide a meal.');
INSERT INTO ServiceUsageLogEntry VALUES(7, NULL, 'Used SoupKitchen At site2', 'Provide a meal.');
INSERT INTO ServiceUsageLogEntry VALUES(7, NULL, 'Used SoupKitchen At site3', 'Provide a meal.');
INSERT INTO ServiceUsageLogEntry VALUES(8, NULL, 'Used SoupKitchen At site2', 'Provide a meal.');
INSERT INTO ServiceUsageLogEntry VALUES(8, NULL, 'Used SoupKitchen At site3', 'Provide a meal.');
INSERT INTO ServiceUsageLogEntry VALUES(9, NULL, 'Used MaleBunkAvailable At site2', 'Late check-in');
INSERT INTO ServiceUsageLogEntry VALUES(9, NULL, 'Used MaleBunkAvailable At site3', 'Late check-in');
INSERT INTO ServiceUsageLogEntry VALUES(10, NULL, 'Used MaleBunkAvailable At site2', 'N/A');
INSERT INTO ServiceUsageLogEntry VALUES(10, NULL, 'Used MaleBunkAvailable At site3', 'N/A');
INSERT INTO ServiceUsageLogEntry VALUES(11, NULL, 'Used MaleBunkAvailable At site2', 'Check-in to room.');
INSERT INTO ServiceUsageLogEntry VALUES(11, NULL, 'Used MaleBunkAvailable At site3', 'N/A');
INSERT INTO ServiceUsageLogEntry VALUES(12, NULL, 'Used MaleBunkAvailable At site2', 'Late check-in');
INSERT INTO ServiceUsageLogEntry VALUES(12, NULL, 'Used MaleBunkAvailable At site3', 'Late check-in');

-- Insert into FieldModifiedLogEntry
INSERT INTO FieldModifiedLogEntry VALUES(1, NULL,'ClientID:1, FirstName:JJ, LastName:Client, IDNumber:0000, IDDescription:Driver Licence, IsHeadOfHousehold:0, Phone:0000');
INSERT INTO FieldModifiedLogEntry VALUES(2, NULL,'ClientID:2, FirstName:JJ, LastName:Client, IDNumber:0000, IDDescription:Driver Licence, IsHeadOfHousehold:0, Phone:0000');
INSERT INTO FieldModifiedLogEntry VALUES(3, NULL,'ClientID:3, FirstName:JJ, LastName:Client, IDNumber:0000, IDDescription:Driver Licence, IsHeadOfHousehold:0, Phone:0000');
INSERT INTO FieldModifiedLogEntry VALUES(4, NULL,'ClientID:4, FirstName:JJ, LastName:Client, IDNumber:0000, IDDescription:Driver Licence, IsHeadOfHousehold:0, Phone:0000');
INSERT INTO FieldModifiedLogEntry VALUES(5, NULL,'ClientID:5, FirstName:JJ, LastName:Client, IDNumber:0000, IDDescription:Driver Licence, IsHeadOfHousehold:0, Phone:0000');
INSERT INTO FieldModifiedLogEntry VALUES(6, NULL,'ClientID:6, FirstName:JJ, LastName:Client, IDNumber:0000, IDDescription:Driver Licence, IsHeadOfHousehold:0, Phone:0000');
INSERT INTO FieldModifiedLogEntry VALUES(7, NULL,'ClientID:7, FirstName:JJ, LastName:Client, IDNumber:0000, IDDescription:Driver Licence, IsHeadOfHousehold:0, Phone:0000');
INSERT INTO FieldModifiedLogEntry VALUES(8, NULL,'ClientID:8, FirstName:JJ, LastName:Client, IDNumber:0000, IDDescription:Driver Licence, IsHeadOfHousehold:0, Phone:0000');
INSERT INTO FieldModifiedLogEntry VALUES(9, NULL,'ClientID:9, FirstName:JJ, LastName:Client, IDNumber:0000, IDDescription:Driver Licence, IsHeadOfHousehold:0, Phone:0000');
INSERT INTO FieldModifiedLogEntry VALUES(10, NULL,'ClientID:10, FirstName:JJ, LastName:Client, IDNumber:0000, IDDescription:Driver Licence, IsHeadOfHousehold:0, Phone:0000');
INSERT INTO FieldModifiedLogEntry VALUES(11, NULL,'ClientID:11, FirstName:JJ, LastName:Client, IDNumber:0000, IDDescription:Driver Licence, IsHeadOfHousehold:0, Phone:0000');
INSERT INTO FieldModifiedLogEntry VALUES(12, NULL,'ClientID:12, FirstName:JJ, LastName:Client, IDNumber:0000, IDDescription:Driver Licence, IsHeadOfHousehold:0, Phone:0000');


-- Insert into Item
INSERT INTO Item VALUES (10000001, 400001, 'Romaine', 10, '2017-04-29', 'Refrigerated', 'Food', 'Vegetables');
INSERT INTO Item VALUES (10000002, 400001, 'Spinach', 11, '2017-05-01', 'Refrigerated', 'Food', 'Vegetables');
INSERT INTO Item VALUES (10000003, 400001, 'Butterhead', 12, '2017-04-30', 'Refrigerated', 'Food', 'Vegetables');
INSERT INTO Item VALUES (10000004, 400001, 'Arugula', 12, '2017-04-30', 'Refrigerated', 'Food', 'Vegetables');
INSERT INTO Item VALUES (10000005, 400001, 'Kale', 10, '2017-05-21', 'Refrigerated', 'Food', 'Vegetables');
INSERT INTO Item VALUES (10000006, 400001, 'Chicory', 9, '2017-05-22', 'Refrigerated', 'Food', 'Vegetables');
INSERT INTO Item VALUES (10000007, 400001, 'Dandelion', 15, '2017-05-18', 'Refrigerated', 'Food', 'Vegetables');
INSERT INTO Item VALUES (10000008, 400001, 'Mesclun', 10, '2017-05-17', 'Refrigerated', 'Food', 'Vegetables');
INSERT INTO Item VALUES (10000009, 400001, 'Microgreens', 17, '2017-05-25', 'Refrigerated', 'Food', 'Vegetables');
INSERT INTO Item VALUES (10000010, 400001, 'Radicchio', 11, '2017-05-29', 'Refrigerated', 'Food', 'Vegetables');

INSERT INTO Item VALUES (10000011, 400001, 'Almonds', 5, '2018-01-10', 'Dry Good', 'Food', 'Nuts/grains/beans');
INSERT INTO Item VALUES (10000012, 400001, 'Walnuts', 10, '2018-01-05', 'Dry Good', 'Food', 'Nuts/grains/beans');
INSERT INTO Item VALUES (10000013, 400001, 'Macadamia Nuts', 20, '2018-01-05', 'Dry Good', 'Food', 'Nuts/grains/beans');
INSERT INTO Item VALUES (10000014, 400001, 'Hazelnuts', 7, '2017-10-06', 'Dry Good', 'Food', 'Nuts/grains/beans');
INSERT INTO Item VALUES (10000015, 400001, 'Peanuts', 11, '2018-02-07', 'Dry Good', 'Food', 'Nuts/grains/beans');
INSERT INTO Item VALUES (10000016, 400001, 'Cacao', 23, '2018-02-04', 'Dry Good', 'Food', 'Nuts/grains/beans');
INSERT INTO Item VALUES (10000017, 400001, 'Cashews', 6, '2017-11-05', 'Dry Good', 'Food', 'Nuts/grains/beans');
INSERT INTO Item VALUES (10000018, 400001, 'Sunflower Seeds', 7, '2017-05-22', 'Dry Good', 'Food', 'Nuts/grains/beans');
INSERT INTO Item VALUES (10000019, 400001, 'Pistachios', 10, '2017-05-19', 'Dry Good', 'Food', 'Nuts/grains/beans');
INSERT INTO Item VALUES (10000020, 400001, 'Pine Nuts', 25, '2018-02-16', 'Dry Good', 'Food', 'Nuts/grains/beans');

INSERT INTO Item VALUES (10000021, 400001, 'Pesto', 3, '2017-04-29', 'Dry Good', 'Food', 'Sauce/Condiment/Seasoning');
INSERT INTO Item VALUES (10000022, 400001, 'Ketchup', 4, '2017-05-20', 'Dry Good', 'Food', 'Sauce/Condiment/Seasoning');
INSERT INTO Item VALUES (10000023, 400001, 'Steak sauce', 7, '2018-05-10', 'Dry Good', 'Food', 'Sauce/Condiment/Seasoning');
INSERT INTO Item VALUES (10000024, 400001, 'Cranberry sauce', 5, '2017-05-10', 'Dry Good', 'Food', 'Sauce/Condiment/Seasoning');
INSERT INTO Item VALUES (10000025, 400001, 'Mustard', 1, '2017-09-11', 'Dry Good', 'Food', 'Sauce/Condiment/Seasoning');
INSERT INTO Item VALUES (10000026, 400001, 'Mayonnaise', 10, '2018-05-10', 'Dry Good', 'Food', 'Sauce/Condiment/Seasoning');
INSERT INTO Item VALUES (10000027, 400001, 'Sriracha sauce', 5, '2018-09-10', 'Dry Good', 'Food', 'Sauce/Condiment/Seasoning');
INSERT INTO Item VALUES (10000028, 400001, 'Soy sauce', 9, '2017-07-23', 'Dry Good', 'Food', 'Sauce/Condiment/Seasoning');
INSERT INTO Item VALUES (10000029, 400001, 'Barbecue sauce', 6, '2017-08-01', 'Dry Good', 'Food', 'Sauce/Condiment/Seasoning');
INSERT INTO Item VALUES (10000030, 400001, 'Marinara sauce', 13, '2017-12-02', 'Dry Good', 'Food', 'Sauce/Condiment/Seasoning');

INSERT INTO Item VALUES (10000031, 400001, 'Fresca', 21, '2018-12-02', 'Refrigerated', 'Food', 'Juice/Drink');
INSERT INTO Item VALUES (10000032, 400001, 'Sprite', 18, '2017-01-02', 'Refrigerated', 'Food', 'Juice/Drink');
INSERT INTO Item VALUES (10000033, 400001, 'Mountain Dew', 27, '2018-07-01', 'Refrigerated', 'Food', 'Juice/Drink');
INSERT INTO Item VALUES (10000034, 400001, 'Coca-Cola', 15, '2018-05-06', 'Refrigerated', 'Food', 'Juice/Drink');
INSERT INTO Item VALUES (10000035, 400001, 'Mist Twst', 21, '2017-11-03', 'Refrigerated', 'Food', 'Juice/Drink');
INSERT INTO Item VALUES (10000036, 400001, 'Fanta', 3, '2017-06-16', 'Refrigerated', 'Food', 'Juice/Drink');
INSERT INTO Item VALUES (10000037, 400001, 'Mug Root Beer', 6, '2017-09-23', 'Refrigerated', 'Food', 'Juice/Drink');
INSERT INTO Item VALUES (10000038, 400001, 'Pepsi', 9, '2018-02-04', 'Refrigerated', 'Food', 'Juice/Drink');
INSERT INTO Item VALUES (10000039, 400001, '7 up', 1, '2017-07-25', 'Refrigerated', 'Food', 'Juice/Drink');
INSERT INTO Item VALUES (10000040, 400001, 'Canada Dry', 3, '2017-10-02', 'Refrigerated', 'Food', 'Juice/Drink');

INSERT INTO Item VALUES (10000041, 400001, 'Beef', 7, '2017-10-05', 'Frozen', 'Food', 'Meat/seafood');
INSERT INTO Item VALUES (10000042, 400001, 'Ground Beef', 14, '2018-01-01', 'Frozen', 'Food', 'Meat/seafood');
INSERT INTO Item VALUES (10000043, 400001, 'Pork', 12, '2017-05-05', 'Frozen', 'Food', 'Meat/seafood');
INSERT INTO Item VALUES (10000044, 400001, 'Lamb', 6, '2017-11-11', 'Frozen', 'Food', 'Meat/seafood');
INSERT INTO Item VALUES (10000045, 400001, 'Goat', 16, '2017-07-15', 'Frozen', 'Food', 'Meat/seafood');
INSERT INTO Item VALUES (10000046, 400001, 'Ground Pork', 18, '2017-08-10', 'Frozen', 'Food', 'Meat/seafood');
INSERT INTO Item VALUES (10000047, 400001, 'Bacon', 21, '2018-02-04', 'Frozen', 'Food', 'Meat/seafood');
INSERT INTO Item VALUES (10000048, 400001, 'Sausages', 23, '2018-01-01', 'Frozen', 'Food', 'Meat/seafood');
INSERT INTO Item VALUES (10000049, 400001, 'Peperoni', 15, '2017-12-16', 'Frozen', 'Food', 'Meat/seafood');
INSERT INTO Item VALUES (10000050, 400001, 'Beef', 30, '2017-12-12', 'Frozen', 'Food', 'Meat/seafood');

INSERT INTO Item VALUES (10000051, 400001, 'Cheddar cheese', 18, '2017-07-12', 'Refrigerated', 'Food', 'Dairy/eggs');
INSERT INTO Item VALUES (10000052, 400001, 'Cream cheese', 15, '2017-08-21', 'Refrigerated', 'Food', 'Dairy/eggs');
INSERT INTO Item VALUES (10000053, 400001, 'Mozzarella', 5, '2017-06-03', 'Refrigerated', 'Food', 'Dairy/eggs');
INSERT INTO Item VALUES (10000054, 400001, 'Brie', 3, '2017-09-01', 'Refrigerated', 'Food', 'Dairy/eggs');
INSERT INTO Item VALUES (10000055, 400001, 'Feta', 12, '2017-05-07', 'Refrigerated', 'Food', 'Dairy/eggs');
INSERT INTO Item VALUES (10000056, 400001, 'American cheese', 18, '2017-04-28', 'Refrigerated', 'Food', 'Dairy/eggs');
INSERT INTO Item VALUES (10000057, 400001, 'Swiss cheese', 6, '2017-05-30', 'Refrigerated', 'Food', 'Dairy/eggs');
INSERT INTO Item VALUES (10000058, 400001, 'Cottage cheese', 8, '2017-09-03', 'Refrigerated', 'Food', 'Dairy/eggs');
INSERT INTO Item VALUES (10000059, 400001, 'Pepper jack cheese', 16, '2017-07-12', 'Refrigerated', 'Food', 'Dairy/eggs');
INSERT INTO Item VALUES (10000060, 400001, 'Cottage cheese', 7, '2017-05-13', 'Refrigerated', 'Food', 'Dairy/eggs');

INSERT INTO Item VALUES (10000061, 400001, 'Toothbrush', 20, '9999/01/01', 'Dry Good', 'Supply', 'Personal hygiene');
INSERT INTO Item VALUES (10000062, 400001, 'Toothpaste', 40, '2018-04-15', 'Dry Good', 'Supply', 'Personal hygiene');
INSERT INTO Item VALUES (10000063, 400001, 'Shampoo', 30, '2019-05-13', 'Dry Good', 'Supply', 'Personal hygiene');
INSERT INTO Item VALUES (10000064, 400001, 'Deodorant', 10, '2018-10-12', 'Dry Good', 'Supply', 'Personal hygiene');
INSERT INTO Item VALUES (10000065, 400001, 'Soap/detergent', 30, '2019-07-15', 'Dry Good', 'Supply', 'Personal hygiene');

INSERT INTO Item VALUES (10000066, 400001, 'Man shirt', 30, '9999/01/01', 'Dry Good', 'Supply', 'Clothing');
INSERT INTO Item VALUES (10000067, 400001, 'Man pant', 30, '9999/01/01', 'Dry Good', 'Supply', 'Clothing');
INSERT INTO Item VALUES (10000068, 400001, 'Female shirt', 30, '9999/01/01', 'Dry Good', 'Supply', 'Clothing');
INSERT INTO Item VALUES (10000069, 400001, 'Female panit', 30, '9999/01/01', 'Dry Good', 'Supply', 'Clothing');
INSERT INTO Item VALUES (10000070, 400001, 'Female underwear', 30, '9999/01/01', 'Dry Good', 'Supply', 'Clothing');


INSERT INTO Item VALUES (10000071, 400002, 'Potato', 10, '2017-05-18', 'Refrigerated', 'Food', 'Vegetables');
INSERT INTO Item VALUES (10000072, 400002, 'Carrot', 11, '2017-05-19', 'Refrigerated', 'Food', 'Vegetables');
INSERT INTO Item VALUES (10000073, 400002, 'Ginger', 12, '2017-05-20', 'Refrigerated', 'Food', 'Vegetables');
INSERT INTO Item VALUES (10000074, 400002, 'Turnip', 12, '2017-06-20', 'Refrigerated', 'Food', 'Vegetables');
INSERT INTO Item VALUES (10000075, 400002, 'Rutabaga', 10, '2017-07-21', 'Refrigerated', 'Food', 'Vegetables');
INSERT INTO Item VALUES (10000076, 400002, 'Sweet potato', 9, '2017-06-22', 'Refrigerated', 'Food', 'Vegetables');
INSERT INTO Item VALUES (10000077, 400002, 'Radish', 15, '2017-05-18', 'Refrigerated', 'Food', 'Vegetables');
INSERT INTO Item VALUES (10000078, 400002, 'Beet', 10, '2017-05-17', 'Refrigerated', 'Food', 'Vegetables');
INSERT INTO Item VALUES (10000079, 400002, 'Parsnip', 17, '2017-05-25', 'Refrigerated', 'Food', 'Vegetables');
INSERT INTO Item VALUES (10000080, 400002, 'Dalkon', 11, '2017-05-29', 'Refrigerated', 'Food', 'Vegetables');

INSERT INTO Item VALUES (10000081, 400002, 'Wheat', 5, '2018-01-10', 'Dry Good', 'Food', 'Nuts/grains/beans');
INSERT INTO Item VALUES (10000082, 400002, 'Rye', 10, '2018-01-05', 'Dry Good', 'Food', 'Nuts/grains/beans');
INSERT INTO Item VALUES (10000083, 400002, 'Brown rice', 20, '2018-01-05', 'Dry Good', 'Food', 'Nuts/grains/beans');
INSERT INTO Item VALUES (10000084, 400002, 'Oats', 7, '2017-10-06', 'Dry Good', 'Food', 'Nuts/grains/beans');
INSERT INTO Item VALUES (10000085, 400002, 'Popcorn', 11, '2018-02-07', 'Dry Good', 'Food', 'Nuts/grains/beans');
INSERT INTO Item VALUES (10000086, 400002, 'White rice', 23, '2018-02-04', 'Dry Good', 'Food', 'Nuts/grains/beans');
INSERT INTO Item VALUES (10000087, 400002, 'Millet', 6, '2017-11-05', 'Dry Good', 'Food', 'Nuts/grains/beans');
INSERT INTO Item VALUES (10000088, 400002, 'Quinoa', 7, '2017-05-22', 'Dry Good', 'Food', 'Nuts/grains/beans');
INSERT INTO Item VALUES (10000089, 400002, 'Wheat', 10, '2017-05-19', 'Dry Good', 'Food', 'Nuts/grains/beans');
INSERT INTO Item VALUES (10000090, 400002, 'Oats', 25, '2018-02-16', 'Dry Good', 'Food', 'Nuts/grains/beans');

INSERT INTO Item VALUES (10000091, 400002, 'Pesto', 3, '2017-05-29', 'Dry Good', 'Food', 'Sauce/Condiment/Seasoning');
INSERT INTO Item VALUES (10000092, 400002, 'Ketchup', 4, '2017-05-20', 'Dry Good', 'Food', 'Sauce/Condiment/Seasoning');
INSERT INTO Item VALUES (10000093, 400002, 'Steak sauce', 7, '2018-05-10', 'Dry Good', 'Food', 'Sauce/Condiment/Seasoning');
INSERT INTO Item VALUES (10000094, 400002, 'Cranberry sauce', 5, '2017-05-10', 'Dry Good', 'Food', 'Sauce/Condiment/Seasoning');
INSERT INTO Item VALUES (10000095, 400002, 'Mustard', 1, '2017-09-11', 'Dry Good', 'Food', 'Sauce/Condiment/Seasoning');
INSERT INTO Item VALUES (10000096, 400002, 'Mayonnaise', 10, '2018-05-10', 'Dry Good', 'Food', 'Sauce/Condiment/Seasoning');
INSERT INTO Item VALUES (10000097, 400002, 'Sriracha sauce', 5, '2018-09-10', 'Dry Good', 'Food', 'Sauce/Condiment/Seasoning');
INSERT INTO Item VALUES (10000098, 400002, 'Soy sauce', 9, '2017-07-23', 'Dry Good', 'Food', 'Sauce/Condiment/Seasoning');
INSERT INTO Item VALUES (10000099, 400002, 'Barbecue sauce', 6, '2017-08-01', 'Dry Good', 'Food', 'Sauce/Condiment/Seasoning');
INSERT INTO Item VALUES (10000100, 400002, 'Marinara sauce', 13, '2017-12-02', 'Dry Good', 'Food', 'Sauce/Condiment/Seasoning');

INSERT INTO Item VALUES (10000101, 400002, 'Coconut water', 21, '2018-12-02', 'Refrigerated', 'Food', 'Juice/Drink');
INSERT INTO Item VALUES (10000102, 400002, 'Carrot juice', 18, '2017-01-02', 'Refrigerated', 'Food', 'Juice/Drink');
INSERT INTO Item VALUES (10000103, 400002, 'Grape juice', 27, '2018-07-01', 'Refrigerated', 'Food', 'Juice/Drink');
INSERT INTO Item VALUES (10000104, 400002, 'Apple juice', 15, '2018-05-06', 'Refrigerated', 'Food', 'Juice/Drink');
INSERT INTO Item VALUES (10000105, 400002, 'Orange juice', 21, '2017-11-03', 'Refrigerated', 'Food', 'Juice/Drink');
INSERT INTO Item VALUES (10000106, 400002, 'Tomato juice', 3, '2017-06-16', 'Refrigerated', 'Food', 'Juice/Drink');
INSERT INTO Item VALUES (10000107, 400002, 'Grapefruit juice', 6, '2017-09-23', 'Refrigerated', 'Food', 'Juice/Drink');
INSERT INTO Item VALUES (10000108, 400002, 'Vegetable juice', 9, '2018-02-04', 'Refrigerated', 'Food', 'Juice/Drink');
INSERT INTO Item VALUES (10000109, 400002, 'Orange juice', 1, '2017-07-25', 'Refrigerated', 'Food', 'Juice/Drink');
INSERT INTO Item VALUES (10000110, 400002, 'Guava juice', 3, '2017-10-02', 'Refrigerated', 'Food', 'Juice/Drink');

INSERT INTO Item VALUES (10000111, 400002, 'Catfish', 7, '2017-10-05', 'Frozen', 'Food', 'Meat/seafood');
INSERT INTO Item VALUES (10000112, 400002, 'Shrimps', 14, '2018-01-01', 'Frozen', 'Food', 'Meat/seafood');
INSERT INTO Item VALUES (10000113, 400002, 'Salmon', 12, '2017-05-10', 'Frozen', 'Food', 'Meat/seafood');
INSERT INTO Item VALUES (00000114, 400002, 'Octopus', 6, '2017-11-11', 'Frozen', 'Food', 'Meat/seafood');
INSERT INTO Item VALUES (10000115, 400002, 'Crab meat', 16, '2017-07-15', 'Frozen', 'Food', 'Meat/seafood');
INSERT INTO Item VALUES (10000116, 400002, 'Mussel', 18, '2017-08-10', 'Frozen', 'Food', 'Meat/seafood');
INSERT INTO Item VALUES (10000117, 400002, 'Clam', 21, '2018-02-04', 'Frozen', 'Food', 'Meat/seafood');
INSERT INTO Item VALUES (10000118, 400002, 'Fish fillet', 23, '2018-01-01', 'Frozen', 'Food', 'Meat/seafood');
INSERT INTO Item VALUES (10000119, 400002, 'Sea bass', 15, '2017-12-16', 'Frozen', 'Food', 'Meat/seafood');
INSERT INTO Item VALUES (10000120, 400002, 'Trout', 30, '2017-12-12', 'Frozen', 'Food', 'Meat/seafood');

INSERT INTO Item VALUES (10000121, 400002, 'Eggs', 18, '2017-05-12', 'Refrigerated', 'Food', 'Dairy/eggs');
INSERT INTO Item VALUES (10000122, 400002, 'Quail eggs', 15, '2017-05-21', 'Refrigerated', 'Food', 'Dairy/eggs');
INSERT INTO Item VALUES (10000123, 400002, 'Liquid egg whites', 5, '2017-06-03', 'Refrigerated', 'Food', 'Dairy/eggs');
INSERT INTO Item VALUES (10000124, 400002, 'Eggs', 3, '2017-04-29', 'Refrigerated', 'Food', 'Dairy/eggs');
INSERT INTO Item VALUES (10000125, 400002, 'Eggs', 12, '2017-05-07', 'Refrigerated', 'Food', 'Dairy/eggs');
INSERT INTO Item VALUES (10000126, 400002, 'Liquid egg products', 18, '2017-05-27', 'Refrigerated', 'Food', 'Dairy/eggs');
INSERT INTO Item VALUES (10000127, 400002, 'Liquid egg products', 6, '2017-05-30', 'Refrigerated', 'Food', 'Dairy/eggs');
INSERT INTO Item VALUES (10000128, 400002, 'Eggs', 8, '2017-06-03', 'Refrigerated', 'Food', 'Dairy/eggs');
INSERT INTO Item VALUES (10000129, 400002, 'Eggs', 16, '2017-05-15', 'Refrigerated', 'Food', 'Dairy/eggs');
INSERT INTO Item VALUES (10000130, 400002, 'Quail eggs', 7, '2017-05-29', 'Refrigerated', 'Food', 'Dairy/eggs');

INSERT INTO Item VALUES (10000131, 400002, 'Blanket', 20, '9999/01/01', 'Dry Good', 'Supply', 'Shelter');
INSERT INTO Item VALUES (10000132, 400002, 'Sleeping bag', 30, '9999/01/01', 'Dry Good', 'Supply', 'Shelter');
INSERT INTO Item VALUES (10000133, 400002, 'Tent', 10, '9999/01/01', 'Dry Good', 'Supply', 'Shelter');
INSERT INTO Item VALUES (10000134, 400002, 'Pillow', 25, '9999/01/01', 'Dry Good', 'Supply', 'Shelter');
INSERT INTO Item VALUES (10000135, 400002, 'Sheets', 15, '9999/01/01', 'Dry Good', 'Supply', 'Shelter');

INSERT INTO Item VALUES (10000136, 400002, 'Toilet paper', 50, '9999/01/01', 'Dry Good', 'Supply', 'Other');
INSERT INTO Item VALUES (10000137, 400002, 'Dog food', 15, '2018/03/01', 'Dry Good', 'Supply', 'Other');
INSERT INTO Item VALUES (10000138, 400002, 'Cat food', 20, '2018/01/01', 'Dry Good', 'Supply', 'Other');
INSERT INTO Item VALUES (10000139, 400002, 'Batteries', 30, '2022/01/01', 'Dry Good', 'Supply', 'Other');
INSERT INTO Item VALUES (10000140, 400002, 'Toilet sesat cover', 35, '9999/01/01', 'Dry Good', 'Supply', 'Other');


INSERT INTO Item VALUES (10000141, 400003, 'Chicken tighs', 7, '2017-03-20', 'Refrigerated', 'Food', 'Meat/seafood');
INSERT INTO Item VALUES (10000142, 400003, 'Chicken breast', 8, '2017-03-19', 'Refrigerated', 'Food', 'Meat/seafood');
INSERT INTO Item VALUES (10000143, 400003, 'Chicken tender', 6, '2017-03-26', 'Refrigerated', 'Food', 'Meat/seafood');
INSERT INTO Item VALUES (10000144, 400003, 'Whole chicken', 9, '2017-03-28', 'Refrigerated', 'Food', 'Meat/seafood');
INSERT INTO Item VALUES (10000145, 400003, 'Chicken drumsticks', 14, '2017-03-15', 'Refrigerated', 'Food', 'Meat/seafood');
INSERT INTO Item VALUES (10000146, 400003, 'Chicken tighs', 3, '2017-03-01', 'Refrigerated', 'Food', 'Meat/seafood');

INSERT INTO Item VALUES (10000147, 400003, '2% milk', 3, '2017-03-15', 'Refrigerated', 'Food', 'Dairy/eggs');
INSERT INTO Item VALUES (10000148, 400003, 'Whole milk', 10, '2017-03-19', 'Refrigerated', 'Food', 'Dairy/eggs');
INSERT INTO Item VALUES (10000149, 400003, 'Fat-free milk', 6, '2017-03-26', 'Refrigerated', 'Food', 'Dairy/eggs');
INSERT INTO Item VALUES (10000150, 400003, 'Lactose-Free milk', 9, '2017-03-28', 'Refrigerated', 'Food', 'Dairy/eggs');
INSERT INTO Item VALUES (10000151, 400003, 'Whole milk', 5, '2017-03-15', 'Refrigerated', 'Food', 'Dairy/eggs');
INSERT INTO Item VALUES (10000152, 400003, '2% milk', 1, '2017-03-29', 'Refrigerated', 'Food', 'Dairy/eggs');

-- Insert into Request
    -- Pending requests of Employee
INSERT INTO Request VALUES (1, 'emp1', NULL, 400002, 10000071, 3, 0, 'Pending');
INSERT INTO Request VALUES (2, 'emp1', NULL, 400002, 10000071, 3, 0, 'Pending');
INSERT INTO Request VALUES (3, 'emp1', NULL, 400002, 10000081, 2, 0, 'Pending');
INSERT INTO Request VALUES (4, 'emp1', NULL, 400002, 10000082, 2, 0, 'Pending');
INSERT INTO Request VALUES (5, 'emp1', NULL, 400002, 10000101, 5, 0, 'Pending');
INSERT INTO Request VALUES (6, 'emp1', NULL, 400002, 10000102, 5, 0, 'Pending');
INSERT INTO Request VALUES (7, 'emp1', NULL, 400002, 10000111, 5, 0, 'Pending');
INSERT INTO Request VALUES (8, 'emp1', NULL, 400002, 10000112, 5, 0, 'Pending');
INSERT INTO Request VALUES (9, 'emp1', NULL, 400002, 10000121, 10, 0, 'Pending');
INSERT INTO Request VALUES (10, 'emp1', NULL, 400002, 10000122, 10, 0, 'Pending');

INSERT INTO Request VALUES (11, 'emp1', NULL, 400003, 10000141, 5, 0, 'Pending');
INSERT INTO Request VALUES (12, 'emp1', NULL, 400003, 10000142, 5, 0, 'Pending');
INSERT INTO Request VALUES (13, 'emp1', NULL, 400003, 10000147, 3, 0, 'Pending');
INSERT INTO Request VALUES (14, 'emp1', NULL, 400003, 10000148, 3, 0, 'Pending');


INSERT INTO Request VALUES (15, 'emp2', NULL, 400001, 10000001, 3, 0, 'Pending');
INSERT INTO Request VALUES (16, 'emp2', NULL, 400001, 10000002, 3, 0, 'Pending');
INSERT INTO Request VALUES (17, 'emp2', NULL, 400001, 10000011, 4, 0, 'Pending');
INSERT INTO Request VALUES (18, 'emp2', NULL, 400001, 10000012, 4, 0, 'Pending');
INSERT INTO Request VALUES (19, 'emp2', NULL, 400001, 10000031, 5, 0, 'Pending');
INSERT INTO Request VALUES (20, 'emp2', NULL, 400001, 10000032, 5, 0, 'Pending');
INSERT INTO Request VALUES (21, 'emp2', NULL, 400001, 10000141, 6, 0, 'Pending');
INSERT INTO Request VALUES (22, 'emp2', NULL, 400001, 10000142, 6, 0, 'Pending');
INSERT INTO Request VALUES (23, 'emp2', NULL, 400001, 10000151, 7, 0, 'Pending');
INSERT INTO Request VALUES (24, 'emp2', NULL, 400001, 10000152, 7, 0, 'Pending');

INSERT INTO Request VALUES (25, 'emp2', NULL, 400003, 10000141, 2, 0, 'Pending');
INSERT INTO Request VALUES (26, 'emp2', NULL, 400003, 10000142, 2, 0, 'Pending');
INSERT INTO Request VALUES (27, 'emp2', NULL, 400003, 10000147, 1, 0, 'Pending');
INSERT INTO Request VALUES (28, 'emp2', NULL, 400003, 10000148, 1, 0, 'Pending');

INSERT INTO Request VALUES (29, 'emp2', NULL, 400001, 10000061, 7, 0, 'Pending');
INSERT INTO Request VALUES (30, 'emp2', NULL, 400001, 10000062, 7, 0, 'Pending');
INSERT INTO Request VALUES (31, 'emp2', NULL, 400001, 10000063, 7, 0, 'Pending');
INSERT INTO Request VALUES (32, 'emp2', NULL, 400001, 10000064, 7, 0, 'Pending');
INSERT INTO Request VALUES (33, 'emp2', NULL, 400001, 10000065, 7, 0, 'Pending');
INSERT INTO Request VALUES (34, 'emp2', NULL, 400001, 10000066, 10, 0, 'Pending');
INSERT INTO Request VALUES (35, 'emp2', NULL, 400001, 10000067, 10, 0, 'Pending');


INSERT INTO Request VALUES (36, 'emp3', NULL, 400001, 10000003, 5, 0, 'Pending');
INSERT INTO Request VALUES (37, 'emp3', NULL, 400001, 10000004, 5, 0, 'Pending');
INSERT INTO Request VALUES (38, 'emp3', NULL, 400001, 10000013, 5, 0, 'Pending');
INSERT INTO Request VALUES (39, 'emp3', NULL, 400001, 10000033, 5, 0, 'Pending');
INSERT INTO Request VALUES (40, 'emp3', NULL, 400001, 10000034, 5, 0, 'Pending');

INSERT INTO Request VALUES (41, 'emp3', NULL, 400002, 10000073, 5, 0, 'Pending');
INSERT INTO Request VALUES (42, 'emp3', NULL, 400002, 10000074, 5, 0, 'Pending');
INSERT INTO Request VALUES (43, 'emp3', NULL, 400002, 10000083, 5, 0, 'Pending');
INSERT INTO Request VALUES (44, 'emp3', NULL, 400002, 10000084, 5, 0, 'Pending');
INSERT INTO Request VALUES (45, 'emp3', NULL, 400002, 10000103, 5, 0, 'Pending');

INSERT INTO Request VALUES (46, 'emp3', NULL, 400001, 10000063, 5, 0, 'Pending');
INSERT INTO Request VALUES (47, 'emp3', NULL, 400001, 10000064, 5, 0, 'Pending');
INSERT INTO Request VALUES (48, 'emp3', NULL, 400001, 10000065, 5, 0, 'Pending');
INSERT INTO Request VALUES (49, 'emp3', NULL, 400001, 10000066, 5, 0, 'Pending');
INSERT INTO Request VALUES (50, 'emp3', NULL, 400001, 10000067, 5, 0, 'Pending');
INSERT INTO Request VALUES (51, 'emp3', NULL, 400001, 10000068, 5, 0, 'Pending');
INSERT INTO Request VALUES (52, 'emp3', NULL, 400001, 10000069, 5, 0, 'Pending');

INSERT INTO Request VALUES (53, 'emp3', NULL, 400002, 10000133, 5, 0, 'Pending');
INSERT INTO Request VALUES (54, 'emp3', NULL, 400002, 10000134, 5, 0, 'Pending');
INSERT INTO Request VALUES (55, 'emp3', NULL, 400002, 10000135, 5, 0, 'Pending');
INSERT INTO Request VALUES (56, 'emp3', NULL, 400002, 10000136, 5, 0, 'Pending');
INSERT INTO Request VALUES (57, 'emp3', NULL, 400002, 10000137, 5, 0, 'Pending');
INSERT INTO Request VALUES (58, 'emp3', NULL, 400002, 10000138, 5, 0, 'Pending');
INSERT INTO Request VALUES (59, 'emp3', NULL, 400002, 10000139, 5, 0, 'Pending');

    -- 4 Closed Requests per Employee User
INSERT INTO Request VALUES (60, 'emp1', NULL, 400002, 10000071, 3, 3, 'Closed');
INSERT INTO Request VALUES (61, 'emp1', NULL, 400002, 10000072, 3, 2, 'Closed');
INSERT INTO Request VALUES (62, 'emp1', NULL, 400002, 10000073, 3, 1, 'Closed');
INSERT INTO Request VALUES (63, 'emp1', NULL, 400002, 10000074, 3, 0, 'Closed');

INSERT INTO Request VALUES (64, 'emp2', NULL, 400001, 10000001, 3, 3, 'Closed');
INSERT INTO Request VALUES (65, 'emp2', NULL, 400001, 10000002, 3, 2, 'Closed');
INSERT INTO Request VALUES (66, 'emp2', NULL, 400001, 10000003, 3, 1, 'Closed');
INSERT INTO Request VALUES (67, 'emp2', NULL, 400001, 10000004, 3, 0, 'Closed');

INSERT INTO Request VALUES (68, 'emp3', NULL, 400001, 10000003, 5, 5, 'Closed');
INSERT INTO Request VALUES (69, 'emp3', NULL, 400001, 10000003, 5, 4, 'Closed');
INSERT INTO Request VALUES (70, 'emp3', NULL, 400001, 10000003, 5, 3, 'Closed');
INSERT INTO Request VALUES (71, 'emp3', NULL, 400001, 10000003, 5, 0, 'Closed');

    -- Pending Request of Volunteer
INSERT INTO Request VALUES (72, 'vol1', NULL, 400002, 10000071, 3, 0, 'Pending');
INSERT INTO Request VALUES (73, 'vol1', NULL, 400002, 10000071, 3, 0, 'Pending');
INSERT INTO Request VALUES (74, 'vol1', NULL, 400002, 10000081, 2, 0, 'Pending');
INSERT INTO Request VALUES (75, 'vol1', NULL, 400002, 10000082, 2, 0, 'Pending');
INSERT INTO Request VALUES (76, 'vol1', NULL, 400002, 10000101, 5, 0, 'Pending');
INSERT INTO Request VALUES (77, 'vol1', NULL, 400002, 10000102, 5, 0, 'Pending');
INSERT INTO Request VALUES (78, 'vol1', NULL, 400002, 10000111, 5, 0, 'Pending');
INSERT INTO Request VALUES (79, 'vol1', NULL, 400002, 10000112, 5, 0, 'Pending');
INSERT INTO Request VALUES (80, 'vol1', NULL, 400002, 10000121, 10, 0, 'Pending');
INSERT INTO Request VALUES (81, 'vol1', NULL, 400002, 10000122, 10, 0, 'Pending');

INSERT INTO Request VALUES (82, 'vol1', NULL, 400003, 10000141, 5, 0, 'Pending');
INSERT INTO Request VALUES (83, 'vol1', NULL, 400003, 10000142, 5, 0, 'Pending');
INSERT INTO Request VALUES (84, 'vol1', NULL, 400003, 10000147, 3, 0, 'Pending');
INSERT INTO Request VALUES (85, 'vol1', NULL, 400003, 10000148, 3, 0, 'Pending');


INSERT INTO Request VALUES (86, 'vol2', NULL, 400001, 10000001, 3, 0, 'Pending');
INSERT INTO Request VALUES (87, 'vol2', NULL, 400001, 10000002, 3, 0, 'Pending');
INSERT INTO Request VALUES (88, 'vol2', NULL, 400001, 10000011, 4, 0, 'Pending');
INSERT INTO Request VALUES (89, 'vol2', NULL, 400001, 10000012, 4, 0, 'Pending');
INSERT INTO Request VALUES (90, 'vol2', NULL, 400001, 10000031, 5, 0, 'Pending');
INSERT INTO Request VALUES (91, 'vol2', NULL, 400001, 10000032, 5, 0, 'Pending');
INSERT INTO Request VALUES (92, 'vol2', NULL, 400001, 10000141, 6, 0, 'Pending');
INSERT INTO Request VALUES (93, 'vol2', NULL, 400001, 10000142, 6, 0, 'Pending');
INSERT INTO Request VALUES (94, 'vol2', NULL, 400001, 10000151, 7, 0, 'Pending');
INSERT INTO Request VALUES (95, 'vol2', NULL, 400001, 10000152, 7, 0, 'Pending');

INSERT INTO Request VALUES (96, 'vol2', NULL, 400003, 10000141, 2, 0, 'Pending');
INSERT INTO Request VALUES (97, 'vol2', NULL, 400003, 10000142, 2, 0, 'Pending');
INSERT INTO Request VALUES (98, 'vol2', NULL, 400003, 10000147, 1, 0, 'Pending');
INSERT INTO Request VALUES (99, 'vol2', NULL, 400003, 10000148, 1, 0, 'Pending');

INSERT INTO Request VALUES (100, 'vol2', NULL, 400001, 10000061, 7, 0, 'Pending');
INSERT INTO Request VALUES (101, 'vol2', NULL, 400001, 10000062, 7, 0, 'Pending');
INSERT INTO Request VALUES (102, 'vol2', NULL, 400001, 10000063, 7, 0, 'Pending');
INSERT INTO Request VALUES (103, 'vol2', NULL, 400001, 10000064, 7, 0, 'Pending');
INSERT INTO Request VALUES (104, 'vol2', NULL, 400001, 10000065, 7, 0, 'Pending');
INSERT INTO Request VALUES (105, 'vol2', NULL, 400001, 10000066, 10, 0, 'Pending');
INSERT INTO Request VALUES (106, 'vol2', NULL, 400001, 10000067, 10, 0, 'Pending');

INSERT INTO Request VALUES (107, 'vol3', NULL, 400001, 10000003, 5, 0, 'Pending');
INSERT INTO Request VALUES (143, 'vol3', NULL, 400001, 10000004, 5, 0, 'Pending');
INSERT INTO Request VALUES (109, 'vol3', NULL, 400001, 10000013, 5, 0, 'Pending');
INSERT INTO Request VALUES (110, 'vol3', NULL, 400001, 10000033, 5, 0, 'Pending');
INSERT INTO Request VALUES (111, 'vol3', NULL, 400001, 10000034, 5, 0, 'Pending');

INSERT INTO Request VALUES (112, 'vol3', NULL, 400002, 10000073, 5, 0, 'Pending');
INSERT INTO Request VALUES (113, 'vol3', NULL, 400002, 10000074, 5, 0, 'Pending');
INSERT INTO Request VALUES (114, 'vol3', NULL, 400002, 10000083, 5, 0, 'Pending');
INSERT INTO Request VALUES (115, 'vol3', NULL, 400002, 10000084, 5, 0, 'Pending');
INSERT INTO Request VALUES (116, 'vol3', NULL, 400002, 10000103, 5, 0, 'Pending');

INSERT INTO Request VALUES (117, 'vol3', NULL, 400001, 10000063, 5, 0, 'Pending');
INSERT INTO Request VALUES (118, 'vol3', NULL, 400001, 10000064, 5, 0, 'Pending');
INSERT INTO Request VALUES (119, 'vol3', NULL, 400001, 10000065, 5, 0, 'Pending');
INSERT INTO Request VALUES (120, 'vol3', NULL, 400001, 10000066, 5, 0, 'Pending');
INSERT INTO Request VALUES (121, 'vol3', NULL, 400001, 10000067, 5, 0, 'Pending');
INSERT INTO Request VALUES (122, 'vol3', NULL, 400001, 10000068, 5, 0, 'Pending');
INSERT INTO Request VALUES (123, 'vol3', NULL, 400001, 10000069, 5, 0, 'Pending');

INSERT INTO Request VALUES (124, 'vol3', NULL, 400002, 10000133, 5, 0, 'Pending');
INSERT INTO Request VALUES (125, 'vol3', NULL, 400002, 10000134, 5, 0, 'Pending');
INSERT INTO Request VALUES (126, 'vol3', NULL, 400002, 10000135, 5, 0, 'Pending');
INSERT INTO Request VALUES (127, 'vol3', NULL, 400002, 10000136, 5, 0, 'Pending');
INSERT INTO Request VALUES (128, 'vol3', NULL, 400002, 10000137, 5, 0, 'Pending');
INSERT INTO Request VALUES (129, 'vol3', NULL, 400002, 10000138, 5, 0, 'Pending');
INSERT INTO Request VALUES (130, 'vol3', NULL, 400002, 10000139, 5, 0, 'Pending');


        -- 4 Closed Requests per Employee User
INSERT INTO Request VALUES (131, 'vol1', NULL, 400002, 10000071, 3, 3, 'Closed');
INSERT INTO Request VALUES (132, 'vol1', NULL, 400002, 10000072, 3, 2, 'Closed');
INSERT INTO Request VALUES (133, 'vol1', NULL, 400002, 10000073, 3, 1, 'Closed');
INSERT INTO Request VALUES (134, 'vol1', NULL, 400002, 10000074, 3, 0, 'Closed');

INSERT INTO Request VALUES (135, 'vol2', NULL, 400001, 10000001, 3, 3, 'Closed');
INSERT INTO Request VALUES (136, 'vol2', NULL, 400001, 10000002, 3, 2, 'Closed');
INSERT INTO Request VALUES (137, 'vol2', NULL, 400001, 10000003, 3, 1, 'Closed');
INSERT INTO Request VALUES (138, 'vol2', NULL, 400001, 10000004, 3, 0, 'Closed');

INSERT INTO Request VALUES (139, 'vol3', NULL, 400001, 10000003, 5, 5, 'Closed');
INSERT INTO Request VALUES (140, 'vol3', NULL, 400001, 10000003, 5, 4, 'Closed');
INSERT INTO Request VALUES (141, 'vol3', NULL, 400001, 10000003, 5, 3, 'Closed');
INSERT INTO Request VALUES (142, 'vol3', NULL, 400001, 10000003, 5, 0, 'Closed');
