@extends('personal_public')
@section('title')
经常采购配件
@endsection
@section('css/js')
@endsection
@section('content')
			<div class="right1">
				<div class="right1-top">
					<div class="left2">
						<a href="{{route('accessories')}}" @if($showIcon == 1) class="on" @endif>全部</a>
						<a href="{{route('accessories',['mo'=>3])}}" @if($showIcon == 3) class="on" @endif>三个月前采购过的产品</a>
						<!-- <a href="javascript:;">已完成</a> -->
					</div>
					<div class="right2">
						<input type="text" placeholder="输入客户自编号" class="ipt"/>
						<input type="submit" value="" class="btn" id='search'/>
					</div>
					<script type="text/javascript">
						$('#search').on('click', function(){
								if($('.ipt').val() == ''){
									alert('请输入关键词'); return false;
								}
								window.location.href = '/accessories?k='+$('.ipt').val();
						});
					</script>
				</div>
				<div class="right1-top2">
					<div class="left3">
						<select name="" id="selectOp">
							<option value="0">选择一个类别</option>
							@foreach($category as $k=>$v)
								<option value="{{$v['id']}}">{{$v['name']}}</option>
							@endforeach
						</select>
					</div>
					<script type="text/javascript">
						$('#selectOp').change(function(){
							var cid = $(this).val();
							if(cid == 0){
								return false;
							}
							window.location.href = "/accessories?c="+cid;
						});
					</script>
					<!-- <div class="right3">
						采购购物车  （5）
					</div> -->
				</div>
				<div class="xj-box">
					<div class="xj-table">
						<table>
							<tr>
								<th>零件图片</th>
								<th>来自客户编号</th>
								<th>客户描述</th>
								<th>布劳宁型号</th>
								<!-- <th>材质</th>
								<th>单位</th> -->
								<th>历史单价</th>
								<!-- <th>操作</th> -->
								<th>所属分类</th>
							</tr>
							@foreach($goods as $k => $v)
							<tr>
								<td>
									@if( count($v['getgoodsinfo']['get_parent_attachment']['attachment']) > 0 )
										<img src="{{$v['getgoodsinfo']['get_parent_attachment']['attachment']['0']['guid']}}" alt="" />
									@else
										<img src="{{asset('images/xj.jpg')}}" alt="" />
									@endif
								</td>

								<td>{{$v['client_osn']}}</td>

								<td>{{$v['client_desc']}}</td>

								<td>{{$v['getgoodsinfo']['post_title']}}</td>

								<!-- <td>黄铜</td>
								<td>5件</td> -->
								<td>{{$v['tax_price']}}</td>
								<!-- <td><a href="javascript:;" class="edit" title="修改">修改</a></td> -->
								<td>
									<select class='selectCategory' goods_id = "{{$v['goods_id']}}">
										<option value="0">选择一个类别</option>
										@foreach($category as $kk=>$vv)
										<option value="{{$vv['id']}}" @if($v['category_id'] == $vv['id']) selected="selected" @endif >{{$vv['name']}}</option>
										@endforeach
									</select>
								</td>
							</tr>
							@endforeach

							<script type="text/javascript">
								$(function(){
									$('.selectCategory').change(function(){
										$(this).css("background-color","#abcdef");
										var category_id = $(this).val();
										var goods_id = $(this).attr('goods_id');
										$.get("{{route('accessories')}}", {gid:goods_id, cid:category_id}, function(){

										},'json')
									});
								});
							</script>

						</table>

					</div>
					<div class="paginate">
						{{$goods->links()}}
					</div>

						<style type="text/css">
							.pagination{
								overflow: hidden;
								text-align: center;
							}
							.pagination>li>a, .pagination>li>span {
									    color: #abcdef;
									    font-size: 20px;
									}
							.pagination>li {
								display: inline;
								padding: 0 1px;

							}		

							.pagination>li>a:hover, .pagination>li>span:hover, .pagination>li>a:focus, .pagination>li>span:focus {
							    color: #3366ff;
							   /* background-color: #abcdef;
							    border-color: #abcdef*/
							}

							.pagination>.active>a, .pagination>.active>span, .pagination>.active>a:hover, .pagination>.active>span:hover, .pagination>.active>a:focus, .pagination>.active>span:focus {
							    z-index: 2;
							    color: #3366ff;
							   /* background-color: #abcdef;
							    border-color: #abcdef*/
							}

							.pagination>.disabled>span, .pagination>.disabled>span:hover, .pagination>.disabled>span:focus, .pagination>.disabled>a, .pagination>.disabled>a:hover, .pagination>.disabled>a:focus {
							    color: #000; background-color: #fff; border-color: #000; cursor: not-allowed
							}
						</style>			
					</div>		
			</div>
		</div>
@endsection