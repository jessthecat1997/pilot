@extends('layouts.log')
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-primary">
        <div class="panel-heading">
          Manage User Roles
        </div>
        <div class="panel-body">
          <form class="form-horizontal" role="form">
            {{ csrf_field() }}

            <div class="form-group">
              <div class="col-md-12">
               <label class="control-label">Select User</label>
               <select class="form-control" id="user_id">
                 @forelse($user as $u)
                 <option value="{{ $u->id }}">Name: {{ $u->name }} | Username: {{ $u->email }}</option>
                 @empty
                 @endforelse
               </select>
             </div>
           </div>
           <div class="form-group">
            <div class="col-md-12">
              <label class="control-label">Select Role</label>
              <select class="form-control" name="role_id">
               @forelse($roles as $r)
               <option value="{{ $r->id }}">{{ $r->name }}</option>
               @empty
               @endforelse
             </select>
           </div>
         </div>
         <div class="form-group">
          <div class="col-md-6 pull-left">
            <button type="button" class="btn btn-primary save-user">
              Save
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
  var us_id = null;
  $(document).ready(function(){

    $(document).on('change', '#user_id', function(e){
      e.preventDefault();
      us_id = $('#user_id').val();
      console.log($('#user_id').val());

      $(document).on('click', '.save-user', function(e){
        console.log(us_id);
        $.ajax({
          type: 'PUT',
          url: '{{ route("roles.index") }}/' + us_id,
          data: {
            '_token' : $('input[name=_token]').val(),
            'role_id' : $('#role_id').val(),
            'user_id' : us_id,
          },
          success: function (data){
            location.reload();
          }
        })
      })
    })
  })

</script>
@endpush
