@extends('layouts.default')
@section('title', '主页')

@section('content')
@if (Auth::check())
 <div class="row">
    <div class="col-md-8">
        <section class="status_form">
        @include('shared._status_form')
        </section>
        <h4>微博列表</h4>
        <hr>
        @include('shared._feed')
        </div>
        <aside class="col-md-4">
        <section class="user_info">
        @include('shared._user_info', ['user' => Auth::user()])
        </section>
        </aside>
 </div>
 @else

<div class="jumbotron">
    <h1>Hello Laravel</h1>
    <p class="lead">
    你现在所看到的是 <a href="" >
    </p>
    <p>
    一切，将从这里开始。
    </p>
    @guest
    <p>
    <a class="btn btn-lg btn-success" href="{{ route('signup') }}" role="button">注册</a>
    </p>
    @endguest    
</div>
@endif
@stop