<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'ConsigneesController@home');

Auth::routes();

Route::get('/home', 'HomeController@index');

// Brokerage Routes
Route::resource('/brokerage', 'BrokerageController');
Route::resource('/brokerage/newserviceorder', 'BrokerageController');
Route::resource('/dutiesandtaxes', 'DutiesAndTaxesController');
Route::post('/storedutiesandtaxes', 'DutiesAndTaxesController@store')->name('storedutiesandtaxes');

Route::get('/brokerage/{brokerage_id}/view', 'BrokerageController@view_brokerage');
Route::get('brokerageData', 'DatatablesController@brokerage_datatable')->name('br.data');


//Consignee
Route::resource('consignee', 'ConsigneesController');
Route::post('CreateConsignee', 'ConsigneesController@store')->name('createconsignee');
Route::get('admin/csData', 'DatatablesController@consignee_datatable')->name('consignee.data');
Route::get('admin/csDatamain', 'DatatablesController@consignee_datatable_main')->name('consignee_get_data');
Route::get('admin/getCities/{province_id?}', 'ConsigneesController@get_cities')->name('get_prov_cities');
Route::get('/consignee/{id}/getConsignee', 'ConsigneesController@get_detail');




//Maintenance Routes

Route::resource('/admin/vehicletype', 'VehicleTypesController');
Route::resource('/admin/service_ordertype', 'ServiceOrderTypesController');
Route::resource('/admin/brokerage_status_type', 'BrokerageStatusTypesController');
Route::resource('/admin/container_type', 'ContainerTypesController');
Route::resource('/admin/exchange_rate', 'ExchangeRatesController');
Route::resource('/admin/receive_type', 'ReceiveTypesController');
Route::resource('/admin/employee_type', 'EmployeeTypesController');
Route::resource('/admin/vehicle','VehiclesController');
Route::resource('/admin/area', 'AreasController');
Route::resource('/admin/billing', 'BillingsController');
Route::resource('/admin/charge','ChargesController'); 
Route::resource('/admin/brokerage_fee', 'BrokerageFeesController');
Route::resource('/admin/cds_fee','CdsFeesController');
Route::resource('/admin/ipf_fee','ImportProcessingFeesController');
Route::resource('/admin/standard_arearates','StandardAreaRatesController');
Route::resource('/admin/vat_rate','VatRatesController');
Route::resource('/admin/bank_account','BankAccountsController');
Route::resource('/admin/location_province','LocationProvincesController');
Route::resource('/admin/location_city','LocationCitiesController');



//Sub maintenance
Route::get('/admin/location_city/new_province', 'LocationCitiesController@new_province');

//Utilities Routes
Route::resource('/utilities/employee', 'EmployeesController');
Route::resource('/utilities/employee/{employee}/view', 'EmployeeRolesController');
Route::get('/admin/emp_roleData/{employee_id}/data', 'DatatablesController@emp_role_datatable');
Route::get('/utilities/emData', 'DatatablesController@employees_datatable')->name('em.data');

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



Route::get('/utilities/container_type_deactivated/{filter}','DatatablesController@ct_deactivated');
Route::get('/utilities/container_type_data','ContainerTypesController@ct_utilities')->name('container_type.utilities_index');
Route::put('/utilities/container_type_reactivate/{id}','ContainerTypesController@reactivate');


Route::get('/utilities/brokerage_status_type_deactivated/{filter}','DatatablesController@bst_deactivated');
Route::get('/utilities/brokerage_status_type_data','BrokerageStatusTypesController@bst_utilities')->name('brokerage_status_type.utilities_index');
Route::put('/utilities/brokerage_status_type_reactivate/{id}','BrokerageStatusTypesController@reactivate');


Route::get('/utilities/employee_type_deactivated/{filter}','DatatablesController@et_deactivated');
Route::get('/utilities/employee_type_data','EmployeeTypesController@et_utilities')->name('employee_type.utilities_index');
Route::put('/utilities/employee_type_reactivate/{id}','EmployeeTypesController@reactivate');


Route::get('/utilities/exchange_rate_deactivated/{filter}','DatatablesController@er_deactivated');
Route::get('/utilities/exchange_rate_data','ExchangeRatesController@er_utilities')->name('exchange_rate.utilities_index');
Route::put('/utilities/exchange_rate_reactivate/{id}','ExchangeRatesController@reactivate');


Route::get('/utilities/ipf_fee_deactivated/{filter}','DatatablesController@ipf_deactivated');
Route::get('/utilities/ipf_fee_data','IpfFeesController@ipf_utilities')->name('ipf_fee.utilities_index');
Route::put('/utilities/ipf_fee_reactivate/{id}','IpfFeesController@reactivate');


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



//Maintenance Datas

