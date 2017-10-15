@extends('layouts.log')

@section('content')
<div class="container" style="margin-top:40px">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong> Login</strong>
                </div>
                <div class="panel-body">
                 <form class="form-signin" role="form" method="POST" action="/login/prelogin">
                    {{ csrf_field() }}
                    <fieldset>
                        <div class="row">
                            <div class="center-block">
                                <img class="profile-img"
                                src="/images/user.png" alt="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-10  col-md-offset-1 ">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </span> 
                                         <input id="email" type="text" class="form-control" name="email" placeholder="Username" required autofocus>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-lock"></i>
                                        </span>
                                        <input id="password" type="password" class="form-control" name="password" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" id="login-btn">Login</button>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
