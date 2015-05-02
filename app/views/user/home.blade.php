@extends('layouts.base')


@section('body')


<section>

    <div class ='container'>

        <h1> User Home: {{ Auth::user()->username }}</h1>


        <input type="hidden" value="{{ Auth::user()->username}}" id ="username"/>
        <input type="hidden" value="{{ $_SERVER['SERVER_NAME'] }}" id ="current-enviroment"/>

        @foreach ($users as $user)
        @if ($user->username != Auth::user()->username)
        <div class ='row' id = "lobby-{{ $user->username }}" >

            <div class ="col-lg-2">
                User Name :

            </div>

            <div class="col-lg-3">

                {{ $user->username }}

            </div>


            <div class ="col-lg-2 status">
                Offline
                
            </div>
            <div class ="col-lg-2 request">
                @if ($user->is_a_friend())
                <button class="ladda-button" data-color="purple" data-style="contract" disabled="disabled">FRIEND</button>
                @elseif ($user->request_sent())
                <button class="ladda-button" data-color="purple" data-style="contract">PING</button>
                @else
                <button class="ladda-button" data-color="purple" data-style="contract" disabled="disabled">SENT</button>
                @endif
            </div>
            
        </div>
        
        <div class ="row">
            <hr/>
        </div>
        @endif
        @endforeach

    </div>

</section>

@stop


@section('all_script')
@parent
{{ HTML::script('js/strophe.js') }}   
{{ HTML::script('js/strophe.muc.js') }}   
{{ HTML::script('js/leaderboard.js') }}   
{{ HTML::script('js/main.js')}}

@stop