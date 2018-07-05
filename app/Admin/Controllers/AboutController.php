<?php

namespace App\Admin\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\About;
use App\Models\Type as Category;

class AboutController extends Controller
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

            $content->header(trans('about.name'));
            $content->description(trans('about.name'));

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

            $content->header(trans('about.edit'));
            $content->description(trans('about.edit'));

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

            $content->header(trans('goods.add'));
            $content->description(trans('goods.add'));

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
        return Admin::grid(About::class, function (Grid $grid) {
            $grid->filter(function($filter){
                $filter->like('title', trans('about.title'));
            });
            $grid->model()->orderBy('ID', 'desc');
            $grid->id(trans('about.id'))->sortable();
            $grid->title(trans('about.title'));
            $grid->addr(trans('about.addr'));
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
        return Admin::form(About::class, function (Form $form) {
            $form->tab(trans('about.base_info'), function ($form) {
                $form->display('id', 'ID');
                $form->text('title',trans('about.title'));
                $form->text('addr',trans('about.addr'));
                $form->text('content',trans('about.content'));
            })->tab(trans('about.fuwu'), function (Form $form) {
                $form->image('img1',trans('img1'))->move('/image')->removable();
                $form->text('title1',trans('title1'));
                $form->text('text1',trans('text1'));
                $form->image('img2',trans('img2'))->move('/image')->removable();
                $form->text('title2',trans('title2'));
                $form->text('text2',trans('text2'));
                $form->image('img3',trans('img3'))->move('/image')->removable();
                $form->text('title3',trans('title3'));
                $form->text('text3',trans('text3'));
                $form->image('img4',trans('img4'))->move('/image')->removable();
                $form->text('title4',trans('title4'));
                $form->text('text4',trans('text4'));
            });
            $form->display('created_at', trans('admin.created_at'));
            $form->display('updated_at', trans('admin.updated_at'));
        });
    }
}
