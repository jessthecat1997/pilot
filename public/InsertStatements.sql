CREATE DATABASE PilotCargoRecords;
GO
USE PilotCargoRecords
GO
CREATE Table Consignee
(
    ConsigneeNo int IDENTITY(0, 1) NOT NULL UNIQUE,
    ConsigneeID AS 'CON-'+CAST(YEAR(DateRegistered)AS VARCHAR)+'-'+RIGHT('0000' + CAST(ConsigneeNo AS VARCHAR(4)), 4) PERSISTED NOT NULL,
    CompanyName VARCHAR(50),
    ContactPerson VARCHAR(150),
    Contact_Email VARCHAR(50),
    Contact_Phone VARCHAR(50),
    Address VARCHAR(50),
	Flag VARCHAR(30) CHECK (Flag In('Active', 'Inactive')) Default 'Active',
	DateRegistered date default getDate()
    PRIMARY KEY (ConsigneeID) 
)

CREATE TABLE Contract
(
    ContractNo int IDENTITY(0, 1) NOT NULL UNIQUE,
    ContractRef AS 'CON-'+RIGHT('000000' + CAST(ContractNo AS VARCHAR(6)), 6) PERSISTED, 
    ConsigneeID VARCHAR(39) NOT NULL UNIQUE,
    ProcessRate NUMERIC(8, 2) NOT NULL,
    DateCreated DATETIME NOT NULL,
    ContractDuration int NOT NULL,
	Flag VARCHAR(30) CHECK (Flag In('Active', 'Inactive')) default 'Active',
    FOREIGN KEY (ConsigneeID) REFERENCES Consignee(ConsigneeID),
    PRIMARY KEY (ContractRef) 
)

CREATE TABLE Area(
	AreaNo int IDENTITY(0, 1) NOT NULL UNIQUE,
	AreaName Varchar(50) NOT NULL,
	DateCreated date default getDate() NOT NULL,
	DateLastUpdated date default getDate(), 
	Flag VARCHAR(30) CHECK (Flag In('Active', 'Inactive')) default 'Active',
	PRIMARY KEY(AreaNo)	
)

CREATE TABLE Rate(
  AreaRateNo int IDENTITY (0, 1) NOT NULL UNIQUE,
  AreaRateRef AS 'RATE-REF-'+RIGHT('000000' + CAST(AreaRateNo AS VARCHAR(6)), 6) PERSISTED, 
  ContractRef VARCHAR (10),
  StartLocation int,
  EndLocation int,
  MinimumRate NUMERIC(15,2),
  MaximumRate NUMERIC(15,2),
  Flag VARCHAR(30) CHECK (Flag in('Active', 'Inactive')) default 'Active',
  FOREIGN KEY(StartLocation) REFERENCES Area(AreaNo),
  FOREIGN KEY(EndLocation) REFERencES Area(AreaNo),
  FOREIGN KEY(ContractRef) REFERENCES Contract(ContractRef),
  PRIMARY KEY (AreaRateRef)
)


CREATE TABLE ServiceOrderType
(
	ServiceOrderTypeNo int IDENTITY(0, 1) NOT NULL UNIQUE,
	ServiceOrderTypeID AS 'SO-TYPE-'+RIGHT('000000' + CAST(ServiceOrderTypeNo AS VARCHAR(6)), 6) PERSISTED,
	ServiceOrderTypeName VARCHAR(50) NOT NULL UNIQUE,
	DateCreated date default getDate() NOT NULL,
	DateLastUpdated date default getDate(), 
	Flag VARCHAR(30) CHECK (Flag IN('Active', 'Inactive')) default 'Active',
	PRIMARY KEY (ServiceOrderTypeID)
)

CREATE TABLE DeliveryType
(
	DeliveryTypeNo int IDENTITY(0, 1) NOT NULL UNIQUE,
	DeliveryTypeID AS 'DEL-TYPE-'+RIGHT('000000' + CAST(DeliveryTypeNo AS VARCHAR(6)), 6) PERSISTED,
	DeliveryTypeName VARCHAR(50) NOT NULL UNIQUE,
	DateCreated date default getDate() NOT NULL,
	DateLastUpdated date default getDate(),
	Flag VARCHAR(30) CHECK (Flag IN('Active', 'Inactive')) Default 'Active',
	PRIMARY KEY (DeliveryTypeID)
)

CREATE TABLE PaymentMode
(
	PaymentModeNo int IDENTITY(0, 1) NOT NULL UNIQUE,
	PaymentModeID AS'PMODE-'+RIGHT('000000' + CAST(PaymentModeNo AS VARCHAR(6)), 6) PERSISTED NOT NULL,  
	PaymentModeName varchar(100) NOT NULL UNIQUE,
	DateCreated date default getDate() NOT NULL,
	DateLastUpdated date default getDate(),
	Flag VARCHAR(30) CHECK (Flag IN('Active', 'Inactive')) DEFAULT 'Active',
	PRIMARY KEY(PaymentModeID)
)

CREATE TABLE PaymentTerm
(
	PaymentTermNo int IDENTITY(0, 1) NOT NULL UNIQUE,
	PaymentTermID AS'PTERM-'+RIGHT('000000' + CAST(PaymentTermNo AS VARCHAR(6)), 6) PERSISTED NOT NULL,  
	PaymentTermValue int NOT NULL,
	DateCreated date default getDate() NOT NULL,
	DateLastUpdated date default getDate(),
	Flag VARCHAR(30) CHECK (Flag IN('Active', 'Inactive')) DEFAULT 'Active',
	PRIMARY KEY(PaymentTermID)
)

CREATE TABLE ServiceOrder
(
	ServiceOrderNo int IDENTITY(0, 1) NOT NULL UNIQUE,
	ServiceOrderID AS'SO-'+CAST(YEAR(ReceiveDate)AS VARCHAR)+'-'+RIGHT('0000' + CAST(ServiceOrderNo AS VARCHAR(4)), 4) PERSISTED NOT NULL,
    ServiceOrderTypeID VARCHAR(14) NOT NULL,
	ConsigneeID VARCHAR(39),
	PickupPoint VARCHAR(20) NOT NULL,
	DestinationPoint VARCHAR(20) NOT NULL,
	PaymentModeID VARCHAR(12) NOT NULL,
	PaymentTermID VARCHAR(12) NOT NULL,
	Deposit NUMERIC(15,2) NOT NULL,
	ReturnContainerTo VARCHAR(30),
	Status VARCHAR(50) default 'Idle' NOT NULL, 
	ReceivedVia VARCHAR(30) CHECK(ReceivedVia IN('Phone Call', 'Email', 'Personal')),
	ReceiveDate date default getDate(),
	Flag VARCHAR(30) CHECK (Flag In('Active', 'Inactive')) DEFAULT 'Active',
	FOREIGN KEY (ConsigneeID) REFERENCES Consignee(ConsigneeID),
	FOREIGN KEY (ServiceOrderTypeID) REFERENCES ServiceOrderType(ServiceOrderTypeID),
	FOREIGN KEY (PaymentTermID) REFERENCES PaymentTerm(PaymentTermID),
	FOREIGN KEY (PaymentModeID) REFERENCES PaymentMode(PaymentModeID),
	PRIMARY KEY(ServiceOrderID)
)

select * from deliverytype


CREATE TABLE PackageType
(
	PackageTypeNo int IDENTITY(0, 1) NOT NULL UNIQUE,
	PackageTypeID AS 'PACK-TYPE-'+RIGHT('000000' + CAST(PackageTypeNo AS VARCHAR(6)), 6) PERSISTED, 
	PackageTypeName VARCHAR(50) NOT NULL UNIQUE,
	DateCreated date default getDate() NOT NULL,
	DateLastUpdated date default getDate(),
	Flag VARCHAR(30) CHECK (Flag IN('Active', 'Inactive')) DEFAULT 'Active',
	PRIMARY KEY(PackageTypeID)
)

CREATE TABLE ContainerType
(
	ContainerTypeNo int IDENTITY(0,1) NOT NULL UNIQUE,
	ContainerTypeID AS 'CONT-TYPE-'+RIGHT('000000' + CAST(ContainerTypeNo AS VARCHAR(6)), 6) PERSISTED, 
	ContainerTypeName VARCHAR(50) NOT NULL UNIQUE,
	DateCreated date default getDate() NOT NULL,
	DateLastUpdated date default getDate(),
	Flag VARCHAR(30) CHECK (Flag IN('Active', 'Inactive')) Default 'Active',
	PRIMARY KEY(ContainerTypeID)
)

CREATE TABLE Container
(
	ContainerNumber varchar(30) NOT NULL UNIQUE,
	ContainerTypeID VARCHAR(16),
	NotifyParty VARCHAR(30) NOT NULL,
	Status VARCHAR(20) CHECK(Status IN('Available', 'In Use')) Default 'Available',
	Flag VARCHAR(30) CHECK(Flag IN('Active', 'Inactive')) Default 'Active',
	FOREIGN KEY (ContainerTypeID) REFERENCES ContainerType(ContainerTypeID),
	PRIMARY KEY(ContainerNumber)
)


CREATE TABLE CargoType
(
	CargoTypeNo int IDENTITY(0, 1) NOT NULL UNIQUE,
	CargoTypeID AS 'CARGO-TYPE-'+RIGHT('000000' + CAST(CargoTypeNo AS VARCHAR(6)), 6) PERSISTED, 
	CargoTypeName VARCHAR(50) NOT NULL UNIQUE,
	DateCreated date default getDate() NOT NULL,
	DateLastUpdated date default getDate(), 
	Flag VARCHAR(30) CHECK (Flag IN('Active', 'Inactive')) DEFAULT 'Active',
	PRIMARY KEY(CargoTypeID)
)

