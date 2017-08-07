SQL Create Table Statements
CS 6400 - Spring 2017
Team 067

CREATE TABLE `User` (
	`Username`	varchar(50) NOT NULL PRIMARY KEY,
	`SiteID`	INTEGER NOT NULL,
	`Password`	varchar(50) NOT NULL,
	`FirstName`	INTEGER NOT NULL,
	`LastName`	INTEGER NOT NULL,
	FOREIGN KEY(`SiteID`) REFERENCES Site
);

CREATE TABLE `Site` (
	`SiteID`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	`ShortName`	varchar(50) NOT NULL,
	`Phone`	varchar(20) NOT NULL,
	`StreetAddress`	varchar(250) NOT NULL,
	`City`	varchar(50) NOT NULL,
	`State`	varchar(20) NOT NULL,
	`Zipcode`	varchar(20) NOT NULL
);

CREATE TABLE `SoupKitchen` (
	`ServiceID`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	`SiteID`	INTEGER NOT NULL,
	`FacilityName`	varchar(250) NOT NULL,
	`HoursOfOperation`	varchar(50) NOT NULL,
	`SeatsCapacity`	INTEGER NOT NULL,
	`SeatsAvailable`	INTEGER NOT NULL,
	FOREIGN KEY(`SiteID`) REFERENCES `Site`
);

CREATE TABLE `SoupKitchenConditionForUse` (
	`ServiceID`	INTEGER NOT NULL,
	`ConditionForUse`	varchar(250) NOT NULL
	FOREIGN KEY(`ServiceID`) REFERENCES `SoupKitchen`
	PRIMARY KEY(`ServiceID`,`ConditionForUse`),
);

CREATE TABLE `FoodPantry` (
	`ServiceID`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	`SiteID`	INTEGER NOT NULL,
	`FacilityName`	varchar(250) NOT NULL,
	`HoursOfOperation`	varchar(50) NOT NULL,
	FOREIGN KEY(`SiteID`) REFERENCES `Site`
);

CREATE TABLE `FoodPantryConditionForUse` (
	`ServiceID`	INTEGER NOT NULL,
	`ConditionForUse`	varchar(250) NOT NULL
	FOREIGN KEY(`ServiceID`) REFERENCES `FoodPantry`
	PRIMARY KEY(`ServiceID`,`ConditionForUse`),
);

CREATE TABLE `Shelter` (
	`ServiceID`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	`SiteID`	INTEGER NOT NULL,
	`FacilityName`	varchar(250) NOT NULL,
	`HoursOfOperation`	varchar(50) NOT NULL,
	`MaleBunkAvailable`	INTEGER NOT NULL,
	`FemaleBunkAvailable`	INTEGER NOT NULL,
	`MixedBunkAvailable`	INTEGER NOT NULL,
	`FamilyRoomAvailable`	INTEGER NOT NULL,
	FOREIGN KEY(`SiteID`) REFERENCES Site
);

CREATE TABLE `ShelterConditionForUse` (
	`ServiceID`	INTEGER NOT NULL,
	`ConditionForUse`	varchar(250) NOT NULL
	FOREIGN KEY(`ServiceID`) REFERENCES `Shelter`
	PRIMARY KEY(`ServiceID`,`ConditionForUse`),
);

CREATE TABLE `FoodBank` (
	`ServiceID`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	`SiteID`	INTEGER NOT NULL
FOREIGN KEY(`SiteID`) REFERENCES Site
);

CREATE TABLE `Request` (
	`RequestID`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	`Username`	INTEGER NOT NULL,
	`TimeStamp`	INTEGER NOT NULL,
	`ServiceID`	INTEGER NOT NULL,
	`ItemID`	INTEGER NOT NULL,
	`ItemQuantity`	INTEGER NOT NULL,
	`ItemProvided`	INTEGER NOT NULL,
	`Status`	INTEGER NOT NULL,
	FOREIGN KEY(`Username`) REFERENCES User,
	FOREIGN KEY(`ServiceID`) REFERENCES FoodBank,
	FOREIGN KEY(`ItemID`) REFERENCES Item
);

CREATE TABLE `Item` (
	`ItemID`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	`ServiceID`	INTEGER NOT NULL,
	`ItemName`	varchar(50) NOT NULL,
	`NumberOfUnits`	INTEGER NOT NULL,
	`ExpirationDate`	date NOT NULL,
	`StorageType`	varchar(50) NOT NULL,
	`Category`	varchar(50) NOT NULL,
	`Subcategory`	varchar(50) NOT NULL,
	FOREIGN KEY(`ServiceID`) REFERENCES FoodBank
);

CREATE TABLE `WaitlistEntry` (
	`ServiceID`	INTEGER NOT NULL,
	`ClientID`	INTEGER NOT NULL,
	`OrderIndex`	INTEGER NOT NULL,
	FOREIGN KEY(`ServiceID`) REFERENCES Shelter,
	FOREIGN KEY(`ClientID`) REFERENCES Client
);

CREATE TABLE `Client` (
	`ClientID`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	`FirstName`	varchar(50) NOT NULL,
	`LastName`	varchar(50) NOT NULL,
	`IDNumber`	varchar(20) NOT NULL,
	`IDDescription`	varchar(250) NOT NULL,
	`IsHeadOfHousehold`	boolean NOT NULL,
	`Phone`	varchar(20) NOT NULL
);

CREATE TABLE `FieldModifiedLogEntry` (
	`ClientID`	INTEGER NOT NULL,
	`TimeStamp`	INTEGER NOT NULL,
	`Description`	varchar(250) NOT NULL,
	PRIMARY KEY(`ClientID`,`TimeStamp`),
	FOREIGN KEY(`ClientID`) REFERENCES `Client`
);

CREATE TABLE `ServiceUsageLogEntry` (
	`ClientID`	INTEGER NOT NULL,
	`TimeStamp`	INTEGER NOT NULL,
	`ServiceType`	varchar(250) NOT NULL,
	PRIMARY KEY(`ClientID`,`TimeStamp`, `ServiceType`),
	FOREIGN KEY(`ClientID`) REFERENCES Client
);

