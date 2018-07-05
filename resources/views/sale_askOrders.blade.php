@extends('sale_public')
@section('css/js')
@endsection
@section('content')
				<div class="sale-right">
				<div class="title">
					<span>管理询价单</span>
					<div class="right2">
						<input type="text" placeholder="输入关键词" class="ipt"/>
						<input type="submit" value="" class="btn" id='search'/>
					</div>
					<script type="text/javascript">
						$('#search').on('click', function(){
								var keywords = $('.ipt').val();
								if( keywords == '' ){
									alert('请输入关键词'); return false;
								}
								location.href = "/aorders?k="+keywords;
						});
					</script>
				</div>
				<div class="xj-box">
					<div class="xj-table border">
						<table>
							<tr>
								<th>询价主题</th>
								<th>客户</th>
								<th>发布日期</th>
								<th>截止日期</th>
								<th>操作</th>
							</tr>
							@foreach($askOrders as  $k => $v)
							<tr>
								<td>{{$v['theme']}}</td>
								<td>{{$v['user_name']}}</td>
								<td>{{$v['created_at']}}</td>
								<td>{{$v['quoted_price_end_time']}}</td>
								<td>
										@if($v['status']==0)
										   <a href="{{route('aodetail',['order_id'=>$v['id']])}}" class="bj">
											报价
											</a>
										@else
											已报价
										@endif
								</td>
							</tr>
							@endforeach
						</table>
					</div>					
				</div>
			</div>
			
		</div>
@endsection
@section('js')