CREATE TABLE Cargo
(

	CargoNo int IDENTITY(0, 1) NOT NULL UNIQUE,
	CargoRef AS 'CARGO-'+RIGHT('000000' + CAST(CargoNo AS VARCHAR(6)), 6) PERSISTED, 
	ServiceOrderID VARCHAR(38) NOT NULL,
	TotalAmmount NUMERIC(18, 2),
	MiscCharges NUMERIC(18, 2),
	TotalInsurnace NUMERIC(18,2),
	TotalFreight NUMERIC(18,2),
	TotalCharges NUMERIC (18,2),
	FOREIGN KEY(ServiceOrderID) REFERENCES ServiceOrder(ServiceOrderID),
	PRIMARY KEY(CargoRef)
)


CREATE TABLE ItemSection(
	ItemSectionNo INT IDENTITY(0,1),
	ItemSectionID AS 'ITEM-SEC-'+RIGHT('000000' + CAST(ItemSectionNo AS VARCHAR(6)), 6) PERSISTED,
    SectionName TEXT,
	Flag varchar(10) DEFAULT 'Active',
	DateCreated DATETIME DEFAULT GETDATE(),
	LastUpdated DATETIME DEFAULT GETDATE(),
    PRIMARY KEY (ItemSectionID)
)

CREATE TABLE ItemCategory(
	ItemCategoryNo INT IDENTITY(0, 1),
	ItemCategoryID AS 'ITEM-CAT-'+RIGHT('000000' + CAST(ItemCategoryNo AS VARCHAR(6)), 6) PERSISTED,
    CategoryName TEXT,
    ItemSectionID VARCHAR(15),
	Flag varchar(10) DEFAULT 'Active',
	DateCreated DATETIME DEFAULT GETDATE(),
	LasUpdatedt DATETIME DEFAULT GETDATE(),
	FOREIGN KEY (ItemSectionID) REFERENCES ItemSection(ItemSectionID),
    PRIMARY KEY(ItemCategoryID)
)

CREATE TABLE Item(
	ItemNo INT IDENTITY (0, 1),
	ItemID AS 'ITEM-'+RIGHT('00000' + CAST(ItemNo AS VARCHAR(6)), 6) PERSISTED,
	ItemName TEXT,
	HSCode VARCHAR(20) NOT NULL UNIQUE,
	DutyRate int NOT NULL,
    ItemCategoryID VARCHAR(15),
	Flag Varchar(10) DEFAULT 'Active',
    DateCreated DATETIME DEFAULT GETDATE(),
	LastUpdated DATETIME DEFAULT GETDATE(),
    FOREIGN KEY (ItemCategoryID) REFERENCES ItemCategory (ItemCategoryID),
    PRIMARY KEY (HSCode)
)




CREATE TABLE CargoContents
(
	CargoContentNo int IDENTITY (0, 1) NOT NULL UNIQUE,
	CargoContentRef AS 'CAR-CONTENT-'+RIGHT('000000' + CAST(CargoContentNo AS VARCHAR(6)), 6) PERSISTED, 
	ItemID	 VARCHAR(20) NOT NULL,
	CargoRef VARCHAR(12) NOT NULL,
	NetAmount NUMERIC(15, 2) NOT NULL,
	Insurance NUMERIC(15, 2) NOT NULL,
	Freight NUMERIC(15, 2) NOT NULL,
	FOREIGN KEY (CargoRef) REFERENCES Cargo(CargoRef),
	FOREIGN KEY (ItemID) REFERENCES Item(HSCode),
	PRIMARY KEY (CargoContentRef)
)

CREATE TABLE Exchange
(
	ExchangeRateNo int IDENTITY (0, 1) NOT NULL UNIQUE,
	ExchangeRateRef AS 'EX-'+RIGHT('000000' + CAST(ExchangeRateNo AS VARCHAR(6)), 6) PERSISTED, 
	ExchangeRate NUMERIC(5,3) NOT NULL,
	DateCreated date default getDate() NOT NULL,
	DateLastUpdated date default getDate(),
	DateEffective date, 
	Flag VARCHAR(30) CHECK (Flag IN('Active', 'Inactive')) DEFAULT 'Active',
	PRIMARY KEY(ExchangeRateRef)
)

CREATE TABLE Vat
(
	VatRateNo int IDENTITY(0,1) NOT NULL UNIQUE,
	VatRateRef AS 'VAT-'+RIGHT('000000' + CAST(VatRateNo AS VARCHAR(6)), 6) PERSISTED, 
	VatRate int NOT NULL,
	DateCreated date default getDate() NOT NULL,
	DateLastupdated date default getDate(),
	PRIMARY KEY(VatRateRef)
)

CREATE TABLE CustomsTaxDecleration
(
	CustomsReferenceNo int IDENTITY(0, 1) NOT NULL UNIQUE,
	CustomsReferenceID AS'DEC-'+CAST(YEAR(DateCreated)AS VARCHAR)+'-'+RIGHT('0000' + CAST(CustomsReferenceNo AS VARCHAR(4)), 4) PERSISTED NOT NULL,
    ConsigneeID VARCHAR(39) NOT NULL,
	ServiceOrderID VARCHAR(38) NOT NULL,
	DutiableValue NUMERIC(15, 2) NOT NULL,
	CustomsDuty NUMERIC(15, 2) NOT NULL,
	BankCharges NUMERIC(15, 2),
	BrokerageFee NUMERIC(15, 2),
	Arrastre NUMERIC(15, 2) NOT NULL,
	Wharfage NUMERIC(15, 2) NOT NULL,
	CDS NUMERIC (15, 2) NOT NULL,
	STAMPS NUMERIC(15, 2) NOT NULL,
	IPF NUMERIC (15, 2) NOT NULL,
	TotalLandedCost NUMERIC(15, 2) NOT NULL,
	VatRateRef varchar(10) NOT NULL,
	TotalTax NUMERIC (15, 2) NOT NULL,
	LessDeposit NUMERIC (15, 2),
	GrandTotal NUMERIC(15, 2) NOT NULL,
	DateCreated date default getDate(),
	FOREIGN KEY(VatRateRef) REFERENCES Vat(VatRateRef),
	FOREIGN KEY(ConsigneeID) REFERENCES Consignee(ConsigneeID),
	FOREIGN KEY(ServiceOrderID) REFERENCES ServiceOrder(ServiceOrderID),	
	PRIMARY KEY(CustomsReferenceID)
)

CREATE TABLE CargoTax
(
	CargoTaxNo int IDENTITY(0, 1) NOT NULL UNIQUE,
	CargoTaxReference AS'CARGO-TAX-'+RIGHT('000000' + CAST(CargoTaxNo AS VARCHAR(6)), 6) PERSISTED NOT NULL,
	CustomsReferenceID VARCHAR(39) NOT NULL,
	ServiceOrderID VARCHAR(38) NOT NULL,
	ItemID VARCHAR(20) NOT NULL,
	ExportValue NUMERIC(15,2) NOT NULL,
	Insurance NUMERIC(15, 2) NOT NULL,
	FreightValue NUMERIC(15,2) NOT NULL,
	TotalValue NUMERIC(15, 2) NOT NULL,
	DutiablePesoValue NUMERIC (15,2) NOT NULL,
	CustomsDuty NUMERIC(15,2) NOT NULL,
	ExchangeRateRef VARCHAR(9) NOT NULL,
    FOREIGN KEY(ExchangeRateRef) REFERENCES Exchange(ExchangeRateRef),
    FOREIGN KEY(ItemID) REFERENCES Item(HSCode),
    FOREIGN KEY(CustomsReferenceID) REFERENCES CustomsTaxDecleration(CustomsReferenceID),
    PRIMARY KEY(CargoTaxReference)
)


CREATE TABLE EmployeeType
(
	EmployeeTypeNo int IDENTITY(0, 1) NOT NULL UNIQUE,
	EmployeeTypeID AS 'EMP-TYPE-'+RIGHT('000000' + CAST(EmployeeTypeNo AS VARCHAR(6)), 6) PERSISTED, 
	EmployeeTypeName VARCHAR(50) NOT NULL UNIQUE,
	DateRegistered date default getDate() NOT NULL,
	DateLastUpdated date default getDate(),
	Flag VARCHAR(30) CHECK (Flag IN('Active', 'Inactive')) default 'Active',
	PRIMARY KEY (EmployeeTypeID) 
)


Create Table Employee
(
	EmployeeNo int IDENTITY(0, 1) NOT NULL UNIQUE,
	EmployeeID AS 'EMPLOYEE-'+RIGHT('000000' + CAST(EmployeeNo AS VARCHAR(6)), 6) PERSISTED, 
	Employee_FirstName VARCHAR(50) NOT NULL,
	Employee_LastName VARCHAR(50) NOT NULL,
	Employee_MiddleName VARCHAR(50),
	EmployeeTypeID VARCHAR(15),
	Flag VARCHAR(30) CHECK (Flag IN('Active', 'Inactive')) DEFAULT 'Active',
	FOREIGN KEY (EmployeeTypeID) REFERENCEs EmployeeType(EmployeeTypeID),
	PRIMARY KEY(EmployeeID),	
)

CREATE TABLE Charges
(
	ChargeNo int IDENTITY(0, 1) NOT NULL UNIQUE,
	ChargeID AS 'CH-'+RIGHT('000000' + CAST(ChargeNo AS VARCHAR(6)), 6) PERSISTED, 
	ChargeName VARCHAR(50), 
	ChargeType VARCHAR(30) CHECK (ChargeType IN('Fees', 'Penalty')) NOT NULL,
	DateCreated date default getDate() NOT NULL,
	DateLastUpdated date default getDate(),
	Flag VARCHAR(30) CHECK (Flag IN('Active', 'Inactive')) default 'Active',
	PRIMARY KEY(ChargeID)
)

CREATE TABLE RenderedCharges
(
	ChargeNo int IDENTITY(0, 1) NOT NULL UNIQUE,
	TransactionChargeRef AS 'REND-'+RIGHT('000000' + CAST(ChargeNo AS VARCHAR(6)), 6) PERSISTED, 
	ServiceOrderID VARCHAR(38) NOT NULL,
	ChargeName VARCHAR(9) NOT NULL,
	Ammount NUMERIC(10, 2) NOT NULL, 
	DateProcessed date default getDate(),  	
	FOREIGN KEY(ServiceOrderID) REFERENCES ServiceOrder(ServiceOrderID),	
	FOREIGN KEY(ChargeName) REFERENCES Charges(ChargeID),
	PRIMARY KEY(TransactionChargeRef)
)

