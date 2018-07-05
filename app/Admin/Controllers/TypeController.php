<?php

namespace App\Admin\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\TermTaxonomy;
use App\Models\Terms;
use App\Models\Type as Category;

class TypeController extends Controller
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

            $content->header(trans('type.name'));
            $content->description(trans('type.name'));

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

            $content->header(trans('type.edit'));
            $content->description(trans('type.edit'));

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

            $content->header(trans('type.add'));
            $content->description(trans('type.add'));

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
         return Admin::grid(Terms::class, function (Grid $grid) {
            $grid->filter(function($filter){
                $filter->like('name', '分类名称');
            });

            $grid->model()->leftJoin('wp_term_taxonomy', 'wp_term_taxonomy.term_id', '=', 'wp_terms.term_id')->where('wp_term_taxonomy.taxonomy', 'product_cat');
            $grid->model()->orderBy('wp_term_taxonomy.term_id', 'desc');
            $grid->term_id(trans('type.id'))->sortable();
            $grid->column('name', '分类名称');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Terms::class, function (Form $form) {
                $form->display('term_id', trans('news.id'));
                $form->text('name', '分类名称')->rules('required');
                $form->select('gettermtaxonomy.taxonomy', '选择分类')->options(['product_cat'=>'product_cat']);
        });
    }
}
