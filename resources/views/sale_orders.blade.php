@extends('sale_public')
@section('css/js')
@endsection
@section('content')
				<div class="title">
					<span>采购单</span>
					<div class="right2">
						<input type="text" placeholder="输入订单号" class="ipt"/>
						<input type="submit" value="" class="btn" id='search'/>
					</div>
					<script type="text/javascript">
						$('#search').on('click', function(){
								var keywords = $('.ipt').val();
								if( keywords == '' ){
									alert('请输入关键词'); return false;
								}
								location.href = "/sorders?k="+keywords;
						});
					</script>
				</div>
				<div class="right3-table">
					@foreach( $orders as $k => $v)
					<div class="table3-box">
						<table>
							<tr>
								<th colspan="8">
									<div class="time"><span>下单时间：{{$v['created_at']}} </span><span>订单号：{{$v['order_nr']}}</span></div>
									<div class="name">下单用户：{{$v['getuserinfo']['uname']}} ({{$v['getuserinfo']['phone']}})</div>
								</th>
							</tr>
							<tr>
								<td>商品总数</td>
								<td>含税比例</td>
								<td>总金额</td>
								<td>订单状态</td>
								<td class="borderLeft">
									<span>操作</span>					
								</td>
							</tr>
							<tr class="bold">
								<td>{{$v['orderNumAll']}}</td>
								<td><p>含17%增值税</p></td>
								<td><span>{{$v['priceAll']}}</span></td>
								<td>确定中</td>
								<td class="borderLeft">
									<a href="{{route('odetail',['id'=>$v['id']])}}">订单详情</a>
								</td>
							</tr>
						</table>
					</div>
					@endforeach
				</div>
@endsection
@section('js')