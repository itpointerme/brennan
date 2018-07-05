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

class TermsController extends Controller
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

            $content->header(trans('clause.name'));
            $content->description(trans('clause.name'));

            $content->body($this->grid());
        });
    }

    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header(trans('clause.add'));
            $content->description(trans('clause.add'));

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
            $grid->model()->orderBy('ID', 'desc');
            $grid->model()->where('id', '!=', 1);
            $grid->model()->where('id', '!=', 6);
            $grid->model()->where('id', '!=', 7);
            $grid->id('ID')->sortable();
            $grid->title(trans('clause.title'));
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
                $form->text('title',trans('clause.title'));
                $form->file('pdf',trans('clause.pdf'))->move('/image')->rules('mimes:pdf');
            });
            $form->display('created_at', trans('admin.created_at'));
            $form->display('updated_at', trans('admin.updated_at'));
        });
    }
}