Route::get('/admin/sotData', 'DatatablesController@sot_datatable')->name('sot.data');
Route::get('/admin/vtData', 'DatatablesController@vt_datatable')->name('vt.data');
Route::get('/admin/chData', 'DatatablesController@ch_datatable')->name('ch.data');
Route::get('/admin/bstData', 'DatatablesController@bst_datatable')->name('bst.data');
Route::get('/admin/ctData', 'DatatablesController@ct_datatable')->name('ct.data');
Route::get('/admin/erData', 'DatatablesController@er_datatable')->name('er.data');
Route::get('/admin/rtData', 'DatatablesController@rt_datatable')->name('rt.data');
Route::get('/admin/etData', 'DatatablesController@et_datatable')->name('et.data');
Route::get('/admin/vData','DatatablesController@v_datatable')->name('v.data');
Route::get('/admin/arData', 'DatatablesController@ar_datatable')->name('ar.data');
Route::get('/admin/blData', 'DatatablesController@bl_datatable')->name('bl.data');
Route::get('/admin/bfData', 'DatatablesController@bf_datatable')->name('bf.data');
Route::get('/admin/cdsData', 'DatatablesController@cds_datatable')->name('cds.data');
Route::get('/admin/ipfData', 'DatatablesController@ipf_datatable')->name('ipf.data');
Route::get('/admin/vrData', 'DatatablesController@vr_datatable')->name('vr.data');
Route::get('/admin/sarData', 'DatatablesController@sar_datatable')->name('sar.data');
Route::get('/admin/lpData', 'DatatablesController@lp_datatable')->name('lp.data');
Route::get('/admin/lcData', 'DatatablesController@lc_datatable')->name('lc.data');
Route::get('pdfview','PaymentsController@pdfview');

//Skipper
//Orders
Route::resource('/orders', 'OrdersController');

//Payments
Route::resource('/payment', 'PaymentsController');
Route::get('admin/pso_head', 'DatatablesController@pso_head_datatable')->name('pso_head.data');
Route::get('/payment/{payment_id}/show_pdf', 'PaymentsController@payment_pdf');
Route::get('admin/rev/{id}', 'DatatablesController@prev_datatable')->name('prev.data');

//Billing
Route::resource('/billing', 'BillingDetailsController');
Route::get('/billing/{id}/create', 'BillingDetailsController@show_billing');
Route::get('/billing/{billing_id}/show_pdf', 'BillingDetailsController@bill_pdf');
Route::get('admin/invoice/{so_head_id}', 'BillingDetailsController@billing_invoice')->name('invoice.data');
// Route::get('/bill/display/{id}', 'BillingDetailsController@display_bill');
Route::get('/billing/{id}/total', 'DatatablesController@totalbillings')->name('totalbill.data');
Route::get('billing', 'BillingDetailsController@index')->name('view.index');
Route::get('admin/brso_head', 'DatatablesController@brso_head_datatable')->name('brso_head.data');
Route::get('admin/trso_head', 'DatatablesController@trso_head_datatable')->name('trso_head.data');
Route::get('admin/expenses/{id}', 'DatatablesController@expenses_datatable')->name('expenses.data');
Route::get('admin/revenue/{id}', 'DatatablesController@revenue_datatable')->name('revenue.data');
Route::get('admin/paybills/{id}', 'PaymentsController@payments_table')->name('payments.data');
Route::resource('/billingrevenue', 'BillingRevenuesController');
Route::resource('/billingexpense', 'BillingExpensesController');


//Maintenance data
Route::get('/admin/billData', 'DatatablesController@bill_datatable')->name('bill.data');

//Maintenance aroute
Route::resource('/admin/billing', 'BillingsController');

//Reports
Route::resource('/reports/shipment', 'ShipmentReportsController');
Route::resource('/reports/delivery', 'DeliveryReportsController');
Route::get('/reports/shipmentData', 'DatatablesController@shipment_datatable')->name('shipment.data');
Route::get('/reports/deliveryData', 'DatatablesController@delivery_datatable')->name('delivery.data');

//vanessa addition
Route::get('/trial_report','TrialController@index');


//Jessie


//Locations
Route::resource('/location', 'LocationsController');
Route::get('/locationData', 'DatatablesController@location_datatable')->name('location_data');
Route::get('/location/{id}/getLocation', 'LocationsController@get_location')->name('get_location_data');

//Quotations
Route::resource('/quotation', 'QuotationsController');
Route::get('/quotation/{id}/print', 'QuotationsController@print');
Route::get('/admin/getQuotations', 'DatatablesController@get_quotations')->name('quotation_data');
//vanessa addition
Route::resource('admin/quotation_template','QuotationTemplateController');

// Trucking Route
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
//Delivery Receipt Routes
Route::get('admin/tr_soData/{type?}/view', 'DatatablesController@trucking_so_datatable')->name('tr_so.data');
Route::get('/trucking/{trucking_id}/delivery/{delivery_id}/view', 'TruckingsController@view_delivery')->name('delivery.view');
Route::get('/trucking/{trucking_id}/delivery/create', 'TruckingsController@new_delivery')->name('delivery.create');
Route::get('/trucking/{trucking_id}/container/{container_id}', 'TruckingsController@getContainerDetail')->name('container_detail.data');
Route::get('/trucking/{trucking_id}/delivery/{delivery_id}/show_pdf', 'TruckingsController@delivery_pdf')->name('delivery.pdf');
Route::get('/trucking/{trucking_id}/get_deliveries', 'DatatablesController@get_trucking_deliveries');


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
Route::resource('/admin/utilities', 'UtilitiesController');
Route::resource('/admin/settings', 'BusinessSettingsController');


//Query
# Active Contracts
Route::get('queries', 'QueriesController@index')->name('queries.index');
Route::get('queries/get_active_contract/{status?}', 'DatatablesController@get_active_contract')->name('get_active_contract');
Route::get('queries/get_pending_deliveries/{status?}', 'DatatablesController@get_pending_deliveries')->name('get_pending_deliveries');
Route::get('queries/get_unreturned_containers', 'DatatablesController@get_unreturned_containers')->name('get_unreturned_containers');
Route::get('queries/get_query_bills/{status?}', 'DatatablesController@get_query_bills')->name('get_query_bills');
Route::get('queries/get_expiring_vehicle_registrations', 'DatatablesController@get_expiring_vehicle_registrations')->name('get_expiring_vehicle_registrations');