CREATE TABLE Invoice
(
	InvoiceNo int IDENTITY(0, 1) NOT NULL UNIQUE,
	InvoiceRef AS'INV-'+CAST(YEAR(DateCreated)AS VARCHAR)+'-'+RIGHT('0000' + CAST(InvoiceNo AS VARCHAR(4)), 4) PERSISTED NOT NULL,
   	InvoiceTypeName VARCHAR(30) Check (InvoiceTypeName IN('Billing', 'Refundable', 'Brokerage Fee')),
	ConsigneeID VARCHAR(39),
	ServiceOrderID VARCHAR(38),
	DateCreated date default getDate() NOT NULL,
	DateLastUpdated date default getDate(),
	Total NUMERIC(15, 2) NOT NULL,
	FOREIGN KEY(ConsigneeID) REFERENCES Consignee(ConsigneeID),
	FOREIGN KEY(ServiceOrderID) REFERENCES ServiceOrder(ServiceOrderID),
	PRIMARY KEY(InvoiceRef)
)


CREATE TABLE InvoiceDetails
(
	InvoiceDetailsNo int IDENTITY(0, 1) NOT NULL UNIQUE,
	InvoiceDetailsRef AS'INV-DET-'+RIGHT('000000' + CAST(InvoiceDetailsNo AS VARCHAR(6)), 6) PERSISTED NOT NULL,
    InvoiceRef VARCHAR(39),
	TransactionChargeRef VARCHAR(11),
	FOREIGN KEY(TransactionChargeRef) REFERENCES RenderedCharges(TransactionChargeRef),
	FOREIGN KEY(InvoiceRef) REFERENCES Invoice(InvoiceRef),
	PRIMARY KEY(InvoiceDetailsRef)
)

CREATE TABLE Payment
(
	PaymentNo int IDENTITY(0, 1) NOT NULL UNIQUE,
	PaymentID AS'PAYMENTREF-'+CAST(YEAR(DateCreated)AS VARCHAR)+'-'+RIGHT('0000' + CAST(PaymentNo AS VARCHAR(4)), 4) PERSISTED NOT NULL,
	ConsigneeID VARCHAR(39),
	InvoiceRef VARCHAR(39),
	PaymentType VARCHAR(30),
	Ammount NUMERIC(15, 2),
	DateCreated date default getDate(),
	FOREIGN KEY(ConsigneeID) REFERENCES Consignee(ConsigneeID),
	FOREIGN KEY(InvoiceRef) REFERENCES Invoice(InvoiceRef),
	PRIMARY KEY(PaymentID)
)

CREATE TABLE EmployeeAssignments
(	
	EmployeeAssignmentNo int IDENTITY(0, 1) NOT NULL UNIQUE,
	EmployeeAssignmentRef AS 'EMP-SO-'+RIGHT('000000' + CAST(EmployeeAssignmentNo AS VARCHAR(6)), 6) PERSISTED NOT NULL,
	ServiceOrderID VARCHAR(38) NOT NULL,
	EmployeeID VARCHAR(15) NOT NULL,
	TaskName VARCHAR(50) NOT NULL,
	StartDate date NOT NULL,
	EndDate date NOT NULL,
	FOREIGN KEY(ServiceOrderID) REFERENCES ServiceOrder(ServiceOrderID),
	FOREIGN KEY(EmployeeID) REFERENCES Employee(EmployeeID),
	PRIMARY KEY(EmployeeAssignmentRef) 
)

CREATE TABLE VehicleType
(
	VehicleTypeNo int IDENTITY(0, 1) NOT NULL UNIQUE,
	VehicleTypeID AS 'VEHICLE-TYPE-'+RIGHT('000000' + CAST(VehicleTypeNo AS VARCHAR(6)), 6) PERSISTED NOT NULL,
	VehicleTypeName VARCHAR(50) NOT NULL UNIQUE,
	DateCreated date default getDate() NOT NULL,
	DateLastUpdated date default getDate(),
	Flag VARCHAR(30) CHECK (Flag IN('Active', 'Inactive')) Default 'Active',
	PRIMARY KEY(VehicleTypeID)
)

CREATE TABLE Vehicle
(
	VehiclePlateNo VARCHAR(15) NOT NULL UNIQUE,
	VehicleTypeID VARCHAR(19) NOT NULL,
	ModelName VARCHAR(30) NOT NULL,
	Flag VARCHAR(30) CHECK (Flag in ('Active', 'Inactive')) Default 'Active',
	FOREIGN KEY (VehicleTypeID)  REFERENCES VehicleType(VehicleTypeID),
	PRIMARY KEY (VehiclePlateno) 
)

CREATE TABLE VehicleAssignments
(
	VehicleAssignmentNo int IDENTITY(0, 1) NOT NULL UNIQUE,
	VehicleAssignmentRef AS 'VEH-'+RIGHT('000000' + CAST(VehicleAssignmentNo AS VARCHAR(6)), 6) PERSISTED NOT NULL,
	ServiceOrderID Varchar(38) NOT NULL, 
	VehiclePlateNo VARCHAR(15),
	ContainerNumber VARCHAR(30) NOT NULL,
	FOREIGN KEY (ServiceOrderID) REFERENCES ServiceOrder(ServiceOrderID),
	FOREIGN KEY (ContainerNumber) REFERENCES Container(ContainerNumber),
	FOREIGN KEY (VehiclePlateNo) REFERENCES Vehicle(VehiclePlateNo),
	PRIMARY KEY(VehicleAssignmentRef) 
)

CREATE TABLE DeliverySchedule
(
	DeliverySchedNo int IDENTITY(0, 1) NOT NULL UNIQUE,
	DeliverySchedRefNo AS'DEL-SCHED'+RIGHT('000000' + CAST(DeliverySchedNo AS VARCHAR(6)), 6) PERSISTED NOT NULL,
	ServiceOrderID VARCHAR(38) NOT NULL,
	EmployeeAssignmentRef VARCHAR(13) NOT NULL,
	VehicleAssignmentRef VARCHAR(10) NOT NULL,
	PickupPoint VARCHAR(50) NOT NULL,
	DestinationPoint VARCHAR(50) NOT NULL,
	StartDate date NOT NULL,
	EndDate date NOT NULL,
	FOREIGN KEY(ServiceOrderID) REFERENCES ServiceOrder(ServiceOrderID),
	FOREIGN KEY(EmployeeAssignmentRef) REFERENCES EmployeeAssignments(EmployeeAssignmentRef),
	FOREIGN KEY(VehicleAssignmentRef) REFERENCES VehicleAssignments(VehicleAssignmentRef),
	PRIMARY KEY(DeliverySchedRefNo)
)

CREATE TABLE CommercialInvoice
(
	CommercialInvoiceNo varchar(50) NOT NUlL UNIQUE,
	CargoRef varchar(12) NOT NULL,
	FOREIGN KEY(CargoRef) REFERENCES Cargo(CargoRef),
	PRIMARY KEY(CommercialInvoiceNo)
)
CREATE TABLE BillOfLading
(
	BillOfLadingNo varchar(50) NOT NULL UNIQUE,
	ServiceOrderID varchar(38) NOT NULL,
	OceanVessel varchar(50) NOT NULL,
	PortOfLoading varchar(50) NOT NULL,
	PlaceOfReceipt varchar(50),
	PortOfDischarge varchar(50) NOT NULL,
	PlaceOfDelivery varchar(50),
	ContainerLoad varchar(50) NOT NULL,
	ScopeOfIssuance varchar(50) NOT NULL,
	FreightCharges varchar(50) NOT NULL,
	ShipmentSubjectedTo varchar(50) NOT NULL,
	FOREIGN KEY(ServiceOrderID) REFERENCES ServiceOrder(ServiceOrderID),
	PRIMARY KEY(BillOfLadingNo)
)

CREATE TABLE CargoDescription
(
	CargoDescNo int IDENTITY(0, 1) NOT NULL UNIQUE,
	CargoDescID AS'CARGO-DESC-'+RIGHT('000000' + CAST(CargoDescNo AS VARCHAR(6)), 6) PERSISTED NOT NULL,
	BillOfLadingNo varchar(50) NOT NULL,
	CargoTypeID varchar(17) NOT NULL,
	ContainerTypeID varchar(16) NOT NULL,
	PackageTypeID varchar(16) NOT NULL,
	NoOfPackages int NOT NULL,
	DescriptionOfGoods text,
	GrossWeight NUMERIC (10, 2)NOT NULL,
	FOREIGN KEY (BillOfLadingNo) REFERENCES BillOfLading(BillOfLadingNo),
	FOREIGN KEY (CargoTypeID) REFERENCES CargoType(CargoTypeID),
	FOREIGN KEY (ContainerTypeID) REFERENCES ContainerType(ContainerTypeID),
	FOREIGN KEY (PackageTypeID) REFERENCES PackageType(PackageTypeID),
	PRIMARY KEY (CargoDescID)
)


CREATE TABLE PackingList
(
	PackingListNo varchar(30) NOT NULL UNIQUE,
	ServiceOrderID varchar(38) NOT NULL UNIQUE,
	NetWeight NUMERIC (15, 2) NOT NULL,
	GrossWeight NUMERIC (15, 2) NOT NULL,
	TotalCarton NUMERIC(15, 2) NOT NULL,
	FOREIGN KEY (ServiceOrderID) REFERENCES ServiceOrder(ServiceOrderID),
	PRIMARY KEY (PackingListNo)
)

