@extends('sale_public')
@section('css/js')
@endsection
@section('content')
				<div class="theme">
					<p>采购订单标题</p>
					<div class="theme-box">
						<div class="theme-left">
							<p class="long"><span>询价单号</span>{{$orderDetail['order_nr']}}</p>
							<!-- <p class="long"><span>询价日期</span>2018-02-28 12:00</p> -->
							<!-- <p class="long"><span>截止日期</span>2018-02-28 12:00</p> -->
							<p class="long"><span>下单日期</span>{{$orderDetail['created_at']}}</p>
						</div>
						<div class="theme-right">
							确定中
							<p>签订有效期    2018-04-20</p>
						</div>
					</div>
				</div>
				<div class="line"></div>
				<div class="xj-box">
					<div class="title">采购物品</div>
					<div class="xj-table">
						<table >
							<tr>
								<th width="40">零件图片</th>
								<th width="60">布劳宁型号</th>
								<!-- <th width="30">材质</th>
								<th width="30">单位</th> -->
								<th width="30">含税单价</th>
								<th width="50">采购数量</th>
								<th width="30">含税金额</th>
								<!-- <th width="40">交货日期</th> -->
								<th width="40">客户自编号</th>
								<th width="50">客户描述</th>
								<!-- <th width="40">本地库存</th>
								<th width="40">美国库存</th> -->
							</tr>
							@foreach($orderDetail['getordergoods'] as $k=>$v)
							<tr>
								<td>
									@if($v['getgoodsinfo']['get_parent_attachment']['attachment'])
											<img src="{{$v['getgoodsinfo']['get_parent_attachment']['attachment']['0']['guid']}}" alt="" />
									@else
											<img src="{{asset('images/xj.jpg')}}" alt="" />
									@endif
								</td>
								<td>{{$v['getgoodsinfo']['post_title']}}</td>
								<!-- <td>黄铜</td>
								<td>件</td> -->
								<td>{{$v['tax_price']}}</td>
								<td>{{$v['goods_number']}}</td>
								<td>20</td>
								<!-- <td></td> -->
								<td>{{$v['client_osn']}}</td>
								<td>{{$v['client_desc']}}</td>
								<!-- <td>100</td>
								<td>0</td>								 -->
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
						<p>{{$orderDetail['address']}}</p>
					</div>
					<div class="purchase-message">
						<span>其他约定</span>
						<p>{{$orderDetail['supplement']}}</p>
					</div>
					<div class="purchase-message">
						<span>附件</span>
						<img src="{{$orderDetail['appendix_path']}}">
					</div>
					<div class="purchase-message">
						<span>合同上传</span>
						<div onclick="$('#previewImg').click()" id="preview"><img src="{{asset('images/m-icon1.jpg')}}" alt=""/></div>
						<input type="file" onchange="previewImage(this)" style="display: none;" id="previewImg">
					</div>
				</div>
				<input type="submit" value="立即确定" class="sub"/>
@endsection
@section('js')