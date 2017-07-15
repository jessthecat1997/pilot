@extends('layouts.maintenance')
@section('content')
<div class = "container-fluid">
    <div class = "row">
        <h3><img src="/images/bar.png"> Maintenance | Brokerage Fee</h3>
        <hr>
        <div class = "col-md-3 col-md-offset-9">
            <button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#bfModal" style = "width: 100%;">New Brokerage Fee</button>
        </div>
    </div>
    <br />
    <div class = "row">
        <div class = "panel-default panel">
            <div class = "panel-body">
                <table class = "table-responsive table" id = "bf_table">
                    <thead>
                        <tr>
                            <td>
                                No.
                            </td>
                            <td>
                                Dutiable Value Minimum
                            </td>
                            <td>
                                Dutiable Value Maximum
                            </td>
                            <td>
                                Brokerage Fee Amount
                            </td>
                            <td>
                                Created at
                            </td>
                            <td>
                                Actions
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <section class="content">
        <form role="form" method = "POST" id = "commentForm">
            {{ csrf_field() }}
            <div class="modal fade" id="bfModal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">New Brokerage Fee Range</h4>
                        </div>
                        <div class="modal-body">            
                            <div class="form-group required">
                                <label class = "control-label" >Dutiable Value Minimum:</label>
                                <input type = "text" class = "form-control money_s"  style = " text-align: right" id="minimum"  name="minimum"  data-rule-required="true" />
                            </div>
                        </div>
                        <div class="modal-body">            
                            <div class="form-group required">
                                <label class = "control-label" >Dutiable Value Maximum:</label>
                                <input type = "text" class = "form-control money_s"  style = " text-align: right" id="maximum"  name="maximum"  data-rule-required="true" />
                            </div>
                        </div>
                        <div class="modal-body">            
                            <div class="form-group required">
                                <label class = "control-label">Brokerage Fee Amount:</label>
                                <input type = "text" class = "form-control money" style = " text-align: right" id="amount"  name="amount" data-rule-required="true" />
                            </div>

                        </div>
                        <div class="modal-footer">
                            <input id = "btnSave" type = "submit" class="btn btn-success submit" value = "Save" />
                           <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                           
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
    <section class="content">
        <form role = "form" method = "POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <div class="modal fade" id="confirm-delete" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            Deactivate record
                        </div>
                        <div class="modal-body">
                            Confirm Deactivating
                        </div>
                        <div class="modal-footer">
                            <button class = "btn btn-danger " id = "btnDelete" >Deactivate</button>
                             <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                           
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</div>
@endsection
@push('styles')
<style>
    .maintenance
    {
        border-left: 10px solid #2ad4a5;
        background-color:rgba(128,128,128,0.1);
        color: #fff;
    }
