@extends('personal_public')
@section('title')
新增采购订单
@endsection
@section('css/js')
<link href="{{asset('css/mobiscroll.css')}}" rel="stylesheet" />
<link href="{{asset('css/mobiscroll_date.css')}}" rel="stylesheet" />
@endsection
@section('content')
<div style="width: 100%;background-color: white;z-index: 9999999;position: absolute;top: 0;left: 0;margin: 0 auto;text-align: center;">
<form method="post" action="{{route('addporder')}}" enctype="multipart/form-data">
			<div class="right" style="float:none;margin: 0 auto;">
				<div class="right-top">
					<div class="itemleft" onclick="window.location.href='/' ">
						<img src="@if(Auth::user()->head) {{Auth::user()->head}} @else {{asset('images/logo.png')}} @endif" alt="" />
						<p>@if($company) {{$company->name}} @endif</p>
					</div>
					<div class="itemright">
						<p>采购订单</p>
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
								<!-- <th width="30">材质</th>
								<th width="30">单位</th> -->
								<th width="20">采购数量</th>
								<th width="20">客户自编号</th>
								<th width="80">客户描述</th>
								<th width="20"></th>
							</tr>
							@foreach($goodsList as $k=>$v)
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
									{{--<td>{{$v['getgoodsinfo']['getstuff']['getname']['stuff_name']}}</td>--}}
									{{--<td>{{$v['getgoodsinfo']['getgoods']['unit']}}</td>--}}
									<td><input type="text" name='goods_number[]' required /></td>
									<td><input type="text" name='client_osn[]' required /></td>
									<td><input type="text" name='client_desc[]' required/></td>
									<td><a href="javascript:;" class="close">X</a></td>
									<input type="hidden" name="goods_id[]" value="{{$v['goods_id']}}" >
									<input type="hidden" name="tax_price[]" value="{{$v['tax_price']}}" >
								</tr>
							@endforeach
						</table>
					</div>					
					<a href="javascript:;" class="add">+&nbsp;&nbsp;添加历史采购产品</a>
				</div>
				<div class="line"></div>
				<div class="purchase">
					<div class="title">采购要求</div>
					<div class="purchase-message">
						<span>收货地址</span>
						<p class="address_show">{{$goods['0']['address']}}</p>
						<p><input type="text" name="address" style="display: none;" class="address_none"></p>		
						<a href="javascript:;" id='changeAddress' >更换地址</a>
						<a href="javascript:;" id='closeAddress' style="display: none;">关闭</a>
						<script type="text/javascript">
							$('#changeAddress').on('click', function(){
								$('.address_none').css('display', '');
								$('.address_show').css('display', 'none');
								$('#changeAddress').css('display', 'none');
								$('#closeAddress').css('display', '');
							});
							$('#closeAddress').on('click', function(){
								$('.address_none').css('display', 'none');
								$('#changeAddress').css('display', '');
								$('#closeAddress').css('display', 'none');
								$('.address_show').css('display', '');
							});
						</script>
					</div>
					<div class="purchase-message">
						<span>其他约定</span>
						<textarea name="supplement" rows="" cols=""></textarea>
					</div>
					<div class="purchase-message">
						<span>上传附件</span>
						<div onclick="$('#previewImg').click()" id="preview"><img src="{{asset('images/m-icon1.jpg')}}" alt=""/></div>
						<input type="file"  id="previewImg" style="display: none;" name="files">
						<div id='upFile' style="display: none;"><img id="blah" src="#" alt="your image" style="width: 30%;" />
						<div id='file_name'>文件名</div></div>
					</div>
				</div>	

				<script type="text/javascript">
						function readURL(input) {
						  if (input.files && input.files[0]) {
						  	$('#file_name').text(input.files[0].name);
						    var reader = new FileReader();
						    reader.onload = function(e) {
						      $('#blah').attr('src', e.target.result);
						      $('#upFile').css('display', 'block');
						    }
						    reader.readAsDataURL(input.files[0]);
						  }
						}

						$("#previewImg").change(function() {
						  	readURL(this);
						  	$('#blan').css('display','block');
						});	
					</script>

				<input type="submit" value="立即提交" class="sub"/>
			</div>
		</div>
