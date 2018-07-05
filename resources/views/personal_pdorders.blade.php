@extends('personal_public')
@section('title')
新增采购订单
@endsection
@section('css/js')
<link href="{{asset('css/mobiscroll.css')}}" rel="stylesheet" />
<link href="{{asset('css/mobiscroll_date.css')}}" rel="stylesheet" />
@endsection
@section('content')
			<div class="right">
				<div class="right-top">
					<div class="itemleft">
						<img src="{{asset('images/logo.png')}}" alt="" />
						<p>@if($company) {{$company->name}} @endif</p>
					</div>
					<div class="itemright">
						<p>采购订单详情</p>
					</div>
				</div>
				<div class="line"></div>
				<div class="xj-box">
					<div class="title">采购物品</div>
					<div class="xj-table">
						<table>
							<tr>
								<th width="40">零件图片</th>
								<th width="60">布劳宁型号</th>
								<th width="20">单价</th>
								<th width="50">采购数量</th>
								<th width="20">客户自编号</th>
								<th width="80">客户描述</th>
							</tr>
							@foreach($pushOrderListsDetail['getordergoods'] as $k=>$v)
								<tr>
									<td>
										@if($v['getgoodsinfo']['get_parent_attachment']['attachment'])
											<img src="{{$v['getgoodsinfo']['get_parent_attachment']['attachment']['0']['guid']}}" alt="" />
										@else
											<img src="{{asset('images/xj.jpg')}}" alt="" />
										@endif
									</td>
									<td>{{$v['getgoodsinfo']['post_title']}}</td>
									<td>{{$v['tax_price']}}</td>
									<td>{{$v['goods_number']}}</td>
									<td>{{$v['client_osn']}}</td>
									<td>{{$v['client_desc']}}</td>
								</tr>
							@endforeach
						</table>
					</div>
				</div>
				<div class="line"></div>
				<div class="purchase">
					<div class="title">采购要求</div>
					<div class="purchase-message">
						<span>收货地址</span>
						<p class="address_show">{{$pushOrderListsDetail['address']}}</p>
					</div>
					<div class="purchase-message">
						<span>其他约定</span>
						<textarea name="supplement" rows="" cols="">{{$pushOrderListsDetail['supplement']}}</textarea>
					</div>
					<div class="purchase-message">
						<span>附件</span>
						<img src="{{$pushOrderListsDetail['appendix_path']}}">
					</div>
				</div>	
				<input type="submit" value="返回" class="sub" id='goback'/>
				<script type="text/javascript">$('#goback').on('click',function(){ window.location.href= "{{route('porders')}}" });</script>
			</div>
		</div>
@endsection

