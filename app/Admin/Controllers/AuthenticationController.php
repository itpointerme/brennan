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

class AuthenticationController extends Controller
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

            $content->header(trans('authen.base_info'));
            $content->description(trans('authen.base_info'));

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
            $grid->model()->where('id', '=', 1);
            $grid->model()->orderBy('ID', 'desc');
            $grid->id('ID')->sortable();
            $grid->text(trans('authen.text'))->limit(100);;
            $grid->actions(function ($actions) {
                $actions->disableDelete();
            });
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
            $form->tab(trans('authen.base_info'), function ($form) {
                $form->display('id', 'ID');
                $form->textarea('text',trans('authen.text'));
            });
            $form->display('created_at', trans('admin.created_at'));
            $form->display('updated_at', trans('admin.updated_at'));
        });
    }
}
