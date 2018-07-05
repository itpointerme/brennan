@extends('public')
@section('css/js')
@endsection
@section('content')
<div class="catpos-box">
			<div class="catpos">
				<a href="#">首页</a>
				<em>></em>
				<span>目录</span>
				<em>></em>
				<span>查找配件</span>				
			</div>
		</div>
		<div class="proBox2">
			<div class="title lighter">第1步：选择形状</div>
			<div class="choose-allready">
				<div class="t">您选择了：</div>
				<div class="img"><img src="{{asset('images/4-1.jpg')}}" alt="" /></div>
				<div class="font">
					<p>弯头产品</p>
					<span>Straight</span>
				</div>
			</div>
			<div class="title lighter">第2步：选择连接形式</div>
			<div class="choose-allready">
				<div class="t">您选择了：</div>
				<div class="img"><img src="{{asset('images/4-8.jpg')}}" alt="" /></div>
				<div class="font">
					<p>{{$connection['title']}}</p>
				</div>
			</div>
			<div class="title lighter">第3步：选择材质</div>
			<div class="choosebox1 color">
				@foreach($stuff as $k => $v)
				<div class="choose1" stuff = "{{$v['id']}}" >					
					<div class="img">
						<div class="conner"></div>
						<img src="{{asset('images/4-color1.jpg')}}" alt="" />
					</div>
					<p>{{$v['stuff_name']}}</p>
				</div>
				@endforeach
			</div>
			<div class="link"><a href="/connect/{{$cid}}/{{$sid}}" class="prev">上一步</a><a href="javascript:;" onclick='nextTo()' class="next">确认</a></div>
		</div>
@endsection
@section('js')

<script>
	function nextTo()
	{
		var cid = "{{$cid}}";
		var sid = "{{$sid}}";
		var conid = "{{$conid}}";
		var selectStuff = $('.on').attr('stuff');
		if(selectStuff != undefined){
			window.location.href = "/sresult/"+cid+"/"+sid+"/"+conid+"/"+selectStuff;	
		}else{
			alert('请选择材质');
		}
	}
	$('.choosebox1 .choose1').click(function(){
				$('.choosebox1 .choose1').removeClass('on');
				$(this).addClass('on');
			})
</script>
@endsection

		

