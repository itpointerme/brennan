@extends('personal_public')
@section('title')
管理采购订单
@endsection
@section('css/js')
<link href="{{asset('css/mobiscroll.css')}}" rel="stylesheet" />
<link href="{{asset('css/mobiscroll_date.css')}}" rel="stylesheet" />
@endsection
@section('content')

			<div class="right">
				<div class="right-top">
					<div class="itemleft">
						<img src="img/logo.png" alt="" />
						<p>布劳宁（上海）液压气动有限公司</p>
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
								<th width="30">材质</th>
								<th width="30">单位</th>
								<th width="40">采购数量</th>
								<th width="40">客户自编号</th>
								<th width="80">客户描述</th>
								<th width="20"></th>
							</tr>
							<tr>
								<td><img src="img/xj.jpg" alt="" /></td>
								<td>0302-05-B</td>
								<td>材质</td>
								<td>件</td>
								<td><input type="text" /></td>
								<td><input type="text" /></td>
								<td><input type="text" /></td>
								<td><a href="javascript:;" class="close">X</a></td>
							</tr>
							<tr>
								<td><img src="img/xj.jpg" alt="" /></td>
								<td>0302-05-B</td>
								<td>材质</td>
								<td>件</td>
								<td><input type="text" /></td>
								<td><input type="text" /></td>
								<td><input type="text" /></td>
								<td><a href="javascript:;" class="close">X</a></td>
							</tr>
							<tr>
								<td><img src="img/no.jpg" alt="" /></td>
								<td>0302-05-B</td>
								<td>材质</td>
								<td>件</td>
								<td><input type="text" /></td>
								<td><input type="text" /></td>
								<td><input type="text" /></td>
								<td><a href="javascript:;" class="close">X</a></td>
							</tr>
						</table>
					</div>					
					<a href="#" class="add">+&nbsp;&nbsp;添加历史采购产品</a>
				</div>
				<div class="line"></div>
				<div class="purchase">
					<div class="title">采购要求</div>
					<div class="purchase-message">
						<span>收货地址</span>
						<p>河北省 保定市 北市区</p>			
						<a href="#">更换地址</a>
					</div>
					<div class="purchase-message">
						<span>其他约定</span>
						<textarea name="" rows="" cols=""></textarea>
					</div>
					<div class="purchase-message">
						<span>上传附件</span>
						<div onclick="$('#previewImg').click()" id="preview"><img src="img/m-icon1.jpg" alt=""/></div>
						 <input type="file" style="display: none;" id="previewImg" >
					</div>
				</div>				
				<input type="submit" value="立即提交" class="sub"/>
			</div>
		</div>
		
		<div class="add-cg-bj"></div>
		<div class="add-cg-box">
			<div class="top">
				<span>选择物品</span>
				<a href="javascript:;" class="close"><img src="img/close.png" alt="" /></a>
			</div>
			<div class="search">
				<input type="text" placeholder="物品名称" class="ipt"/>
				<input type="submit" value="" class="sub"/>
			</div>
			<div class="cg-table-box">
				<table>
					<tr>
						<th><input type="checkbox" id="allcheck" onclick="checkAll(this)"/></th>
						<th>所属类目</th>
						<th>物品名称</th>
						<th>规格型号</th>
						<th>单位</th>
					</tr>
					<tr>
						<td><input type="checkbox" name='cartCheckBox' onclick="checkEach(this)"/></td>
						<td>黄铜</td>
						<td>弯头产品</td>
						<td>NHD777088</td>
						<td>件</td>
					</tr>
					<tr>
						<td><input type="checkbox" name='cartCheckBox' onclick="checkEach(this)"/></td>
						<td>黄铜</td>
						<td>弯头产品</td>
						<td>NHD777088</td>
						<td>件</td>
					</tr>
				</table>
			</div>
			<div class="link">
				<a href="#" class="sure">确定</a>
				<a href="#" class="cancel">取消</a>
			</div>
		</div>
		<script>
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
			function checkAll(){   
		        if($('#allcheck').is(":checked")){  
			        $("[name='cartCheckBox']").prop("checked",true); 
			    }else{  
			        $("[name='cartCheckBox']").prop("checked",false);  
		       	}  
			}  
			//每个单选框  
			function checkEach(obj){ 				         
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
	
		<script>
			$('.xj-box table tr td a.close').click(function(){
				$(this).parent().parent().remove();
			})
		</script>
		<!-- Swiper JS -->
    	<script src="js/swiper-4.1.6.min.js"></script>
		<script src="js/PcSiteJs.js"></script>
		<script src="js/mobiscroll_date.js" charset="gb2312"></script> 
		<script src="js/mobiscroll.js"></script> 
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
		
		});
		</script>
@endsection
