@extends('public')
@section('css/js')
@endsection
@section('content')
		<div class="catpos-box">
			<div class="catpos">
				<a href="{{url('/')}}">首页</a>
				<em>></em>
				<span>搜索产品</span>
			</div>
		</div>
		<div class="proBox2">
			<div class="proleft">	
				<ul>
					@if($goods)
						@foreach($goods as $g_v)
						<li>
							<a href="{{route('gdetail',['id'=>$g_v['ID']])}}">
								<div class="img">
									<img src="@if( $g_v['attachment']) {{$g_v['attachment'][0]['guid']}} @else {{asset('images/pro5.jpg')}} @endif" alt="" />
								</div>
								<span>{{$g_v['post_title']}}</span>
							</a>
						</li>
						@endforeach
					@else
						<li>
							<a href="">不好意思 没有搜到任何产品</a>
						</li>	
					@endif
				</ul>
				
			</div>
			
		</div>
	
@endsection

		

