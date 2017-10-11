@extends('layouts.maintenance')
@section('content')
<div class = "container-fluid">
    <div class = "row">
        <h2>&nbsp;Maintenance | Brokerage | Brokerage Fee</h2>
        <hr>
        <div class = "col-md-3 col-md-offset-9">
            <button  class="btn btn-info btn-md new" data-toggle="modal" data-target="#bfModal" style = "width: 100%;">New Brokerage Fee Range</button>
        </div>
    </div>
    <br />
    <div class = "row">
        <div class = "panel-default panel">
            <div class = "panel-body">
                <table class = "table-responsive table  table-striped cell-border table-bordered" id = "bf_table">
                    <thead>
                        <tr>
                            <td>
                                Date Effective
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
                                Actions
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bfs as $bf)
                        <tr>
                            <td>
                                {{ Carbon\Carbon::parse($bf->dateEffective)->format("F d, Y") }}
                            </td>
                            <td>
                                {{ $bf->minimum}}
                            </td>
                            <td>
                                {{ $bf->maximum}}
                            </td>
                            <td>
                                {{ $bf->amount}}
                            </td>
                            <td>
                                <button value = "{{ $bf->id }}" style="margin-right:10px;" class="btn btn-md btn-primary edit">Update</button><button value = "{{ $bf->id }}" class="btn btn-md btn-danger deactivate">Deactivate</button>
                                <input type = "hidden" class = "date_effective" value = "{{$bf->dateEffective}}">

                            </td>
                        </tr>
                        @empty
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <form role="form" method = "POST" class="commentForm">
        <div class="modal fade" id="bfModal" role="dialog">
            <div class="form-group">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">New Brokerage Fee Range</h4>
                        </div>
                        <div class="modal-body ">       
                            <div class="form-group required">
                                <label class="control-label " for="dateEffective">Date Effective:</label>
                                <input type="date" class="form-control" name = "dateEffective" id="dateEffective" placeholder="Enter Effective Date" data-rule-required="true">
                            </div>

                            <br />
                            <div class = "collapse" id = "bf_table_warning">
                                <div class="alert alert-danger">
                                    <strong>Warning!</strong> Requires at least one brokerage fee.
                                </div>
                            </div>
                            <div class = "collapse" id = "bf_warning">
                                <div class="alert alert-danger">
                                    <strong>Warning!</strong> Something is wrong with the range.
                                </div>
                            </div>
                            <div class = "panel panel-default">
                                <div  style="overflow-x: auto;">
                                    <div class = "panel-default">
                                        {{ csrf_field() }}
                                        <table class="table responsive table-hover" width="100%" id= "bf_parent_table" style = "overflow-x: scroll; left-margin: 5px; right-margin: 5px;">
                                            <thead>
                                                <tr>
                                                    <td width="20%">
                                                        <div class="form-group required">
                                                            <label class = "control-label"><strong>Minimum Dutiable Value</strong></label>
                                                        </div>
                                                    </td>
                                                    <td width="20%">
                                                        <div class="form-group required">
                                                            <label class = "control-label"><strong>Maximum Dutiable Value</strong></label>
                                                        </div>
                                                    </td>

                                                    <td width="20%">
                                                        <div class="form-group required">
                                                            <label class = "control-label"><strong>Brokerage Fee Amount</strong></label>
                                                        </div>
                                                    </td>
                                                    <td width="10%" style="text-align: center;">
                                                        <strong>Action</strong>
                                                    </td>
                                                </tr>
                                            </thead>
                                            <tr id = "bf-row">
                                                <td>

                                                    <div class = "form-group input-group" >
                                                        <span class = "input-group-addon">$</span>
                                                        <input type = "text" class = "form-control money bf_minimum_valid"  
                                                        value ="0.00" name = "minimum" id = "minimum"  data-rule-required="true" readonly="true"  />
                                                    </div>

                                                </td>
                                                <td>
                                                    <div class = "form-group input-group">
                                                        <span class = "input-group-addon">$</span>
                                                        <input type = "text" class = "form-control money bf_maximum_valid" value ="0.00" name = "maximum" id = "maximum" />
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class = "form-group input-group " >
                                                        <span class = "input-group-addon">Php</span>
                                                        <input type = "text" class = "form-control money amount_valid" value ="0.00" name = "amount" id = "amount"  data-rule-required="true" />
                                                    </div>

                                                </td>
                                                <td style="text-align: center;">
                                                    <button class = "btn btn-danger btn-md delete-bf-row">x</button>
                                                </td>
                                            </tr>
                                        </table>
                                        <div class = "form-group" style = "margin-left:10px">
                                            <button    class = "btn btn-primary btn-md new-bf-row pull-left">New Range</button>
                                            <br /><br />
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button id = "btnSave" type = "submit" class="btn btn-success finalize-bf">Save</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>           
                        </div>
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

