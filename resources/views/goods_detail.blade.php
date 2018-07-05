@extends('public')
@section('css/js')
<link rel='stylesheet' href='{{asset("css/masterslider.css")}}' type='text/css' />
<link rel='stylesheet' href='{{asset("css/ms-showcase2.css")}}' type='text/css' />
<link rel='stylesheet' href='{{asset("css/masterslider.main.css")}}' type='text/css' /> 
<script type="text/javascript" src="{{asset('js/modernizr-2.6.2.min.js')}}"></script>
<script type='text/javascript' src="{{asset('js/masterslider.min.js')}}"></script>
<script type='text/javascript' src="{{asset('js/jquery.easing.min.js')}}"></script>  
@endsection
@section('content')
		<div class="catpos-box">
			<div class="catpos">
				<a href="#">首页</a>
				<em>></em>
				<span>
					@if($goodsInfo['get_category'])
						{{$goodsInfo['get_category']['0']['get_items']['getterminfo']['name']}}
					@endif	
				</span>
				<em>></em>
				<span>{{$goodsInfo['post_title']}}</span>
			</div>
		</div>
		<div class="pro-main-box">
			<div class="picList">
				<div class="ms-showcase2-template ms-dir-v"> 
				  <!-- masterslider -->
					<div class="master-slider ms-skin-default" id="masterslider">
						@foreach($goodsInfo['get_imgs'] as $v_img)
							<div class="ms-slide">
								<img src="{{asset('images/loading-2.gif')}}" data-src="{{$v_img['get_goods_img']['guid']}}" alt=""/> 
								<img class="ms-thumb" src="{{$v_img['get_goods_img']['guid']}}" alt="" /> 
							</div>
						@endforeach
					</div>
				  <!-- end of masterslider --> 
				</div>
			</div>
			<div class="pro-right">
				<h2>{{$goodsInfo['post_title']}}</h2>
				<a href="javascript:;" class="download" style="display: none;" ><img src="{{asset('images/download.png')}}" alt="" />下载CAD和图纸</a>
				<ul>
					<li>类别<span>
					@if($goodsInfo['get_category'])
						{{$goodsInfo['get_category']['0']['get_items']['getterminfo']['name']}}
					@endif
					</span></li>
					<li>连接<span>
						@if($goodsInfo['get_ter_taxonomy_connect']) 
								{{$goodsInfo['get_ter_taxonomy_connect']['0']['get_items']['getterminfo']['name']}}
						@endif		
					</span></li>
					<li>形状<span>
						@if($goodsInfo['get_ter_taxonomy_shape']) 
							{{$goodsInfo['get_ter_taxonomy_shape']['0']['get_items']['getterminfo']['name']}}
						@endif							
					</span></li>					
				</ul>
				<div class="system">
					<a id='printAr'>打印</a>
					<a id='collectionAr' index="{{$goodsInfo['ID']}}" class="collection" data-id = 0>
						@if(!empty($goodsInfo['get_collect']))
							已收藏
						@else
							收藏
						@endif
					</a>
					<a id='shareAr'>分享</a>
				</div>
				<script type="text/javascript">
					$(function(){
						var collect = "{{$goodsInfo['get_collect']['id']}}";
						if(collect){
							$('.collection').html('已收藏');
						}
					});
				</script>
				<div class="checked">
					<p>已选<span>
						@if($cart_count > 0)
							{{$cart_count}}
						@else
							0
						@endif
					</span>个</p>
					<a href="javascript:;" class="joinin" >加入询价单</a>
				</div>
				
			</div>
		</div>
		<div style="text-align: center;margin: 0 auto; width: 100%;display:none;" id='cad'>
			<iframe id='myiframe' src="" style="width: 80%;height: 40rem;" frameborder="no" border="0" marginwidth="0" marginheight="0" scrolling="no" allowtransparency="yes"></iframe>
		</div>
		<div class="pro-table">
			<div class="table0">
				<table border="1">
					<tr>
						@if($r)
							@foreach( $r as $rv )
								<th width="80">{{$rv[1]}}</th>
							@endforeach
						@endif	
							<th width="200">
								<label onclick="checkAll(this)" class="label">全部选择<input type="checkbox" id="allcheck"/></label>
							</th>
					</tr>
				</table>
			</div>
			<div class="table1">
				<table border="1">
					
					@foreach( $goodsInfo['get_sku'] as $sku_v)
						<tr onclick="checkEach(this,{{$sku_v['ID']}})" data-id="{{$sku_v['ID']}}">
							<?php 
								$search_v = '/<td>(.*?)<\/td>/is';
								preg_match_all($search_v,$sku_v['meta_value'],$r_v,PREG_SET_ORDER );
							?>
							@foreach($r_v as $k=>$v)
								@if($k%2 == 1)
									<td width="80">{{$v[1]}}</td>
								@endif
							@endforeach
							<td width="200">
								<div class="label @if(in_array($sku_v['ID'], $cart)) on @endif">
									{{$sku_v['post_title']}}
									<input type="checkbox" name='cartCheckBox' sku_id = '{{$sku_v["ID"]}}' @if(in_array($sku_v['ID'], $cart)) checked @endif"/>
								</div>
							</td>
						</tr>
					@endforeach
				</table>
			</div>
		</div>
		<div id="message"></div>
		
		<div class="tip" id="tip1">
			<div class="close"><img src="{{asset('images/close.png')}}" alt="" /></div>
			<div class="tip-font">确认从询价单内移除？</div>
			<div class="link">
				<a href="jvascript:;" class="sure">确认</a>
				<a href="jvascript:;" class="cancel">取消</a>
			</div>
		</div>
		<div class="tip" id="tip2">
			<div class="close"><img src="{{asset('images/close.png')}}" alt="" /></div>
			<div class="tip-font">加入询价单成功！</div>
			<div class="link">
				<a href="jvascript:;" class="sure" id='addCard'>去询价单提交</a>
				<a href="jvascript:;" class="cancel">继续选择产品</a>
			</div>
		</div>
		<!--效果-->

