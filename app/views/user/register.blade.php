@extends('layouts.base')


@section('body')


<!-- Header -->
<header>
    <div class="container">
        <div class="intro-text">
            <form action = "{{ route('sessions.store') }}" novalidate method="POST">
                
                {{ Form::token(); }}
                <div class="row">
                    <div class="col-sm-6 text-center">
                        
                        
                        <div class="form-group">
                            <input type="text" name = "name" class="form-control" placeholder="Your Firstname *" id="email" required data-validation-required-message="Please enter your email address.">
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="form-group">
                            <input type="text" name = "username" class="form-control" placeholder="Your Username *" id="email" required data-validation-required-message="Please enter your email address.">
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="form-group">
                            <input type="email" name = "email" class="form-control" placeholder="Your Email *" id="email" required data-validation-required-message="Please enter your email address.">
                            <p class="help-block text-danger"></p>
                        </div>
                        
                        <div class="form-group">
                            <input type="password" name = "password" class="form-control" placeholder="Your Password *" id="name" required data-validation-required-message="Please enter your name.">
                            <p class="help-block text-danger"></p>
                        </div>
                        
                    </div>
                    
                    <div class="clearfix"></div>
                    <div class="col-lg-12 text-center">
                        <div id="success">{{ isset($message) ? $message : "" }}</div>
                        <button type="submit" class="btn btn-xl">LOGIN</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</header>
@stop

