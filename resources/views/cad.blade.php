@extends('public')
@section('css/js')
@endsection
@section('content')
	<!--以上可共用-->
	<div class="catpos-box">
		<div class="catpos">
			<a href="{{url('')}}">首页</a>
			<em>></em>
			<span>CAD下载</span>
		</div>
	</div>
	<div class="jp-content">
		<div class="jp-top">
			<div class="title">
				<span>CAD下载</span>
			</div>
			<div class="video-box">
				<video class="video" id="video1" poster="{{asset('images/poster.jpg')}}" controls="controls">
					<source src="../dnaps/video.mp4" type='video/mp4' />
				</video>
			</div>
		</div>

	</div>
@endsection
@section('js')