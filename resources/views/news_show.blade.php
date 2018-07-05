@extends('public')
@section('css/js')
@endsection
@section('content')
<!--以上可共用-->
<div class="catpos-box">
	<div class="catpos">
		<a href="{{url('')}}">首页</a>
		<em>></em>
		<a href="{{route('news')}}">公司新闻</a>
		<em>></em>
		<span>新闻详情</span>
	</div>
</div>
<div class="news-main">
	<h1>{{$data->title}}</h1>
	<h2>发布日期：{{str_limit($data->created_at,10,'')}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;浏览次数：54</h2>
	<div class="main">
		{!!$data->text!!}
	</div>
	<div class="relative">
		<div class="share">	
			<span>分享</span>
			<div class="bdsharebuttonbox">
				<a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a>
				<a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>
				<a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a>						
			</div>
		</div>
		<div class="relative-news">
			<h4>相关阅读</h4>
			<ul>
				@foreach($data2 as $val)
					<li><a href="{{route('news_show',['id'=>$val->id])}}">{{$val->title}}</a></li>
				@endforeach
			</ul>
		</div>
	</div>
</div>
@endsection
@section('js')