</style>
@endpush
@push('scripts')
<script type="text/javascript">
    var data;
    $(document).ready(function(){
        var bftable = $('#bf_table').DataTable({
            processing: true,
            serverSide: true,
            'scrollx': true,
            ajax: 'http://localhost:8000/admin/bfData',
            columns: [
            { data: 'id' },
            { data: 'minimum',
            "render" : function( data, type, full ) {
                return formatNumber_s(data); } },
            { data: 'maximum',
            "render" : function( data, type, full ) {
                return formatNumber_s(data); } },
            { data: 'amount',
            "render" : function( data, type, full ) {
                return formatNumber(data); } },
            { data: 'created_at'},
            { data: 'action', orderable: false, searchable: false }

            ],  "order": [[ 1, "desc" ]],
        });
        $(document).ready(function() {
            $("#commentForm").validate({
                rules: 
                {
                    minimum:
                    {
                        required: true,
                    },
                     maximum:
                    {
                        required: true,
                    },
                     amount:
                    {
                        required: true,
                    },

                },
                messages: {
                    minimum:
                    {
                        required: "This field is required",
                    },
                     maximum:
                    {
                        required:"This field is required",
                    },
                     amount:
                    {
                        required: "This field is required",
                    },
                },
        onkeyup: false, //turn off auto validate whilst typing
        submitHandler: function (form) {
            return false;
        }
    });
        });



        $(document).on('click', '.new', function(e){
            resetErrors();
            $('.modal-title').text('New Brokerage Fee Range');
            $('#minimum').val("");
            $('#maximum').val("");
            $('#amount').val("");
            $('#bfModal').modal('show');

        });
        $(document).on('click', '.edit',function(e){
            resetErrors();
            var bf_id = $(this).val();
            data = bftable.row($(this).parents()).data();
            $('#minimum').val(data.minimum);
            $('#maximum').val(data.maximum);
            $('#amount').val(data.amount);
            $('.modal-title').text('Update Brokerage Fee Range');
            $('#bfModal').modal('show');
        });
        $(document).on('click', '.deactivate', function(e){
            var bf_id = $(this).val();
            data = bftable.row($(this).parents()).data();
            $('#confirm-delete').modal('show');
        });



// Confirm Delete Button
$('#btnDelete').on('click', function(e){
    e.preventDefault();
    $.ajax({
        type: 'DELETE',
        url:  '/admin/brokerage_fee/' + data.id,
        data: {
            '_token' : $('input[name=_token').val()
        },
        success: function (data)
        {
            bftable.ajax.reload();
            $('#confirm-delete').modal('hide');

            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "rtl": false,
                "positionClass": "toast-bottom-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": 300,
                "hideDuration": 1000,
                "timeOut": 2000,
                "extendedTimeOut": 1000,
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            toastr["success"]("Record deactivated successfully")
        }
    })
});

// Confirm Save Button
$('#btnSave').on('click', function(e){

    var minimum_nocomma = $('#minimum').maskMoney('unmasked')[0];
    var maximum_nocomma = $('#maximum').maskMoney('unmasked')[0];
    var amount_nocomma = $('#amount').maskMoney('unmasked')[0];

    if (minimum_nocomma == "0.00"){
        minimum_nocomma = "";
    }
    if (maximum_nocomma == "0.00"){
        maximum_nocomma = "";
    }
    if (amount_nocomma == "0.00"){
        amount_nocomma = "";
    }

    e.preventDefault();
    var title = $('.modal-title').text();
    if(title == "New Brokerage Fee")
    {
        $.ajax({
            type: 'POST',
            url:  '/admin/brokerage_fee',
            data: {
                '_token' : $('input[name=_token]').val(),
                'minimum' : minimum_nocomma,
                'maximum' : maximum_nocomma,
                'amount' : amount_nocomma,
            },
            success: function (data)
            {
                if(typeof(data) === "object"){
                    bftable.ajax.reload();
                    $('#bfModal').modal('hide');
                    $('.modal-title').text('New Brokerage Fee Range');

                    //Show success

                    toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "rtl": false,
                        "positionClass": "toast-bottom-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": 300,
                        "hideDuration": 1000,
                        "timeOut": 2000,
                        "extendedTimeOut": 1000,
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    }
                    toastr["success"]("Record addded successfully")

                    bftable.ajax.reload();
                    $('#bfModal').modal('hide');
                    $('#minimum').val('');
                    $('#maximum').val('');
                    $('#amount').val('');



                    $('.modal-title').text('New Brokerage Fee Range');


                }
                else{
                    resetErrors();
                    var invdata = JSON.parse(data);
                    $.each(invdata, function(i, v) {
            console.log(i + " => " + v); // view in console for error messages
            var msg = '<label class="error" for="'+i+'">'+v+'</label>';
            $('input[name="' + i + '"], select[name="' + i + '"]').addClass('inputTxtError').after(msg);
        });
                    
                }
            },
            
        })
    }
    else
    {
        $.ajax({
            type: 'PUT',
            url:  '/admin/brokerage_fee/' + data.id,
            data: {
                '_token' : $('input[name=_token]').val(),
                'minimum' : minimum_nocomma,
                'maximum' : maximum_nocomma,
                'amount' : amount_nocomma,
            },
            success: function (data)
            {
                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "rtl": false,
                    "positionClass": "toast-bottom-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": 300,
                    "hideDuration": 1000,
                    "timeOut": 2000,
                    "extendedTimeOut": 1000,
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }
                toastr["success"]("Record updated successfully")

                bftable.ajax.reload();
                $('#bfModal').modal('hide');
                
                $('.modal-title').text('New Brokerage Fee');
            }
        })
    }
});

});

function resetErrors() {
    $('form input, form select').removeClass('inputTxtError');
    $('label.error').remove();
}
</script>
@endpush