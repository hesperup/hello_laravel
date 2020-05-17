@extends('layouts.default')
@section('title', '主页')

@section('content')
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
@stop