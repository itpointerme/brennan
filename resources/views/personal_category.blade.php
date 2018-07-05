@extends('personal_public')
@section('title')
自定义类目管理
@endsection
@section('css/js')
<script type="text/javascript" src="{{asset('js/jquery.cityselect.js')}}"></script>
@endsection
@section('content')
			<div class="right1">
				<div class="right3-top">
					<span class="add-span">管理分类</span>
					<em>双击修改分类名称</em>
					<a href="javascript:;" class="add_fl" style="display: block;width: 120px;height: 40px; text-align: center;line-height: 40px; color: #fff; background: #42484b; font-size: 18px;float: right;">新增</a>
				</div>
				<div class="right2-table">
					<table>
						<tr data-id = '0'>
							<th>分类名称 </th>
							<th>排序 </th>
							<th>操作 </th>
						</tr>

						@foreach($clientCategory as  $k=>$v)
						<tr>
							<td ondblclick="ShowElement(this)" class="type" width="50%" aid='{{$v["id"]}}' >{{$v['name']}}</td>
							<td style="text-align:center;">
								<span class="move up" onclick="check(this,'MoveUp')"></span>
								<span class="move down" onclick="check(this,'MoveDown')"></span>
							</td>
							<td style="text-align:center;">
								<a href="javascript:;" class="del" title="删除" onclick="delTo(this,{{$v['id']}})" >删除</a>
							</td>
						</tr>
						@endforeach
					</table>
				</div>
			</div>
		</div>、
		<script type="text/javascript">
	        function ShowElement(element) {
	            var oldhtml = element.innerHTML;
	            //如果已经双击过，内容已经存在input，不做任何操作
	            if(oldhtml.indexOf('type="text"') > 0){
	                return;
	            }
	            //创建新的input元素
	            var newobj = document.createElement('input');
	            //为新增元素添加类型
	            newobj.type = 'text';
	            //为新增元素添加value值
	            newobj.value = oldhtml;
	            //为新增元素添加光标离开事件
	            newobj.onblur = function() {
	                element.innerHTML = this.value == oldhtml ? oldhtml : this.value;
	                //当触发时判断新增元素值是否为空，为空则不修改，并返回原有值 

	                $.get("{{route('pcategory')}}", {id:element.getAttribute("aid"), value:this.value }, function (e) {
	                	if(e.code == 0){
	                		//alert('更新成功');
	                	}
	                },'json')
	            }
	            //设置该标签的子节点为空
	            element.innerHTML = '';
	            //添加该标签的子节点，input对象
	            element.appendChild(newobj);
	            //设置选择文本的内容或设置光标位置（两个参数：start,end；start为开始位置，end为结束位置；如果开始位置和结束位置相同则就是光标位置）
	            newobj.setSelectionRange(oldhtml.length, oldhtml.length);
	            //设置获得光标
	            newobj.focus();	
	        }
	        
	        function check(t,oper){  
		        var data_tr=$(t).parent().parent(); //获取到触发的tr  
	            if(oper=="MoveUp"){    //向上移动  
	                if($(data_tr).prev().attr('data-id')==0){ //获取tr的前一个相同等级的元素是否为空  
	                   return;  
	                }else{  
	                    $(data_tr).insertBefore($(data_tr).prev()); //将本身插入到目标tr的前面   
	                }  
	            }else{  
                    if($(data_tr).next().html()==null){  
                    	return;  
                 	}else{  
                      	$(data_tr).insertAfter($(data_tr).next()); //将本身插入到目标tr的后面   
                 	}	  
	            }  
		    }  
		    $('.add_fl').click(function(){
		    	var html = '<tr>'
							+'<td ondblclick="ShowElement(this)" class="type" width="50%"><input type="text"></td>'
							+'<td style="text-align:center;">'
								+'<span class="move up" onclick=check(this,"MoveUp")></span>'
								+'<span class="move down" onclick=check(this,"MoveDown")></span>'
							+'</td>'
							+'<td style="text-align:center;">'
								+'<a href="javascript:;" class="save" title="保存" onclick="saveTo(this)" >保存</a>'
								+'<a href="javascript:;" class="del" title="删除" onclick="delTo1(this)"  >删除</a>'
							+'</td>'
						+'</tr>';
		    	$('.right2-table table tbody').append(html);

		    })

		    function delTo(em, id){
		    	if(confirm('确认删删除么？')){
					$.get("{{route('pcategory')}}", {id:id, type:'del'}, function (e) {
						em.parentNode.parentNode.remove()
					},'json')
		    	}
		    }

		    function delTo1(em){
		    	em.parentNode.parentNode.remove()
		    }

		    function saveTo(e){
		    	var tr = $(e).closest('tr');
		    	$.get("{{route('pcategory')}}", {value:tr.find('input').val(), type:'add'}, function () {
						location.reload();
					},'json')
		    }
    	</script>
@endsection