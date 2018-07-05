@extends('public')
@section('css/js')
@endsection
@section('content')
<!--以上可共用-->
<div class="catpos-box">
	<div class="catpos">
		<a href="{{url('')}}">首页</a>
		<em>></em>
		<span>关于我们</span>
	</div>
</div>
<div class="about-content1">
	<div class="about1">
		<div class="img"><img src="{{asset('images/about1.png')}}" alt="" /></div>
		<div class="font">
			<h1>{{$about->title}}</h1>
			<p>{{$about->content}}</p>
			<img src="{{asset('images/about1-img.png')}}" alt="" />
		</div>
	</div>
</div>
<div class="about-content2">
	<div class="about2">
		@foreach($year as $key=>$val)
			@if($key == 0)
				<div class="dsj-box on">
					<div class="img">
						<img src='{{asset("uploads/$val->img")}}' alt="" />
					</div>
					<div class="font">
						<h1>{{$val->year}}</h1>
						<p>{{$val->description}}</p>
					</div>
				</div>
			@else
				<div class="dsj-box">
					<div class="img">
						<img src='{{asset("uploads/$val->img")}}' alt="" />
					</div>
					<div class="font">
						<h1>{{$val->year}}</h1>
						<p>{{$val->description}}</p>
					</div>
				</div>
			@endif
		@endforeach
		<a href="javascript:;" class="left"><img src="{{asset('images/left.png')}}" alt="" /></a>
		<a href="javascript:;" class="right"><img src="{{asset('images/right.png')}}" alt="" /></a>
		<div class="dsj-list">
			<p><span></span></p>
			<ul>
				@foreach($year as $key=>$val)
					@if($key == 0)
						<li class="on"><span>{{$val->year}}</span></li>
					@else
						<li><span>{{$val->year}}</span></li>
					@endif
				@endforeach
			</ul>
		</div>
		<div class="dsj-list-wap">
			<p><span></span></p>
			<ul>
				@foreach($year as $key=>$val)
					@if($key == 0)
						<li class="on"><span>{{$val->year}}</span></li>
					@else
						<li><span>{{$val->year}}</span></li>
					@endif
				@endforeach
			</ul>
		</div>		
	</div>						
</div>
<div class="about-content3">
	<div class="about3">
		<ul>
			<li>
				<div class="img">
					<img src='{{asset("uploads/$about->img1")}}' alt="" />
				</div>
				<h2>{{$about->title1}}</h2>
				<p>{{$about->text1}}</p>
			</li>
			<li>
				<div class="img">
					<img src='{{asset("uploads/$about->img2")}}' alt="" />
				</div>
				<h2>{{$about->title2}}</h2>
				<p>{{$about->text2}}</p>
			</li>
			<li>
				<div class="img">
					<img src='{{asset("uploads/$about->img2")}}' alt="" />
				</div>
				<h2>{{$about->title3}}</h2>
				<p>{{$about->text3}}</p>
			</li>
			<li>
				<div class="img">
					<img src='{{asset("uploads/$about->img2")}}' alt="" />
				</div>
				<h2>{{$about->title4}}</h2>
				<p>{{$about->text4}}</p>
			</li>
		</ul>
	</div>			
