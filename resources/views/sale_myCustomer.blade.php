@extends('sale_public')
@section('css/js')
@endsection
@section('content')
				<div class="title">
					<span>我的客户</span>
					<div class="right2">
						<input type="text" placeholder="输入关键词" class="ipt" id='keywords'/>
						<input type="submit" value="" class="btn" id='search' />
					</div>
				</div>
				<div class="xj-box">
					<div class="xj-table">
						<table id='dataChange'>
							<tr>
								<th>客户名称</th>
								<th>所在地区</th>
								<th>联系电话</th>
								<!-- <th>操作</th> -->
							</tr>
							@foreach( $myCustomers as $k => $v )
							<tr>
								<td>{{ $v['uname'] }}</td>
								<td>
									@if($v['getaddress'])
										{{ $v['getaddress'][0]['getprovincename']['name'] }} 
										{{ $v['getaddress'][0]['getcityname']['name'] }}
										{{ $v['getaddress'][0]['getareaname']['name'] }}
									@endif	
								</td>
								<td>{{ $v['phone'] }}</td>
								<td></td>
							</tr>
							@endforeach
						</table>
					</div>					
				</div>
@endsection
@section('js')
<script type="text/javascript">
	$(function(){
		$('#search').on('click',function(){
			var keywords = $('#keywords').val();
			if( keywords == '' ){
				alert('请输入关键词'); return false;
			}
			$.get("{{route('mycustomer')}}",{ keywords:keywords },function(cjson){
				var html = '<tr><th>客户名称</th><th>所在地区</th><th>联系电话</th><th>操作</th></tr>';
				$.each(cjson,function(i,v){
					html += "<tr>";
					html +=	"<td>"+v.uname+"</td>";
					html +=	"<td>";
					if(v.getaddress.length > 0){
							if(v.getaddress['0'].getprovincename){
								html +=	 v.getaddress['0'].getprovincename.name;		
							}
							if(v.getaddress['0'].getcityname){
								html +=	 v.getaddress['0'].getcityname.name;
							}
							if(v.getaddress['0'].getareaname){
								html +=	 v.getaddress['0'].getareaname.name;			
							}
					}
					html +=	"</td>";
					html +=	"<td>"+v.phone+"</td>";
					html +=	"<td></td>";
					html +=	 "</tr>";
				});
				$('#dataChange').html(html);
			},'json')
		});
	});
</script>	
@endsection