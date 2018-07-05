<?php

namespace App\Admin\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\Advert;
use App\Models\Type as Category;

class AdvertController extends Controller
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

            $content->header(trans('advert.base_info'));
            $content->description(trans('advert.base_info'));

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

            $content->header(trans('advert.edit'));
            $content->description(trans('advert.edit'));

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

            $content->header(trans('advert.add'));
            $content->description(trans('advert.add'));

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
        return Admin::grid(Advert::class, function (Grid $grid) {
            $grid->filter(function($filter){
                $filter->like('advert', trans('year.base_info'));
            });
            $grid->model()->orderBy('ID', 'desc');
            $grid->id('ID')->sortable();
            $grid->img(trans('aadvert.img'));
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Advert::class, function (Form $form) {
            $form->tab(trans('advert.base_info'), function ($form) {
                $form->display('id', 'ID');
                $form->image('img',trans('year.img'))->move('/image')->removable();
            });
            $form->display('created_at', trans('admin.created_at'));
            $form->display('updated_at', trans('admin.updated_at'));
        });
    }
}
