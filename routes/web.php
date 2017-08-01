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

//Consignee
Route::resource('/consignee', 'ConsigneesController');
Route::get('admin/csData', 'DatatablesController@consignee_datatable')->name('consignee.data');




//Maintenance Routes

Route::resource('/admin/vehicletype', 'VehicleTypesController');
Route::resource('/admin/service_ordertype', 'ServiceOrderTypesController');
Route::resource('/admin/charge','ChargesController');
Route::resource('/admin/brokerage_status_type', 'BrokerageStatusTypesController');
Route::resource('/admin/container_type', 'ContainerTypesController');
Route::resource('/admin/exchange_rate', 'ExchangeRatesController');
Route::resource('/admin/receive_type', 'ReceiveTypesController');
Route::resource('/admin/employee_type', 'EmployeeTypesController');
Route::resource('/admin/vehicle','VehiclesController');
Route::resource('/admin/area', 'AreasController');
Route::resource('/admin/billing', 'BillingsController');
Route::resource('/admin/brokerage_fee', 'BrokerageFeesController');
Route::resource('/admin/cds_fee','CdsFeesController');
Route::resource('/admin/ipf_fee','IpfFeesController');


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

Route::get('pdfview','PaymentsController@pdfview');

//Skipper
//Payments
Route::resource('/payment', 'PaymentsController');
Route::get('admin/pso_head', 'DatatablesController@pso_head_datatable')->name('pso_head.data');
Route::get('/payment/{payment_id}/show_pdf', 'PaymentsController@payment_pdf');

//Billing
Route::resource('/billing', 'BillingDetailsController');
Route::get('/billing/view/{id}/create', 'BillingDetailsController@show_billing');
Route::get('/billing/{billing_id}/show_pdf', 'BillingDetailsController@bill_pdf');
Route::get('admin/invoice/{so_head_id}', 'BillingDetailsController@billing_invoice')->name('invoice.data');
// Route::get('/bill/display/{id}', 'BillingDetailsController@display_bill');
Route::get('/billing/{id}/total', 'DatatablesController@totalbillings')->name('totalbill.data');
Route::get('billing', 'BillingDetailsController@index')->name('view.index');
Route::get('admin/so_head', 'DatatablesController@so_head_datatable')->name('so_head.data');


//Maintenance data
Route::get('/admin/billData', 'DatatablesController@bill_datatable')->name('bill.data');

//Maintenance aroute
Route::resource('/admin/billing', 'BillingsController');

//Reports
Route::resource('/reports/shipment', 'ShipmentReportsController');
Route::get('/reports/shipmentData', 'DatatablesController@shipment_datatable')->name('shipment.data');


//Jessie


// Trucking Route
Route::resource('/trucking/delivery_receipts', 'DeliveryReceiptsController');
Route::resource('/trucking/contracts', 'ContractsController');
Route::resource('/trucking', 'TruckingsController');
Route::get('/trucking/{trucking_id}/view', 'TruckingsController@view_trucking');
Route::get('admin/{trucking_id}/deliveryData', 'DatatablesController@trucking_delivery');
Route::get('admin/{vehicle_type}/getVehicles', 'TruckingsController@getVehicles');
Route::post('/trucking/{trucking_id}/store_delivery', 'TruckingsController@store_delivery');
Route::put('/trucking/{trucking_id}/update_delivery', 'TruckingsController@update_delivery');
Route::put('/trucking/{trucking_id}/update_container/{container_id}', 'TruckingsController@update_container');
//Delivery Receipt Routes
Route::get('admin/tr_soData/{type?}/view', 'DatatablesController@trucking_so_datatable')->name('tr_so.data');
Route::get('/trucking/{trucking_id}/delivery/{delivery_id}/view', 'TruckingsController@view_delivery')->name('delivery.view');
Route::get('/trucking/{trucking_id}/delivery/create', 'TruckingsController@new_delivery')->name('delivery.create');
Route::get('/trucking/{trucking_id}/container/{container_id}', 'TruckingsController@getContainerDetail')->name('container_detail.data');
Route::get('/trucking/{trucking_id}/delivery/{delivery_id}/show_pdf', 'TruckingsController@delivery_pdf')->name('delivery.pdf');
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
Route::post('/trucking/contracts/{contract_id}/store_rates', 'ContractsController@store_contract_rates');
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