</div>
<script>
	var zwidth = $('.dsj-list').width();	
	$('.dsj-list ul li').width(zwidth/11-20);
	var num = $('.dsj-list ul li').length;
	var w = $('.dsj-list ul li').outerWidth();
	var w1 = w/2;
	var hwidth = $('.dsj-list').width()/2+w1;			
	var width = num*w;			
	$('.dsj-list ul').width(width+'px');
	$('.dsj-list p').width(width+'px');
	$('.about2 .left').click(function(){
		var ind = 0;
		$('.dsj-list ul li').each(function(){
			if($(this).hasClass('on')){
				ind  =$(this).index();
			}					
		})		
		var eq = ind-1;
		if(ind == 0){
			eq = 0;
		}
		$('.dsj-list ul li').eq(eq).click();
	})	
	$('.about2 .right').click(function(){
		var ind = 0;
		$('.dsj-list ul li').each(function(){
			if($(this).hasClass('on')){
				ind  =$(this).index();
			}					
		})		
		var eq = ind+1;
		if(ind == length-1){
			eq = length-1;
		}
		$('.dsj-list ul li').eq(eq).click();
	})	
	$('.dsj-list ul li').click(function(){
		var index = $(this).index();		
		var length = $('.dsj-list ul li').length-1;
		$('.dsj-list ul li').removeClass('on');
		$(this).addClass('on');
		$('.dsj-box').removeClass('on');
		$('.dsj-box').eq(index).addClass('on');
		var span = parseInt(index*w);
		var spanW = span+w1;
		$('.dsj-list p span').width(spanW+'px');
		var max = length-5;
		$('.dsj-box').removeClass('on');
		$('.dsj-box').eq(index).addClass('on');
		
		if(index >=5){
			if(index >= max){						
				var spanN = 11-(length-index)-1;
				var span = parseInt(spanN*w);
				var spanW = span+w1;							
				$('.dsj-list p span').width(spanW+'px');
				index = max;
				var num = index-5;
				var left = num*w;
				$('.dsj-list ul').animate({'left':-left+'px'});	
			}else{
				var num = index-5;
				var left = num*w;
				$('.dsj-list p span').width(hwidth+'px');
				$('.dsj-list ul').animate({'left':-left+'px'});		
			}
				
		}else{
			$('.dsj-list ul').animate({'left':0+'px'});
		}
	})			
</script>


<script>
	var zwidthwap = $('.dsj-list-wap').width();	
	
	$('.dsj-list-wap ul li').width(zwidthwap/3-20);
	var numwap = $('.dsj-list-wap ul li').length;
	var wwap = $('.dsj-list-wap ul li').outerWidth();
	var w1wap = wwap/2;			
	var hwidthwap = zwidthwap/2;			
	var widthwap = numwap*wwap;			
	$('.dsj-list-wap ul').width(widthwap+'px');
	$('.dsj-list-wap p').width(widthwap+'px');
	$('.about2 .left').click(function(){
		var ind = 0;
		$('.dsj-list-wap ul li').each(function(){
			if($(this).hasClass('on')){
				ind  =$(this).index();
			}					
		})		
		var eq = ind-1;
		if(ind == 0){
			eq = 0;
		}
		$('.dsj-list-wap ul li').eq(eq).click();
	})	
	$('.about2 .right').click(function(){
		var ind = 0;
		$('.dsj-list-wap ul li').each(function(){
			if($(this).hasClass('on')){
				ind  =$(this).index();
			}					
		})		
		var eq = ind+1;
		if(ind == length-1){
			eq = length-1;
		}
		$('.dsj-list-wap ul li').eq(eq).click();
	})	
	$('.dsj-list-wap ul li').click(function(){
		var index = $(this).index();		
		var length = $('.dsj-list-wap ul li').length-1;
		$('.dsj-list-wap ul li').removeClass('on');
		$(this).addClass('on');
		$('.dsj-box-wap').removeClass('on');
		$('.dsj-box-wap').eq(index).addClass('on');
		var span = parseInt(index*wwap);
		var spanW = span+w1wap;
		$('.dsj-list-wap p span').width(spanW+'px');
		var max = length-1;
		$('.dsj-box').removeClass('on');
		$('.dsj-box').eq(index).addClass('on');				
		if(index >=1){
			if(index > max){						
//						var spanN = 3-(length-index)-1;
//						var span = parseInt(spanN*w);
//						var spanW = span+w1;							
				$('.dsj-list-wap p span').width(zwidthwap+'px');
				index = max;
				var num = index-1;
				var left = num*wwap;
				$('.dsj-list-wap ul').animate({'left':-left+'px'});	
			}else{
				var num = index-1;
				var left = num*wwap;
				$('.dsj-list-wap p span').width(hwidthwap+'px');
				$('.dsj-list-wap ul').animate({'left':-left+'px'});		
			}
				
		}else{
			$('.dsj-list-wap ul').animate({'left':0+'px'});
		}
	})
</script>
@endsection
@section('js')