@endsection
@section('js')
		<script src="{{asset('js/aos.js')}}"></script>
		<script>
			AOS.init({
				easing: 'ease-out-back',
				duration: 1000
			});
			
		</script>
		<!-- Swiper JS -->
    	<script src="{{asset('js/swiper-4.1.6.min.js')}}"></script>
		<script src="{{asset('js/PcSiteJs.js')}}"></script>
		<script type="text/javascript">		
		$(document).ready(function(){
			var slider = new MasterSlider();
			slider.setup('masterslider' , {
				width:300,
				height:300,
				space:5,
				view:'basic'
			});	
			slider.control('thumblist' , {autohide:false ,dir:'v',arrows:false});
		});
		function checkAll(){   
	        if($('#allcheck').is(":checked")){  
		        $("[name='cartCheckBox']").prop("checked",true); 
		        $('.pro-table table tr .label').addClass('on');
		        total();
		    }else{  
		        $("[name='cartCheckBox']").prop("checked",false);  
		        $('.pro-table table tr .label').removeClass('on');
		        total();
	       	}  
		}  
		//每个单选框  
		function checkEach(obj,id){ 	
			var id = id;
			if($(obj).find('td .label input[type="checkbox"]').is(":checked")){		
				// $(obj).find('td .label input[type="checkbox"]').prop("checked",false);
				// $(obj).find('td .label').removeClass('on');
				//判断 id 是否在 购物车中 
				$.get("{{route('is_cart')}}" ,{id:id} ,function(msg){
					if(msg.code == 0){
						$('#tip1').show();	
					}else{
						$(obj).find('td .label input[type="checkbox"]').prop("checked",false);
						$(obj).find('td .label').removeClass('on');
						total();
					}
				},'json')

				$('#tip1').attr('data-id',id);

			}else{
				$(obj).find('td .label input[type="checkbox"]').prop("checked",true);
				$(obj).find('td .label').addClass('on');
				//cad
				var oid = $(obj).find('td .label input[type="checkbox"]').attr('sku_id');
				$.get("/getcad/"+oid, {}, function(e){
					if(e.link != null){
						$('.download').css('display', 'block');
						$('#myiframe').attr('src', e.link+'&amp;email=465478519@qq.com');

					}
				}, 'json');

			}				         
		    var count = total();
		    if(count==$("[name='cartCheckBox']").size()){  
		    	$('.pro-table table tr th .label').addClass('on');
		        $("#allcheck").prop("checked",true);  
		    }else{   
				$("#allcheck").prop("checked",false);
				$('.pro-table table tr th .label').removeClass('on');
		    }   
       	}  

       	$('.tip .close,.tip .cancel').click(function(){
       		$('#tip1').hide();
       		$('#tip2').hide();
       	})
       	$('#tip1 .sure').click(function(){
       		var id = $('#tip1').attr('data-id');
       		$('.table1 table tr').each(function(){
       			if($(this).attr('data-id') == id){
       				$(this).find('td .label input[type="checkbox"]').prop("checked",false);
					$(this).find('td .label').removeClass('on');

					//var gid = $(this).find('td .label input[type="checkbox"]').attr('sku_id');
					//ajax 删除当前询价单

	        			 $.ajax({
				        	headers:{'X-CSRF-TOKEN':'{{csrf_token()}}'},
				        	type:'POST',
				        	url:"{{route('askorderdel')}}",
				        	data:{rowid:id},
				        	dataType:'json',
				        	success:function(data){
				        		console.log(data);
				        		success('从询价单移除成功!');
				        		//计算已选几个
				        		 total();
				        	}
				        })
       			}
       		})
       		$('#tip1').hide();
       	})
       	$('.joinin').click(function(){
       		var is_login = '{{Auth::check()}}';
    		if(!is_login){
    			$('.register-box').css('display', '');return false;
    		}
    		$('#addCard').attr('href', "{{route('askaorders')}}");
       		//获取所选sku_id  加入询价单
    		var $sku_id = [];
    		$('input[name="cartCheckBox"]:checked').each(function(){

				$sku_id.push($(this).attr('sku_id')); 
			});
			//console.log($sku_id);
			if($sku_id.length > 0){
				var url = "{{ route('card') }}" ;
				$.post(url,{data:$sku_id},function(msg){
				},'json')
			}

       		$('#tip2').show();
       	})
       	$('#tip2 .sure').click(function(){
       		$('#tip2').hide();
       	})
       	function total(){
       		var count=0; 
       		$("input[name='cartCheckBox']").each(function(index, element) {  
		        if($(this).is(":checked")){  
		            count++;  
		        }  
		    });  
		    $('.pro-right .checked p span').html(count);
		    return count;
       	}
       	$('#printAr').on('click',function(){
	         window.print();
       	});

       	$("#collectionAr").click(function() {
       		var id=$(this).attr('index');
       		var is_login = '{{Auth::check()}}';
    		if(!is_login){
    			$('.register-box').css('display', '');return false;
    		}
    		
	        $.ajax({
	        	headers:{'X-CSRF-TOKEN':'{{csrf_token()}}'},
	        	type:'POST',
	        	url:"{{route('ajax_add')}}",
	        	data:{id:id},
	        	dataType:'json',
	        	success:function(data){
	        		if(data.code==1){
	        			success('收藏成功!');
	        			$('.collection').html('已收藏');
	        		}else if(data.code==2){
	        			//ajax 取消收藏
	        			 $.ajax({
				        	headers:{'X-CSRF-TOKEN':'{{csrf_token()}}'},
				        	type:'POST',
				        	url:"{{route('ajax_del')}}",
				        	data:{id:id},
				        	dataType:'json',
				        	success:function(data){
				        		success('取消收藏!');
				        		$('.collection').html('收藏');
				        	}
				        })
	        		}
	        	}
	        })
    	})

    	$('.download').on('click', function(){
    		$('#cad').css('display', 'block');
    	});

    	/*$('.collection').click(function(){
       		var id = $(this).attr('data-id');
       		if(id == 0){
       			$(this).html('已收藏');
       			$(this).attr('data-id',1);
       			success('收藏成功!');
       		}else{
       			$(this).html('收藏');
       			$(this).attr('data-id',0);
       			success('取消收藏!');
       		}
       		
       	})*/
       	function success(Message){
			var staTar = jQuery(window);
			var width = jQuery(window).width();
			var html = "<div id = 'flashMessage'  class='noty_w noty_suc'><div class='noty_bar noty_type_error'><div class='noty_message'><span class='noty_text'>"+Message+"</span></div></div></div>";
			$("#message").html(html);
			$("#flashMessage")
				.css({
					'left':width/2-jQuery("#flashMessage").width()/2})
					.fadeIn(800);
			setTimeout("hideTips()",2000);
		
			hideTips = function(){
				$("#flashMessage").fadeOut(500);
				$("#message").html('');
			};
		}
		</script>
@endsection		