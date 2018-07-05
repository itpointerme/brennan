<?php

namespace App\Admin\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\Banner;
use App\Models\Type as Category;

class BannerController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header(trans('banner.name'));
            $content->description(trans('banner.name'));

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header(trans('banner.edit'));
            $content->description(trans('banner.edit'));

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header(trans('banner.add'));
            $content->description(trans('banner.add'));

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Banner::class, function (Grid $grid) {
            $grid->filter(function($filter){
                $filter->like('banner', trans('banner.name'));
            });
            $grid->model()->orderBy('ID', 'desc');
            $grid->id('ID')->sortable();
            $grid->text1(trans('banner.text1'));
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Banner::class, function (Form $form) {
            $form->tab(trans('banner.base_info'), function ($form) {
                $form->display('id', 'ID');
                $form->image('img1',trans('banner.img1'))->move('/image')->removable();
                $form->image('img2',trans('banner.img2'))->move('/image')->removable();
                $form->text('text1',trans('banner.text1'));
                $form->text('text2',trans('banner.text2'));
                $form->text('addr',trans('banner.addr'));
            });
            $form->display('created_at', trans('admin.created_at'));
            $form->display('updated_at', trans('admin.updated_at'));
        });
    }
}
