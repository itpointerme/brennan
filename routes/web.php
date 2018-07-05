<?php

Auth::routes();

Route::post('selectpass','Auth\LoginController@selectpass')->name('selectpass');
//首页
Route::get('/','IndexController@index');
//关于我们
Route::get('about','AboutController@about')->name('about');
//联系我们
Route::get('contact','ContactController@contact')->name('contact');
//新闻列表
Route::get('news','NewsController@news')->name('news');
//新闻详情
Route::get('news_show/{id}','NewsController@news_show')->name('news_show');
//条款
Route::get('clause','ClauseController@clause')->name('clause');
//条款pdf
Route::get('pdf/{id}','ClauseController@pdf')->name('pdf');
//条款的免责声明和质量政策
Route::get('clause_show/{id}','ClauseController@clause_show')->name('clause_show');
//认证及证书
Route::get('authentication','AuthenticationController@authentication')->name('authentication');
//认证的PDF
Route::get('authentication_pdf/{id}','AuthenticationController@authentication_pdf')->name('authentication_pdf');
//CAD
Route::get('cad','CadController@cad')->name('cad');
//竞品查询
Route::get('competitive','CompetitiveController@competitive')->name('competitive');
//ajax竞品查询
Route::post('ajax_competitive','CompetitiveController@ajax_competitive')->name('ajax_competitive');
//产品列表
Route::get('goodslist/{id}/{page?}/{op?}','ProductsController@index')->name('goodslist');
//产品详情
Route::get('goodsdetail/{id}','ProductsController@detail')->name('gdetail');
//添加到购物车
Route::any('card','ProductsController@card')->name('card');
//上传图片接口
Route::any('uploadimg','HomeController@uploadImg')->name('uploadimg');
//筛选之选择形状
Route::get('shape', 'ProductsController@shape')->name('shape');
//筛选之连接形式
Route::get('connect/{sid}', 'ProductsController@connect')->name('connect');
//筛选之选择材质
Route::get('stuff/{cid}/{sid}/{conid}', 'ProductsController@stuff')->name('stuff');
//查找结果
Route::get('sresult/{sid}/{conid}' ,'ProductsController@selectResult')->name('sresult');
//获取更多商品
Route::get('ajaxGoods', 'ProductsController@ajaxGoods')->name('ajaxgoods');
//搜多商品 公共
Route::any('search', 'ProductsController@searchGoods')->name('search');
//ajax添加产品收藏
Route::post('ajax_add','ProductsController@ajax_add')->name('ajax_add');
Route::post('ajax_del','ProductsController@ajax_del')->name('ajax_del');
//删除询价单
Route::post('askorderdel','ProductsController@askorderdel')->name('askorderdel');
Route::get('getcad/{id}', 'ProductsController@getcad')->name('getcad');
Route::get('is_cart', 'ProductsController@is_cart')->name('is_cart');

/**
* 个人中心 和销售 路由
*/
Route::group(['middleware' => 'auth'] , function(){
		//个人中心
		Route::get('personal', 'PersonalController@index')->name('personal');
		//地址管理
		Route::any('address', 'PersonalController@address')->name('address');
		//个人资料
		Route::any('contacts', 'PersonalController@contacts')->name('contacts');
		//公司信息
		Route::any('company', 'PersonalController@company')->name('company');
		//密码修改
		Route::any('password', 'PersonalController@password')->name('password');
		//采购订单管理 Purchase Orders List
		Route::any('porders', 'PersonalController@porders')->name('porders');
		//采购订单详情 Purchase Orders Detail
		Route::any('pdorders/{oid}', 'PersonalController@pdorders')->name('pdorders');
		//采购订单新增  Purchase Orders add
		Route::any('paorders', 'PersonalController@paorders')->name('paorders');
		//采购订单添加 do
		Route::post('addporder', 'PersonalController@addporder')->name('addporder');
		//询价订单 管理
		Route::any('askorders', 'PersonalController@askorders')->name('askorders');	
		//询价订单 新增 ask orders add
		Route::any('askaorders', 'PersonalController@askaorders')->name('askaorders');
		//询价订单详情 ask orders detail
		Route::any('askdorders/{order_id}', 'PersonalController@askdorders')->name('askdorders');
		//自定义类目
		Route::any('pcategory', 'PersonalController@category')->name('pcategory');
		//经常采购配件
		Route::any('accessories', 'PersonalController@accessories')->name('accessories');	
		//配件收藏夹
		Route::any('collection', 'PersonalController@collection')->name('collection');
		//添加询价单
		Route::get('addcarts', 'PersonalController@addcarts')->name('addcarts');
		Route::post('addaskorder', 'PersonalController@addaskorder')->name('addaskorder');
		//删除询价单
		Route::get('delcart', 'PersonalController@delcart')->name('delcart');
		//ajax删除产品收藏
		Route::post('del_collect','PersonalController@del_collect')->name('del_collect');
		//销售中心首页
		Route::get('sale', 'SaleCenterController@index')->name('sale');
		//销售管理 start
		Route::get('stock', 'SaleCenterController@stock')->name('stock');
		//销售我的资料
		Route::get('saledata', 'SaleCenterController@saleData')->name('saledata');
		//销售我的密码
		Route::get('salepassword', 'SaleCenterController@password')->name('salepassword');
		//销售我的客户
		Route::get('mycustomer', 'SaleCenterController@myCustomer')->name('mycustomer');
		//销售管理询价单
		Route::get('aorders', 'SaleCenterController@askOrders')->name('aorders');
		//销售管理采购单
		Route::get('sorders', 'SaleCenterController@orders')->name('sorders');
		//销售采购订单详情
		Route::get('odetail/{oid}', 'SaleCenterController@orderDetail')->name('odetail');
		//询价订单详情
		Route::any('aodetail/{oid}', 'SaleCenterController@askOrderDetail')->name('aodetail');
		//订单列表页面 暂定
		Route::get('order', 'OrderController@index')->name('order');
		//ajax用户修改个人头像
		Route::any('head','PersonalController@head')->name('head');
		//ajax销售修改个人头像
		Route::any('heads','SaleCenterController@heads')->name('heads');
});

/**
* 注册登陆 忘记密码
*/
Route::group(['namespace' => 'Auth'], function(){
    Route::post('registertolist', 'RegisterController@register');
    Route::get('forgetPwd', 'LoginController@forgetPwd')->name('forgetPwd');
});

Route::post('importExport',"ExcelController@importExport")->name('importExport');