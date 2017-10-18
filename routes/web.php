<?php
Route::get('/login','LoginController@home');
Route::post('/login/prelogin','LoginController@validateUsers');
Route::get('/login/postlogin','LoginController@postLogin');
Route::get('/logout','LoginController@logout');
Route::post('/login/validateUsers','LoginController@validateUsers');
Route::get('/tlogin','LoginController@thome');
Route::post('/login/tvalidateUsers','LoginController@tvalidateUsers');

Route::group(['middleware' => ['admin']], function() {
			//Maintenance
	Route::get('/', 'DashboardController@index');
	Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');
	Route::resource('/employees/{employee_id}/incidents', 'EmployeeIncidentsController');
	Route::resource('/employees/{employee_id}/accidents', 'EmployeeAccidentsController');
	Route::resource('/employees', 'EmployeesController');
	Route::resource('/employees/newemployee', 'EmployeesController');
	Route::post('/StoreEmployee', 'EmployeesController@store')->name('EmployeeSave');
	Route::get('/employees/{employee_id}/view', 'EmployeesController@view_employee', function ($from_new = null) {
		return $from_new;});
	Route::get('/employees/{employee_id}/edit', 'EmployeesController@edit_employee');

	Route::get('/employeeData', 'DatatablesController@employee_datatable')->name('employee.data');
	Route::post('/storeUser', 'EmployeesController@store_user')->name('UserStore');

//Brokerage Routes

	Route::resource('consignee', 'ConsigneesController');
	Route::post('CreateConsignee', 'ConsigneesController@store')->name('createconsignee');



//Maintenance Routes

	Route::resource('/admin/vehicletype', 'VehicleTypesController');
	Route::resource('/admin/service_ordertype', 'ServiceOrderTypesController');
	Route::resource('/admin/brokerage_status_type', 'BrokerageStatusTypesController');
	Route::resource('/admin/container_type', 'ContainerTypesController');
	Route::resource('/admin/exchange_rate', 'ExchangeRatesController');
	Route::resource('/admin/vehicle','VehiclesController');
	Route::put('/admin/vehicle/{id}/{plateNumber?}', 'VehiclesController@v_update');
	Route::resource('/admin/billing', 'BillingsController');
	Route::resource('/admin/charge','ChargesController');
	Route::resource('/admin/brokerage_fee', 'BrokerageFeesController');
	Route::resource('/admin/cds_fee','CdsFeesController');
	Route::resource('/admin/ipf_fee','ImportProcessingFeesController');
	Route::resource('/admin/arrastre_fee', 'ArrastreFeesController');
	Route::resource('/admin/wharfage_fee', 'wharfageFeesController');
	Route::resource('/admin/cargo_type', 'CargoTypesController');
	Route::resource('/admin/standard_arearates','StandardAreaRatesController');
	Route::resource('/admin/bank_account','BankAccountsController');
	Route::resource('/admin/location_province','LocationProvincesController');
	Route::resource('/admin/location_city','LocationCitiesController');
	Route::post('/admin/location_city/new_province', 'LocationCitiesController@new_province');
	Route::resource('/admin/attachment_type','RequirementsController');
	Route::resource('/admin/arrastre_fee','ArrastreFeesController');
	Route::resource('/admin/lcl_type','LclTypesController');
	Route::resource('/admin/basis_type','BasisTypeController');
	Route::resource('/admin/dangerous_cargo_type','DangerousCargoTypeController');
	Route::resource('/admin/wharfage_fee','WharfageFeeController');
	Route::resource('/admin/wharfage_fee_lcl','WharfageFeeLclController');
	Route::resource('/admin/arrastre_fee_lcl','ArrastreFeeLclController');
	Route::resource('/admin/arrastre_fee_dc','ArrastreFeeDcController');
	Route::resource('/admin/section','SectionsController');
	Route::resource('/admin/category','CategoryTypesController');
	Route::resource('/admin/item','ItemsController');


		//Reports
	Route::resource('/reports/shipment', 'ShipmentReportsController');
	Route::resource('/reports/delivery', 'DeliveryReportsController');
	Route::resource('/reports/billing_rep', 'BillingReportsController');
	Route::get('/reports/shipmentData', 'DatatablesController@shipment_datatable')->name('shipment.data');
	Route::get('/reports/deliveryData/{frequency?}', 'DatatablesController@delivery_datatable')->name('delivery.data');
	Route::get('/reports/billrepData', 'BillingReportsController@bill_table')->name('billRep.data');
	Route::get('/reports/delivery/del_pdf/{blank?}/{status?}/{frequency?}/{date_from?}/{date_to?}', 'DeliveryReportsController@delivery_pdf_report');
	Route::get('/reports/billing/bill_pdf/{blank?}/{status?}/{frequency?}/{date_from?}/{date_to?}', 'BillingReportsController@billing_pdf_report');
	Route::get('reports/shipment/print/{frequency}', 'ShipmentReportsController@print');

		//Queries
	Route::get('queries', 'QueriesController@index')->name('queries.index');
	Route::get('queries/get_active_contract/{status?}', 'DatatablesController@get_active_contract')->name('get_active_contract');
	Route::get('queries/get_peMM<nding_deliveries/{status?}', 'DatatablesController@get_pending_deliveries')->name('get_pending_deliveries');
	Route::get('queries/get_unreturned_containers', 'DatatablesController@get_unreturned_containers')->name('get_unreturned_containers');
	Route::get('queries/get_query_bills/{status?}', 'DatatablesController@get_query_bills')->name('get_query_bills');
	Route::get('queries/get_finished_trucking_orders', 'DatatablesController@get_finished_trucking_orders')->name('get_finished_trucking_orders');
	Route::get('queries/get_expiring_vehicle_registrations', 'DatatablesController@get_expiring_vehicle_registrations')->name('get_expiring_vehicle_registrations');

		//Utilities
	Route::resource('/utilities/settings','UtilityController');
//Utilities Routes
	Route::resource('/utilities/settings','UtilitiesBrokerageController');


	Route::resource('/utilities/employee', 'EmployeesController');
	Route::resource('/utilities/employee/{employee}/view', 'EmployeeRolesController');
	Route::get('/utilities/cds_fee_deactivated/{filter}','DatatablesController@cds_deactivated');
	Route::get('/utilities/cds_fee_data','CdsFeesController@cds_utilities')->name('cds_fee.utilities_index');
	Route::put('/utilities/cds_fee_reactivate/{id}','CdsFeesController@reactivate');
	Route::get('/utilities/brokerage_fee_deactivated/{filter}',
		'DatatablesController@bf_deactivated');
	Route::get('/utilities/brokerage_fee_data','BrokerageFeesController@bf_utilities')->name('brokerage_fee.utilities_index');
	Route::put('/utilities/brokerage_fee_reactivate/{id}','BrokerageFeesController@reactivate');
	Route::get('/utilities/charge_deactivated/{filter}',
		'DatatablesController@ch_deactivated');
	Route::get('/utilities/charge_data','ChargesController@ch_utilities')->name('charges.utilities_index');
	Route::put('/utilities/charge_reactivate/{id}','ChargesController@reactivate');
	Route::get('/utilities', 'UtilityController@utility_index')->name('utilities_index');
	Route::get('/utilities/container_type_deactivated/{filter}','DatatablesController@ct_deactivated');
	Route::get('/utilities/container_type_data','ContainerTypesController@ct_utilities')->name('container_type.utilities_index');
	Route::put('/utilities/container_type_reactivate/{id}','ContainerTypesController@reactivate');
	Route::get('/utilities/brokerage_status_type_deactivated/{filter}','DatatablesController@bst_deactivated');
	Route::get('/utilities/brokerage_status_type_data','BrokerageStatusTypesController@bst_utilities')->name('brokerage_status_type.utilities_index');
	Route::put('/utilities/brokerage_status_type_reactivate/{id}','BrokerageStatusTypesController@reactivate');
	Route::resource('/utilities/employee_type', 'EmployeeTypesController');
	Route::get('/utilities/employee_type_deactivated/{filter}','DatatablesController@et_deactivated');
	Route::get('/utilities/employee_type_data','EmployeeTypesController@employee_type_utilities')->name('employee_type.utilities_index');
	Route::put('/utilities/employee_type_reactivate/{id}','EmployeeTypesController@reactivate');
	Route::get('/utilities/exchange_rate_deactivated/{filter}','DatatablesController@er_deactivated');
	Route::get('/utilities/exchange_rate_data','ExchangeRatesController@er_utilities')->name('exchange_rate.utilities_index');
	Route::put('/utilities/exchange_rate_reactivate/{id}','ExchangeRatesController@reactivate');
	Route::get('/utilities/ipf_fee_deactivated/{filter}','DatatablesController@ipf_deactivated');
	Route::get('/utilities/ipf_fee_data','ImportProcessingFeesController@ipf_utilities')->name('ipf_fee.utilities_index');
	Route::put('/utilities/ipf_fee_reactivate/{id}','ImportProcessingFeesController@reactivate');
	Route::resource('/utilities/receive_type', 'ReceiveTypesController');
	Route::get('/utilities/receive_type_deactivated/{filter}','DatatablesController@rt_deactivated');
	Route::get('/utilities/receive_type_data','ReceiveTypesController@rt_utilities')->name('receive_type.utilities_index');
	Route::put('/utilities/receive_type_reactivate/{id}','ReceiveTypesController@reactivate');
	Route::get('/utilities/service_order_type_deactivated/{filter}','DatatablesController@sot_deactivated');
	Route::get('/utilities/service_order_type_data','ServiceOrderTypesController@sot_utilities')->name('sot.utilities_index');
	Route::put('/utilities/service_order_type_reactivate/{id}','ServiceOrderTypesController@reactivate');
	Route::get('/utilities/vehicle_type_deactivated/{filter}','DatatablesController@vt_deactivated');
	Route::get('/utilities/vehicle_type_data','VehicleTypesController@vt_utilities')->name('vehicle_type.utilities_index');
	Route::put('/utilities/vehicle_type_reactivate/{id}','VehicleTypesController@reactivate');
	Route::get('/utilities/vehicle_deactivated/{filter}','DatatablesController@v_deactivated');
	Route::get('/utilities/vehicle_data','VehiclesController@v_utilities')->name('vehicle.utilities_index');
	Route::put('/utilities/vehicle_reactivate/{id}','VehiclesController@reactivate');
	Route::get('/utilities/location_province_deactivated/{filter}','DatatablesController@lp_deactivated');
	Route::get('/utilities/location_province_data','LocationProvincesController@lp_utilities')->name('location_province.utilities_index');
	Route::put('/utilities/location_province_reactivate/{id}','LocationProvincesController@reactivate');
	Route::get('/utilities/location_city_deactivated/{filter}','DatatablesController@lc_deactivated');
	Route::get('/utilities/location_city_data','LocationCitiesController@lc_utilities')->name('location_city.utilities_index');
	Route::put('/utilities/location_city_reactivate/{id}','LocationCitiesController@reactivate');
	Route::get('/utilities/standard_arearates_deactivated/{filter}','DatatablesController@sar_deactivated');
	Route::get('/utilities/standard_arearates_data','StandardAreaRatesController@sar_utilities')->name('standard_area_rate.utilities_index');
	Route::put('/utilities/standard_arearates_reactivate/{id}','StandardAreaRatesController@reactivate');
	Route::get('/utilities/locations_deactivated/{filter}','DatatablesController@location_deactivated');
	Route::get('/utilities/locations_data','LocationsController@location_utilities')->name('location.utilities_index');
	Route::put('/utilities/locations_reactivate/{id}','LocationsController@reactivate');
	Route::get('/utilities/employees_deactivated/{filter}','DatatablesController@employees_deactivated');
	Route::get('/utilities/employee_data','EmployeesController@employee_utilities')->name('location.utilities_index');
	Route::put('/utilities/employees_reactivate/{id}','EmployeesController@reactivate');
	Route::resource('/admin/vat_rate','VatRatesController');
	Route::get('/utilities/vat_rate_deactivated/{filter}','DatatablesController@vr_deactivated');
	Route::get('/utilities/vat_rate_data','VatRatesController@vr_utilities');
	Route::put('/utilities/vat_rate_reactivate/{id}','VatRatesController@reactivate');
	Route::put('/utilities/attachment_type_reactivate/{id}','RequirementsController@reactivate');

//Vanessaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa addition before galawin ni skip
	Route::put('/utilities/location_reactivate/{id}','LocationsController@reactivate');
	Route::put('/utilities/section_reactivate/{id}','SectionsController@reactivate');
	Route::put('/utilities/category_reactivate/{id}','CategoryTypesController@reactivate');
	Route::get('admin/getCategory/{sections_id?}', 'ItemsController@get_categories')->name('get_item_categories');
	Route::put('/utilities/item_reactivate/{id}','ItemsController@reactivate');
//end of Vanessaaaaaaaaaaaaaaaaaaaaaaaaa


		//Employees and Users
	Route::resource('/employees/{employee_id}/incidents', 'EmployeeIncidentsController');
	Route::resource('/employees/{employee_id}/accidents', 'EmployeeAccidentsController');
	Route::resource('/employees', 'EmployeesController');
	Route::resource('/employees/newemployee', 'EmployeesController');
	Route::post('/StoreEmployee', 'EmployeesController@store')->name('EmployeeSave');
	Route::get('/employees/{employee_id}/view', 'EmployeesController@view_employee', function ($from_new = null) {
		return $from_new;});
	Route::get('/employees/{employee_id}/edit', 'EmployeesController@edit_employee');
	Route::get('/employeeData', 'DatatablesController@employee_datatable')->name('employee.data');
	Route::post('/storeUser', 'EmployeesController@store_user')->name('UserStore');
	Route::resource('/users', 'UserController');
	Route::get('admin/users_table', 'UserController@user_table')->name('users.data');
	Route::put('/update_user/{id?}', 'EmployeesController@updateUser')->name('update_user');

		//Backup and recovery
	Route::resource('/admin/backup_and_recovery', 'BackupRecoveryController');

		//Audit Trail
	Route::resource('/admin/audit_trail', 'AuditTrailController');
});
Route::group(['middleware' => ['access']], function() {
	Route::resource('/orders', 'OrdersController');
	Route::get('/orderData', 'DatatablesController@order_datatable')->name('order.data');
	Route::post('/orders/create_so_detail', 'OrdersController@create_so_detail')->name('create_so_detail');
	Route::resource('/attachment', 'ServiceOrderAttachmentsController');
	Route::get('/orders/{order_id?}/getAttachments', 'DatatablesController@attach_datatable')->name('attach.data');
	Route::get('/orders/{or_id?}/get_atts', 'DatatablesController@atts_datatable');
	Route::post('/orders/create_so_billing_header', 'OrdersController@create_so_billing_header')->name('create_so_billing_header');
	Route::get('/orders/{order_id?}/getAttachment/{attach_id?}', 'ServiceOrderAttachmentsController@download_file');
		//Dashboard
	Route::get('/', 'DashboardController@index');
	Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');
		//Consignee
	Route::resource('consignee', 'ConsigneesController');
	Route::post('CreateConsignee', 'ConsigneesController@store')->name('createconsignee');
	Route::get('/consignee/{id}/getConsignee', 'ConsigneesController@get_detail');
	Route::get('/deliveryFees/{id?}', 'BillingDetailsController@getDeliveryFees')->name('getDeliveryFees');
	Route::get('admin/tr_soData/{type?}/view', 'DatatablesController@trucking_so_datatable')->name('tr_so.data');
	Route::get('/trucking/{trucking_id}/delivery/{delivery_id}/view', 'TruckingsController@view_delivery')->name('delivery.view');
	Route::get('/trucking/{trucking_id}/delivery/create', 'TruckingsController@new_delivery')->name('delivery.create');
	Route::get('/trucking/{trucking_id}/container/{container_id}', 'TruckingsController@getContainerDetail')->name('container_detail.data');
	Route::get('/trucking/{trucking_id}/delivery/{delivery_id}/show_pdf', 'TruckingsController@delivery_pdf')->name('delivery.pdf');
	Route::get('/trucking/{trucking_id}/get_deliveries', 'DatatablesController@get_trucking_deliveries');
	Route::get('/getAreaRate', 'TruckingsController@get_area_rate')->name('get_area_rate');
	Route::get('/truck_schedule', 'TruckingsController@show_trucks')->name('show_trucks');
	Route::get('/get_truck_schedule','TruckingsController@getTruckSchedule')->name('get_truck_schedule');

			//Maintenance Data
	Route::get('admin/csData', 'DatatablesController@consignee_datatable')->name('consignee.data');
	Route::get('admin/csDatamain', 'DatatablesController@consignee_datatable_main')->name('consignee_get_data');
	Route::get('admin/getCities/{province_id?}', 'ConsigneesController@get_cities')->name('get_prov_cities');
	Route::get('/ipf_maintain_data', 'ImportProcessingFeesController@ipf_maintain_data')->name('ipf_maintain_data');
	Route::get('/bf_maintain_data', 'BrokerageFeesController@bf_maintain_data')->name('bf_maintain_data');
	Route::get('/af_maintain_data', 'ArrastreFeesController@af_maintain_data')->name('af_maintain_data');
	Route::get('/wf_maintain_data', 'WharfageFeeController@wf_maintain_data')->name('wf_maintain_data');
	Route::get('/wf_lcl_maintain_data', 'WharfageFeeLclController@wf_lcl_maintain_data')->name('wf_lcl_maintain_data');
	Route::get('/af_lcl_maintain_data', 'ArrastreFeeLclController@af_lcl_maintain_data')->name('af_lcl_maintain_data');
	Route::get('/af_dc_maintain_data', 'ArrastreFeeDcController@af_dc_maintain_data')->name('af_dc_maintain_data');
	Route::get('/admin/location_city/new_province', 'LocationCitiesController@new_province');
	Route::get('/admin/emp_roleData/{employee_id}/data', 'DatatablesController@emp_role_datatable');
	Route::get('/utilities/emData', 'DatatablesController@employees_datatable')->name('em.data');
	Route::get('/admin/sotData', 'DatatablesController@sot_datatable')->name('sot.data');
	Route::get('/admin/vtData/{isActive?}', 'DatatablesController@vt_datatable')->name('vt.data');
	Route::get('/admin/chData/{isActive?}', 'DatatablesController@ch_datatable')->name('ch.data');
	Route::get('/admin/bstData/', 'DatatablesController@bst_datatable')->name('bst.data');
	Route::get('/admin/ctData/{isActive?}', 'DatatablesController@ct_datatable')->name('ct.data');
	Route::get('/admin/erData/{isActive?}', 'DatatablesController@er_datatable')->name('er.data');
	Route::get('/admin/rtData', 'DatatablesController@rt_datatable')->name('rt.data');
	Route::get('/admin/etData/{isActive?}', 'DatatablesController@et_datatable')->name('et.data');
	Route::get('/admin/vData/{isActive?}','DatatablesController@v_datatable')->name('v.data');
	Route::get('/admin/arData', 'DatatablesController@ar_datatable')->name('ar.data');
	Route::get('/admin/blData', 'DatatablesController@bl_datatable')->name('bl.data');
	Route::get('/admin/bfData', 'DatatablesController@bf_datatable')->name('bf.data');
	Route::get('/admin/cdsData/{isActive?}', 'DatatablesController@cds_datatable')->name('cds.data');
	Route::get('/admin/cargoTypeData', 'DatatablesController@cargoType_datatable')->name('cargoType.data');
	Route::get('/admin/afData', 'DatatablesController@af_datatable')->name('arrastre.data');
	Route::get('/admin/wfData', 'DatatablesController@wf_datatable')->name('wharfage.data');
	Route::get('/admin/ipfData', 'DatatablesController@ipf_datatable')->name('ipf.data');
	Route::get('/admin/vrData', 'DatatablesController@vr_datatable')->name('vr.data');
	Route::get('/admin/sarData/{isActive?}', 'DatatablesController@sar_datatable')->name('sar.data');
	Route::get('/admin/lpData/{isActive?}', 'DatatablesController@lp_datatable')->name('lp.data');
	Route::get('/admin/lcData/{isActive?}', 'DatatablesController@lc_datatable')->name('lc.data');
	Route::get('/admin/atData/{isActive?}', 'DatatablesController@req_datatable')->name('req.data');
	Route::get('/admin/afData/{isActive?}', 'DatatablesController@af_datatable')->name('af.data');
	Route::get('/admin/lclData/{isActive?}', 'DatatablesController@lcl_datatable')->name('lcl.data');
	Route::get('/admin/btData/{isActive?}', 'DatatablesController@bt_datatable')->name('bt.data');
	Route::get('/admin/dctData/{isActive?}', 'DatatablesController@dct_datatable')->name('dct.data');
	Route::get('/admin/wfData/{isActive?}', 'DatatablesController@wf_datatable')->name('wf.data');
	Route::get('/admin/wf_lcl_Data/{isActive?}', 'DatatablesController@wf_lcl_datatable')->name('wf_lcl.data');
	Route::get('/admin/af_lcl_Data/{isActive?}', 'DatatablesController@af_lcl_datatable')->name('af_lcl.data');
	Route::get('/admin/af_dc_Data/{isActive?}', 'DatatablesController@af_dc_datatable')->name('af_dc.data');
	Route::get('/admin/secData/{isActive?}', 'DatatablesController@sec_datatable')->name('sec.data');
	Route::get('/admin/catData/{isActive?}', 'DatatablesController@cat_datatable')->name('cat.data');
	Route::get('/admin/itemData/{isActive?}', 'DatatablesController@item_datatable')->name('item.data');

	//Deposits
Route::resource('/cdeposit', 'ConsigneeDepositsController');
Route::get('/getDeposits/{id?}', 'ConsigneeDepositsController@view_deposit')->name('depositView');
Route::resource('/dpayment', 'DepositPaymentsController');

});
Route::group(['middleware' => ['broker']], function() {
		//Brokerage
	Route::resource('/brokerage', 'BrokerageController');
	Route::resource('/brokerage/newserviceorder', 'BrokerageController');
	Route::resource('/dutiesandtaxes', 'DutiesAndTaxesController');
	Route::get('getCategory/{section_id?}', 'DutiesAndTaxesController@get_category')->name('get_category');
	Route::get('getItem/{category_id?}', 'DutiesAndTaxesController@get_item')->name('get_item');

// Contract
	Route::get('/admin/conheadData', 'DatatablesController@contracts_datatable')->name('contract.data');
	Route::post('/trucking/contracts/create_view', 'ContractsController@create_contract')->name('create_contract');
	Route::get('/trucking/contracts/create_view', 'ContractsController@view_contract');
	Route::get('/trucking/contracts/{contract_id}/view', 'ContractsController@manage_contract');
	Route::get('/trucking/contracts/{contract_id}/amend', 'ContractsController@amend_contract');
	Route::get('/trucking/contracts/consignee_contracts/{consignee_id?}/{contractFor?}', 'DatatablesController@get_contracts')->name('get_contracts');
	Route::get('/trucking/contracts/consignee_con_details/{contract_id?}', 'TruckingsController@get_contract_details')->name('get_contract_details');
	Route::get('/trucking/contracts/{contract_id}/show_pdf', 'ContractsController@contract_pdf');
	Route::get('/trucking/contracts/{contract_id}/agreement_pdf', 'ContractsController@agreement_pdf');
	Route::get('/trucking/contracts/{contract_id}/rates', 'DatatablesController@get_contract_details');
	Route::get('/trucking/contracts/{contract_id}/draft', 'ContractsController@draft_contract');
	Route::post('/trucking/contracts/{contract_id}/store_rates', 'ContractsController@store_contract_rates');
	Route::get('/trucking/contracts/get_quotations/{consignee_id}', 'ContractsController@get_quotations');
	Route::get('/trucking/contracts/get_con_contracts/{consignee_id}', 'ContractsController@get_con_contracts');
//Vanessa addition
	Route::get('/admin/ctempData', 'DatatablesController@ctemp_datatable')->name('ctemp.data');
	Route::resource('/admin/contract_template','ContractTemplatesController');


//Delivery to Temporary Billing
	Route::get('/trucking/{trucking_id}/delivery/{delivery_id}/bill', 'TruckingsController@bill_delivery');
	Route::put('/trucking/{trucking_id}/delivery/{delivery_id}/update_delivery_bill', 'TruckingsController@update_delivery_bill');
	Route::post('/trucking/{trucking_id}/delivery/{delivery_id}/store_delivery_bill', 'TruckingsController@store_delivery_bill');

//DOMPDF
	Route::get('/dompdfExample', 'TruckingsController@create_pdf');

//FullCalendar
	Route::get('/FullCalendar', 'TruckingsController@show_calendar');

//Utilities home route
	Route::resource('/utilities/settings','UtilityController');
	Route::get('/utilities', 'UtilityController@utility_index')->name('utilities_index');
	//Backup and recovery
	Route::resource('/admin/backup_and_recovery', 'BackupRecoveryController');

//Audit Trail
	Route::resource('/admin/audit_trail', 'AuditTrailController');


//Query
# Active Contracts
	Route::get('queries', 'QueriesController@index')->name('queries.index');
	Route::get('queries/get_active_contract/{status?}', 'DatatablesController@get_active_contract')->name('get_active_contract');
	Route::get('queries/get_peMM<nding_deliveries/{status?}', 'DatatablesController@get_pending_deliveries')->name('get_pending_deliveries');
	Route::get('queries/get_unreturned_containers', 'DatatablesController@get_unreturned_containers')->name('get_unreturned_containers');
	Route::get('queries/get_query_bills/{status?}', 'DatatablesController@get_query_bills')->name('get_query_bills');
	Route::get('queries/get_finished_trucking_orders', 'DatatablesController@get_finished_trucking_orders')->name('get_finished_trucking_orders');
	Route::get('queries/get_expiring_vehicle_registrations', 'DatatablesController@get_expiring_vehicle_registrations')->name('get_expiring_vehicle_registrations');


	Route::post('/storedutiesandtaxes', 'DutiesAndTaxesController@store')->name('storedutiesandtaxes');
	Route::get('/generatedutiesandtaxes', 'DutiesAndTaxesController@generate_taxes')->name('generatedutiesandtaxes');
	Route::post('/brokerage/create_br_billing_header', 'BrokerageController@create_br_billing_header')->name("create_br_billing_header");
	Route::post('/storeheader', 'BrokerageController@save_neworder')->name('saveBrokerageOrder');
	Route::post('/postBrokeragePayable', 'BillingDetailsController@postBrokeragePayable')->name('post_brokerage_payables');
	Route::post('/postBrokerageRefundable', 'BillingDetailsController@postBrokerageRefundable')->name('postBrokerageRefundable');
	Route::patch('/brokerage/{brokerage_id}/order/statusTaxUpdate', 'DutiesAndTaxesController@update_taxstatus');
	Route::patch('/brokerage/{brokerage_id}/order/statusupdate', 'BrokerageController@update_status');
	Route::get('/brokerage_create_order/{detail_id?}', 'BrokerageController@create_new')->name('brokerageOrder');
	Route::get('/brokerage/{brokerage_id}/order', 'BrokerageController@view_order');
	Route::get('/brokerage/{brokerage_id}/get_dutiesandtaxes', 'DatatablesController@get_dutiesandtaxes_table');
	Route::get('/brokerage/{brokerage_id}/create_dutiesandtaxes', 'DutiesAndTaxesController@create');
	Route::get('/brokerage/{brokerage_id}/view', 'BrokerageController@view_brokerage');
	Route::get('brokerageData', 'DatatablesController@brokerage_datatable')->name('br.data');
	Route::get('/brokerage/{brokerage_id?}/print', 'BrokerageController@print')->name('brokeragepdfprint');
	Route::get('/brokerage/{brokerage_id}/get_approveddutiesandtaxes', 'BrokerageController@get_approveddutiesandtaxes');
	Route::get('/brokerageFees/{id?}', 'BillingDetailsController@getBrokerageFees')->name('getBrokerageFees');
	Route::get('/charges/{id?}', 'BillingDetailsController@getBrokerageCharges')->name('getCharges');
	Route::get('/brokerageBillingDetails/{id?}', 'BillingDetailsController@getBrokerageBillingDetails')->name('getBrokerageBillingDetails');
	Route::get('/brokerageRefundableDetails/{id?}', 'BillingDetailsController@getBrokerageRefundableDetails')->name('getBrokerageRefundableDetails');
});
Route::group(['middleware' => ['trucking']], function() {
		//Trucking-Locations
	Route::resource('/location', 'LocationsController');
	Route::get('/locationData', 'DatatablesController@location_datatable')->name('location_data');
	Route::get('/location/{id}/getLocation', 'LocationsController@get_location')->name('get_location_data');
		//Trucking-Quotations
	Route::resource('/quotation', 'QuotationsController');
	Route::get('/quotation/{id}/print', 'QuotationsController@print');
	Route::get('/admin/getQuotations', 'DatatablesController@get_quotations')->name('quotation_data');
	Route::get('/admin/get_quotation_location/{location_id?}', 'QuotationsController@get_quotation_location')->name('get_quotation_location');
	Route::get('/admin/get_quotation_rates', 'QuotationsController@get_quotation_rates')->name('get_quotation_rates');
	Route::resource('admin/quotation_template','QuotationTemplateController');
		//Trucking Route
	Route::resource('/trucking/delivery_receipts', 'DeliveryReceiptsController');
	Route::resource('/trucking/contracts', 'ContractsController');
	Route::resource('/trucking', 'TruckingsController');
	Route::get('/trucking/{trucking_id}/view', 'TruckingsController@view_trucking');
	Route::get('admin/{trucking_id}/deliveryData', 'DatatablesController@trucking_delivery');
	Route::get('admin/{vehicle_type}/getVehicles', 'TruckingsController@getVehicles');
	Route::post('/trucking/{trucking_id}/store_delivery', 'TruckingsController@store_delivery');
	Route::put('/trucking/{trucking_id}/update_delivery', 'TruckingsController@update_delivery');
	Route::get('/trucking/{trucking_id}/delivery/{delivery_id}/edit', 'TruckingsController@edit_delivery');
	Route::put('/trucking/{trucking_id}/delivery/{delivery_id}/update_delivery', 'TruckingsController@update_delivery_record');
	Route::put('/trucking/{trucking_id}/update_container/{container_id}', 'TruckingsController@update_container');
	Route::post('/trucking/{trucking_id}/delivery/{delivery_id}/reschedule', 'TruckingsController@reschedule_delivery');
		//Delivery Receipt Routes

		//Contract
	Route::get('/admin/conheadData', 'DatatablesController@contracts_datatable')->name('contract.data');
	Route::post('/trucking/contracts/create_view', 'ContractsController@create_contract')->name('create_contract');
	Route::get('/trucking/contracts/create_view', 'ContractsController@view_contract');
	Route::get('/trucking/contracts/{contract_id}/view', 'ContractsController@manage_contract');
	Route::get('/trucking/contracts/{contract_id}/amend', 'ContractsController@amend_contract');
	Route::get('/trucking/contracts/consignee_contracts/{consignee_id?}/{contractFor?}', 'DatatablesController@get_contracts')->name('get_contracts');
	Route::get('/trucking/contracts/consignee_con_details/{contract_id?}', 'TruckingsController@get_contract_details')->name('get_contract_details');
	Route::get('/trucking/contracts/{contract_id}/show_pdf', 'ContractsController@contract_pdf');
	Route::get('/trucking/contracts/{contract_id}/agreement_pdf', 'ContractsController@agreement_pdf');
	Route::get('/trucking/contracts/{contract_id}/rates', 'DatatablesController@get_contract_details');
	Route::get('/trucking/contracts/{contract_id}/draft', 'ContractsController@draft_contract');
	Route::post('/trucking/contracts/{contract_id}/store_rates', 'ContractsController@store_contract_rates');
	Route::get('/trucking/contracts/get_quotations/{consignee_id}', 'ContractsController@get_quotations');
	Route::get('/trucking/contracts/get_con_contracts/{consignee_id}', 'ContractsController@get_con_contracts');
	Route::get('/admin/ctempData', 'DatatablesController@ctemp_datatable')->name('ctemp.data');
	Route::resource('/admin/contract_template','ContractTemplatesController');
		//Delivery to Temporary Billing
	Route::get('/trucking/{trucking_id}/delivery/{delivery_id}/bill', 'TruckingsController@bill_delivery');
	Route::put('/trucking/{trucking_id}/delivery/{delivery_id}/update_delivery_bill', 'TruckingsController@update_delivery_bill');
	Route::post('/trucking/{trucking_id}/delivery/{delivery_id}/store_delivery_bill', 'TruckingsController@store_delivery_bill');
		//DOMPDF
	Route::get('/dompdfExample', 'TruckingsController@create_pdf');
		//FullCalendar
	Route::get('/FullCalendar', 'TruckingsController@show_calendar');
});
Route::group(['middleware' => ['billing']], function() {
//Billing
	Route::resource('/billing', 'BillingDetailsController');
	Route::resource('/billing_header', 'BillingDetailsController');
	Route::get('/billing/{id}/create', 'BillingDetailsController@show_billing');
	Route::get('/billing/{id}/view', 'BillingDetailsController@view_billing');
	Route::get('/billing/{billing_id}/show_pdf', 'BillingDetailsController@bill_pdf');
	Route::get('admin/bill_invoice', 'BillingDetailsController@billing_invoice')->name('invoice.data');
	Route::get('admin/bill_history/{id}', 'BillingDetailsController@billing_history')->name('history.data');
	Route::get('admin/bill_unpaid/{id}', 'BillingDetailsController@unpaid_invoice')->name('unpaid.data');
	Route::get('/paid_bill', 'BillingDetailsController@paid_bill')->name('paid.data');
	Route::get('admin/bill_paid', 'BillingDetailsController@paid_bill')->name('paid_bill.data');

		//Trucking Bills
	Route::post('/trucking/create_tr_billing_header', 'TruckingsController@create_tr_billing_header')->name('create_tr_billing_header');
	Route::get('/billDetails/{id?}', 'BillingDetailsController@getBillingDetails')->name('getBillingDetails');
	Route::post('/postTruckingPayable', 'BillingDetailsController@postTruckingPayable')->name('post_trucking_payables');
	Route::post('/postTruckingExpense', 'BillingDetailsController@postTruckingExpense')->name('post_trucking_expense');
	Route::get('/billing/{id}/total', 'DatatablesController@totalbillings')->name('totalbill.data');
	Route::get('billing', 'BillingDetailsController@index')->name('view.index');
	Route::get('admin/brso_head', 'DatatablesController@brso_head_datatable')->name('brso_head.data');
	Route::get('admin/trso_head', 'DatatablesController@trso_head_datatable')->name('trso_head.data');
	Route::get('admin/expenses/{id}', 'DatatablesController@expenses_datatable')->name('expenses.data');
	Route::get('admin/revenue/{id}', 'DatatablesController@revenue_datatable')->name('revenue.data');
	Route::get('admin/paybills/{id}', 'PaymentsController@payments_table')->name('payments.data');
	Route::get('/charge/{id}/getCharge', 'BillingDetailsController@get_detail');
	Route::get('/charge/{id}/getExp', 'BillingDetailsController@get_expense');
	Route::get('/billing/{billing_id}/rc_pdf', 'BillingDetailsController@ref_pdf');
	Route::put('/billing/{id}/finalize', 'BillingDetailsController@finalize_bill')->name('finalize_bill');
	Route::put('/billing_void/{id?}', 'BillingDetailsController@void_bill')->name('void_bill');
	Route::post('/postHeader', 'BillingDetailsController@postBilling_header')->name('bill_header');
	Route::post('/postDetails', 'BillingDetailsController@postBilling_details')->name('bill_details');

		//Payment
	Route::get('pdfview','PaymentsController@pdfview');
	Route::resource('/payment', 'PaymentsController');
	Route::get('admin/pso_head', 'DatatablesController@pso_head_datatable')->name('pso_head.data');
	Route::get('/payment_receipt/{payment_id?}', 'PaymentsController@payment_pdf')->name('payment_receipt');
	Route::get('/payment_deposit_receipt/{payment_id?}', 'PaymentsController@payment_deposit_pdf')->name('payment_deposit_receipt');
	Route::get('admin/rev/{id}', 'DatatablesController@prev_datatable')->name('prev.data');
	Route::get('admin/payment_bills/{id}', 'PaymentsController@bills_table')->name('paybills.data');
	Route::put('payment/{id?}/cheques', 'PaymentsController@verify_cheque')->name('verify_chq');
	Route::get('admin/p_order', 'DatatablesController@pso_datatable')->name('p_order.data');
	Route::get('admin/cheque_confirm', 'ChequesController@cheque_table')->name('chq.data');
	Route::post('/postCheque', 'PaymentsController@storeCheque')->name('postCheque');
	Route::resource('/cheque', 'ChequesController');
	Route::put('/confirm_cheque/{id?}', 'ChequesController@confirm_cheque')->name('con_cheque');
});
