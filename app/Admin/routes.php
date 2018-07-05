<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    //首页banner
        $router->resource('banner/index', BannerController::class);
    //首页广告位
        $router->resource('advert/index', AdvertController::class);

    //新闻
        $router->resource('news/index', NewsController::class);    

    //基本信息
        //关于我们
        $router->resource('about/index', AboutController::class); 
        //年份记录
        $router->resource('year/index', YearController::class);
        //职位名称
        $router->resource('contact/index', ContactController::class);
        //公司地点
        $router->resource('distribution/index', DistributionController::class);

    //用户管理    
        //用户列表
        $router->resource('users/index', UsersController::class);
        //用户地址
        $router->resource('address/index', AddressController::class);
    //条款内容
        $router->resource('clause/index', ClauseController::class); 
    //条款文件
        $router->resource('terms/index', TermsController::class);
    //免责声明
        $router->resource('disclaimer/index', DisclaimerController::class);
    //文献与认证
        $router->resource('authentication/index', AuthenticationController::class);
    //文献与认证的PDF列表
        $router->resource('authenticationpdf/index', AuthenticationpdfController::class);

    //商品管理
        //商品列表
        $router->resource('goods/goodslist', GoodsListController::class);
        //商品分类
        $router->resource('goods/type', TypeController::class);

    //订单管理
        //询价订单
        $router->resource('order/ask_order', AskOrderController::class);
        //采购订单
        $router->resource('order/purchase', PurchaseOrderController::class);
    //库存查询
        $router->resource('stock', StockController::class);
});
