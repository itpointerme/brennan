@extends('public')
@section('css/js')
@endsection
@section('content')
<div class="catpos-box">
	<div class="catpos">
		<a href="{{url('')}}">首页</a>
		<em>></em>
		<span>联系我们</span>
	</div>
</div>
<div class="contact-content">
	<div class="contact-top">
		<div class="left">
			<h1>{{$about->title}}</h1>
			<h2>{{$about->addr}}</h2>
			@foreach($contact as $val)
				<div class="message">
					<b>{{$val->post}}</b>
					<p>{{$val->name}}<br>
					{{$val->x_name}}<br>
					电话：{{$val->tel}}<br>
					</p>
				</div>
			@endforeach
		</div>
		<div class="right">
			<img src="{{asset('images/map.jpg')}}" alt="" />
		</div>		
	</div>
	
	<div class="address-content">
		<div class="title">
			布劳宁在全球设有分支机构，其中包括13个位于战略位置的分销中心。
		</div>
		@foreach($distribution as $val)
			<dl>
				<dt>{{$val['0']->fen}}</dt>
				@foreach($val as $val2)
					<dd><a>{{$val2->title}}</a></dd>
				@endforeach
			</dl>
		@endforeach
	</div>
</div>
@endsection
@section('js')