@extends('personal_public')
@section('title')
我的收货地址
@endsection
@section('css/js')
<script type="text/javascript" src="{{asset('js/jquery.cityselect.js')}}"></script>
@endsection
@section('content')
			<div class="right1">
				<div class="right3-top blue">
					<span class="add-span">公司信息</span>
				</div>
				<div class="company-message">
					<div class="message">
						<span>公司名称</span>
						<div class="ipt-box">
							<input type="text" class="ipt1" value="@if($comList){{$comList->name}}@endif" id="name" />
						</div>						
					</div>
					<div class="message">
						<span>联系电话</span>
						<div class="ipt-box">
							<select name="" id="" class="ipt1">
								<option value="1">中国大陆（+86）</option>
							</select>
						</div>						
					</div>
					<div class="message">
						<span></span>
						<div class="ipt-box">
							<input type="text" class="ipt1 ipt2" placeholder="区号" value="@if($comList) {{ $comList->area_code }} @endif" id="area_code" />
							<input type="text" class="ipt1 ipt3" placeholder="电话号码" value="@if($comList) {{ $comList->phone }} @endif" id="phone" />
							<em>或</em>
							<input type="text" class="ipt1 ipt3" placeholder="手机号码" value="@if($comList) {{ $comList->mobile_phone }} @endif" id="mobile_phone" />
							<em>二者至少填一项</em>
						</div>
					</div>
					<!--PC端选择地址-->
					<div class="message" id="citySelect">
						<span>公司地址</span>
						<div class="ipt-box">
							<select class="ipt1 ipt4 prov" id="province">
								<option  checked='checked' > 
									@if($comList) 
										@if($comList->getpro)
											{{ $comList->getpro->name }} 
										@endif	
									@endif </option>
							</select>  
         					<select class="ipt1 ipt4 city" disabled="disabled" id="city" >
         						<option>
         							@if($comList)
         								@if($comList->getcity) {{ $comList->getcity->name }}

         								@elseif($comList->getarea) {{ $comList->getarea->name }}

         								@endif</option>
         							@endif	
         					</select>
         					<select class="ipt1 ipt4 dist" disabled="disabled" id="county">
         						<option>
         							@if($comList)
	         							@if($comList->getarea) 
	         								{{ $comList->getarea->name }}
	         							@endif
	         						@endif	
	         					</option>
         					</select>
						</div>						
					</div>
					<!--手机端选择地址-->
					<div class="message" id="zone">
						<span>公司地址</span>
						<div class="ipt-box">
							<input type="text" name="city" readonly id="wapcity" class="ipt1" />
						</div>						
					</div>
					<div class="message">
						<span></span>
						<div class="ipt-box">
		         			<input type="text" class="ipt1" placeholder="请不要重复输入省份/城市" id='address' value="@if($comList) {{$comList->address}} @endif" />
						</div>						
					</div>
					<div class="message">
						<span>公司介绍</span>
						<div class="ipt-box">
							<textarea name="" id="company_introduction" cols="30" rows="10">
								@if($comList) {{$comList->introduction}} @endif
							</textarea>
						</div>
					</div>
					<div class="message">
						<span></span>
						<div class="ipt-box">
							<div class="point">
								我们建议您填写详细的公司介绍，例如历史、业绩、经营范围、发展前景等。<br>
								不支持HTML语言<br>
								内容请控制在50-2000个字符内
							</div>
						</div>						
					</div>
					<div class="message">
						<input type="submit" value="保存" class="sub" name="submit" />
					</div>
				</div>
			</div>
		</div>
		</script>
@endsection
@section('js')		
<script type="text/javascript">
	$("#citySelect").citySelect({nodata:"none",required:false}); 
	$("input[name='submit']").on('click',function(){
		var name = $('#name').val();
		var province = $('#province').val();
		var city = $('#city').val();
		var county = $('#county').val();
		var area_code = $('#area_code').val();
		var phone = $('#phone').val();
		var mobile_phone = $('#mobile_phone').val();
		var address = $('#address').val();
		var company_introduction = $('#company_introduction').val();
		var data = {
			name:name,
			pro:province,
			city:city,
			area_code:area_code,
			phone:phone,
			mobile_phone:mobile_phone,
			address:address,
			company_introduction:company_introduction,
			county:county
		};
		$.post("{{route('company')}}",data,function(e){
			if(e.code == 0){
				alert(e.msg);
			}
		},'json');
	});
</script>
@endsection