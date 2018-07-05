@extends('personal_public')
@section('title')
新增采购订单
@endsection
@section('css/js')
<link href="{{asset('css/mobiscroll.css')}}" rel="stylesheet" />
<link href="{{asset('css/mobiscroll_date.css')}}" rel="stylesheet" />
@endsection
@section('content')
<form method="post" action="{{route('addporder')}}" enctype="multipart/form-data">
			<div class="right">
				<div class="right-top">
					<div class="itemleft">
						<p>当前您还不满足添加采购订单条件</p>
					</div>
				</div>
			</div>
		</div>
</form>		
@endsection