@endsection
@push('styles')
<style>
.class-brokerage-fee
{
    border-left: 10px solid #8ddfcc;
    background-color:rgba(128,128,128,0.1);
    color: #fff;
}
.maintenance
{
    border-left: 10px solid #8ddfcc;
    background-color:rgba(128,128,128,0.1);
    color: #fff;
}

</style>
@endpush
@push('scripts')
<script type="text/javascript">
    $('#brokeragecollapse').addClass('in');
    $('#collapse2').addClass('in');
    var minimum_id = [];
    var maximum_id = [];

    var amount_value = [];
    var minimum_id_descrp = [];
    var maximum_id_descrp = [];
    var amount_value_descrp = [];



    var data,bf_id;

    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;


    $(document).ready(function(){
        var bf_row = "<tr>" + $('#bf-row').html() + "</tr>";

        $('.money').each(function(){
            $(this).inputmask("numeric", {
                radixPoint: ".",
                groupSeparator: ",",
                digits: 2,
                autoGroup: true,
                rightAlign: true,
                removeMaskOnSubmit:true,
            })

        })
        
        //$(minimum).attr("disabled", true);

        var bftable = $('#bf_table').DataTable({
            processing: false,
            serverSide: false,
            deferRender:true,
            'scrollx': true,
            columns: [

            { data: 'dateEffective' },

            { data: 'minimum',
            "render": function(data, type, row){
                return data.split("\n").join("<br/>");}
            },
            { data: 'maximum',
            "render": function(data, type, row){
                return data.split("\n").join("<br/>");}
            },
            { data: 'amount',
            "render": function(data, type, row){
                return data.split("\n").join("<br/>");}
            },
            { data: 'action', orderable: false, searchable: false }

            ],  "order": [[ 0, "desc" ]],


        });

        $("#commentForm").validate({
            rules: 
            {
                dateEffective:
                {
                    required: true,
                    date:true,
                },

                
            },
            onkeyup: function(element) {$(element).valid()
            }, 
            
        });

        $(document).on('click', '.new', function(e){
            resetErrors();
            $('.modal-title').text('New Brokerage Fee Range');

            $('#dateEffective').val(today);

            $("#bf_parent_table > tbody").html("");
            $('#bf_parent_table > tbody').html(bf_row);
            $('#minimum').val("0.00");
            $('#maximum').val("0.00");
            $('#amount').val("0.00");
            $('.money').each(function(){
                $(this).inputmask("numeric", {
                    radixPoint: ".",
                    groupSeparator: ",",
                    digits: 2,
                    autoGroup: true,
                    rightAlign: true,
                    removeMaskOnSubmit:true,
                })

            })
            $('#bfModal').modal('show');
        });


        $(document).on('click', '.edit',function(e){
            resetErrors();
            bf_id = $(this).val();
            $('.modal-title').text('Update Brokerage Fee Range');
            data = bftable.row($(this).parents()).data();
            $('#dateEffective').val($(this).closest('tr').find('.date_effective').val());
            console.log($(this).closest('tr').find('.date_effective').val());

            $('#bfModal').modal('show');

            $.ajax({
                type: 'GET',
                url:  '{{ route("bf_maintain_data") }}',
                data: {
                    '_token' : $('input[name=_token').val(),
                    'bf_id' : $(this).val(),
                },
                success: function (data)
                {
                    var rows = "";
                    for(var i = 0; i < data.length; i++){
                        rows += '<tr id = "bf-row"><td><div class = "form-group input-group" ><span class = "input-group-addon">$</span><input type = "text" class = "form-control bf_minimum_valid money" value ="' + data[i].minimum + '" name = "minimum" id = "minimum"  data-rule-required="true" readonly="true"  style="text-align: right" /></div></td><td><div class = "form-group input-group"><span class = "input-group-addon">$</span><input type = "text" class = "form-control money bf_maximum_valid" value ="'+ data[i].maximum+'" name = "maximum" id = "maximum"  data-rule-required="true" style="text-align: right;" /></div></td><td><div class = "form-group input-group " ><span class = "input-group-addon">Php</span><input type = "text" class = "form-control amount_valid money" value ="'+ data[i].amount+'" name = "amount" id = "amount"  data-rule-required="true"  style="text-align: right;"/></div></td><td style="text-align: center;"><button class = "btn btn-danger btn-md delete-bf-row">x</button></td></tr>';

                    }
                    $('#bf_parent_table > tbody').html("");
                    $('#bf_parent_table > tbody').append(rows);

                    $('.money').each(function(){
                        $(this).inputmask("numeric", {
                            radixPoint: ".",
                            groupSeparator: ",",
                            digits: 2,
                            autoGroup: true,
                            rightAlign: true,
                            removeMaskOnSubmit:true,
                        })

                    })
                    
                }

            })
        });

        $(document).on('click', '.deactivate', function(e){
           bf_id = $(this).val();
           data = bftable.row($(this).parents()).data();
           $('#confirm-delete').modal('show');
       });


        $(document).on('click', '.delete-bf-row', function(e){
            e.preventDefault();

            if($('#bf_parent_table > tbody > tr').length == 1){

                var obj = $(this).closest('tr');
                $(obj).nextAll().each(function(){
                    $(this).remove();
                })
                obj.remove();
                $('#bf_table_warning').addClass('fade in');

            }
            else{
                var obj = $(this).closest('tr');
                $(obj).nextAll('tr').each(function(){
                    $(this).remove();
                })
                obj.remove();
                $('#bf_table_warning').removeClass('fade in');

            }
        })

        $(document).on('click', '.new-bf-row', function(e){
            e.preventDefault();
            $('#bf_table_warning').removeClass('fade in');
            if(validatebfRows() === true){
               $('input[name=maximum]').each(function(){
                $(this).attr("readonly", "true");

            });

               $('#bf_parent_table').append(bf_row);
               $('.money').each(function(){
                $(this).inputmask("numeric", {
                    radixPoint: ".",
                    groupSeparator: ",",
                    digits: 2,
                    autoGroup: true,
                    rightAlign: true,
                    removeMaskOnSubmit:true,
                })

            })

               $(this).closest('tr').find('.bf_maximum_valid').attr('readonly', true);
               $(this).closest('tr').find('.bf_minimum_valid').attr('readonly', true);
               for(var i = 0; i < minimum.length; i++){
                minimum[i+1].value = (parseFloat("" +$(maximum[i]).inputmask('unmaskedvalue')) + 0.01).toFixed(2);
            }

        }

    })

        $(document).on('change', '.bf_minimum_valid', function(e){
            $(".bf_minimum_valid").each(function(){
                if($(this).val() != ""){
                    $(this).css('border-color', 'green');
                    $('#bf_warning').removeClass('in');

                }
                else{
                    $(this).css('border-color', 'red');
                }
            });
        })

        $(document).on('change', '.bf_minimum_valid', function(e){
            $(".bf_minimum_valid").each(function(){
                if($(this).val() != ""){
                    $(this).css('border-color', 'green');
                    $('#bf_warning').removeClass('in');

                    for(var i = 0; i < minimum.length; i++){
                        minimum[i+1].value = parseFloat(maximum[i].value) + 0.01;
                    }
                }
                else{
                    $(this).css('border-color', 'red');
                }
            });
        })

        $(document).on('keypress', '.amount_valid', function(e){
            $(".amount_valid").each(function(){
                try{
                    var amount = parseFloat($(this).val());
                }
                catch(err){

                }
                if(typeof(amount) === "string"){

                }
                else{

                }
                if($(this).val() != ""){
                    $(this).css('border-color', 'green');
                    $('#bf_warning').removeClass('in');
                }
                else{
                    $(this).css('border-color', 'red');
                }
            });
        })

        $('#btnDelete').on('click', function(e){
            e.preventDefault();
            $.ajax({
                type: 'DELETE',
                url:  '/admin/brokerage_fee/' + bf_id,
                data: {
                    '_token' : $('input[name=_token').val()
                },
                success: function (data)
                {
                    bftable.ajax.url( '{{ route("bf.data") }}' ).load();
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

        $(document).on('click', '.finalize-bf', function(e){
            e.preventDefault();


            if(finalvalidatebfRows() === true && $('#bf_parent_table > tbody > tr').length > 0 ){

                var title = $('.modal-title').text();

                
                if(title == "New Brokerage Fee Range"){

                   if ($('#dateEffective').valid()){
                    console.log('min' + minimum_id);    
                    console.log(maximum_id);    
                    jsonMinimum = JSON.stringify(minimum_id);
                    jsonMaximum = JSON.stringify(maximum_id);
                    jsonAmount = JSON.stringify(amount_value);

                    $.ajax({
                        type: 'POST',
                        url:  '/admin/brokerage_fee',
                        data: {
                            '_token' : $('input[name=_token]').val(),
                            'dateEffective' : $('#dateEffective').val(),
                            'minimum' : jsonMinimum,
                            'maximum' :jsonMaximum,
                            'amount' : jsonAmount,
                        },

                        success: function (data){

                            if(typeof(data) === "object"){
                                bftable.ajax.url( '{{ route("bf.data") }}' ).load();
                                $('#bfModal').modal('hide');
                                $('.modal-title').text('New Brokerage Fee Range');
                                $('#minimum').val("0.00");
                                $('#maximum').val("0.00"); 
                                $('#amount').val("0.00");

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
                                toastr["success"]("Record added successfully")
                                $('#btnSave').removeAttr('disabled');
                            }else{

                                e.preventDefault();
                                resetErrors();
                                var invdata = JSON.parse(data);
                                $.each(invdata, function(i, v) {
                                    console.log(i + " => " + v);
                                    var msg = '<label class="error" for="'+i+'">'+v+'</label>';
                                    $('input[name="' + i + '"], select[name="' + i + '"]').addClass('inputTxtError').after(msg);
                                });
                            }
                        }
                    })
                    
                }
                
            }else{
                if ($('#dateEffective').valid()){
                       // $('#btnSave').attr('disabled', 'true');
                       jsonMinimum = JSON.stringify(minimum_id);
                       jsonMaximum = JSON.stringify(maximum_id);
                       jsonAmount = JSON.stringify(amount_value);

                       $.ajax({
                        type: 'PUT',
                        url:  '/admin/brokerage_fee/' + bf_id,
                        data: {
                            '_token' : $('input[name=_token]').val(),
                            'dateEffective' : $('#dateEffective').val(),
                            'minimum' : jsonMinimum,
                            'maximum' :jsonMaximum,
                            'amount' : jsonAmount,
                            'bf_head_id': bf_id,
                        },

                        success: function (data){
                            bftable.ajax.url( '{{ route("bf.data") }}' ).load();
                            $('#bfModal').modal('hide');
                            $('.modal-title').text('New Brokerage Fee Range');
                            $('#minimum').val("0.00");
                            $('#maximum').val("0.00"); 
                            $('#amount').val("0.00");



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
                            $('#btnSave').removeAttr('disabled');
                        }
                    })
                   }
               }

           }
       });
});





function validatebfRows()
{

    minimum_id = [];
    maximum_id = [];
    amount_value = [];

    minimum_id_descrp = [];
    maximum_id_descrp = [];
    amount_value_descrp = [];

    range_pairs = [];
    dateEffective = document.getElementsByName('dateEffective');
    minimum =  document.getElementsByName('minimum');
    maximum =   document.getElementsByName('maximum');
    amount =  document.getElementsByName('amount');
    error = "";
    var min;
    var max;
    var amt;

    if(dateEffective === ""){

        dateEffective.style.borderColor = 'red';    
        error += "Date Effective Required.";

    } 

    
    for(var i = 0; i < minimum.length; i++){
        var temp;


        amt = parseFloat($(amount[i]).inputmask('unmaskedvalue'))
        max = parseFloat($(maximum[i]).inputmask('unmaskedvalue'))
        min = parseFloat($(minimum[i]).inputmask('unmaskedvalue'))

        if(max < 0)
        {
            maximum[i].style.borderColor = 'red';
            error += "Maximum Required.";
        }

        else
        {
            maximum[i].style.borderColor = 'green';
            maximum_id_descrp.push($(maximum[i]).inputmask('unmaskedvalue'));
            maximum_id.push($(maximum[i]).inputmask('unmaskedvalue'));
            $('#bf_warning').removeClass('in');
        }

        if(amt < 0)
        {
            amount[i].style.borderColor = 'red';
            error += "Amount Required.";
        }

        else
        {

            amount[i].style.borderColor = 'green';
            amount_value.push($(amount[i]).inputmask('unmaskedvalue'));
            $('#bf_warning').removeClass('in');

        }

        if($(minimum[i]).inputmask('unmaskedvalue') === $(maximum[i]).inputmask('unmaskedvalue')){

            maximum[i].style.borderColor = 'red';
            error += "Same.";
        }

        if($(minimum[i]).inputmask('unmaskedvalue') > $(maximum[i]).inputmask('unmaskedvalue')){

            maximum[i].style.borderColor = 'red';
            error += "Minimum is greater than maximum";
            $('#bf_warning').addClass('in');
        }   

        pair = {
            minimum: $(minimum[i]).inputmask('unmaskedvalue'),
            maximum : $(maximum[i]).inputmask('unmaskedvalue')
        };
        console.log($(minimum[i]).inputmask('unmaskedvalue'));
        console.log($(maximum[i]).inputmask('unmaskedvalue'));
        range_pairs.push(pair);
    }
    var i, j, n;
    found= false;
    n=range_pairs.length;

    for (i=0; i<n; i++) {                        
        for (j=i+1; j<n; j++)
        {              
            if (range_pairs[i].minimum === range_pairs[j].maximum && range_pairs[i].maximum === range_pairs[j].maximum){
                found = true;
                
                maximum[i].style.borderColor = 'red';

                minimum[j].style.borderColor = 'red';
                maximum[j].style.borderColor = 'red';
            }
        }   
    }
    if(found == true){
        error+= "Existing rate.";
    }

        //Final validation
        if(error.length == 0){
            return true;
        }

        else
        {
            console.log(error);
            return false;
        }

    }

    function finalvalidatebfRows()
    {
        minimum_id = [];
        maximum_id = [];
        amount_value = [];

        minimum_id_descrp = [];
        maximum_id_descrp = [];
        amount_value_descrp = [];

        range_pairs = [];

        minimum = document.getElementsByName('minimum');
        maximum = document.getElementsByName('maximum');
        amount = document.getElementsByName('amount');
        var min, max, amt;
        error = "";

        if($('#dateEffective').val() == ""){


            error += "Date Effective Required.";
        }

        for(var i = 0; i < minimum.length; i++){
         amt = parseFloat($(amount[i]).inputmask('unmaskedvalue'))
         max = parseFloat($(maximum[i]).inputmask('unmaskedvalue'))
         min = parseFloat($(minimum[i]).inputmask('unmaskedvalue'))

         if(min < 0)
         {

            error += "Minimum Required.";
            $('#bf_warning').addClass('in');
        }

        else
        {

            minimum_id_descrp.push($(minimum[i]).inputmask('unmaskedvalue'));
            var min = $(minimum[i]).inputmask('unmaskedvalue');
            minimum_id.push($(minimum[i]).inputmask('unmaskedvalue') );
        }
        if(max < 0 )
        {
            maximum[i].style.borderColor = 'red';
            error += "Maximum Required.";
            $('#bf_warning').addClass('in');
        }

        else
        {
            maximum[i].style.borderColor = 'green';
            maximum_id_descrp.push($(maximum[i]).inputmask('unmaskedvalue'));
            maximum_id.push($(maximum[i]).inputmask('unmaskedvalue'));
            $('#bf_warning').removeClass('in');
        }

        if(amt < 0)
        {
            amount[i].style.borderColor = 'red';
            error += "Amount Required.";
            $('#contract_rates_warning').addClass('in');
        }

        else
        {

            amount[i].style.borderColor = 'green';
            amount_value.push($(amount[i]).inputmask('unmaskedvalue'));
            $('#bf_warning').removeClass('in');

        }

        if($(minimum[i]).inputmask('unmaskedvalue') === $(maximum[i]).inputmask('unmaskedvalue')){

            maximum[i].style.borderColor = 'red';
            error += "Same.";
            $('#bf_warning').addClass('in');
        }

        if($(minimum[i]).inputmask('unmaskedvalue') > $(maximum[i]).inputmask('unmaskedvalue')){

            maximum[i].style.borderColor = 'red';
            error += "Minimum is greater than maximum";
            $('#bf_warning').addClass('in');
        }   
        pair = {
            minimum: $(minimum[i]).inputmask('unmaskedvalue'),
            maximum:$(maximum[i]).inputmask('unmaskedvalue')
        };
        range_pairs.push(pair);
    }
    var i, j, n;
    found= false;
    n=range_pairs.length;
    for (i=0; i<n; i++) {                        
        for (j=i+1; j<n; j++)
        {              
            if (range_pairs[i].minimum === range_pairs[j].minimum && range_pairs[i].maximum === range_pairs[j].maximum){
                found = true;
                
                maximum[i].style.borderColor = 'red';


                maximum[j].style.borderColor = 'red';
            }
        }   
    }
    if(found == true){
        error+= "Existing rate.";
        $('#bf_warning').addClass('in');
    }

    if(error.length == 0){
        return true;
    }
    else
    {
        return false;
    }
}
function resetErrors() {
    $('form input, form select').removeClass('inputTxtError');
    $('label.error').remove();
}
</script>
@endpush