@extends('personal_public')
@section('title')
新增采购订单
@endsection
@section('css/js')
<link href="{{asset('css/mobiscroll.css')}}" rel="stylesheet" />
<link href="{{asset('css/mobiscroll_date.css')}}" rel="stylesheet" />
@endsection
@section('content')
			<div class="right1">
				<div class="right1-top">
					<div class="left2">
						<a href="javascript:;" class="on" id='all' >全部</a>
						<a href="javascript:;" id='ing'>交易中</a>
						<a href="javascript:;" id='end'>已完成</a>
					</div>
					<div class="right2">
						<input type="text" placeholder="输入订单号" class="ipt" id='keywords'/>
						<input type="submit" value="" class="btn" id='search'/>
					</div>
				</div>
              
				<div class="right3-table">
					@foreach($pushOrderLists as $k => $v)
					<div class="table3-box ing{{$v['status']}}" >
						<table>
							<tr>
								<th colspan="8">
									<div class="time"><span>下单时间：{{$v['created_at']}}</span><span>订单号：{{$v['order_nr']}}</span></div>
									<div class="name">布劳宁业务员：{{$sale->uname}}( {{$sale->phone}} )  备注</div>
								</th>
							</tr>
							<tr>
								<!-- <td>布劳宁型号</td>
								<td>客户自编号</td>
								<td>客户描述</td>
								<td>数量</td>
								<td>单价</td>
								<td>金额</td> 
								<td>总金</td>
								<td class="borderLeft">
									<span>已发货</span>						
								</td> -->
								<td>商品总数</td>
								<td>含税比例</td>
								<td>总金额</td>
								<td>订单状态</td>
								<td class="borderLeft">
									<span>操作</span>						
								</td>
							</tr>
							{{-- @foreach( $v['getordergoods'] as $k => $vv)
							<tr class="bold">
								<td>{{$vv['getgoodsinfo']['post_title']}}</td>
								<td>{{$vv['client_osn']}}</td>
								<td>{{$vv['client_desc']}}</td>
								<td>{{$vv['goods_number']}}</td>
								<td>{{$vv['tax_price']}}</td>
								<td><span>{{$vv['tax_price_all']}}</span><!-- <p>含17%增值税</p> --></td>
								<td class="borderLeft">
									<a href="#">订单详情</a>
									<!-- <a href="#">查看物流</a> -->
								</td>
							</tr>
							@endforeach --}}
							<tr class="bold">
								<td>{{$v['orderNumAll']}}</td>
								<td>15%</td>
								<td>{{$v['priceAll']}}</td>
								<td>
									@if($v['status'] == 2)
										发货中
									@else
									    已完成
									@endif
								</td>
								<td class="borderLeft">
									<a href="{{route('pdorders',['id'=>$v['id']])}}">订单详情</a>
								</td>
							</tr>
						</table>
					</div>
					@endforeach
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
				$('.ing2').css('display', '');
				$('.ing3').css('display', 'none');
			});

			$('#end').on('click',function(){
				$('#ing').removeClass('on');
				$('#all').removeClass('on');
				$(this).addClass('on');
				$('.ing2').css('display', 'none');
				$('.ing3').css('display', '');
			});

			$('#all').on('click',function(){
				$('#ing').removeClass('on');
				$('#end').removeClass('on');
				$(this).addClass('on');
				$('.ing2').css('display', '');
				$('.ing3').css('display', '');
			});

			$('#search').on('click',function(){
				var keywords = $('#keywords').val();
				if(keywords == ''){
					alert('输入关键字');
				}
				$.get("{{route('porders')}}",{keywords:keywords},function($e){
					var html ='';
						$.each($e, function(index, value){
							console.log(value);
				        			/*html += '<tr class=" ing'+value.status+'">';
				        			html += '<td>'+value.theme+'</td>';
									html += '<td style="text-align:center;" >'+value.created_at+'</td>';
									html += '<td style="text-align:center;">'+value.quoted_price_end_time+'</td>';
									html += '<td style="text-align:center;">';
									html += '<a href="/askdorders/'+value.id+'" class="see" title="查看报价" > 查看报价 </a>';
									html += '<a href="#" class="del" title="删除" onclick="del('+value.id+')" >删除</a>';
									html += '</td>';
									html += '</tr>';*/
									html += '<div class="table3-box ing'+value.status+'" >';
									html += '<table>';
									html += '<tr>';
									html += 	'<th colspan="8" >';
									html +=     '<div class="time">';
									html +=     '<span>下单时间'+value.created_at+'</span><span>订单号:'+value.order_nr+'</span></div><div class="name">布劳宁业务员：{{$sale->uname}} ( {{$sale->phone}} ) 备注</div></th></tr>'; 
									html += '</tr>';
									html += '<td>商品总数</td>';
									html += '<td>含税比例</td>';
									html += '<td>总金额</td>';
									html += '<td>订单状态</td>';
									html += '<td class="borderLeft"> <span>操作</span> </td>';
									html += '<tr>';
									html += '</tr>';

									html += '<tr class="bold">';
									html += '<td>'+value.orderNumAll+'</td>';
									html += '<td>15%</td>';
									html += '<td>'+value.priceAll+'</td>';
									html += '<td>';
									if(value.status == 2){
									html += '发货中';	
									}else{
									html += '已完成';
									}
									html += '</td>';
									html += '<td class="borderLeft">';
									html += '<a href=\"/pdorders/'+value.id+'\">订单详情</a>';
									html += "</td></tr>";
									html += '</table>';
									html += "</div>";
				        		});
						
			       $('.right3-table').html(html);
				},'json');
			});
		})
	</script>
@endsection