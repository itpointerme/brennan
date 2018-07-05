<?php

namespace App\Admin\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\Clause;
use App\Models\Type as Category;

class ClauseController extends Controller
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

            $content->header(trans('clause.base_info'));
            $content->description(trans('clause.base_info'));

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

            $content->header(trans('clause.edit'));
            $content->description(trans('clause.edit'));

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
        return Admin::grid(Clause::class, function (Grid $grid) {
            $grid->filter(function($filter){
                $filter->like('title', trans('clause.title'));
            });
            $grid->model()->where('id', '=', 1);
            $grid->model()->orderBy('ID', 'desc');
            $grid->id('ID')->sortable();
            $grid->text(trans('clause.text'))->limit(100);;
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
        return Admin::form(Clause::class, function (Form $form) {
            $form->tab(trans('clause.base_info'), function ($form) {
                $form->display('id', 'ID');
                $form->textarea('text',trans('clause.text'));
            });
            $form->display('created_at', trans('admin.created_at'));
            $form->display('updated_at', trans('admin.updated_at'));
        });
    }
}
