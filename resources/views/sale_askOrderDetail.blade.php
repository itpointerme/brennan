@extends('sale_public')
@section('css/js')
@endsection
@section('content')
<form action="" method="post" >
			<div class="sale-right">
				<div class="theme">
					<p>{{$askOrderInfo['theme']}}</p>
					<div class="theme-box">
						<div class="theme-left">
							<p class="long"><span>询价单号</span>{{$askOrderInfo['order_nr']}}</p>
							<p class="long"><span>询价日期</span>{{$askOrderInfo['created_at']}}</p>
							<p class="long"><span>截止日期</span>{{$askOrderInfo['quoted_price_end_time']}}</p>
						</div>
						<div class="theme-right">
							@if( $askOrderInfo['status'] == 0 )
								报价中
							@else
								已报价
							@endif
							<p>签订有效期    2018-04-20</p>
						</div>
					</div>
				</div>
				<div class="line"></div>
				<div class="xj-box">
					<div class="title">询价物品</div>
					<div class="xj-table">
							 {{ csrf_field() }}
							<table class="long">
								<tr>
									<th width="40">零件图片</th>
									<th width="60">布劳宁型号</th>
									<!-- <th width="30">材质</th>
									<th width="30">单位</th> -->
									<th width="20">含税单价</th>
									<th width="40">采购数量</th>
									<th width="20">含税金额</th>
									<th width="40">客户自编号</th>
									<th width="80">客户描述</th>
									<th width="40">本地库存</th>
									<th width="40">美国库存</th>
								</tr>

								@foreach($askOrderInfo['getordergoods'] as $k => $v)
									<tr>
										<td>
										@if($v['getgoodsinfo']['get_parent_attachment']['attachment'])
											<img src="{{$v['getgoodsinfo']['get_parent_attachment']['attachment']['0']['guid']}}" alt="" />
										@else
											<img src="{{asset('images/xj.jpg')}}" alt="" />
										@endif
										</td>
										<td>{{$v['getgoodsinfo']['post_title']}}</td>
										{{--<td>{{$v['getgoodskuinfo']['getstuff']['getname']['stuff_name']}}</td>--}}
										{{--<td>{{$v['getgoodskuinfo']['getgoods']['unit']}}</td>--}}
										<td><input type="text" name='tax_price[]' required="required" /></td>
										<td><input type="text" value="{{$v['goods_number']}}" /></td>
										<td><input type="text" name='tax_price_all[]' required="required" /></td>
										<td><input type="text" value="{{$v['client_desc']}}" /></td>
										<td><input type="text" value="{{$v['client_desc']}}" /></td>
										<input type="hidden" name="id[]" value="{{$v['id']}}">
										<td>@if($v['getgoodsinfo']['get_stock']) {{$v['getgoodsinfo']['get_stock']['stock_local']}} @else 0 @endif</td>
										<td>@if($v['getgoodsinfo']['get_stock']) {{$v['getgoodsinfo']['get_stock']['stock_america']}} @else 0 @endif</td>	
									</tr>	
								@endforeach
							</table>
					</div>					
				</div>
				<div class="line"></div>
				<div class="purchase">
					<div class="title">采购要求</div>
					<div class="purchase-message">
						<span>交货地</span>
						<p>{{$askOrderInfo['address']}}</p>
					</div>
					<div class="purchase-message">
						<span>报价是否含税</span>
						<p>@if($askOrderInfo['tax']==0) 不含 @else 含 @endif</p>
					</div>
					<div class="purchase-message">
						<span>补充说明</span>
						<p>{{$askOrderInfo['supplement']}}</p>
					</div>
				</div>
				<div class="purchase">
					<div class="title">联系信息</div>
					<div class="purchase-message">
						<span>公司名称</span>
						<p>{{$askOrderInfo['company_name']}}</p>
					</div>
					<div class="purchase-message">
						<span>您的姓名</span>
						<p>{{$askOrderInfo['user_name']}}</p>
					</div>
					<div class="purchase-message">
						<span>联系电话</span>
						<p>{{$askOrderInfo['phone']}} - {{$askOrderInfo['mobile']}}</p>
					</div>
					<div class="purchase-message">
						<span>电子邮箱</span>
						<p>{{$askOrderInfo['email']}}</p>
					</div>
				</div>
				<input type="submit" value="立即提交" class="sub" name="submit" />
			</div>
			
		</div>
</form>
@endsection
@section('js')
@endsection