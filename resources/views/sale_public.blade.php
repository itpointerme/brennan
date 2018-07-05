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
		<link href="css/main.css" rel="stylesheet" type="text/css"/>
		
    	<!--WebSiteCss-->
		<link rel="stylesheet" type="text/css" href="{{asset('css/PcSiteStyle.css')}}">
		<link rel="stylesheet" type="text/css" href="{{asset('css/1210PcSiteStyle.css')}}">
		<link rel="stylesheet" type="text/css" href="{{asset('css/1050PcSiteStyle.css')}}">
		<link rel="stylesheet" type="text/css" href="{{asset('css/900PcSiteStyle.css')}}">
		
		<!--WebSiteJs-->
		<script src="{{asset('js/jquery-1.11.1.min.js')}}"></script>	
		<script src="{{asset('js/jquery.SuperSlide.2.1.js')}}"></script>	
		@yield('css/js')
	</head>	
	<body>
		@section('header')
		<div class="member-header-box">
			<div class="member-header-center">
				<a href="{{url('/')}}"><img src="{{asset('images/logo-member.png')}}" alt=""/></a>
			</div>
		</div>
		<div class="member-sale-box">
			<div class="sale-left">
				<div class="img">
					<img src="{{asset('images/tx2.png')}}" alt="" />
				</div>
				<div class="name">{{Auth::user()->uname}}</div>
				
				<ul>
					<li><a href="{{route('aorders')}}">管理询价订单</a></li>
					<li><a href="{{route('sorders')}}">管理采购订单</a></li>
					<li><a href="{{route('mycustomer')}}">我的客户</a></li>
					<li><a href="{{route('stock')}}">库存查询</a></li>
					<li><a href="{{route('saledata')}}">我的资料</a></li>
					<li><a href="{{route('salepassword')}}">密码修改</a></li>
				</ul>
			</div>
			<div class="sale-right">
				<div class="title"><span>@yield('nav_title')</span></div>
				
				@yield('content')
			</div>
			
		</div>
		@show
		
		<!--以下可共用-->
		@extends('public_footer')
		
		@yield('js')
		<!-- Swiper JS -->
    	<script src="{{asset('js/swiper-4.1.6.min.js')}}"></script>
		<script src="{{asset('js/PcSiteJs.js')}}"></script>
	</body>
</html>