CREATE TABLE PackingListDescription
(
  PLDescNo int IDENTITY(0,1) NOT NULL UNIQUE,
  PLDescID AS 'PL-DESC-'+RIGHT('000000' + CAST(PLDescNo AS VARCHAR(6)), 6) PERSISTED NOT NULL,
  PackingListNo varchar(30) NOT NULL,
  PartNo varchar(15) NOT NULL,
  Description text, 
  PackageTypeID varchar(16) NOT NULL, 
  NetWeight NUMERIC (15, 2) NOT NULL,
  GrossWeight NUMERIC (15, 2) NOT NULL,
  TotalPack NUMERIC(15, 2) NOT NULL,
  FOREIGN KEY(PackageTypeID) REFERENCES PackageType(PackageTypeID),
  FOREIGN KEY(PackingListNo) REFERENCES PackingList(PackingListNo),
  PRIMARY KEY(PLDescNo)
)

SET IDENTITY_INSERT Consignee ON
INSERT INTO Consignee (ConsigneeNo, CompanyName, ContactPerson, Contact_Email, Contact_Phone, Address)
VALUES(1, 'Sample Company Name',  'Sample Contact Person', 'Sample Email', 'Sample Phone', 'Sample Address')
SET IDENTITY_INSERT Consignee OFF
GO

SET IDENTITY_INSERT Contract ON
INSERT INTO Contract (ContractNo, ConsigneeID, ProcessRate, DateCreated, ContractDuration)
VALUES(1, 'CON-2017-0001',  100000.00, 'January 1, 2017', 5)
SET IDENTITY_INSERT Contract OFF
GO


SET IDENTITY_INSERT Area ON
INSERT INTO Area (AreaNo, AreaName)
VALUES(1, 'Sample Area Name')
SET IDENTITY_INSERT Area OFF
GO

INSERT INTO AREA(AreaName)
VALUES('Sample Area Name 2')

SET IDENTITY_INSERT Rate ON
INSERT INTO Rate (AreaRateNo, ContractRef, StartLocation, EndLocation, MaximumRate, MinimumRate)
VALUES(1, 'CON-000001', 1, 2, 1000.0001, 2000.00)
SET IDENTITY_INSERT Rate OFF
GO
	
SET IDENTITY_INSERT ServiceOrderType ON
INSERT INTO ServiceOrderType (ServiceOrderTypeNo, ServiceOrderTypeName)
VALUES(1,  'Brokerage')
SET IDENTITY_INSERT ServiceOrderType OFF
GO

INSERT INTO ServiceOrderType(ServiceOrderTypeName)
VALUES('Trucking')

INSERT INTO ServiceOrderType(ServiceOrderTypeName)
VALUES('Brokerge and Trucking')

	select * from Container
SET IDENTITY_INSERT Exchange ON
INSERT INTO Exchange (ExchangeRateNo, ExchangeRate)
VALUES(1,  50.00)
SET IDENTITY_INSERT Exchange OFF
GO

SET IDENTITY_INSERT DeliveryType ON
INSERT INTO DeliveryType (DeliveryTypeNo, DeliveryTypeName)
VALUES(1,  'Domestic')
SET IDENTITY_INSERT DeliveryType OFF
GO
select * from paymentterm
SET IDENTITY_INSERT PaymentMode ON
INSERT INTO PaymentMode (PaymentModeNo, PaymentModeName)
VALUES(1,  'Cash')
SET IDENTITY_INSERT PaymentMode OFF
GO

INSERT INTO PaymentMode (PaymentModeName)
VALUES( 'Bank')

SET IDENTITY_INSERT PaymentTerm ON
INSERT INTO PaymentTerm (PaymentTermNo, PaymentTermValue)
VALUES(1,  15)
SET IDENTITY_INSERT PaymentTerm OFF
GO

select * from ServiceOrder
SET IDENTITY_INSERT ServiceOrder ON
INSERT INTO ServiceOrder(ServiceOrderNo, ServiceOrderTypeID, PaymentModeID, PaymentTermID, ConsigneeID, PickupPoint, DestinationPoint,  Deposit, ReceivedVia, flag)
VALUES(1, 'SO-TYPE-000001', 'PMODE-000001','PTERM-000001', 'CON-2017-0001', 'Pier', 'Sample Area',  555000.00, 'Phone Call', 'Active')
SET IDENTITY_INSERT ServiceOrder OFF
GO

SET IDENTITY_INSERT PackageType ON
INSERT INTO PackageType(PackageTypeNo, PackageTypeName)
VALUES(1, 'Carton')
SET IDENTITY_INSERT PackageType OFF
GO

INSERT INTO PackageType(PackageTypeName)
VALUES('Bulk')

INSERT INTO PackageType(PackageTypeName)
VALUES('Unit')

SET IDENTITY_INSERT ContainerType ON
INSERT INTO ContainerType(ContainerTypeNo, ContainerTypeName)
VALUES(1, '1x20')
SET IDENTITY_INSERT ContainerType OFF
GO
select * from ContainerType
INSERT INTO ContainerType(ContainerTypeName)
VALUES('1x40')

INSERT INTO Container(ContainerNumber, ContainerTypeID, NotifyParty)
VALUES('WBPU400006000', 'CONT-TYPE-000001', 'Powerfreight Logistics Servics')


SET IDENTITY_INSERT CargoType ON
INSERT INTO CargoType(CargoTypeNo, CargoTypeName)
VALUES(1, 'Dry Bulk')
SET IDENTITY_INSERT CargoType OFF
GO

INSERT INTO CargoType(CargoTypeName)
VALUES('Liquid Builk')

INSERT INTO CargoType(CargoTypeName)
VALUES('Container Cargo')

-- ---------------------------
SET IDENTITY_INSERT Cargo ON
INSERT INTO Cargo (CargoNo, ServiceOrderID ) VALUES (1, 'SO-2017-0001');
SET IDENTITY_INSERT Cargo OFF
Go
-- --------------------------
-- Insertss For all sections


