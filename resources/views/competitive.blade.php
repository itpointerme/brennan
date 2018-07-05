@extends('public')
@section('css/js')
@endsection
@section('content')
	<div class="catpos-box">
		<div class="catpos">
			<a href="{{url('')}}">首页</a>
			<em>></em>
			<span>竞品查询</span>
		</div>
	</div>
	<div class="jp-content">
		<div class="jp-top">
			<div class="title">
				<span>竞品查询</span>
				<em>使用此表格可以使用竞争对手的零件号找到不劳宁的零件，选择供应商并再下面的框中输入部件号或部分号</em>
			</div>
			<div class="searchcontent">
				<div class="searchbox">
					<h2>竞争对手零件信息</h2>
					<select name="" id="choice">
						<option value="0">选择供应商</option>
						@foreach($webvxout as $val)
							<option value="{{$val->VendorKey}}">{{$val->VendorName}}</option>
						@endforeach
					</select>
					<input type="text" placeholder="请输入供应商部件号" class="ipt" id="num">
					<input type="submit" class="sub" />
				</div>
			</div>
		</div>
		<div class="jp-bottom">
			<div class="title">
				<span>搜索结果</span>
				<em>找到<b id="fen">0</b>份记录<i style="font-style:normal;" id="yes"></i>。您可以通过在上面的搜索表单中输入更多的数据来对结果进行微调。</em>
			</div>
			<div class="table-box">
				<table>
					<tr>
						<th>Competitor Part</th>
						<th>Brennan Part</th>
						<th>Description</th>
						<th></th>
					</tr>
					<tbody class="huan">

					</tbody>
				</table>
			</div>
		</div>
	</div>

<script>
	$('.sub').click(function(){
		var choice=$('#choice option:selected').val();
		var num=$.trim($('#num').val());
		if(choice==0){
			alert('请选择供应商');
			return false;
		}
		if(num==''){
			alert('请输入供应商部件号');
			return false;
		}

		$.ajax({
			headers:{'X-CSRF-TOKEN':'{{csrf_token()}}'},
			type:'POST',
			url:"{{route('ajax_competitive')}}",
			data:{choice:choice,num:num},
			dataType:'json',
			success:function(data){
				if(data.msg=='ok'){
					$('.huan').html(data.text);
					$('#fen').text(data.count)
					if(data.count > 50){
						$('#yes').text('(显示前50份)')
					}else{
						$('#yes').text('')
					}
				}
			}
		})
	})
</script>
@endsection
@section('js')