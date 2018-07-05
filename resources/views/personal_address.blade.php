@extends('personal_public')
@section('title')
我的收货地址
@endsection
@section('css/js')
<script type="text/javascript" src="{{asset('js/jquery.cityselect.js')}}"></script>
@endsection
@section('content')
			<div class="right1">
				<div class="right3-top">
					<span class="add-span">收货地址</span>
					<a href="javascript:;" class="add-link">添加收货地址</a>
				</div>
				<div class="right2-table">
					<table id='addTable'>
						<tr>
							<th>所在地区 </th>
							<th>详细地址 </th>
							<th>收货人</th>
							<th>手机号/固话 </th>
							<th>备注 </th>
							<th>操作 </th>
						</tr>
						@foreach( $address as $v)
							<tr>
								<td style="text-align:center;">
									@if($v->getprovincename) {{ $v->getprovincename->name }} @endif
									@if($v->getcityname) {{ $v->getcityname->name }} @endif
									@if($v->getareaname) {{ $v->getareaname->name }} @endif
									
								</td>
								<td style="text-align:center;">{{ $v->address_name }}</td>
								<td style="text-align:center;">{{ $v->name }}</td>
								<td style="text-align:center;">{{ $v->mobile }}</td>
								<td style="text-align:center;">{{ $v->mask }}</td>
								<td style="text-align:center;">
									<a href="javascript:;" class="del" title="删除" del_id = "{{ $v->id }}" >删除</a>
								</td>
							</tr>
						@endforeach
					</table>
				</div>
			</div>
@endsection
<!--PC端新增收货地址弹窗-->
		<div class="dialogBg">
			<div class="dialog pc">
				<div class="top">
					<span>新增收货地址</span>
					<a href="javascript:;" class="close"><img src="{{asset('images/close.png')}}" alt="" /></a>
				</div>
				<div class="message" id="citySelect">
					<span>所在地区</span>
					<select class="ipt1 prov" id="province"></select>  
         			<select class="ipt1 city" disabled="disabled" id="city" ></select>  
         			<select class="ipt1 dist" disabled="disabled" id="county"></select> 
				</div>
				<div class="message">
					<span>详细地址</span>
					<input type="text" class="ipt2" id='address'/>
				</div>
				<div class="message">
					<span>收货人</span>
					<input type="text" class="ipt3" id='name'/>
				</div>
				<div class="message">
					<span>联系电话</span>
					<input type="text" class="ipt3" id='mobile'/>
				</div>
				<div class="message">
					<span>备注</span>
					<input type="text" class="ipt2" id='mask'/>
				</div>
				<div class="message">
					<input type="submit" value="保存" class="sub" id='saveAddress'/>
				</div>
			</div>
		</div>


		
		<!--手机端新增收货地址弹窗-->
		<div class="dialog mobile">
			<div class="top">
				<span>新增收货地址</span>
				<a href="javascript:;" class="close"><img src="{{asset('images/close.png')}}" alt="" /></a>
			</div>
			<div class="message" id="zone">
				<span>所在地区</span>
				<input type="text" name="city" readonly id="wapcity" class="ipt3"/>
			</div>
			<div class="message">
				<span>详细地址</span>
				<input type="text" class="ipt2" />
			</div>
			<div class="message">
				<span>收货人</span>
				<input type="text" class="ipt3" />
			</div>
			<div class="message">
				<span>联系电话</span>
				<input type="text" class="ipt3" />
			</div>
			<div class="message">
				<span>备注</span>
				<input type="text" class="ipt2" />
			</div>
			<div class="message">
				<input type="submit" value="保存" class="sub"/>
			</div>
		</div>

@section('js')
<script>
			$('.add-link').click(function(){
				var width=$(window).width();
				if(width > 900){
					$('.dialogBg').show();
					$('.dialog.pc').show();
				}else{
					$('body').addClass('fixed');
					$('.dialog.mobile').animate({left:'0'},300);
				}
			})
			$('.dialog .top .close').click(function(){
				$('.dialogBg').hide();
				$('.dialog.pc').hide();
				$('body').removeClass('fixed');
				$('.dialog.mobile').animate({left:'100%'},300);
			})
			$("#citySelect").citySelect({nodata:"none",required:false}); 

			//提交
			$('#saveAddress').on('click',function(){
					var province = $('#province').val();
					var city = $('#city').val();
					var county = $('#county').val();
					var address = $('#address').val();
					var name = $('#name').val();
					var mobile = $('#mobile').val();
					var mask = $('#mask').val();
				
					if(province == '' || city == '' || county == '' || address == '' || name == '' || mobile == '' || mask == ''){
							alert('资料填写不完善');return false;
					}
					if( county == null && city != '' && province != ''){
						county = city;
						city = '';
					}

					console.log(province);
					console.log('city-------'+city);
					console.log('county------'+county);
				
					$.post("{{route('address')}}",{submit:'submit',pro:province,city:city,county:county,address:address,name:name,mobile:mobile,mask:mask},function(e){
						var html = '';
						if(e.code == 0){
							$('.dialogBg').hide();
							$('.dialog.pc').hide();
							html  = '<tr>';
							html += '<td style="text-align:center;">'+province+city+county+'</td>';
							html += '<td style="text-align:center;">'+address+'</td>';
							html += '<td style="text-align:center;">'+name+'</td>';
							html += '<td style="text-align:center;">'+mobile+'</td>';
							html += '<td style="text-align:center;">'+mask+'</td>';
							html += '<td style="text-align:center;"><a href="javascript:;" class="del" title="删除" id="'+e.id+'">删除</a></td>';
							html += '</tr>';
							$('#addTable tbody').append(html);

						}else{
							alert(e.msg);
						}
					},'json');

			});

			$('.del').on('click',function(){ 
				var that = $(this);
				var id = that.attr('del_id');
				if(confirm("确定删除?")){
	 				$.get("{{route('address')}}",{del:1,id:id},function(obj){
							if( obj.code == 0 ){
							that.parent().parent().remove();
						}
					},'json');
	 			};
			});
		</script>
@endsection

		