@extends('public')
@section('css/js')
@endsection
@section('content')
<div class="fullSlide">
	<div class="bd">
		<ul>
			@foreach($banner as $val)
				<li style="background:url({{asset('images/banner.jpg')}}) center center no-repeat; background-size:cover;">
					<div class="font-box">
						<div class="left" aos="fade-right" aos-delay="200">
							<img src='{{asset("uploads/$val->img1")}}' alt=""/>
						</div>
						<div class="right">
							@if($val->img2 != '')
								<img src='{{asset("uploads/$val->img2")}}' alt="" class="img2"  aos="fade-left" aos-delay="200"/>
							@endif
							<div class="font" aos="fade-left" aos-delay="300">
								<span>{{$val->text1}}</span>
								<p>{{$val->text2}}</p>								
							</div>
							@if($val->addr != '')
								<span aos="fade-left" aos-delay="400"><a href="{{$val->addr}}">查看详情</a></span>
							@endif
						</div>							
					</div>
				</li>
			@endforeach
		</ul>
	</div>
</div>

<div class="index-content1">
	<div class="index1">
		<div class="img"><a href="#"><img src="{{asset('images/pro1.png')}}" alt="" /></a></div>
		<h2><a href="#">标准分类组</a></h2>
		<ul>
			<li><a href="#">库存积压物品</a></li>
			<li><a href="#">法兰配件</a></li>
			<li><a href="#">饰品</a></li>
			<li><a href="#">转换适配器</a></li>
			<li><a href="#">管接头和适配器</a></li>
			<li><a href="#">黄铜配件</a></li>
			<li><a href="#">O形环面密封配件</a></li>
			<li><a href="#">夹</a></li>
		</ul>
	</div>
	<div class="index1 center">
		<div class="img"><a href="#"><img src="{{asset('images/pro2.png')}}" alt="" /></a></div>
		<h2><a href="#">连接类型组</a></h2>
		<ul>
			<li><a href="#">弯头</a></li>
			<li><a href="#">面密封</a></li>
			<li><a href="#">咬合式</a></li>
			<li><a href="#">NPT</a></li>
			<li><a href="#">管</a></li>
			<li><a href="#">Flare-O</a></li>
			<li><a href="#">JIC</a></li>
			<li><a href="#">法兰</a></li>
			<li><a href="#">标准管</a></li>
			<li><a href="#">ORB</a></li>
			<li><a href="#">BSP</a></li>
			<li><a href="#">焊接</a></li>
		</ul>
	</div>
	<div class="index1">
		<div class="img"><a href="#"><img src="{{asset('images/pro3.png')}}" alt="" /></a></div>
		<h2><a href="#">形状类型组</a></h2>
		<ul>
			<li><a href="#">袖子</a></li>
			<li><a href="#">三通</a></li>
			<li><a href="#">形状</a></li>
			<li><a href="#">十字架</a></li>
			<li><a href="#">直</a></li>
			<li><a href="#">弯头</a></li>
		</ul>
	</div>
</div>
<div class="index-content2">
	<div class="index2">
		<h3>不容错过的特色产品</h3>
		<ul>
			<li>
				<a href="#">
					<span class="img"><img src="{{asset('images/img1.jpg')}}" alt="" /></span>
					<h1>0304</h1>
					<p>Standard Nut</p>
				</a>
			</li>
			<li>
				<a href="#">
					<span class="img"><img src="{{asset('images/img2.jpg')}}" alt="" /></span>
					<h1>0304</h1>
					<p>Standard Nut</p>
				</a>
			</li>
			<li>
				<a href="#">
					<span class="img"><img src="{{asset('images/img3.jpg')}}" alt="" /></span>
					<h1>0304</h1>
					<p>Standard Nut</p>
				</a>
			</li>
			<li>
				<a href="#">
					<span class="img"><img src="{{asset('images/img4.jpg')}}" alt="" /></span>
					<h1>0304</h1>
					<p>Standard Nut</p>
				</a>
			</li>
			<li>
				<a href="#">
					<span class="img"><img src="{{asset('images/img1.jpg')}}" alt="" /></span>
					<h1>0304</h1>
					<p>Standard Nut</p>
				</a>
			</li>
			<li>
				<a href="#">
					<span class="img"><img src="{{asset('images/img2.jpg')}}" alt="" /></span>
					<h1>0304</h1>
					<p>Standard Nut</p>
				</a>
			</li>
			<li>
				<a href="#">
					<span class="img"><img src="{{asset('images/img3.jpg')}}" alt="" /></span>
					<h1>0304</h1>
					<p>Standard Nut</p>
				</a>
			</li>
			<li>
				<a href="#">
					<span class="img"><img src="{{asset('images/img4.jpg')}}" alt="" /></span>
					<h1>0304</h1>
					<p>Standard Nut</p>
				</a>
			</li>
		</ul>
		<a href="#" class="link">查看更多<img src="{{asset('images/more.png')}}" alt="" /></a>
	</div>			
