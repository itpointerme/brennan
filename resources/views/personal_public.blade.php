<!doctype html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">		
		<meta name="renderer" content="webkit">
		<title>@yield('title')</title>
		<meta name="keywords" content="">
		<meta name="description" content="">		
		@yield('css')
		<!--效果-->
    	<link rel="stylesheet" href="{{asset('css/swiper.min.css')}}">
    	<link rel="stylesheet" href="{{asset('css/animate.css')}}">
    	<!--导航-->
		<link href="{{asset('css/main.css')}}" rel="stylesheet" type="text/css"/>
		
    	<!--WebSiteCss-->
		<link rel="stylesheet" type="text/css" href="{{asset('css/PcSiteStyle.css')}}">
		<link rel="stylesheet" type="text/css" href="{{asset('css/1210PcSiteStyle.css')}}">
		<link rel="stylesheet" type="text/css" href="{{asset('css/1050PcSiteStyle.css')}}">
		<link rel="stylesheet" type="text/css" href="{{asset('css/900PcSiteStyle.css')}}">
		
		<!--WebSiteJs-->
		<script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>	
		<script src="{{asset('js/jquery.SuperSlide.2.1.js')}}"></script>	
		
		<!--wap城市-->
		<script src="{{asset('js/picker.min.js')}}"></script>
		<script src="{{asset('js/city.js')}}"></script>
		<!--pc城市-->
		@yield('css/js')
	</head>	
	<body>
		@section('header')
		<div class="member-header-box">
			<div class="member-header-center">
				<a href="{{url('/')}}"><img src="{{asset('images/logo-member.png')}}" alt=""/></a>
			</div>
		</div>
		<div class="member-top-box">
			<div class="member-top-center">
				<div class="left">
					<div class="img">
						<img src="@if(Auth::user()->head) {{Auth::user()->head}} @else {{asset('images/logo-member.png')}} @endif " alt="" />
					</div>
					<div class="font">
						<div class="title">@if($company) {{$company->name}} @endif<span> @if($user) {{$user->phone}} @endif</span></div>
						<div class="level">
							账号安全等级
							<span>
								<img src="{{asset('images/level1.png')}}" alt="" />
								<img src="{{asset('images/level2.png')}}" alt="" />
								<img src="{{asset('images/level3.png')}}" alt="" />
								<img src="{{asset('images/level4.png')}}" alt="" />
								<img src="{{asset('images/level5.png')}}" alt="" />
							</span>
						</div>
					</div>
				</div>
				<div class="right">
					<div class="title">专属销售代表</div>
					<div class="main">
						<div class="img">
							<img src="{{asset('images/tx2.png')}}" alt="" />
						</div>
						<div class="font">
							<p>@if($sale) {{$sale->uname}} @endif</p>
							<p>@if($sale) {{$sale->phone}} @endif</p>
							<p>@if($sale) {{$sale->email}} @endif</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="member-main-box">
			<div class="left">
				<p>订单管理</p>
				<ul>
					<li><a href="{{route('askaorders')}}">新增询价单</a></li>
					<li><a href="{{route('paorders')}}">新增采购订单</a></li>
					<li><a href="{{route('askorders')}}">管理询价订单</a></li>
					<li><a href="{{route('porders')}}">管理采购订单</a></li>
				</ul>
				<p>产品管理</p>
				<ul>
					<li><a href="{{route('accessories')}}">经常采购配件</a></li>
					<li><a href="{{route('pcategory')}}">自定义类目管理</a></li>
					<li><a href="{{route('collection')}}">配件收藏夹</a></li>
				</ul>
				<p>账号管理</p>
				<ul>
					<li><a href="{{route('company')}}">公司信息</a></li>
					<li><a href="{{route('contacts')}}">联系人信息</a></li>
					<li><a href="{{route('password')}}">密码修改</a></li>
					<li><a href="{{route('address')}}">收货地址</a></li>
				</ul>
			</div>
			
			@yield('content')

		</div>
		@show
		<!--以下可共用-->
		@extends('public_footer')
		
		@yield('js')
		<!-- Swiper JS -->
    	<script src="{{asset('js/swiper-4.1.6.min.js')}}"></script>
		<script src="{{asset('js/PcSiteJs.js')}}"></script>
		<script src="{{asset('js/zone.js')}}"></script>
	</body>
</html>