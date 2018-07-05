<?php

namespace App\Admin\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\Authentication;
use App\Models\Type as Category;

class AuthenticationpdfController extends Controller
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

            $content->header(trans('authen.name2'));
            $content->description(trans('authen.name2'));

            $content->body($this->grid());
        });
    }

    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header(trans('authen.add'));
            $content->description(trans('authen.add'));

            $content->body($this->form());
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

            $content->header(trans('authen.edit'));
            $content->description(trans('authen.edit'));

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Authentication::class, function (Grid $grid) {
            $grid->filter(function($filter){
                $filter->like('title', trans('authen.title'));
            });
            $grid->model()->where('id', '!=', 1);
            $grid->model()->orderBy('ID', 'desc');
            $grid->id('ID')->sortable();
            $grid->fen(trans('authen.fen'));
            $grid->title(trans('authen.title'))->limit(100);
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Authentication::class, function (Form $form) {
            $form->tab(trans('authen.name2'), function ($form) {
                $form->display('id', 'ID');
                $form->select('fen',trans('authen.fen'))->options(['白皮书'=>'白皮书','认证'=>'认证','目录和传单'=>'目录和传单','广告'=>'广告'])->default('白皮书');
                $form->text('title',trans('authen.title'));
                $form->file('pdf',trans('authen.pdf'))->move('/image')->rules('mimes:pdf');
            });
            $form->display('created_at', trans('admin.created_at'));
            $form->display('updated_at', trans('admin.updated_at'));
        });
    }
}