</form>
</div>
		<div class="add-cg-bj"></div>
		<div class="add-cg-box">
			<div class="top">
				<span>选择物品</span>
				<a href="javascript:;" class="close"><img src="{{asset('images/close.png')}}" alt="" /></a>
			</div>
			<!-- 搜索物品开始 -->
			<div class="search">
				<input type="text" placeholder="物品名称" class="ipt" id='searchInput'/>
				<input type="submit" value="" class="sub" id='search'/>
			</div>
			<div class="cg-table-box">
				<table id='selectGoods'>
					<tr>
						<th><input type="checkbox" id="allcheck" onclick="checkAll(this)"/></th>
						<th>图片</th>
						<th>所属类目</th>
						<th>规格型号</th>
						<th>单价</th>
						<!-- <th>物品名称</th> -->
						<!-- <th>单位</th> -->
					</tr>
					@foreach($goodsList_type_1 as $v)
					<tr>
						<td><input type="checkbox" name='cartCheckBox' onclick="checkEach(this)" data-id = "{{$v['goods_id']}}" /></td>
						<td>
							<img src="{{$v['getgoodsinfo']['get_parent_attachment']['attachment'][0]['guid']}}" style="width:50px;height: 50px;">
						</td>
						<td>{{$v['getgoodsinfo']['get_parent_category']['0']['get_items']['getterminfo']['name']}}</td>
						<td>{{$v['getgoodsinfo']['post_title']}}</td>
						<td>{{$v['tax_price']}}</td>
						{{--<td>{{$v['goods_sn']}}</td>--}} 
						{{--<td>{{$v['unit']}}</td> --}}
					</tr>
					@endforeach
					
				</table>
			</div>
			<div class="link">
				<a href="javascript:;" class="sure">确定</a>
				<a href="javascript:;" class="cancel">取消</a>
			</div>
			<script type="text/javascript">
					op = [];
					$('#search').on('click',function(){
						var keywords = $('#searchInput').val();
						if(keywords == ''){
							alert('pleace enter content');return false;
						}
						$.get("{{route('paorders')}}",{type:'search',keywords:keywords},function(msg){
							var html = '';
							html += '<tr><th></th><th>图片</th><th>所属类目</th><th>规格型号</th><th>单价</th></tr>';						
			        		$.each(msg, function(index, value){
			        	
			        			if(value.getgoodsinfo != null ){
					        			html += '<tr>';
					        			html += '<td><input type="checkbox" name="cartCheckBox" onclick="checkEach(this)" data-id = "'+value.goods_id+'"/></td>';
					        			html += '<td>';
					        			html += '<img src="'+value.getgoodsinfo.get_parent_attachment.attachment[0].guid+'" style="width:50px;height: 50px;">';
					        			html += '</td>';
										html += '<td>'+value.getgoodsinfo.get_parent_category['0'].get_items.getterminfo.name+'</td>';
										html += '<td>'+value.getgoodsinfo.post_title+'</td>';
										html += '<td>'+value.tax_price+'</td>';
										html += '</tr>';
								}
			        		});
			        		$('#selectGoods').html(html);
						},'json');
					});


					function checkAll(){   
				        if($('#allcheck').is(":checked")){  
					        $("[name='cartCheckBox']").prop("checked",true); 
					    }else{  
					        $("[name='cartCheckBox']").prop("checked",false);  
				       	}  
					}  
					//每个单选框  
					function checkEach(obj){
						//get data to cart
						if($(obj).is(":checked")){
							if($.inArray($(obj).attr('data-id'),op)<0){
			   					 op.push($(obj).attr('data-id'));
			  				}
						}else{
							op.splice($.inArray($(obj).attr('data-id'),op),1);
						}

					    var count = total();
					    if(count==$("[name='cartCheckBox']").size()){  
					        $("#allcheck").prop("checked",true);  
					    }else{   
							$("#allcheck").prop("checked",false);
					    }   
			       	} 
			       	function total(){
			       		var count=0; 
			       		$("input[name='cartCheckBox']").each(function(index, element) {  
					        if($(this).is(":checked")){  
					            count++;  
					        }  
					    });  
					    return count;
			       	}
		
			</script>
		</div>
