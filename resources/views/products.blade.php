@extends('public')
@section('css/js')
@endsection
@section('content')
		<div class="catpos-box">
			<div class="catpos">
				<a href="#">首页</a>
				<em>></em>
				<span>产品</span>
			</div>
		</div>
		<div class="proBox2">
			<div class="title">{{$goodsCategory['name']}}</div>
			<div class="proright">
				<p>类别</p>
					<select name="" id="selectCatogery">
						<!-- <option value="0">选择一个类别</option> -->
						@foreach($category as $v)
							<option value="{{$v['term_taxonomy_id']}}" @if($cid == $v['term_taxonomy_id']) selected @endif > {{$v['name']}} </option>
						@endforeach
					</select>
				@if(!empty($connect))
				<p>按连接过滤</p>
				@endif
				@foreach($connect as $c_v)
							<label @if(in_array( $c_v['term_id'] , $op_array )) class = 'on' @endif >
								<input type="checkbox" value="{{$c_v['term_id']}}" @if(in_array( $c_v['term_id'] , $op_array )) checked = checked @endif />
								{{$c_v['getterminfo']['name']}}({{$c_v['scount']}})
							</label>
				@endforeach
				@if(!empty($allShape))
				<p>按形状过滤</p>
				@endif
				@foreach($allShape as $c_v)
							<label @if(in_array( $c_v['term_id'] , $op_array )) class = 'on' @endif >
								<input type="checkbox" value="{{$c_v['term_id']}}" @if(in_array( $c_v['term_id'] , $op_array )) checked = checked @endif />
								{{$c_v['getterminfo']['name']}}({{$c_v['scount']}})
							</label>
				@endforeach
			</div>
			<div class="proleft">	
				<ul>
					@if($goods)
						@foreach($goods as $g_v)
						<li>
							<a href="{{route('gdetail',['id'=>$g_v['ID']])}}">
								<div class="img">
									<img src="@if($g_v['attachment']) {{$g_v['attachment'][0]['guid']}} @endif" alt="" />
								</div>
								<span>{{$g_v['post_title']}}</span>
								<p>{{str_limit($g_v['post_content'], 5, '(...)')}}</p>
							</a>
						</li>
						@endforeach
					@else
						<div>没有产品符合您的选择</div>
					@endif	
				</ul>
				<div class="pages">	
					@if($pageNum != 1 )
						@if($p != 1)
						<a class="page pageIndex">首页</a>
						<span class="page" id='up'>上一页</span>
						@endif
						@for($i = $p;$i<=$pageNum ;$i++)
							@if($i <= $p+4)
								<a @if($i == $p) class='currer' @endif href="{{route('goodslist',['cid'=>$cid,'p'=>$i,'op'=>$op])}}">{{$i}}</a>
							@endif
						@endfor

						@if(!empty($goods))
							@if($p < $pageNum)
							<span>...</span>
							
							@if($p != $pageNum)
								<a class="page" id='down'>下一页</a>
								<a class="page pageEnd" >尾页</a>
							@endif

							@endif
						@endif
					@endif
				</div>
				<!--wap page-->
				<div class="pages-wap">
					<span class="prev" id='up1' >上一页</span>
					<a href="javascript:;" class="next" id='down1'>下一页</a>
				</div>
			</div>
			
		</div>
	
@endsection
@section('js')
<script type="text/javascript">
	$(function(){
		var p = {{$p}};
		var otherP = "{{$op}}";
		var op = []	
		if(otherP.length !== 0){
			op = otherP.split('-');	
		}
		$('#up').on('click',function(){
			if(p > 1){
				window.location.href = "{{route('goodslist',['cid'=>$cid,'p'=>$p-1,'op'=>$op])}}";
			}
		});
		$('#down').on('click',function(){
				window.location.href = "{{route('goodslist',['cid'=>$cid,'p'=>$p+1,'op'=>$op])}}";	
		});

		$('#up1').on('click',function(){
			if(p > 1){
				window.location.href = "{{route('goodslist',['cid'=>$cid,'p'=>$p-1,'op'=>$op])}}";
			}
		});
		$('#down1').on('click',function(){
				window.location.href = "{{route('goodslist',['cid'=>$cid,'p'=>$p+1,'op'=>$op])}}";	
		});


		$('.pageIndex').on('click',function(){
			window.location.href = "{{route('goodslist',['cid'=>$cid,'p'=>1,'op'=>$op])}}";
		});

		$('.pageEnd').on('click',function(){
			window.location.href = "{{route('goodslist',['cid'=>$cid,'p'=>$pageNum,'op'=>$op])}}";
		});

		$('#selectCatogery').change(function(){  
		     var cid = $(this).children('option:selected').val();
		     window.location.href = '/goodslist/'+cid+'/1';
		});

		$('.proright label input[type=checkbox]').click(function(){
			if($(this).is(":checked")){
				$(this).parent('label').addClass('on');
				//追加数组元素 并去重
				if($.inArray($(this).val(),op)<0){
   					 op.push($(this).val());
   					 window.location.href = "{{route('goodslist',['cid'=>$cid,'p'=>1])}}/"+op.join('-');
  				}
			}else{
				$(this).parent('label').removeClass('on');
				//删除数组元素
				op.splice($.inArray($(this).val(),op),1);
				window.location.href = "{{route('goodslist',['cid'=>$cid,'p'=>1])}}/"+op.join('-');
			}
			console.log(op.join('-'));
		})
	});
</script>
@endsection

		

