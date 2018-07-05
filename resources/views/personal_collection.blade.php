@extends('personal_public')
@section('title')
自定义类目管理
@endsection
@section('css/js')
@endsection
@section('content')
	<div class="right">
		<div class="theme">
			<p>配件收藏夹</p>					
		</div>	
		<div class="new-pj-list">
			@foreach($data as $key=>$val)
				<div class="item">
					<div class="img">
						<img src="{{$img[$key]}}" alt="" />	
						<div class="link">
							<a href="{{route('gdetail',['id'=>$val['gid']])}}">查看</a>
							<a href="javascript:;" class="del" index="{{$val['id']}}">删除</a>
						</div>
					</div>
					<p class="tit1">{{$val['getgoods']['post_title']}}</p>
					<p class="tit2">{{$val['getgoods']['post_name']}}</p>
				</div>
			@endforeach
		</div>
	</div>

<script>
   	$(".del").click(function() {
   		var id=$(this).attr('index');
        $.ajax({
        	headers:{'X-CSRF-TOKEN':'{{csrf_token()}}'},
        	type:'POST',
        	url:"{{route('del_collect')}}",
        	data:{id:id},
        	dataType:'json',
        	success:function(data){
        		if(data.code==1){
        			location.reload();
        		}
        	}
        })
	})
</script>
@endsection