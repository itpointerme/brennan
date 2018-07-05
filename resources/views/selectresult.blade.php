@extends('public')
@section('css/js')
@endsection
@section('content')
<div class="catpos-box">
			<div class="catpos">
				<a href="#">首页</a>
				<em>></em>
				<span>目录</span>
				<em>></em>
				<span>查找配件</span>				
			</div>
		</div>
		<div class="proBox2">
			<div class="title lighter">查找配件-结果</div>
			<div class="find-result">
				<div class="top">
					您选择了：
				</div>
				<div class="result-box">
					<div class="choose-allready">
						<div class="t">形状:</div>
						<div class="img">
							<img src="@if($shape['images']['attachment']) {{$shape['images']['attachment']['1']['guid']}} @else {{asset('images/4-1.jpg')}} @endif " alt="" />
						</div>
						<div class="font">
							<p>{{$shape['images']['post_title']}}</p>
							<span>{{$shape['name']}}</span>
						</div>
					</div>
					<div class="choose-allready">
						<div class="t">接头:</div>
						<div class="img">
							<img src="@if($connect['images']['attachment']) {{$connect['images']['attachment']['1']['guid']}} @else {{asset('images/4-1.jpg')}} @endif" alt="" />
						</div>
						<div class="font">
							<p>{{$connect['name']}}</p>
						</div>
					</div>
					<!-- <div class="choose-allready color">
						<div class="t">材质 :</div>
						<div class="img"><img src="{{asset('images/4-color1.jpg')}}" alt="" /></div>
						<div class="font">
							<p>黄铜色</p>
						</div>
					</div> -->
				</div>
			</div>
			<div class="title lighter">结果</div>
			<div class="result-list">
				@foreach($goods as $k => $v)
				<a href="{{route('gdetail',['id'=>$v['ID']])}}">
					<div class="img">
						<img src="@if($v['attachment']) {{$v['attachment'][0]['guid']}}  @else {{asset('images/pro5.jpg')}} @endif" alt="" />
					</div>
					<span>{{$v['post_title']}}</span>
					<p>{{$v['post_content']}}</p>
				</a>
				@endforeach
			</div>
		</div>
@endsection


		