INSERT INTO itemsection (sectionname) values ('Live Animals; Animal Products');
INSERT INTO itemsection (sectionname) values ('Vegetable Products');
INSERT INTO itemsection (sectionname) values ('ANIMAL OR VEGETABLE FATS AND OILS AND THEIR CLEAVAGE PRODUCTS;
PREPARED EDIBLE FATS; ANIMAL OR VEGETABLE WAXES ');
INSERT INTO itemsection (sectionname) values ('PREPARED FOODSTUFFS; BEVERAGES, SPIRITS AND VINEGAR;
TOBACCO AND MANUFACTURED TOBACCO SUBSTITUTES ');
INSERT INTO itemsection (sectionname) values ('MINERAL PRODUCTS');
INSERT INTO itemsection (sectionname) values ('PRODUCTS OF THE CHEMICAL OR ALLIED INDUSTRIES');
INSERT INTO itemsection (sectionname) values ('PLASTICS AND ARTICLES THEREOF; RUBBER AND ARTICLES THEREOF');
INSERT INTO itemsection (sectionname) values ('RAW HIDES AND SKINS, LEATHER, FURSKINS AND ARTICLES THEREOF;
SADDLERY AND HARNESS; TRAVEL GOODS, HANDBAGS AND SIMILAR CONTAINERS;
ARTICLES OF ANIMAL GUT (OTHER THAN SILK-WORM GUT)');
INSERT INTO itemsection (sectionname) values ('WOOD AND ARTICLES OF WOOD; WOOD CHARCOAL; CORK AND ARTICLES OF CORK;
MANUFACTURES OF STRAW, OF ESPARTO OR OF OTHER PLAITING MATERIALS;
BASKETWARE AND WICKERWORK ');
INSERT INTO itemsection (sectionname) values ('PULP OF WOOD OR OF OTHER FIBROUS CELLULOSIC MATERIAL;
WASTE AND SCRAP OF PAPER OR PAPERBOARD;
PAPER AND PAPERBOARD AND ARTICLES THEREOF');
INSERT INTO itemsection (sectionname) values ('TEXTILES AND TEXTILE ARTICLES ');
INSERT INTO itemsection (sectionname) values ('FOOTWEAR, HEADGEAR, UMBRELLAS, SUN UMBRELLAS, WALKING-STICKS,
SEAT-STICKS, WHIPS, RIDING-CROPS AND PARTS THEREOF;
PREPARED FEATHERS AND ARTICLES MADE THEREWITH;
ARTIFICIAL FLOWERS; ARTICLES OF HUMAN HAIR
');
INSERT INTO itemsection (sectionname) values ('ARTICLES OF STONE, PLASTER, CEMENT, ASBESTOS, MICA OR SIMILAR MATERIALS;
CERAMIC PRODUCTS; GLASS AND GLASSWARE'); 
INSERT INTO itemsection (sectionname) values ('NATURAL OR CULTURED PEARLS, PRECIOUS OR SEMI-PRECIOUS STONES, PRECIOUS METALS,
METALS CLAD WITH PRECIOUS METAL AND ARTICLES THEREOF;
IMITATION JEWELLERY; COIN');
INSERT INTO itemsection (sectionname) values ('BASE METALS AND ARTICLES OF BASE METAL ');
INSERT INTO itemsection (sectionname) values ('MACHINERY AND MECHANICAL APPLIANCES; ELECTRICAL EQUIPMENT; PARTS THEREOF;
SOUND RECORDERS AND REPRODUCERS, TELEVISION IMAGE AND SOUND RECORDERS
AND REPRODUCERS, AND PARTS AND ACCESSORIES OF SUCH ARTICLES
');
INSERT INTO itemsection (sectionname) values ('VEHICLES, AIRCRAFT, VESSELS AND ASSOCIATED TRANSPORT EQUIPMENT ');
INSERT INTO itemsection (sectionname) values ('OPTICAL, PHOTOGRAPHIC, CINEMATOGRAPHIC, MEASURING, CHECKING, PRECISION,
MEDICAL OR SURGICAL INSTRUMENTS AND APPARATUS; CLOCKS AND WATCHES;
MUSICAL INSTRUMENTS; PARTS AND ACCESSORIES THEREOF ');
INSERT INTO itemsection (sectionname) values ('ARMS AND AMMUNITION; PARTS AND ACCESSORIES THEREOF ');
INSERT INTO itemsection (sectionname) values ('MISCELLANEOUS MANUFACTURED ARTICLES ');
INSERT INTO itemsection (sectionname) values ('WORKS OF ART, COLLECTORS' +' PIECES AND ANTIQUES ');

-- Chapter 1
-- ------------------------------------------------------------------------------
INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Live horses, asses, mules and hinnies. ', 'ITEM-SEC-000000');
INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Live bovine animals. ', 'ITEM-SEC-000000');
INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Live animals.', 'ITEM-SEC-000000');
 
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Horses Pure-bredbreeding animals', '0010.21.00', 3, 'ITEM-CAT-000000');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Horses Other', '0011.29.00', 7, 'ITEM-CAT-000000');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Asses Pure-bred breeding animals', '0101.30.10', 5, 'ITEM-CAT-000000');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Asses Other', '0101.30.90', 5, 'ITEM-CAT-000000');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other', '0101.90.00', 5, 'ITEM-CAT-000000');


INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Cattle  Pure-bred breeding animals', '0102.21.00', 1, 'ITEM-CAT-000001');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Male Cattle (including oxen)', '0102.29.10', 3, 'ITEM-CAT-000001');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other Cattle', '0102.29.90', 3, 'ITEM-CAT-000001');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Buffalo  Pure-bred breeding animals', '0102.31.00', 1, 'ITEM-CAT-000002');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Buffalo Other', '0102.39.00', 3, 'ITEM-CAT-000002');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other Pure-bred breeding animals', '0102.90.10', 1, 'ITEM-CAT-000002');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other', '0102.90.90', 5, 'ITEM-CAT-000002');


-- -----------------------------------------------------------
-- -Chapter 2

INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Meat of bovine animals, fresh or chilled.', 'ITEM-SEC-000000');
INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Meat of bovine animals, frozen', 'ITEM-SEC-000000');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Boneless', '0202.30.00', 10, 'ITEM-CAT-000003');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Boneless frozen', '0203.30.00', 10, 'ITEM-CAT-000004');
-- Same goes
-- -------------------------------------------------------------

INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Live fish', 'ITEM-SEC-000000');
INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Fish, fresh or chilled, excluding fish fillets
and other fish meat of heading 03.04', 'ITEM-SEC-000000');
-- - Kulang pa ng Category for Chapter 3

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Ornamental fish freshwater fry', '0301.11.10', 3, 'ITEM-CAT-000005');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Ornamental fish freshwater fry Other: Koi Carp (Cyprinus carpio)', '0301.11.91', 3, 'ITEM-CAT-000005');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Ornamental fish freshwater fry Other: Goldfish (Carassius auratus)', '0301.11.92', 3, 'ITEM-CAT-000005');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Ornamental fish freshwater fry Other: Siamese fighting fish (Beta splendens)', '0301.11.93', 3, 'ITEM-CAT-000005');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Ornamental fish freshwater fry Other: Oscars (Astonotus ocellatus)', '0301.11.94', 3, 'ITEM-CAT-000005');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Ornamental fish freshwater fry Other: Arowanas (Sckeropages formosus)', '0301.11.95', 3, 'ITEM-CAT-000005');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Salmonidae, Trout(Salmo Trutta, Oncorhynchus mykiss,
Oncorhynchus clarki, Oncrohynchus aguabonita, Oncorhynchus gilae,
Oncorhynchus apache and Oncorhynchus chrysogaster','0302.11.00', 3, 'ITEM-CAT-000006');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Salmonidae, Pacific Salmon(Salmo Trutta, Oncorhynchus nerka,
Oncorhynchus gorbuscha, Oncrohynchus keta, Oncorhynchus tschawytscha,
Oncorhynchus kisutch, Oncorhynchus rhodorus and Oncorhynchus masou','0302.12.00', 3, 'ITEM-CAT-000006');

-- ---------------------------------------------------------------
-- Chapter 4
INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Milk and cream, not concentrated nor containing added sugar or other sweetening matter', 'ITEM-SEC-000000');
INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Milk and cream, concentrated or containing added sugar or other sweetening matter', 'ITEM-SEC-000000');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Of a fat content, by weight, not exceeding 1% in liquid form', '0401.10.10', 3, 'ITEM-CAT-000007');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Of a fat content, by weight, not exceeding 1% in other form', '0401.10.90', 3, 'ITEM-CAT-000007');


INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('In powder, granules or other solid forms, of a fat content, by weight, not exceeding 1.5%,
Not containing added sugar or other sweetening matther. In containers of a gross weight of 20kg or more', '0402.10.41', 1, 'ITEM-CAT-000008');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('In powder, granules or other solid forms, of a fat content, by weight, not exceeding 1.5%,
Not containing added sugar or other sweetening matther. Other', '0402.10.49', 1, 'ITEM-CAT-000008');



-- --------------------------------------------------------------
-- Chapter 5

INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Human hair, unworked, whether or not washed or scoured; waste of human hair.', 'ITEM-SEC-000000');
INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Pigs, hogs or boars bristles and haiir; badger hair and other brush making hair; waste of such bristles of hair. Pigs, hogs pr boars bristles and hair, and waste thereof', 'ITEM-SEC-000000');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Human hair, unworked, whether or not washed or scoured; waste of human hair.', '0501.00.00', 3, 'ITEM-CAT-000009');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Pigs, hogs or boars bristles and haiir; badger hair and other brush making hair; waste of such bristles of hair. Pigs, hogs pr boars bristles and hair, and waste thereof', '0502.00.00', 3, 'ITEM-CAT-000010');


-- ---------------------

-- Chapter 6
INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Bulbs, tubers, tuberous roots, corns, crowns and rhizomes, dormant, in growth or in flower; chicory plants and roots other than roots of heading 12.12.', 'ITEM-SEC-000001');
INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Other live plants (including their roots), cuttings and slips; mushroom spawns', 'ITEM-SEC-000001');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Bulbs, tubers, tuberous roots, corms, crowns and rhizomes, dormant', '0601.10.00', 1, 'ITEM-CAT-000011');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Bulbs, tubers, tuberous roots, corms, crowns andn rhizomes, in growth or in flower; chicory plants and roots chicory plants', '0601.20.10', 1, 'ITEM-CAT-000011');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Bulbs, tubers, tuberous roots, corms, crowns andn rhizomes, in growth or in flower; chicory plants and roots chicory roots', '0601.20.20', 1, 'ITEM-CAT-000011');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Bulbs, tubers, tuberous roots, corms, crowns andn rhizomes, in growth or in flower; chicory plants and roots chicory other', '0601.20.90', 1, 'ITEM-CAT-000011');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Unrooted cuttings and slips of orchids', '0602.10.10', 1, 'ITEM-CAT-000011');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Unrooted cuttings and slips of rubber trees', '0602.10.20', 1, 'ITEM-CAT-000011');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Unrooted cuttings and slips of other', '0602.10.90', 1, 'ITEM-CAT-000011');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Trees, shrubs and bushes, grafted or not, of kinds which bear edible fruits or nots', '0602.20.00', 1, 'ITEM-CAT-000012');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Rhododendrons and azaleas, grafted or not','0602.30.00', 1, 'ITEM-CAT-000012');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Roses, grafted or not','0602.40.00', 1, 'ITEM-CAT-000012');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other rooted orchid cuttings and slips','0602.90.10', 3, 'ITEM-CAT-000012');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other orchid seedlings','0602.90.20', 3, 'ITEM-CAT-000012');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other budded stumps of the genus Hevea','0602.90.40', 3, 'ITEM-CAT-000012');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other Seedlings of the genus Hevea','0602.90.50', 3, 'ITEM-CAT-000012');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other Budwood of the genus Hevea','0602.90.60', 3, 'ITEM-CAT-000012');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other Leatherleaf ferns','0602.90.70', 3, 'ITEM-CAT-000012');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other Other','0602.90.90', 3, 'ITEM-CAT-000012');



-- -------------------------

-- Chapter 7
INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Potatoes, fresh or chilled.', 'ITEM-SEC-000001');
INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Tomatoes, fresh or chilled', 'ITEM-SEC-000001');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Seed','0701.10.00', 1,'ITEM-CAT-000013');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other In quota','0701.90.00A', 40, 'ITEM-CAT-000013');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other Out quota','0701.90.00B', 40, 'ITEM-CAT-000013');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Tomatoes, fresh or chilled', '0702.00.00', 10, 'ITEM-CAT-000014');



-- -----------------------------

-- Chapter 8

INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Coconuts, Brazil nuts and cashew nuts, fresh or dried, whether or not shelled or peeled.', 'ITEM-SEC-000001');
INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Other nuts, fresh or dried, whether or not shelled or peeled', 'ITEM-SEC-000001');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Coconuts Desiccated','0801.11.00', 15, 'ITEM-CAT-000015');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Coconuts in the inner shell (endocarp)','0801.12.00', 15, 'ITEM-CAT-000015');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Coconuts Others','0801.19.00', 15, 'ITEM-CAT-000015');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Brazil nuts in shell','0801.21.00', 3, 'ITEM-CAT-000015');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Brazil nuts shelled','0801.22.00', 3, 'ITEM-CAT-000015');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Cashew nuts in shell','0801.31.00', 7, 'ITEM-CAT-000015');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Cashew nuts shelled','0801.32.00', 7, 'ITEM-CAT-000015');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Almonds in shell','0802.11.00', 3, 'ITEM-CAT-000016');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Almonds shelled','0802.12.00', 3, 'ITEM-CAT-000016');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Hazelnuts or filberts (Corylus spp.): in shell','0802.21.00', 3, 'ITEM-CAT-000016');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Hazelnuts or filberts (Corylus spp.): shelled','0802.22.00', 3, 'ITEM-CAT-000016');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Walnuts in shell','0802.31.00', 3, 'ITEM-CAT-000016');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Walnuts shelled','0802.32.00', 3, 'ITEM-CAT-000016');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Chestnuts (Castanea spp.): in shell','0802.41.00', 3, 'ITEM-CAT-000016');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Chestnuts (Castanea spp.): shelled','0802.42.00', 3, 'ITEM-CAT-000016');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Pistachios in shell','0802.51.00', 3, 'ITEM-CAT-000016');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Pistachios shelled','0802.52.00', 3, 'ITEM-CAT-000016');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Macademia nuts in shell','0802.61.00', 3, 'ITEM-CAT-000016');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Macademia nuts shelled','0802.62.00', 3, 'ITEM-CAT-000016');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Kola nuts (Cola spp.)','0802.70.00', 3, 'ITEM-CAT-000016');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Areca nuts','0802.80.00', 3, 'ITEM-CAT-000016');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other','0802.90.00', 3, 'ITEM-CAT-000016');


