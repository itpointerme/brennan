@extends('personal_public')
@section('title')
管理询价单
@endsection
@section('css/js')
<link href="{{asset('css/mobiscroll.css')}}" rel="stylesheet" />
<link href="{{asset('css/mobiscroll_date.css')}}" rel="stylesheet" />
@endsection
@section('content')
			<div class="right1">
				<div class="right1-top">
					<div class="left2">
						<a href="javascript:;" class="on" id='all'>全部</a>
						<a href="javascript:;" id='ing' >报价中</a>
						<a href="javascript:;" id='end'>已截止</a>
					</div>
					<div class="right2">
						<input type="text" placeholder="输入关键词" class="ipt" id='keywords' />
						<input type="submit" value="" class="btn" id='search' />
					</div>
				</div>
				<div class="right2-table">
					<table>
						<tr>
							<th>询价主题</th>
							<th>发布日期</th>
							<th>截止日期</th>
							<th>操作</th>
						</tr>
						@foreach($askOrderLists as $v)
							<tr class=' ing{{$v["status"]}}' id='one_{{$v["id"]}}' >
								<td>{{ $v['theme'] }}</td>
								<td style="text-align:center;">{{ $v['created_at'] }}</td>
								<td style="text-align:center;">{{ $v['quoted_price_end_time'] }}</td>
								<td style="text-align:center;">
									<a href="{{route('askdorders',['order_id'=>$v['id']] )}}" class="see" title="查看报价">查看报价</a>
									<!-- <a href="#" class="edit" title="修改">修改</a> -->
									<a href="javascript:;" class="del" title="删除" onclick='del({{$v["id"]}})'>删除</a>
								</td>
							</tr>
						@endforeach
						<script type="text/javascript">
							function del(id){
								if(confirm('确定要删除么？')){
									$.get('askorders',{del:id},function(e){
										if(e.code == 0){
											$('#one_'+id).remove();
										}
									},'json')
								}
							}
						</script>
					</table>
				</div>
			</div>
		</div>
@endsection
@section('js')
	<script type="text/javascript">
		$(function(){
			$('#ing').on('click',function(){
				$(this).addClass('on');
				$('#all').removeClass('on');
				$('#end').removeClass('on');
				$('.ing0').css('display', '');
				$('.ing1').css('display', 'none');
			});

			$('#end').on('click',function(){
				$('#ing').removeClass('on');
				$('#all').removeClass('on');
				$(this).addClass('on');
				$('.ing0').css('display', 'none');
				$('.ing1').css('display', '');
			});

			$('#all').on('click',function(){
				$('#ing').removeClass('on');
				$('#end').removeClass('on');
				$(this).addClass('on');
				$('.ing0').css('display', '');
				$('.ing1').css('display', '');
			});

			$('#search').on('click',function(){
				var keywords = $('#keywords').val();
				if(keywords == ''){
					alert('输入关键字');
				}
				$.get("{{route('askorders')}}",{keywords:keywords},function($e){
						var html ='';
							html += '<table>';
							html += '<tr>';
							html += 	'<th>询价主题</th>';
							html += 	'<th>发布日期</th>';
							html += 	'<th>截止日期</th>';
							html += 	'<th>操作</th>';
							html += '</tr>';
						$.each($e, function(index, value){
				        			html += '<tr class=" ing'+value.status+'">';
				        			html += '<td>'+value.theme+'</td>';
									html += '<td style="text-align:center;" >'+value.created_at+'</td>';
									html += '<td style="text-align:center;">'+value.quoted_price_end_time+'</td>';
									html += '<td style="text-align:center;">';
									html += '<a href="/askdorders/'+value.id+'" class="see" title="查看报价" > 查看报价 </a>';
									html += '<a href="#" class="del" title="删除" onclick="del('+value.id+')" >删除</a>';
									html += '</td>';
									html += '</tr>';
				        		});
						html += '</table>';
				       $('.right2-table').html(html);
				},'json');
			});
		})
	</script>
@endsection