@extends('public')
@section('css/js')
@endsection
@section('content')
<!--以上可共用-->
<div class="catpos-box">
	<div class="catpos">
		<a href="{{url('')}}">首页</a>
		<em>></em>
		<a href="{{route('clause')}}">条款</a>
		<em>></em>
		<span>{{$clause->title}}</span>
	</div>
</div>
<div class="news-main">
	<h1>{{$clause->title}}</h1>
	<div class="main">
		{!!$clause->text!!}
	</div>
</div>
@endsection
@section('js')