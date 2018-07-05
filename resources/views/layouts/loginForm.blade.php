<div class="register-box" style="display: none;">
	<div class="close">
		<img src="{{asset('images/close.png')}}" alt="" />
	</div>
	<div class="lg-re">
		<div class="choose-style">
			<span class="on">登录</span>
			<span>注册</span>				
		</div>			
		<div class="login-box on">
			<div  id='login_form'>
				 {{ csrf_field() }}
				<div class="message">
					<p>账户名</p>
					<input type="text" class="ipt" placeholder="请输入您的手机号" name="phone" value="" id='surePhone'/>
					<div class="points"><span class="phone_erro"></span></div>
				</div>
				<div class="message">
					<p>密码</p>
					<input type="password" class="ipt" placeholder="请输入您的密码" name='password' id='surePass'/>
					<div class="points"><span class="pass_erro"></span></div>
				</div>
				<div class="message">
					<input id='submit' type='button' class="sub" value="登录"/>
				</div>
				<div class="forget"><a href="#">忘记密码？</a></div>
			</div>
		</div>
		<script type="text/javascript">
			$('#submit').on('click',function(){
				var data = {
					phone:$('#surePhone').val(),
					password:$('#surePass').val(),
					_token: '{{csrf_token()}}'
				};
				$.ajax({
					url:'{{route('login')}}',
					type:'POST',
					data:data,
					success: function(e){
						if(e.code == 1){
							location.reload();
						}
					},
					error: function(e){
						alert('账号或密码错误');
					}
				});
			});
		</script>
		<div class="login-box">
			<div id='register_form'>
				<div class="message">
					<input type="text" class="ipt" placeholder="请输入您的手机号" id="mobile"/>
					<div class="points"><span></span></div>
				</div>
				<div class="message">
					<div class="message1">
						<input type="text" class="ipt1" placeholder="请输入验证码" id="yzm"/>
						<button class="Submit" type="button">发送验证码</button>
					</div>	
					<div class="points"><span></span></div>
				</div>
				<div class="message">
					<input type="password" class="ipt" placeholder="请输入您的密码" id='pass'/>
					<div class="points"><span></span></div>
				</div>
				<div class="message">
					<input type="password" class="ipt" placeholder="请再次输入密码" id='pass1'/>
					<div class="points"><span></span></div>
				</div>
				<div class="message">
					<input type="submit" class="sub" id='reg' value="注册"/>
				</div>
			</div>								
		</div>
	</div>
	<div class="forgetBox">
		<div class="choose-style">
			<span class="on">忘记密码</span>		
		</div>			
		<div class="login-box on">
			
				<div class="message">
					<input type="text" class="ipt" placeholder="请输入您的手机号" id='forget_mobile'/>
					<div class="points"><span></span></div>
				</div>
				<div class="message">
					<div class="message1">
						<input type="text" class="ipt1" placeholder="请输入验证码" id='forget_yzm'/>
						<button class="Submit Submit1" type="button">发送验证码</button>
					</div>	
					<div class="points"><span></span></div>
				</div>
				<div class="message">
					<input type="password" class="ipt" placeholder="请输入您的新密码" id='forget_pass'/>
					<div class="points"><span></span></div>
				</div>
				<div class="message">
					<input type="submit" class="sub" id='forget_reg' value="确认修改"/>
				</div>
									
		</div>
	</div>
</div>