</div>
<div class="index-content3">
	<div class="index3">
		<div class="index3-top">
			@foreach($advert as $val)
				<div class="left">
					<img src='{{asset("uploads/$val->img")}}' alt="" />
				</div>
			@endforeach
		</div>
		
		<div class="index3-rz">
			<div class="left1">
				<p>认证</p>
				<span>认证认证认证</span>
			</div>
			<div class="right1">
				<div class="picScroll-left">
					<div class="bd">
						<ul class="picList">
							<li>
								<img src="{{asset('img/rz1.jpg')}}" alt="" />
							</li>
							<li>
								<img src="{{asset('images/rz2.jpg')}}" alt="" />
							</li>
							<li>
								<img src="{{asset('images/rz3.jpg')}}" alt="" />
							</li>
							<li>
								<img src="{{asset('images/rz4.jpg')}}" alt="" />
							</li>
							<li>
								<img src="{{asset('images/rz5.jpg')}}" alt="" />
							</li>
							<li>
								<img src="{{asset('images/rz6.jpg')}}" alt="" />
							</li>
							<li>
								<img src="{{asset('images/rz7.jpg')}}" alt="" />
							</li>
						</ul>
					</div>
				</div>
				
				<!--手机端-->
				<div class="picScroll-left-wap">
					<div class="bd">
						<ul class="picList">
							<li>
								<img src="{{asset('images/rz1.jpg')}}" alt="" />
							</li>
							<li>
								<img src="{{asset('images/rz2.jpg')}}" alt="" />
							</li>
							<li>
								<img src="{{asset('images/rz3.jpg')}}" alt="" />
							</li>
							<li>
								<img src="{{asset('images/rz4.jpg')}}" alt="" />
							</li>
							<li>
								<img src="{{asset('images/rz5.jpg')}}" alt="" />
							</li>
							<li>
								<img src="{{asset('images/rz6.jpg')}}" alt="" />
							</li>
							<li>
								<img src="{{asset('images/rz7.jpg')}}" alt="" />
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="index-content4">
	<img src="img/index4-bj1.jpg" alt="" class="wap-bj"/>
	<img src="img/index4-bj.jpg" alt="" class="pc-bj"/>
	<div class="index4">
		<h3>全球分销网络</h3>
		
		<div class="index4-point">
			<ul>
				<li><img src="{{asset('images/point1.png')}}" alt="" />总公司</li>
				<li><img src="{{asset('images/point.png')}}" alt="" />分公司</li>
				
			</ul>
		</div>
	</div>
</div>				
<div class="index-content5">
	<div class="index5">
		<div class="title">
			<h2>特色新闻</h2>
			<h3>NEWS</h3>
		</div>
		<div class="new-list">
			<ul>
				@foreach($news as $val)
					<li>
						<a href="#">
							<span class="img">
								<img src='{{asset("uploads/$val->img")}}' alt="" />
							</span>
							<span class="font">
								<h1>{{$val->title}}</h1>
								<p>{{$val->description}}</p>
								<h6>{{str_limit($val->created_at,10,'')}}</h6>
							</span>
						</a>
					</li>
				@endforeach
			</ul>
		</div>
	</div>			
</div>
<div class="index-content6">
	<div class="index6">
		<div class="font">
			<em>CAD库</em><span>浏览CAD库查阅或下载图纸和设计</span>
		</div>
		<a href="#">查看详情</a>
	</div>
</div>
@endsection
@section('js')