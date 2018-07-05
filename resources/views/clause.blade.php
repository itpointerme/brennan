@extends('public')
@section('css/js')
@endsection
@section('content')
<div class="catpos-box">
	<div class="catpos">
		<a href="{{url('')}}">首页</a>
		<em>></em>
		<span>条款</span>
	</div>
</div>
<div class="tk-content">
	<h1>条款</h1>
	<p>{{$clause->text}}</p>
	<h1>文件</h1>
	<div class="link">
		@foreach($data as $val)
			@if($val->id != 6 && $val->id !=7)
				<a href="{{route('pdf',['id'=>$val->id])}}">{{$val->title}}</a>
			@endif
		@endforeach
		@foreach($data as $val)
			@if($val->id == 6 || $val->id ==7)
				<a href="{{route('clause_show',['id'=>$val->id])}}">{{$val->title}}</a>
			@endif
		@endforeach
	</div>
</div>
@endsection
@section('js')