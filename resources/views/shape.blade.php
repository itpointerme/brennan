@extends('public')
@section('css/js')
@endsection
@section('content')
<div class="catpos-box">
			<div class="catpos">
				<a href="#">首页</a>
				<em>></em>
				<span>产品</span>
				<em>></em>
				<span>查找配件</span>				
			</div>
		</div>
		<div class="proBox2">
			<div class="title lighter">第1步：选择形状</div>
			<div class="choosebox1">
				@foreach($shape as $k=>$v )
					<div class="choose1" sid = "{{$v['term_id']}}">					
						<div class="img">
							<div class="conner"></div>
							@foreach($v['get_goods'] as $vo)
								@if( count($vo['get_goods_img']) > 2)
									@if( $vo['get_goods_img']['1']['guid'] == '' )
										<?php  continue; ?>
									@else
										<img src="{{$vo['get_goods_img']['1']['guid']}}" alt="" />
										<?php break; ?>	
									@endif
								@endif
							@endforeach
						</div>
						<p>{{$v['name']}}</p>
						<!-- <span>Straight</span> -->
					</div>
				@endforeach
			</div>
			<div class="link"><a href="javascript:;" class="next" onclick='nextTo()' >下一步 </a> </div>
		</div>
@endsection
@section('js')

<script>
	function nextTo()
	{
		var selectShape = $('.on').attr('sid');
		if(selectShape != undefined){
			window.location.href = "/connect/"+selectShape;	
		}else{
			alert('请选择形状');
		}
	}
	$('.choosebox1 .choose1').click(function(){
		$('.choosebox1 .choose1').removeClass('on');
		$(this).addClass('on');
	})
</script>
@endsection

		

