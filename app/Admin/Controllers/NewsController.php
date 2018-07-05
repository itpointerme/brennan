<?php

namespace App\Admin\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\News;
use App\Models\Type as Category;

class NewsController extends Controller
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

            $content->header(trans('news.name'));
            $content->description(trans('news.name'));

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

            $content->header(trans('news.edit'));
            $content->description(trans('news.edit'));

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

            $content->header(trans('news.add'));
            $content->description(trans('news.add'));

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
        return Admin::grid(News::class, function (Grid $grid) {
            $grid->filter(function($filter){
                $filter->like('title', trans('news.title'));
            });
            $grid->model()->orderBy('ID', 'desc');
            $grid->id(trans('news.id'))->sortable();
            $grid->img()->image('',50,50);
            $grid->title(trans('news.title'));
            $grid->created_at(trans('admin.created_at'));
            $grid->updated_at()->sortable(trans('admin.updated_at'));
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(News::class, function (Form $form) {
            $form->tab(trans('news.base_info'), function ($form) {
                $form->display('id', trans('news.id'));
                $form->text('title',trans('news.title'));
                $form->textarea('description',trans('description'));
                $form->image('img',trans('news.cover'))->move('/image')->removable();
                $form->editor('text',trans('news.text'));
            });
        });
    }
}
