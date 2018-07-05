@extends('personal_public')
@section('title')
询价单详情
@endsection
@section('css/js')
@endsection
@section('content')
			<div class="right">
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
						</div>
					</div>
				</div>
				<div class="line"></div>
				<div class="xj-box">
					<div class="title">询价物品</div>
					<div class="xj-table">
						<table>
							<tr>
								<th width="40">零件图片</th>
								<th width="60">布劳宁型号</th>
								<!-- <th width="30">材质</th>
								<th width="30">单位</th> -->
								<th width="40">采购数量</th>
								<th width="40">客户自编号</th>
								<th width="80">客户描述</th>
								<th width="50">含税金额</th>
								<th width="40">总金额</th>
							</tr>
							<!-- <tr>
								<td><img src="img/xj.jpg" alt="" /></td>
								<td>0302-05-B</td>
								<td>材质</td>
								<td>件</td>
								<td><input type="text" /></td>
								<td><input type="text" /></td>
								<td><input type="text" /></td>
								<td><a href="javascript:;" class="close">X</a></td>
							</tr> -->
							
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
									{{--<td>{{$v['getgoodsinfo']['getstuff']['getname']['stuff_name']}}</td>--}}
									{{--<td>{{$v['getgoodsinfo']['getgoods']['unit']}}</td>--}}
									<td>{{$v['goods_number']}}</td>
									<td>{{$v['client_osn']}}</td>
									<td>{{$v['client_desc']}}</td>
									<td>{{$v['tax_price']}}</td>
									<td>{{$v['tax_price_all']}}</td>
									<!-- <td><a href="javascript:;" class="close">X</a></td> -->
								</tr>	
							@endforeach
						</table>
					</div>					
					<!-- <a href="#" class="add">+&nbsp;&nbsp;添加产品</a> -->
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
				<div class="line"></div>
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
						<p>{{$askOrderInfo['area']}}-{{$askOrderInfo['phone']}} | {{$askOrderInfo['mobile']}}</p>
					</div>
					<div class="purchase-message">
						<span>电子邮箱</span>
						<p>{{$askOrderInfo['email']}}</p>
					</div>
				</div>
			</div>
		</div>
@endsection		