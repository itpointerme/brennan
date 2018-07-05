@extends('public')
@section('css/js')
@endsection
@section('content')
<!--以上可共用-->
<div class="catpos-box">
	<div class="catpos">
		<a href="{{url('')}}">首页</a>
		<em>></em>
		<span>公司新闻</span>
	</div>
</div>
<div class="news-content">
	<ul class="news_list">
		@foreach($news as $val)
			<li>
				<a href="{{route('news_show',['id'=>$val->id])}}">
					<span class="img"><img src='{{asset("uploads/$val->img")}}' alt="" /></span>						
					<h1>{{$val->title}}</h1>
					<p>{{$val->description}}</p>
					<h3>发布时间 <span>{{str_limit($val->created_at,10,'')}}</span></h3>
				</a>
			</li>
		@endforeach
	</ul>
	{{$news->links()}}
</div>
@endsection
@section('js')