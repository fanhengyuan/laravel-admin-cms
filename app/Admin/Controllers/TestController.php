<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use App\Model;
use Encore\Admin\Show;

class TestController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Test controller';

    public function index(Content $content) {
        // 选填
        $content->header('高大上的CURD');

        // 选填
        $content->description('页面描述小标题');

        // 数据
        $grid = new Grid(new Model\TestModel);
        $grid->column('id', __('ID'))->sortable();
        $grid->column('name', __('测试名字'))->sortable();
        $grid->column('created_at', __('创建时间'))->sortable();
        $grid->column('updated_at', __('修改时间'))->sortable();

        // 筛选
        $grid->filter(function($filter){
            // 在这里添加字段过滤器
            $filter->like('name', '测试名字');
        });

        $grid->disableRowSelector();

        $content->row($grid);

        return $content;
    }

    protected function detail($id)
    {
        $show = new Show(Model\TestModel::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('name', __('测试名字'));
        $show->field('content', __('富文本内容'))->unescape();
        $show->field('created_at', __('创建时间'));
        $show->field('updated_at', __('修改时间'));

        return $show;
    }

    protected function form()
    {
        $form = new Form(new Model\TestModel);

        $form->display('id', __('ID'));
        $form->text('name', __('测试名字'))
            ->rules('required|min:1')
            ->creationRules(['required', "unique:test"])
            ->updateRules(['required', "unique:test,name,{{id}}"]);

        $form->ckeditor('content', __('富文本内容'))->rules('nullable');
        $form->display('created_at', __('创建时间'));

        return $form;
    }
}
