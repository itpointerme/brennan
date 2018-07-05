<!doctype html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<meta name="csrf-token" content="{{ csrf_token() }}" />	
		<meta name="renderer" content="webkit">
		<title>@yield('title')</title>
		<meta name="keywords" content="">
		<meta name="description" content="">	
		@yield('css')
		<!--效果-->
		<link rel="stylesheet" href="{{asset('css/aos.css')}}" />
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
		@yield('css/js')
	</head>
	<body>
		<!--pc头部-->
		@section('header')
		<div class="header-top">
			<div class="header-box">
				<div class="logo">
					<img src="{{asset('images/logo.png')}}" alt="" />
				</div>
				<div class="searchtop">
					<form action="{{route('search')}}" method="post">
						<input type="text" placeholder="输入关键词" name="keywords" />
						<input type="submit" class="sub" value=""/>
					</form>
				</div>
				<div class="right">
					<ul class="item">
						@if(Auth::check())
							<li><a href="{{route('porders')}}" class="order"><img src="{{asset('images/index-icon1.png')}}" alt="" />我的订单</a></li>
							<li><a href="{{route('personal')}}" class="account"><img src="{{asset('images/index-icon2.png')}}" alt="" />我的账户</a></li>
						@else
							<li id='login'><a href="javascript:;" class="account">
								<img src="{{asset('images/index-icon2.png')}}" alt="" />登陆</a>
							</li>
							<li  id='zhuce'>
								<a href="javascript:;" class="account">
									<img src="{{asset('images/index-icon2.png')}}" alt="" />注册</a>
							</li>	
						@endif

						<script type="text/javascript">
							$('#login').on('click', function(){
								$('.register-box').show();
								$('.lg-re .choose-style span').removeClass('on');
								$('.lg-re .choose-style span').eq(0).addClass('on');
								$('.lg-re .register-box').hide();
								$('.lg-re .login-box').eq(0).show();
								
							});
							$('#zhuce').on('click', function(){
								$('.register-box').show();
								$('.lg-re .choose-style span').removeClass('on');
								$('.lg-re .choose-style span').eq(1).addClass('on');
								$('.lg-re .login-box').hide();
								$('.lg-re .login-box').eq(1).show();
								

							});
						</script>
						
						<li><a href="{{route('askaorders')}}" class="cart"><img src="{{asset('images/index-icon3.png')}}" alt="" /></a></li>
					</ul>					
					<div class="language">
						<span>中文<img src="{{asset('images/index-icon4.png')}}" alt="" /></span>
						<ul>
							<li><a href="https://brennaninc.com">EN</a></li>
						</ul>
					</div>					
				</div>
				@section('html')
					@include('layouts/loginForm')
				@endsection
			</div>
		</div>
		<div class="header-bottom">
			<div class="header-box">
				<ul class="nav">
					<li><a href="{{url('/')}}">首页</a></li>
					<li>
						<a href="{{route('shape')}}">产品</a>
						<ul>
							@foreach( $typePub as $k_t => $v_t )
							<li>
								<a href="{{url('goodslist',['cid'=>$v_t['term_id'], 'p'=>1])}}"> 
									{{-- {{str_limit($v_t['name'], 15, '..')}} --}}
									{{$v_t['name']}}
							    </a>
							</li>
							@endforeach
						</ul>
					</li>
					<li><a href="{{route('competitive')}}">竞品查询</a></li>
					<li><a href="#">技术支持</a></li>
					<li><a href="{{route('about')}}">关于我们</a></li>
					<li><a href="{{route('contact')}}">联系我们</a></li>
				</ul>
				<div class="search">
					<form action="{{route('search')}}" method="post">
						<input type="text" placeholder="输入关键词" name="keywords" />
						<input type="submit" class="sub" value=""/>
					</form>
				</div>
			</div>
		</div>	
		<!--wap nav-->
		<div class="mobile-inner-header">
			<div class="mobile-inner-header-icon mobile-inner-header-icon-out"><span></span><span></span><span class="sp1"></span></div>
		</div>
		<div class="mobile-inner-nav">
			<ul class="main-nav">
				<li class="main-li"><a href="#">EN</a></li>
				<li class="main-li"><a href="{{url('/')}}">首页</a></li>
				<li class="main-li">
					<a href="{{url('goodslist/8/1')}}">产品</a>
					<ul>
						@foreach( $typePub as $k_t => $v_t )
							<li>
								<a href="{{url('goodslist',['cid'=>$v_t['term_id'], 'p'=>1])}}"> 
									{{-- {{str_limit($v_t['name'], 15, '..')}} --}}
									{{$v_t['name']}}
							    </a>
							</li>
						@endforeach
					</ul>
				</li>
				<li class="main-li"><a href="{{route('competitive')}}">竞品查询</a></li>
				<li class="main-li"><a href="#">技术支持</a></li>
				<li class="main-li"><a href="{{route('about')}}">关于我们</a></li>
				<li class="main-li"><a href="{{route('contact')}}">联系我们</a></li>
			</ul>
		</div>
		<!--以上可共用-->
		@show
		@yield('content')

		@section('footer')
		<!--以下可共用-->
		@yield('html')
		<!--登录注册弹窗-->
		@extends('public_footer')
		
		<!--wap footer-->
		<div class="footer-wap">
			<ul>
				<li><a href="#"><img src="{{asset('images/index-icon1.png')}}" alt="" />订单</a></li>
				<li><a href="#"><img src="{{asset('images/index-icon2.png')}}" alt="" />账户</a></li>
				<li><a href="#"><img src="{{asset('images/index-icon3.png')}}" alt="" />购物车</a></li>
			</ul>
		</div>
	</body>
	@show
	<!--效果-->
		<script src="{{asset('js/aos.js')}}"></script>
		<script>
			AOS.init({
				easing: 'ease-out-back',
				duration: 1000
			});
			$('.register-box .close').click(function(){
				$('.register-box').hide();
				$('.forgetBox').hide();
				$('.lg-re').show();
			})
			$('.lg-re .choose-style span').click(function(){
				var index = $(this).index();
				$('.lg-re .choose-style span').removeClass('on');
				$(this).addClass('on');
				$('.lg-re .login-box').hide();
				$('.lg-re .login-box').eq(index).show();
			})
			$('.login-box .forget a').click(function(){
				$('.forgetBox').show();
				$('.lg-re').hide();
			})
			//点击发短信按钮
			$(".Submit").click(function(){
				var mcode = Math.round(900000*Math.random()+100000);  
			   	var test = {
				  node:null,
				  count:60,
				  start:function(){
					 if(this.count > 0){
						this.node.innerHTML = this.count--+'s';
						var _this = this;
						setTimeout(function(){
						   _this.start();
						},1000);
					 }else{
						this.node.removeAttribute("disabled");
						this.node.innerHTML = "重新发送";
						this.count = 10;
					 }
				  },
				  //初始化
				  init:function(node){
					 this.node = node;
					 this.node.setAttribute("disabled",true);
					 this.start();
				  }
			   };
				test.init(this);
				$.get(window.location.origin+"/getlogincode",{mobile:$('#mobile').val()},function(data){
            			@if(env('APP_ENV')=='local')
            				console.log(data);
           				@endif
	            }).fail(function(e){
	                console.log( "error "+e);
	            });
					
				return false;
			});


			$(".Submit1").click(function(){
				var mcode = Math.round(900000*Math.random()+100000);  
			   	var test = {
				  node:null,
				  count:60,
				  start:function(){
					 if(this.count > 0){
						this.node.innerHTML = this.count--+'s';
						var _this = this;
						setTimeout(function(){
						   _this.start();
						},1000);
					 }else{
						this.node.removeAttribute("disabled");
						this.node.innerHTML = "重新发送";
						this.count = 10;
					 }
				  },
				  //初始化
				  init:function(node){
					 this.node = node;
					 this.node.setAttribute("disabled",true);
					 this.start();
				  }
			   };
				test.init(this);
				$.get(window.location.origin+"/getlogincode",{mobile:$('#forget_mobile').val()},function(data){
            			@if(env('APP_ENV')=='local')
            				console.log(data);
           				@endif
	            }).fail(function(e){
	                console.log( "error "+e);
	            });
					
				return false;
			});
			//点击注册按钮
			$('#reg').on('click',function(){
	            if(!(/^1[34578]\d{9}$/.test($('#mobile').val())))
            	{
                	alert('手机号不正确');return false;
            	}
	            if($('#yzm').val()=='')
	            {
	                alert('请填写验证码');return false;
	            }
	            if($('#pass').val() == '')
	            {
					alert('请填写密码');return false;
	            }
	            $.post(window.location.origin+"/registertolist",{phone:$('#mobile').val(),pass:$('#pass').val(),code:$('#yzm').val()},
	                function(data){
	                	console.log(data);
	                if(eval('('+data+')').code==0)
	                {
	                    window.location.href='/';
	                }else
	                {
	                    alert(eval('('+data+')').msg);
	                }
	            }).fail(function(e){
	                alert('注册失败，参数错误');
	            });
        	});


        	$('#forget_reg').on('click',function(){
	            if(!(/^1[34578]\d{9}$/.test($('#forget_mobile').val())))
            	{
                	alert('手机号不正确');return false;
            	}
	            if($('#forget_yzm').val()=='')
	            {
	                alert('请填写验证码');return false;
	            }
	            if($('#forget_pass').val() == '')
	            {
					alert('请填写密码');return false;
	            }
	            $.post(window.location.origin+"/registertolist",{phone:$('#forget_mobile').val(),pass:$('#forget_pass').val(),code:$('#forget_yzm').val(),type:1},
	                function(data){
	                	console.log(data);
	                if(eval('('+data+')').code==0)
	                {
	                    window.location.href='/';
	                }else
	                {
	                    alert(eval('('+data+')').msg);
	                }
	            }).fail(function(e){
	                alert('修改失败，参数错误');
	            });
        	});
		</script>
		<script type="text/javascript">
				$(function(){
					
				 	$("input[name='phone']").blur(function()
				 	{
				 		let phone = $("input[name=phone]").val();
				 		validate_phone(phone);
				  	});

				  	$("input[name='password']").blur(function()
				  	{
				 		let password = $("input[name=password]").val();
				 		validate_password(password);
				    	
				  	});
				  	$('#login_form').submit(function(e){
				  		let phone = $("input[name=phone]").val();
						let password = $("input[name=password]").val();
						if(!validate_phone(phone)){event.preventDefault()};
						if(!validate_password(password)){event.preventDefault()};
				  	});
				});
				function validate_phone(phone)
				{
			 		var myreg = /^(((13[0-9]{1})|(14[0-9]{1})|(17[0]{1})|(15[0-3]{1})|(15[5-9]{1})|(18[0-9]{1}))+\d{8})$/;
			    	if(phone &&  myreg.test(phone)){
			    		$('.phone_erro').text('');return true;
					}else{
						$('.phone_erro').text('*您的手机号格式不正确'); return false;
					}
				}

				function validate_password(paw)
				{
					if(paw.length <6){
			    		$('.pass_erro').text('密码长度不小于6位'); return false;
					}else{
						$('.pass_erro').text('');return true;
					};
				}
				
				//产品标题显示
				$('.header-box .nav > li').hover(function(){
					$(this).find('ul').toggle();
				})
				$('.main-nav .main-li').click(function(){
					$(this).find('ul').toggle();
				})

		</script>		
		@yield('js')
		<!-- Swiper JS -->
    	<script src="{{asset('js/swiper-4.1.6.min.js')}}"></script>
		<script src="{{asset('js/PcSiteJs.js')}}"></script>
</html>
