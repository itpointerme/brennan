@extends('personal_public')
@section('title')
我的收货地址
@endsection
@section('css/js')
@endsection
@section('content')
			<div class="right1">
				<div class="right3-top blue">
					<span class="add-span on">基本信息</span>
					<span class="add-span">邮箱验证</span>
					<span class="add-span">手机验证</span>
					<span class="add-span">微信绑定</span>
				</div>
				<!--基本信息-->
				<div class="basicBox on">
					<div class="company-message password">
						<form method="post" action="{{route('head')}}" enctype="multipart/form-data">
						<div class="message">
							<span>联系人姓名</span>
							<div class="ipt-box">
								<input type="text" class="ipt1 ipt7"/ value="{{$userInfo->uname}}" name='uname' required >
								<label><input type="radio" name="sex" value="2" @if($userInfo->sex == 2) checked @endif />女士</label>
								<label><input type="radio" name="sex" value="1" @if($userInfo->sex == 1) checked @endif />先生</label>			
							</div>						
						</div>
						<div class="message">
							<span>身份证号</span>
							<div class="ipt-box">
								<input type="text" class="ipt1" value="{{$userInfo->id_card}}" name="id_card" required  />
							</div>						
						</div>
						{{ csrf_field() }}
						<!-- <div class="message">
							<span>身份证复印件</span>
							<div class="ipt-box">
								<input type="file" class="ipt6" value="{{$userInfo->id_card}}" />
							</div>						
						</div>
						<div class="message">
							<span></span>
							<div class="ipt-box">
								<div class="point">
									最多上传三张图片；jpg、gif、jpeg、png或bmp格式；不超过2M
								</div>
							</div>						
						</div> -->
						<!-- <div class="message">
							<span>所属部门</span>
							<div class="ipt-box">
								<input type="text" class="ipt1"/>
							</div>						
						</div>
						<div class="message">
							<span>职务</span>
							<div class="ipt-box">
								<input type="text" class="ipt1"/>
							</div>						
						</div>-->
						<div class="message">
							<span>上传头像</span>
							<div onclick="$('#previewImg').click()" id="preview"><img src="{{asset('images/m-icon1.jpg')}}" alt=""/></div>
							<input type="file"  id="previewImg" style="display: none;" name="files">
							<img id="blah" src="{{$userInfo->head}}" style="width: 30%;" />
							<script type="text/javascript">
								$(function(){
									var my_val = $('#blah').attr('src');
								})
							</script>

						</div>
						<div class="message">
							<input type="submit" value="确定" class="sub" id='base_information_true'/>
						</div>
						</form>
						<script type="text/javascript">
							$('#base_information_true').on('click',function(e){
									var uname = $("input[name='uname']").val();
									if(uname == ''){
										alert('联系人姓名必填');return false;
									}

									// var id_card = $("input[name='id_card']").val();
									// var sex = $("input[name='sex']:checked").val();
									// $.post("{{route('contacts')}}",{uname:uname,id_card:id_card,sex:sex,type:1},function(res){
									// 	if(res.code == 0)
									// 	{
									// 		alert('修改成功');
									// 		//光标指向下一个
									// 		//$(this).css
									// 	}
									// },'json')
							});
						</script>
						<script type="text/javascript">
							function readURL(input) {
							  if (input.files && input.files[0]) {
							  	$('#file_name').text(input.files[0].name);
							    var reader = new FileReader();
							    reader.onload = function(e) {
							      $('#blah').attr('src', e.target.result);
							      $('#blan').css('display','block');
							    }
							    reader.readAsDataURL(input.files[0]);
							  }
							}

							$("#previewImg").change(function() {
							  	readURL(this);
							  	
							  	console.log($('#blan').css(''));
							});	
						</script>
					</div>
				</div>	
				
				<!--邮箱验证-->
				<div class="basicBox">
					<div class="company-message password">
						<div class="message">
							<span>请输入邮箱</span>
							<div class="ipt-box">
								<input type="text" class="ipt1 ipt7" name="email" value="@if(Auth::user()->email) {{Auth::user()->email}} @endif" />
								<button id="Submit" type="button">发送验证码@if(Auth::user()->email) (已验证) @endif</button>
								
							</div>						
						</div>
						<div class="message">
							<span>请输入验证码</span>
							<div class="ipt-box">
								<input type="text" class="ipt1" name='code'/>
							</div>						
						</div>
						<div class="message">
							<input type="submit" value="确定" class="sub" id='mail_information_true'/>
						</div>
					</div>
				</div>
				<script type="text/javascript">
					$('#mail_information_true').on('click',function(e){
							var email = $("input[name='email']").val();
							var code = $("input[name='code']").val();
							if(code == ''){
								alert('请填写邮箱验证码');return false;
							}
							
							$.post("{{route('contacts')}}",{code:code,email:email,type:3},function(res){
								if(res.code == 0)
								{
									alert('绑定成功');
								}else{
									alert(res.msg);
								}
							},'json')
					});
				</script>

				
				<!--手机验证-->
				<div class="basicBox">
					<div class="company-message password">
						<div class="message">
							<span>请输入手机号码</span>
							<div class="ipt-box">
								<input type="text" class="ipt1 ipt7" value="@if(Auth::user()->phone) {{Auth::user()->phone}} @endif" id='mobile_code' />
								<button id="Submit" type="button" class="sendcode">发送验证码@if(Auth::user()->email) (已验证) @endif</button>
							</div>						
						</div>
						<script type="text/javascript">
							$(".sendcode").click(function(){
								alert('你已经验证，请勿重新验证');return false;
								var mcode = Math.round(900000*Math.random()+100000);  
							   	var test = {
								  node:null,
								  count:60,
								  start:function(){
									 if(this.count > 0){
										this.node.innerHTML = this.count--+'s';
										var _this = this;
										setTimeout(function(){
										   _this.start();
										},1000);
									 }else{
										this.node.removeAttribute("disabled");
										this.node.innerHTML = "重新发送";
										this.count = 10;
									 }
								  },
								  //初始化
								  init:function(node){
									 this.node = node;
									 this.node.setAttribute("disabled",true);
									 this.start();
								  }
							   };
								test.init(this);
								$.get(window.location.origin+"/getlogincode",{mobile:$('#mobile_code').val()},function(data){
				            			@if(env('APP_ENV')=='local')
				            				console.log(data);
				           				@endif
					            }).fail(function(e){
					                console.log( "error "+e);
					            });
									
								return false;
							});
						</script>
						<div class="message">
							<span>请输入验证码</span>
							<div class="ipt-box">
								<input type="text" class="ipt1"/>
							</div>						
						</div>
						<div class="message">
							<input type="submit" value="确定" class="sub" id='phone_true' />
						</div>
						<script type="text/javascript">
							$('#phone_true').on('click', function(){
								
							});
						</script>
					</div>
				</div>

				<script type="text/javascript">
					$(".Submit1").click(function(){
						var mcode = Math.round(900000*Math.random()+100000);  
					   	var test = {
						  node:null,
						  count:60,
						  start:function(){
							 if(this.count > 0){
								this.node.innerHTML = this.count--+'s';
								var _this = this;
								setTimeout(function(){
								   _this.start();
								},1000);
							 }else{
								this.node.removeAttribute("disabled");
								this.node.innerHTML = "重新发送";
								this.count = 10;
							 }
						  },
						  //初始化
						  init:function(node){
							 this.node = node;
							 this.node.setAttribute("disabled",true);
							 this.start();
						  }
					   };
						test.init(this);
						$.get(window.location.origin+"/getlogincode",{mobile:$('#forget_mobile').val()},function(data){
		            			@if(env('APP_ENV')=='local')
		            				console.log(data);
		           				@endif
			            }).fail(function(e){
			                console.log( "error "+e);
			            });
							
						return false;
					});
				</script>
				
				<!--微信绑定-->
				<div class="basicBox">
					<div class="company-message password">
						<div class="message">
							<span>请输入微信号</span>
							<div class="ipt-box">
								<input type="text" class="ipt1 ipt7" name="wechat" id='wechat' value="@if(Auth::user()->wechat) {{Auth::user()->wechat}} @endif" />
							</div>
						</div>
						<div class="message">
							<input type="submit" value="确定" id='wechatTrue' class="sub" />
						</div>
					</div>
				</div>
				<script type="text/javascript">
					$('#wechatTrue').on('click', function(){
							var wechatv = $('#wechat').val();
							if(wechatv == ''){
								alert('请输入微信号');
							}
							$.post("{{route('contacts')}}",{wechat:wechatv,type:5},function(res){
								if(res.code == 0)
								{
									alert('绑定成功');
								}
							},'json')
					});
				</script>							
			</div>
		</div>
		<script>
			$('.right3-top .add-span').click(function(){
				var index = $(this).index();
				$('.right3-top .add-span').removeClass('on');
				$(this).addClass('on');
				$('.basicBox').removeClass('on');
				$('.basicBox').eq(index).addClass('on');
			})
			$("#Submit").click(function(){
				if($('input[name="email"]').val() == '')
				{
					alert('请输入邮箱');return false;
				}
				var mcode = Math.round(900000*Math.random()+100000); 
			   	var test = {
				  node:null,
				  count:200,
				  start:function(){
					 //console.log(this.count);
					 if(this.count > 0){
						this.node.innerHTML = this.count--+'s';
						var _this = this;
						setTimeout(function(){
						   _this.start();
						},1000);
					 }else{
						this.node.removeAttribute("disabled");
						this.node.innerHTML = "重新发送";
						this.count = 10;
					 }
				  },
				  //初始化
				  init:function(node){
					 this.node = node;
					 this.node.setAttribute("disabled",true);
					 this.start();
				  }
			   };
				var btn = document.getElementById("Submit");
				test.init(btn);
				
				//可在此执行发送验证码的代码
				$.post("{{route('contacts')}}",{email:$('input[name="email"]').val(),type:2},function(res){
								if(res.code == 0)
								{
									alert(res.msg);
								}
							},'json')
				return false;
			});
		</script>
@endsection		
  