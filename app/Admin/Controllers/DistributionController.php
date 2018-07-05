<?php

namespace App\Admin\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\Distribution;
use App\Models\Type as Category;

class DistributionController extends Controller
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

            $content->header(trans('distribution.title'));
            $content->description(trans('distribution.title'));

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

            $content->header(trans('distribution.edit'));
            $content->description(trans('distribution.edit'));

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

            $content->header(trans('distribution.add'));
            $content->description(trans('distribution.add'));

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
        return Admin::grid(Distribution::class, function (Grid $grid) {
            $grid->filter(function($filter){
                $filter->like('title', trans('distribution.title'));
            });
            $grid->model()->orderBy('ID', 'desc');
            $grid->id('ID')->sortable();
            $grid->fen(trans('distribution.fen'));
            $grid->title(trans('distribution.title'));
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Distribution::class, function (Form $form) {
            $form->tab(trans('distribution.base_info'), function ($form) {
                $form->display('id', 'ID');
                $form->select('fen',trans('distribution.fen'))->options(['公司总部' => '公司总部', '美国' => '美国', '加拿大' => '加拿大','国际'=>'国际','制造'=>'制造']);
                $form->text('title',trans('distribution.title'));
            });
        });
    }
}
