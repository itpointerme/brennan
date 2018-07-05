<?php

namespace App\Admin\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\Contact;
use App\Models\Type as Category;

class ContactController extends Controller
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

            $content->header(trans('contact.title'));
            $content->description(trans('contact.title'));

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
        return Admin::grid(Contact::class, function (Grid $grid) {
            $grid->filter(function($filter){
                $filter->like('title', trans('contact.title'));
            });
            $grid->model()->orderBy('ID', 'desc');
            $grid->id('ID')->sortable();
            $grid->name(trans('contact.name'));
            $grid->x_name(trans('contact.x_name'));
            $grid->tel(trans('contact.tel'));
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Contact::class, function (Form $form) {
            $form->tab(trans('contact.base_info'), function ($form) {
                $form->display('id', 'ID');
                $form->text('post',trans('contact.post'));
                $form->text('name',trans('contact.name'));
                $form->text('x_name',trans('contact.x_name'));
                $form->text('tel',trans('contact.tel'));
            });
        });
    }
}
