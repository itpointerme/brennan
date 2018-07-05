@extends('personal_public')
@section('title')
新增询价单
@endsection
@section('css/js')
<link href="{{asset('css/mobiscroll.css')}}" rel="stylesheet" />
<link href="{{asset('css/mobiscroll_date.css')}}" rel="stylesheet" />
<!-- <script type="text/javascript" src="{{asset('js/jquery.uploadPreview.min.js')}}"></script> -->
@endsection
@section('content')
<div style="width: 100%;background-color: white;z-index: 999;position: absolute;top: 0;left: 0;margin: 0 auto;text-align: center;">
<form method="post" action="{{route('addaskorder')}}" enctype="multipart/form-data" onsubmit="return check(this)">
	 {{ csrf_field() }}
		<div>
			<div class="right" style="float:none;margin: 0 auto;">
				<div class="right-top">
					<div class="itemleft" onclick="window.location.href='/' ">
						<img src="@if(Auth::user()->head) {{Auth::user()->head}} @else {{asset('images/logo.png')}} @endif" alt="" />
						<p>@if($company) {{$company->name}} @endif</p>
					</div>
					<div class="itemright">
						<p>询价单</p>
						<span>询价日期：{{date('Y-m-d H:i:s ',time())}}</span>
					</div>
				</div>
				<div class="line"></div>
				<div class="theme">
					请输入询价单主题
					<input type="text" class="ipt" name='theme' />
				</div>
				<div class="line"></div>
				<div class="xj-box">
					<div class="title">询价物品</div>
					<div class="xj-table">
						<table class='isTable'>
							<tr>
								<th width="40">零件图片</th>
								<th width="60">布劳宁型号</th>
								<!-- <th width="30">材质</th> -->
								<!-- <th width="30">单位</th> -->
								<th width="40">采购数量<font style="color:red;font-size:15px;">*</font>	</th>
								<th width="40">客户自编号</th>
								<th width="80">客户描述</th>
								<th width="20"></th>
							</tr>

							@foreach($goods as $k=>$v)
							<tr>
								<td>
									@if($v->options->get_parent_attachment['attachment'])
										<img src="{{$v->options->get_parent_attachment['attachment']['0']['guid']}}" alt="" />
									@else
										<img src="{{asset('images/xj.jpg')}}" alt="" />
									@endif
								</td>
								<td>
									@if($v->options->post_title)
										{{$v->options->post_title}} 
									@endif
								</td>
								{{-- <td>{{$v->options->getstuff['getname']['stuff_name']}}</td> --}}
								{{-- <td>@if($v->options->getgoods['unit']) {{$v->options->getgoods['unit']}} @else {{$v->options->unit}} @endif</td> --}}
								<td><input type="text" name='goods_number[]' required /></td>
								<td><input type="text" name='client_osn[]'  /></td>
								<td><input type="text" name='client_desc[]' /></td>
								<td><a href="javascript:;" class="close"  rid = "{{$k}}" >X</a></td>
								<input type="hidden" name="goods_id[]" value="{{$v->id}}" >
							</tr>
							@endforeach
							
						</table>
					</div>					
					<a href="{{route('goodslist',[8])}}" class="add">+&nbsp;&nbsp;添加产品</a>
				</div>
				<div class="line"></div>
				<div class="purchase">
					<div class="title">采购要求</div>
					<div class="purchase-message">
						<span>报价截止日期</span>
						<div class="ipt-box">
							<input type="text" id="USER_AGE" readonly class="input" name="quoted_price_end_time" required />
						</div>
						<font style="color:red;font-size:30px;">*</font>	
					</div>
					<div class="purchase-message">
						<span>交货地</span>
						<input type="text" class="ipt1" name="address" required />
						<font style="color:red;font-size:30px;">*</font>	
					</div>

					<div class="purchase-message">
						<span>补充说明</span>
						<textarea rows="" cols="" name="supplement" ></textarea>
					</div>
					<div class="purchase-message">
						<span>上传附件</span>
						<div onclick="$('#previewImg').click()" id="preview"><img src="{{asset('images/m-icon1.jpg')}}" alt=""/></div>
						<input type="file"  id="previewImg" style="display: none;" name="files">

						<div id='upFile' style="display: none;"><img id="blah" src="#" alt="your image" style="width: 30%;" /><div id='file_name'>文件名</div></div>
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
						  	console.log($('#blan').css(''));
						});	
					</script>

				</div>
				<div class="line"></div>
				<div class="purchase">
					<div class="title">联系信息</div>
					<div class="purchase-message">
						<span>公司名称</span>
						<input type="text" class="ipt1" name='company_name' required value="@if($order){{$order->company_name}}@endif" />
						<font style="color:red;font-size:30px;">*</font>	
					</div>
					<div class="purchase-message">
						<span>您的姓名</span>
						<input type="text" class="ipt1" name='user_name' required value="@if($order){{$order->user_name}}@endif" />
						<font style="color:red;font-size:30px;">*</font>	
					</div>
					<div class="purchase-message">
						<span>您的性别</span>
						<div class="sex-box">
							<label><input type="radio" value="1" name="gender" @if($order) @if($order->gender = 1) checked="checked" @endif @endif/>先生</label>
							<label><input type="radio" value="2" name="gender" @if($order) @if($order->gender = 2) checked="checked" @endif @endif/>女士</label>
						</div>
						
					</div>
					<div class="purchase-message">
						<span>手机号</span>
						<input type="number" class="ipt2" name='mobile' id='mobile' value="@if($order){{$order->mobile}}@endif" />
						<em class="or">或</em>
						<input type="number" class="ipt3" placeholder="区号" name='area' id='area' value="@if($order){{$order->area}}@endif" />
						<em>-</em>
						<input type="number" class="ipt4" placeholder="电话号码" name='phone' id='phone' value="@if($order){{$order->phone}}@endif" />
					</div>
					<div class="purchase-message">
						<span>电子邮箱</span>
						<input type="text" class="ipt1" name='email' required value="@if($order){{$order->email}}@endif" />
						<font style="color:red;font-size:30px;">*</font>	
					</div>
				</div>
				<input type="submit" value="立即提交" class="sub"/>
			</div>
		</div>
		<div class="add-cg-bj"></div>
		<div class="add-cg-box">
			<div class="top">
				<span>选择物品</span>
				<a href="javascript:;" class="close"><img src="{{asset('images/close.png')}}" alt="" /></a>
			</div>
			<div class="search">
				<input type="text" placeholder="物品名称" class="ipt" id='searchInput'/>
				<input type="submit" value="" class="sub" id='search'/>
				<script type="text/javascript">
					op = [];
					$('#search').on('click',function(){
						var keywords = $('#searchInput').val();
						if(keywords == ''){
							alert('pleace enter content');return false;
						}
						$.get("{{route('askaorders')}}",{type:'search',keywords:keywords},function(msg){
							var html = '';
							html += '<tr><th></th><th>所属类目</th><th>物品名称</th><th>规格型号</th><th>单位</th></tr>';						
			        		$.each(msg, function(index, value){
			        			html += '<tr>';
			        			html += '<td><input type="checkbox" name="cartCheckBox" onclick="checkEach(this)" data-id = "'+value.id+'"/></td>';
								html += '<td>'+value.getcategory.title+'</td>';
								html += '<td>'+value.goods_name+'</td>';
								html += '<td>'+value.goods_sn+'</td>';
								html += '<td>'+value.unit+'</td>';
								html += '</tr>';
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
			<div class="cg-table-box">
				<table id='selectGoods'>
					<tr>
						<th></th>
						<th>所属类目</th>
						<th>物品名称</th>
						<th>规格型号</th>
						<th>单位</th>
					</tr>
					@foreach($goodsList as $v)
					<tr>
						<td><input type="checkbox" name='cartCheckBox' onclick="checkEach(this)" data-id = "{{$v['id']}}" /></td>
						<td>{{$v['getcategory']['title']}}</td>
						<td>{{$v['goods_name']}}</td>
						<td>{{$v['goods_sn']}}</td>
						<td>{{$v['unit']}}</td>
					</tr>
					<!-- sku -->
						<!-- @if(!empty($v['getsku'])) 
							我有型号
						@endif 	-->
					@endforeach
				</table>
			</div>
			<div class="link">
				<a href="javascript:;" class="sure">确定</a>
				<a href="javascript:;" class="cancel">取消</a>
			</div>

		</div>
</form>
</div>
		<script type="text/javascript">
			function check(form){
				var mobile = $('#mobile').val();
				var area = $('#area').val();
				var phone = $('#phone').val();
				var getr = $('.isTable tr').length;
				if(getr<=1){
					alert('请选择加入询价单的商品');return false;
				}
				if(mobile.length > 0){
					if(!(/^1[34578]\d{9}$/.test(mobile)))
	            	{
	                	alert('手机号不正确');return false;
	            	}
				}else if(area.length < 0 && phone.length <0){
						alert('请输入电话号码,或者区号');
				}else{
					alert('请输入电话号码 或者手机号'); return false;
				}

				
			}
			$(function(){
				var p = 1;
				$(".cg-table-box").scroll(function(){
			         var $this =$(this),
			         viewH =$(this).height(),
	      	         contentH =$(this).get(0).scrollHeight,
			         scrollTop =$(this).scrollTop();
			        if(contentH - viewH - scrollTop <= 0) {
				        	$.get("{{route('askaorders')}}",{p:p,type:'select_list'},function(e){
				        		var html = '';
				        		$.each(e, function(index, value){
				        			html += '<tr>';
				        			html += '<td><input type="checkbox" name="cartCheckBox" onclick="checkEach(this)" data-id = "'+value.id+'"/></td>';
									html += '<td>'+value.getcategory.title+'</td>';
									html += '<td>'+value.goods_name+'</td>';
									html += '<td>'+value.goods_sn+'</td>';
									html += '<td>'+value.unit+'</td>';
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
		     			console.log(obj);
		     		})
		     	});


			});
		</script>
@endsection
@section('js')		
<script src="{{asset('js/mobiscroll_date.js')}}" charset="gb2312"></script> 
<script src="{{asset('js/mobiscroll.js')}}"></script> 
<script type="text/javascript">
		$(function () {
			var currYear = (new Date()).getFullYear();	
			var opt={};
			opt.date = {preset : 'date'};
			opt.datetime = {preset : 'datetime'};
			opt.time = {preset : 'time'};
			opt.default = {
				theme: 'android-ics light', //皮肤样式
				display: 'modal', //显示方式 
				mode: 'scroller', //日期选择模式
				dateFormat: 'yyyy-mm-dd',
				lang: 'zh',
				showNow: true,
				nowText: "今天",
				startYear: currYear, //开始年份
				endYear: currYear +10//结束年份
			};
		
			$("#USER_AGE").mobiscroll($.extend(opt['date'], opt['default']));

			/*$('.add').click(function(){
				$('.add-cg-bj').show();
				$('.add-cg-box').show();
			})*/
			$('.add-cg-box .close').click(function(){
				$('.add-cg-box').hide();
				$('.add-cg-bj').hide();				
			})
			$('.add-cg-box .link .cancel').click(function(){
				$('.add-cg-box').hide();
				$('.add-cg-bj').hide();				
			})
			$('.xj-box table tr td a.close').click(function(){
				//删除购物车中商品
				$.get("{{route('delcart')}}",{rowid: $(this).attr('rid')},function(msg){},'json');
				$(this).parent().parent().remove();
				
			})

			
		});
		</script>
@endsection		