-- ------------------------------------------------------------------
-- Chapter 9

INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Coffee, whether or not roasted or not decaffeinated; coffe husks and skins; coffee substitutes containing coffee in any proportion.', 'ITEM-SEC-000001');
INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Tea, whether or not flavoured', 'ITEM-SEC-000001');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Coffee, not roasted: not decaffeinated, Arabica WIB or Robusta OIB: In Quota','0901.11.10A', 30, 'ITEM-CAT-000017');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Coffee, not roasted: not decaffeinated, Arabica WIB or Robusta OIB: OUt Quota','0901.11.10B', 40, 'ITEM-CAT-000017');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Coffee, not roasted: not decaffeinated, Other: OUt Quota','0901.11.90A', 30, 'ITEM-CAT-000017');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Coffee, not roasted: not decaffeinated, Other: OUt Quota','0901.11.90B', 40, 'ITEM-CAT-000017');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Coffee, not roasted: decaffeinated, Arabica WIB or Robusta OIB: In Quota','0901.12.10A', 30, 'ITEM-CAT-000017');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Coffee, not roasted: decaffeinated, Arabica WIB or Robusta OIB: OUt Quota','0901.12.10B', 40, 'ITEM-CAT-000017');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Coffee, not roasted: not decaffeinated, Other: OUt Quota','0901.12.90A', 30, 'ITEM-CAT-000017');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Coffee, not roasted: not decaffeinated, Other: OUt Quota','0901.12.90B', 40, 'ITEM-CAT-000017');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Coffee, roasted: not decaffeinated unground: In Quota', '0901.21.10A', 40, 'ITEM-CAT-000017');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Coffee, roasted: not decaffeinated unground: Out Quota', '0901.21.10B', 40, 'ITEM-CAT-000017');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Coffee, roasted: not decaffeinated ground: In Quota', '0901.21.20A', 40, 'ITEM-CAT-000017');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Coffee, roasted: not decaffeinated ground: Out Quota', '0901.21.20B', 40, 'ITEM-CAT-000017');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Coffee, roasted: decaffeinated unground: In Quota', '0901.22.10A', 40, 'ITEM-CAT-000017');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Coffee, roasted: decaffeinated unground: Out Quota', '0901.22.10B', 40, 'ITEM-CAT-000017');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other Cofee husks and skins: In Quota', '0901.90.10A', 40, 'ITEM-CAT-000017');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other Cofee husks and skins: Out Quota', '0901.90.10B', 40, 'ITEM-CAT-000017');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other Cofee substitutes containing coffee: In Quota', '0901.90.20A', 40, 'ITEM-CAT-000017');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other Cofee substitutes containing coffee: In Quota', '0901.90.20B', 40, 'ITEM-CAT-000017');

-- 2nd inserts
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Green tea (not fermented) in immediate packagings of a content not exceeding 3kg: Leaves', '0902.10.10', 3, 'ITEM-CAT-000018');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Green tea (not fermented) in immediate packagings of a content not exceeding 3kg: Other', '0902.10.90', 3, 'ITEM-CAT-000018');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other green tea (not fermented): Leaves', '0902.20.10', 3, 'ITEM-CAT-000018');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other green tea (not fermented): Other', '0902.20.90', 3, 'ITEM-CAT-000018');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Black tea (fermented) and partly fermented team in immediate packings of a content not exceeding 3kg: Leaves', '0902.30.10', 3, 'ITEM-CAT-000018');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Black tea (fermented) and partly fermented team in immediate packings of a content not exceeding 3kg: Other', '0902.30.90', 3, 'ITEM-CAT-000018');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other black tea (fermented) and other partly fermented tea: Leaves', '0902.40.10', 3, 'ITEM-CAT-000018');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other black tea (fermented) and other partly fermented tea: Other', '0902.40.90', 3, 'ITEM-CAT-000018');

-- --------------------------------------------------------------
-- ---Ch. 10
INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Wheat and meslin', 'ITEM-SEC-000001');
INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Rye', 'ITEM-SEC-000001');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Durum wheat seed', '1001.11.00', 0, 'ITEM-CAT-000019');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Durum wheat other', '1001.19.00', 0, 'ITEM-CAT-000019');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other seed', '1001.91.00', 7, 'ITEM-CAT-000019');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other other fit for human consumption meslin', '1001.99.11', 3, 'ITEM-CAT-000019');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other other fit for human consumption other', '1001.99.19', 0, 'ITEM-CAT-000019');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other other other', '1001.99.90', 0, 'ITEM-CAT-000019');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other other other meslin', '1001.99.90A', 3, 'ITEM-CAT-000019');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other other other other', '1001.99.90B', 7, 'ITEM-CAT-000019');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Seed', '1002.10.00', 7, 'ITEM-CAT-000020');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other', '1002.90.00', 7, 'ITEM-CAT-000020');
-- ---------------------

-- -Ch. 11
INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Wheat or meslin flour', 'ITEM-SEC-000001');
INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Cereal flours other than of wheat or meslin', 'ITEM-SEC-000001');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Wheat flour', '1101.00.10', 7, 'ITEM-CAT-000021');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Meslin flour', '1101.00.20', 7, 'ITEM-CAT-000021');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Maize (corn) flour', '1102.20.00', 10, 'ITEM-CAT-000022');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other rice flour', '1102.90.10', 10, 'ITEM-CAT-000022');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other rye flour', '1102.90.20', 7, 'ITEM-CAT-000022');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other other', '1102.90.90', 7, 'ITEM-CAT-000022');
-- ------------------------------
-- ---- Ch. 12
INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Soya beans, whether or not broken', 'ITEM-SEC-000001');
INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Ground-nuts, not roasted or otherwise cooked, whether or not shelled or broken', 'ITEM-SEC-000001');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Seed', '1201.10.00', 1, 'ITEM-CAT-000023');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other', '1201.90.00', 1, 'ITEM-CAT-000023');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Seed', '1202.30.00', 15, 'ITEM-CAT-000024');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other in shell', '1202.41.00', 15, 'ITEM-CAT-000024');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other shelled, whether or not broken', '1202.42.00', 15, 'ITEM-CAT-000024');

-- ---------------------------------------------
-- -Ch. 13
INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Lac; natural gums, resins, gum-resins and oleoresins (for example, balsams)', 'ITEM-SEC-000003');
INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Vegetable saps and extracts; pectic substance, pectinates and peccctates; agaragar and other mucilages and thickeners, whether or not modified, derived from vegetable products', 'ITEM-SEC-000003');


INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Gum arabic', '1301.20.00', 1, 'ITEM-CAT-000025');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other gum benjamin', '1301.90.10', 1, 'ITEM-CAT-000025');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other gum damar', '1301.90.20', 1, 'ITEM-CAT-000025');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other cannabis resins', '1301.90.30', 1, 'ITEM-CAT-000025');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other lac', '1301.90.40', 1, 'ITEM-CAT-000025');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other other', '1301.90.90', 1, 'ITEM-CAT-000025');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Vegetable saps and extracts opium pulvis opii', '1302.11.10', 3, 'ITEM-CAT-000026');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Vegetable saps and extracts opium other', '1302.11.90', 3, 'ITEM-CAT-000026');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Vegetable saps and extracts of liqourice', '1302.12.00', 3, 'ITEM-CAT-000026');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Vegetable saps and extracts of hops', '1302.13.00', 1, 'ITEM-CAT-000026');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Vegetable saps and extracts other extracts and tinctures of cannabis', '1302.19.20', 3, 'ITEM-CAT-000026');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Vegetable saps and extracts other other medicinal extracts', '1302.19.30', 3, 'ITEM-CAT-000026');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Vegetable saps and extracts other vegetable saps and extracts of pyrethrum or of the roots of plants containing rotenone', '1302.19.40', 3, 'ITEM-CAT-000026');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Vegetable saps and extracts other japan (or chinese) lacquer (natural lacquer)', '1302.19.50', 3, 'ITEM-CAT-000026');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Vegetable saps and extracts other other', '1302.19.90', 3, 'ITEM-CAT-000026');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Pectic substance, pectinates and pectaries', '1302.20.00', 3, 'ITEM-CAT-000026');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Mucilages and thickeners, whether or not modified, derived from vegetable products agar-agar', '1302.31.00', 3, 'ITEM-CAT-000026');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Mucilages and thickeners, whether or not modified, derived from vegetable products Mucilages and thickeners, whether or not modified, derived from locust beans, locust bean seeds or guar seeds', '1302.32.00', 3, 'ITEM-CAT-000026');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Mucilages and thickeners, whether or not modified, derived from vegetable products other carrageenan', '1302.39.10', 7, 'ITEM-CAT-000026');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Mucilages and thickeners, whether or not modified, derived from vegetable products other other', '1302.39.90', 1, 'ITEM-CAT-000026');

-- ----------------------------------------
-- --
-- -Ch.14

INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Vegetable materials of a kind used primarily for plaiting (for example, bamboos, rattans, reeds, rushes, osier ,ralfis, cleaned, bleached or dyed cereal straw, and lime bark', 'ITEM-SEC-000001');
INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Vegetable products not elsewhere specified or included', 'ITEM-SEC-000001');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Bamboos', '1401.10.00', 3, 'ITEM-CAT-000027');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Rattans whole raw', '1401.20.11', 3, 'ITEM-CAT-000027');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Rattans whole washed and sulphurised', '1401.20.12', 3, 'ITEM-CAT-000027');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Rattan whole other', '1401.20.29', 3, 'ITEM-CAT-000027');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Rattans split-skin', '1401.20.30', 3, 'ITEM-CAT-000027');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Rattans other', '1401.20.90', 3, 'ITEM-CAT-000027');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other', '1401.90.00', 3, 'ITEM-CAT-000027');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Cotton linters', '1402.20.00', 3, 'ITEM-CAT-000028');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other of a kind used primaly in tanning or dyeing', '1402.90.20', 3, 'ITEM-CAT-000028');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other kapok', '1402.90.30', 7, 'ITEM-CAT-000028');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other other', '1402.90.90', 3, 'ITEM-CAT-000028');
-- ----------------------------------------

-- Ch.15

INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Pig fat (including lard) and poultry fat, other than that of heading 02.09 or 15.03', 'ITEM-SEC-000002');
INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Fats of bovine animals, sheep or goats, other than those of heading 15.03', 'ITEM-SEC-000002');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Lard', '1501.10.00', 3, 'ITEM-CAT-000029');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other pig fat', '1501.20.00', 3, 'ITEM-CAT-000029');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other', '1501.90.00', 3, 'ITEM-CAT-000029');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Tallow edible', '1502.10.10', 3, 'ITEM-CAT-000030');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Tallow other', '1502.10.90', 3, 'ITEM-CAT-000030');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other Edible', '1502.90.10', 3, 'ITEM-CAT-000030');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other other', '1502.90.90', 3, 'ITEM-CAT-000030');
-- --------------------------------------
-- -Ch. 16

INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Sausages and similar products, of meat, meat offal or blood; food preparations based pn these products', 'ITEM-SEC-000003');
INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Other prepared or preserved meat, meat offal or blood', 'ITEM-SEC-000003');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('In alright containers', '1601.00.10', 40, 'ITEM-CAT-000031');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other', '1601.00.90', 40, 'ITEM-CAT-000031');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Homogenised preparations containing pork, in airight containers', '1602.10.10', 45, 'ITEM-CAT-000032');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Homogenised preparations other','1602.20.10', 45, 'ITEM-CAT-000032');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Of liver of any animal', '1602.21.10', 40, 'ITEM-CAT-000032');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Of poultry of heading of turkeys in airtight containers', '1602.31.10', 40, 'ITEM-CAT-000032');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Of poultry heading of turkeys other mechanically deboned or separated meat', '1602.31.91', 40, 'ITEM-CAT-000032');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Of poultry heading of turkey other other', '1602.31.99', 40, 'ITEM-CAT-000032');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Of poultry heading of the fowls of the species gallus domesticus: chicken curry, in airtight containers', '1602.32.10', 40, 'ITEM-CAT-000032');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Of poultry heading of the fowls of the species gallus domesticus: other: in airtight containers', '1602.32.90A', 40, 'ITEM-CAT-000032');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Of poultry heading of the fowls of the species gallus domesticus: other: other', '1602.39.90B', 40, 'ITEM-CAT-000032');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Of poultry heading other in airtight container', '1602.39.00A', 40, 'ITEM-CAT-000032');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Of poultry heading other other', '1602.39.00B', 40, 'ITEM-CAT-000032');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Of swine hams and cuts thereof in airtight containers', '1602.41.10', 40, 'ITEM-CAT-000032');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Of swine hams and cuts thereof other', '1602.41.90', 40, 'ITEM-CAT-000032');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Of swine shoulders and cuts thereof in airtight containers', '1602.42.10', 40, 'ITEM-CAT-000032');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Of swine shoulders and cuts thereof other', '1602.42.90', 40, 'ITEM-CAT-000032');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Of swine other including mixtures luncheon meat in airtight containers', '1602.49.11', 40, 'ITEM-CAT-000032');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Of swine other including mixtures luncheon meat other', '1602.49.19', 40, 'ITEM-CAT-000032');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Of swine other in airtight containers', '1602.49.91', 40, 'ITEM-CAT-000032');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Of swine other other', '1602.49.99', 40, 'ITEM-CAT-000032');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Of bovine animals', '1602.50.00', 35, 'ITEM-CAT-000032');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other, including preparations of blood of any animal: mutton curry, in airtight container', '1602.90.10', 35, 'ITEM-CAT-000032');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other, inlcuding preparations of blood of any animal: other in airtight containers', '1602.90.90A', 35, 'ITEM-CAT-000032');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other, inlcuding preparations of blood of any animal: other other', '1602.90.90B', 35, 'ITEM-CAT-000032');
-- -----------------------------
-- --- 
-- Chapter 17
INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Cane or beet sugar and chemically pure sucrose, in solid form.', 'ITEM-SEC-000004');
INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Other sugars, including chemically pure lactose, maltose, glucose, and fructose
in solid form; sugar syrups not containing added flavouring or colouring matter; artificial honey, whether or not
mixed with natural honey; caramel.', 'ITEM-SEC-000004');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Raw sugar not containing added flavouring or colouring matter: Beet sugar: In Quota', '1701.12.00A', 50, 'ITEM-CAT-000033');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Raw sugar not containing added flavouring or colouring matter: Beet sugar: Out Quota', '1701.12.00B', 50, 'ITEM-CAT-000033');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Raw sugar not containing added flavouring or colouring matter: Cane sugar specified in Subheading note 2 to this chapter: In Quota', '1701.13.00A', 50, 'ITEM-CAT-000033');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Raw sugar not containing added flavouring or colouring matter: Cane sugar specified in Subheading note 2 to this chapter: Out Quota', '1701.13.00B', 65, 'ITEM-CAT-000033');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Raw sugar not containing added flavouring or colouring matter: Other cane sugar: In Quota', '1701.14.00A', 50, 'ITEM-CAT-000033');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Raw sugar not containing added flavouring or colouring matter: Other cane sugar: Out Quota', '1701.14.00B', 65, 'ITEM-CAT-000033');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other Containing added flavouring or colouring matter: Containing over 65% by fry weight of sugar, In Quota', '1701.91.00A', 50, 'ITEM-CAT-000033');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other Containing added flavouring or colouring matter: Containing over 65% by fry weight of sugar, Out Quota', '1701.91.00B', 50, 'ITEM-CAT-000033');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other Containing added flavouring or colouring matter: Other, In Quota', '1701.91.00C', 1, 'ITEM-CAT-000033');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other Containing added flavouring or colouring matter: Other, Out Quota', '1701.91.00D', 1, 'ITEM-CAT-000033');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other: Other: Refined Sugar: White: COntaining over 65% by dry weight of sugar, In Quota ', '1701.99.11A', 50, 'ITEM-CAT-000033');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other: Other: Refined Sugar: White: COntaining over 65% by dry weight of sugar, Out Quota ', '1701.99.11B', 65, 'ITEM-CAT-000033');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other: Other: Refined Sugar: White: Other, In Quota', '1701.99.11C', 1, 'ITEM-CAT-000033');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other: Other: Refined Sugar: White: Other, Out Quota', '1701.99.11D', 1, 'ITEM-CAT-000033');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other: Other: Refined Sugar: Other: Containing over 65% by dry weight of sugar In Quota', '1701.99.19A', 50, 'ITEM-CAT-000033');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other: Other: Refined Sugar: Other: Containing over 65% by dry weight of sugar Out Quota', '1701.99.19B', 65, 'ITEM-CAT-000033');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other: Other: Refined Sugar: Other: Other: In Quota', '1701.99.19C', 1, 'ITEM-CAT-000033');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other: Other: Refined Sugar: Other: Other: Out Quota', '1701.99.19D', 1, 'ITEM-CAT-000033');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other: Other: Other: In Quota', '1701.99.90A', 50, 'ITEM-CAT-000033');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other: Other: Other: In Quota', '1701.99.90B', 65, 'ITEM-CAT-000033');


-- ----
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Lactose and lactose syrup: Containing by weight 99% or more lactose,
expressed as anhydrous lactose, calculated on the dry matter', '1702.11.00', 1, 'ITEM-CAT-000034');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Lactose and lactose syrup: Other', '1702.19.00', 3, 'ITEM-CAT-000034');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Maple sugar and maple syrup', '1702.20.00', 7, 'ITEM-CAT-000034');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Glucose and glucose syrup, not containing fructose or containing
in the dry state less than 20% by weight of fructose: Glucose', '1702.30.10', 3, 'ITEM-CAT-000034');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Glucose and glucose syrup, not containing fructose or containing
in the dry state less than 20% by weight of fructose: Glucose Syrup', '1702.30.20', 3, 'ITEM-CAT-000034');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Glucose and glucose syrup, containing in the dry state at least 20% 
but less than 50% by weight of fructose, excluding invert sugar', '1702.40.00', 3, 'ITEM-CAT-000034');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES('Chemically pure fructose', '1702.50.00', 3, 'ITEM-CAT-000034');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other fructose and fructose syrup, containing in the dry state
more than 50% by weight of fructose, excluding invert sugar: Fructose ', '1702.60.10', 7, 'ITEM-CAT-000034');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other fructose and fructose syrup, containing in the dry state
more than 50% by weight of fructose, excluding invert sugar: Fructose Syrup ', '1702.60.20', 7, 'ITEM-CAT-000034');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other, including invert sugar and other sugar and sugar syrup blends
containing in the dry state 50% by weight of fructose: Maltose and maltose syrups: Chemically pure maltose', '1702.90.11', 3, 'ITEM-CAT-000034');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other, including invert sugar and other sugar and sugar syrup blends
containing in the dry state 50% by weight of fructose: Maltose and maltose syrups: Other', '1702.90.19', 3, 'ITEM-CAT-000034');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other, including invert sugar and other sugar and sugar syrup blends
containing in the dry state 50% by weight of fructose: Artificial honey, whether or not mixed with natural honey', '1702.90.20', 3, 'ITEM-CAT-000034');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other, including invert sugar and other sugar and sugar syrup blends
containing in the dry state 50% by weight of fructose: Flavoured or coloured sugars (excluding maltose)', '1702.90.30', 3, 'ITEM-CAT-000034');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other, including invert sugar and other sugar and sugar syrup blends
containing in the dry state 50% by weight of fructose: Caramel', '1702.90.40', 3, 'ITEM-CAT-000034');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other, including invert sugar and other sugar and sugar syrup blends
containing in the dry state 50% by weight of fructose: Other :Syrups ', '1702.90.91', 3, 'ITEM-CAT-000034');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other, including invert sugar and other sugar and sugar syrup blends
containing in the dry state 50% by weight of fructose: Other :Syrups ', '1702.90.99', 3, 'ITEM-CAT-000034');
-- ------------------------------------------------
-- --Ch.18

INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Cocoa beans, whole or broken, raw or roasted', 'ITEM-SEC-000004');
INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Cocoa shells, husks, skins and other cocoa waste', 'ITEM-SEC-000004');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Cocoa beans, whole or broken, raw or roasted', '1801.00.00', 3, 'ITEM-CAT-000035');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Cocoa shells, husks, skins, and other cocoa wastes', '1802.00.00', 3, 'ITEM-CAT-000036');
-- -------------------------------------------------
-- ----------------------

-- Chapter 19
-- -------------------------------------------------
INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Malts extract: food preparations of flour, groats,
meal, starch or malt extract, not containing cocoa or containing less than 40% by weight of cocoa calculated on a totally defatted
basis, not elsewhere specified or included; food preparations of goods of headings 04.01 to 04.04, not containing cocoa or containing
less than 5% by weight of cocoa calculated on a totally defatted basisis, not elsewhere specified or included', 'ITEM-SEC-000004');
INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Pasta, whhether or not cooked or stuffed (with meat or other substances)
or otherwise prepared, such as spaghetti, macaroni, noodles, lasagna, gnocchi, ravioli, cannelloni; couscous,
whether or not prepared.', 'ITEM-SEC-000004');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Preparations for infant use, put up for retail sale: of malt extract', '1901.10.10', 7, 'ITEM-CAT-000037');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Preparations for infant use, put up for retail sale: of goods of headings 04.01 to 04.04', '1901.10.20', 7, 'ITEM-CAT-000037');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Preparations for infant use, put up for retail sale: of soya-bean powder', '1901.10.30', 7, 'ITEM-CAT-000037');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Preparations for infant use, put up for retail sale: other medical foods', '1901.10.91', 7, 'ITEM-CAT-000037');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Preparations for infant use, put up for retail sale: other other', '1901.10.99', 7, 'ITEM-CAT-000037');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Mixes and doughs for the preparations of bakers' +' wares of heading: of flour, groats, meal, starch or malt extract, not containing cocoa', '1901.20.10', 10, 'ITEM-CAT-000037');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Mixes and doughs for the preparations of bakers'+' wares of heading: of flour, groats, meal, starch or malt extract, containing cocoa', '1901.20.20', 10, 'ITEM-CAT-000037');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Mixes and doughs for the preparations of bakers'+ ' wares of heading: other, not containing cocoa', '1901.20.30', 10, 'ITEM-CAT-000037');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Mixes and doughs for the preparations of bakers' + ' wares of heading: other containing cocoa', '1901.20.40', 10, 'ITEM-CAT-000037');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other: preparations for infant use, not put up for retail sale: medical foods', '1901.90.11', 1, 'ITEM-CAT-000037');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other: preparations for infant use, not put up for retail sale: other', '1901.90.19', 1, 'ITEM-CAT-000037');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other: malt extract', '1901.90.20', 1, 'ITEM-CAT-000037');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other: other, of goods of heading 04.01 to 04.04: filled milk', '1901.90.31', 7, 'ITEM-CAT-000037');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other: other, of goods of heading 04.01 to 04.04: other, containing cocoa powder', '1901.90.32', 7, 'ITEM-CAT-000037');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other: other, of goods of heading 04.01 to 04.04: other', '1901.90.39', 7,'ITEM-CAT-000037');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other: other soya-based preparations: in powder form', '1901.90.41', 3, 'ITEM-CAT-000037');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other: other soya-based  preparations: in other forms', '1901.90.49', 3, 'ITEM-CAT-000037');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other: other: medical foods', '1901.90.91', 7, 'ITEM-CAT-000037');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other: other: other', '1901.90.99', 7, 'ITEM-CAT-000037');


INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Uncooked pasta, not stuffed or otherwise prepared: Containing eggs', '1902.11.00', 15, 'ITEM-CAT-000038');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Uncooked pasta, not stuffed or otherwise prepared: Other: Rice vermicilli (bee hoon)', '1902.19.20', 15, 'ITEM-CAT-000038');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Uncooked pasta, not stuffed or otherwise prepared: Other: Transparent vermicelli', '1902.19.30', 15, 'ITEM-CAT-000038');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Uncooked pasta, not stuffed or otherwise prepared: Other: Noodles', '1902.19.40', 15, 'ITEM-CAT-000038');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Uncooked pasta, not stuffed or otherwise prepared: Other', '1902.19.90', 15, 'ITEM-CAT-000038');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Stuffed pasta, whether or not cooked or otherwise prepared: Stuffed with meat or meat offal', '1902.20.10', 15, 'ITEM-CAT-000038');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Stuffed pasta, whether or not cooked or otherwise prepared: Stuffed with fish, crustaceans or molluscs', '1902.20.30', 15, 'ITEM-CAT-000038');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Stuffed pasta, whether or not cooked or otherwise prepared: Other', '1902.20.90', 15, 'ITEM-CAT-000038');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other pasta: Instant rice vermilli', '1902.30.20', 15, 'ITEM-CAT-000038');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other pasta: Transparent vermilli', '1902.30.30', 15, 'ITEM-CAT-000038');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other pasta: Other instant noodles', '1902.30.40', 15, 'ITEM-CAT-000038');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other pasta: Other', '1902.30.90', 15, 'ITEM-CAT-000038');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Couscous', '1902.40.00', 10, 'ITEM-CAT-000038');

-- -Ch. 20

INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Vegetables, fruits, nuts and other edible parts of plants, prepared or preserved by vinegar or acetic acid', 'ITEM-SEC-000004');
INSERT INTO ItemCategory (CategoryName, ItemSectionID) VALUES ('Tomatoes prepared or preserved otherwise than by vinegar or acetic acid', 'ITEM-SEC-000004');

INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Cucumbers and gherkins', '2001.10.00', 15, 'ITEM-CAT-000039');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other onions', '2001.90.10', 15, 'ITEM-CAT-000039');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other  other', '2001.90.90', 15, 'ITEM-CAT-000039');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Tomatoes, whole or in pieces: cooked otherwise than by steaming or boiling in water', '2002.10.10', 10, 'ITEM-CAT-000040');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Tomatoes, whole or in pieces: other', '2022.10.90', 10, 'ITEM-CAT-000040');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other tomato paste', '2002.90.10', 10, 'ITEM-CAT-000040');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other tomato powder', '2002.90.20', 3, 'ITEM-CAT-000040');
INSERT INTO Item (ItemName, HSCode, DutyRate, ItemCategoryID) VALUES ('Other other', '2002.90.90', 15, 'ITEM-CAT-000040');




select * from cargo
SET IDENTITY_INSERT CargoContents ON
INSERT INTO CargoContents(CargoContentNo, ItemID, CargoRef,  NetAmount, Insurance, Freight)
VALUES(2,  '0010.21.00', 'CARGO-000001', 500.00, 50, 50)
SET IDENTITY_INSERT CargoContents OFF
GO

--- --------------------------

--Exchange

--Vat

--CustomsTaxDecleration

--CargoTax

SET IDENTITY_INSERT EmployeeType ON
INSERT INTO EmployeeType(EmployeeTypeNo, EmployeeTypeName)
VALUES(1, 'Driver')
SET IDENTITY_INSERT EmployeeType OFF
GO

SET IDENTITY_INSERT Employee ON
INSERT INTO Employee(EmployeeNo, Employee_FirstName,  Employee_LastName, EmployeeTypeID)
VALUES(1, 'Sample employee firstN 1', 'sample employee lastN 2', 'EMP-TYPE-000001')
SET IDENTITY_INSERT Employee OFF
GO

-- Rendered Charges

--Invoice

--InvoiceDetails


SET IDENTITY_INSERT EmployeeAssignments ON
INSERT INTO EmployeeAssignments(EmployeeAssignmentNo, ServiceOrderID,  EmployeeID, TaskName, StartDate, EndDate)
VALUES(1, 'SO-2017-0001', 'EMPLOYEE-000001', 'Pickup cargo', '1/9/2017', '1/10/2017')
SET IDENTITY_INSERT EmployeeAssignments OFF
GO

SET IDENTITY_INSERT VehicleType ON
INSERT INTO VehicleType(VehicleTypeNo, VehicleTypeName)
VALUES(1, 'Truck')
SET IDENTITY_INSERT VehicleType OFF
GO	

INSERT INTO Vehicle(VehiclePlateNo, VehicleTypeID, ModelName)
VALUES('AAA-001', 'VEHICLE-TYPE-000001', 'Nissan V10')

SET IDENTITY_INSERT VehicleAssignments ON
INSERT INTO VehicleAssignments(VehicleAssignmentNo, ServiceOrderID, VehiclePlateNo, ContainerNumber)
VALUES(1, 'SO-2017-0001', 'AAA-001', 'WBPU400006000')
SET IDENTITY_INSERT VehicleAssignments OFF
GO	

SET IDENTITY_INSERT DeliverySchedule ON
INSERT INTO DeliverySchedule(DeliverySchedNo, ServiceOrderID, EmployeeAssignmentRef, VehicleAssignmentRef, PickupPoint, DestinationPoint, StartDate, EndDate)
VALUES(1, 'SO-2017-0001', 'EMP-SO-000001', 'VEH-000001', 'Pier', 'Sample Area Name', '2/9/2017', '2/10/2017')
SET IDENTITY_INSERT DeliverySchedule OFF
GO	

