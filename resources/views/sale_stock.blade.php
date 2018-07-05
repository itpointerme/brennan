@extends('sale_public')
@section('css/js')
@endsection
@section('content')
			<div class="sale-right">
				<div class="title">
					<span>库存查询</span>
					<div class="right2">
						<input type="text" placeholder="输入关键词" class="ipt"/>
						<input type="submit" value="" class="btn" id='search'/>
					</div>
				</div>
				<div class="xj-box">
					<div class="xj-table border">
						<table>
							<tr>
								<th width="60">布劳宁型号</th>
								<th width="40">本地库存</th>
								<th width="40">美国库存</th>
							</tr>
							@foreach($stock as $k=>$v)
								<tr>
									<td>{{$v['goods_num']}}</td>
									<td>{{$v['stock_local']}}</td>
									<td>{{$v['stock_america']}}</td>
								</tr>
							@endforeach
						</table>
					</div>					
				</div>
			</div>
			
		</div>
		<script type="text/javascript">
			$('#search').on('click', function () {
				var keywords = $('.ipt').val();
				if(keywords == ''){
					alert('输入关键词搜索'); return false;
				}
				location.href= '/stock?k='+keywords;
			});
		</script>
		@endsection
@section('js')