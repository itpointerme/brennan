@extends('public')
@section('css/js')
@endsection
@section('content')
<div class="catpos-box">
	<div class="catpos">
		<a href="{{url('')}}">首页</a>
		<em>></em>
		<span>文献与认证</span>
	</div>
</div>
<div class="tk-content">
	<h1>文献与认证</h1>
	<p>{{$authentication->text}}</p>
	
	@foreach($data as $val)
		<h1>{{$val['0']->fen}}</h1>
		<div class="link">
			@foreach($val as $val2)
				<a href="{{route('authentication_pdf',['id'=>$val2->id])}}">{{$val2->title}}</a>
			@endforeach
		</div>
	@endforeach
</div>
@endsection
@section('js')