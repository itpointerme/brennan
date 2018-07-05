@extends('personal_public')
@section('title')
我的收货地址
@endsection
@section('css/js')
@endsection
@section('content')
			<div class="right1">
				<div class="right3-top blue">
					<span class="add-span">修改密码</span>
				</div>
				<div class="company-message password">
					<div class="message">
						<span>原始密码</span>
						<div class="ipt-box">
							<input type="text" class="ipt1" id='init_password'/>
						</div>						
					</div>
					<div class="message">
						<span>新密码</span>
						<div class="ipt-box">
							<input type="text" class="ipt1" id='password'/>
						</div>						
					</div>
					<div class="message">
						<span></span>
						<div class="ipt-box">
							<div class="point">
								6-20位字符，只能包含大小写字母、数字及标点符号（除空格）
							</div>
						</div>						
					</div>
					<div class="message">
						<span>确认新密码</span>
						<div class="ipt-box">
							<input type="text" class="ipt1" id='password_confirmation'/>
						</div>						
					</div>
					<div class="message">
						<input type="submit" value="保存" class="sub" id='uppassword' />
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			$("#uppassword").on('click',function(){
				if($('#password').val().length < 6 ){
  						alert('长度请大于6位数');return false;
  					}
  				$.post("{{route('password')}}",
  					  {oldpassword:$('#init_password').val(),password:$('#password').val(),password_confirmation:$('#password_confirmation').val()},
  				function(e){
  					alert(e.msg);
	            },'json')
			});
		</script>
@endsection