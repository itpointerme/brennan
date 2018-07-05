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
				<div class="img"><img src="@if(count($shapeImages['attachment']) > 2) {{$shapeImages['attachment']['1']['guid']}}  @else {{asset('images/4-1.jpg')}} @endif" alt="" /></div>
				<div class="font">
					<p>{{$shape['name']}}</p>
					<!-- <span>Straight</span> -->
				</div>
			</div>
			<div class="title lighter">第2步：选择连接形式</div>
			<div class="choose2-box" >
				<div class="choose2-left">
					<div class="choosebox1">
						@foreach($connect as $k=>$v )
							<div class="choose1" conid = "{{$v['term_id']}}">					
								<div class="img">
									<div class="conner"></div>
									@foreach($v['get_goods'] as $vo)
										@if( count($vo['get_goods_img']) > 2)
												<img src="{{$vo['get_goods_img']['1']['guid']}}" alt="" />
												<?php break; ?>	
										@endif
									@endforeach
								</div>
								<p>{{$v['name']}}</p>
								<!-- <span>Straight</span> -->
							</div>
						@endforeach
					</div>
				</div>
			</div>

			<div class="link"><a href="{{route('shape')}}" class="prev">上一步</a><a href="javascript:;" class="next" onclick = 'nextTo()'>下一步</a></div>
		</div>
@endsection
@section('js')

<script>
	/*function nextTo()
	{
		var cid = "1";
		var sid = "{{$sid}}";
		var selectCon = $('.on').attr('conid');
		if(selectCon != undefined){
			window.location.href = "/stuff/"+cid+"/"+sid+"/"+selectCon;	
		}else{
			alert('请选择连接形式');
		}
	}*/
	function nextTo()
	{
		var sid = "{{$sid}}";
		var selectCon = $('.on').attr('conid');
		console.log(selectCon);
		if(selectCon != undefined){
			window.location.href = "/sresult/"+sid+"/"+selectCon;	
		}else{
			alert('请选择连接形式');
		}
	}
	$('.choosebox1 .choose1').click(function(){
				$('.choosebox1 .choose1').removeClass('on');
				$(this).addClass('on');
			})
</script>
@endsection

		