@endsection
@section('js')
<script type="text/javascript">
			$(function(){
				var p = 1;
				$(".cg-table-box").scroll(function(){
			         var $this =$(this),
			         viewH =$(this).height(),
	      	         contentH =$(this).get(0).scrollHeight,
			         scrollTop =$(this).scrollTop();
			        if(contentH - viewH - scrollTop <= 0) {
				        	$.get("{{route('paorders')}}",{p:p,type:'select_list'},function(e){
				        		var html = '';
				        		$.each(e, function(index, value){
					        			html += '<tr>';
					        			html += '<td><input type="checkbox" name="cartCheckBox" onclick="checkEach(this)" data-id = "'+value.goods_id+'"/></td>';
					        			html += '<td>';
					        			html += '<img src="'+value.getgoodsinfo.get_parent_attachment.attachment[0].guid+'" style="width:50px;height: 50px;">';
					        			html += '</td>';
										html += '<td>'+value.getgoodsinfo.get_parent_category['0'].get_items.getterminfo.name+'</td>';
										html += '<td>'+value.getgoodsinfo.post_title+'</td>';
										html += '<td>'+value.tax_price+'</td>';
										html += '</tr>';
				        		});
				        		p++;
				        		$('#selectGoods').append(html);
				        	},'json');
			        }
		     	});	

		     	$('.sure').on('click',function(){
		     		var n = $('input:checked');
		     		if(n.length == 0){
		     			alert('请选择商品');return false;
		     		}
		     		$.get("{{route('addcarts')}}",{op:op.join('-')},function(obj){
		     			var html = '';
		        		$.each(obj, function(index, value){
		        			  html += '<tr><td>';
		        			  if(value.getgoodsinfo.get_parent_attachment.attachment.length > 0){
		        			    html += '<img src="'+value.getgoodsinfo.get_parent_attachment.attachment['0']['guid']+'"/>';
		        			  }else{
		        			    html += '<img src=\'{{asset("images/xj.jpg")}}\' alt="" />';
		        			  }
							  html += '</td><td>'+value.getgoodsinfo.post_title+'</td>';
							  html += '<td>'+value.tax_price+'</td>';
							  html += '<td><input type="text" name="goods_number[]" required /></td>';
							  html += '<td><input type="text" name="client_osn[]" required /></td>';
							  html += '<td><input type="text" name="client_desc[]" required/></td>';
							  html += '<td><a href="javascript:;" class="close" onclick="closethis(this)">X</a></td>';
							  html += '<input type="hidden" name="goods_id[]" value="'+value.goods_id+'" >';
							  html += '<input type="hidden" name="tax_price[]" value="'+value.tax_price+'" >';
							  html += '</tr>';
		        		});
			        	$('.xj-table table').append(html);
			        	$('.add-cg-box').hide();
			        	$('.add-cg-bj').hide();	

		     		},'json')
		     	});

		     	$('.add').click(function(){
					$('.add-cg-bj').show();
					$('.add-cg-box').show();
				})
				$('.add-cg-box .close').click(function(){
					$('.add-cg-box').hide();
					$('.add-cg-bj').hide();				
				})
				$('.add-cg-box .link .cancel').click(function(){
					$('.add-cg-box').hide();
					$('.add-cg-bj').hide();				
				})

				$('.xj-box table tr td a.close').click(function(){
					$(this).parent().parent().remove();
				})

			    closethis = function(obj){
					$(obj).parent().parent().remove();
				}

			});
</script>
@endsection
