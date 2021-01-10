<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Model\His\V_MRQC_SSBRModel;

class SurgicalPatientListController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '患者手术';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new V_MRQC_SSBRModel);

        $grid->disableCreateButton();
        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableEdit();
        });

        $YGBH = config('his.YGBH');
        $KSDM = config('his.KSDM');
        $MZFS = config('his.MZFS');

        $grid->filter(function($filter){
            $filter->disableIdFilter();
            $filter->like('BRXM', '手术病人姓名');
            $filter->equal('BRXB', '病人性别')->radio([
                '' => '全部',
                1 => '男',
                2 => '女',
            ]);
            $filter->equal('BRKS', '病人科室')->select(config('his.KSDM'));
            $filter->equal('SSYS', '手术医生')->select(config('his.YGBH'));
            $filter->equal('MZDM', '麻醉方式')->select(config('his.MZFS'));
        });

        $grid->column('SSBH', __('手术编号'))->sortable();
        $grid->column('ZYH', __('住院号'))->sortable();
        $grid->column('ZYHM', __('住院号码'))->sortable();
        $grid->column('BRKS', __('科室'))->using($KSDM)->sortable();
        $grid->column('BRXM', __('姓名'));
        $grid->column('BRXB', __('性别'))->using(['1' => '男', '2' => '女']);
        $grid->column('BRNL', __('年龄'));
        $grid->column('APRQ', __('手术安排日期'))->sortable();
        $grid->column('SSRQ', __('手术日期'))->sortable();
        $grid->column('SSYS', __('手术医生'))->using($YGBH);
        $grid->column('MZYS', __('麻醉医生'))->using($YGBH);
        $grid->column('MZDM', __('麻醉方式'))->using($MZFS);
        $grid->column('SSMC', __('手术名称'))->sortable();

        $grid->model()->orderBy('SSBH', 'desc');
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed   $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(V_MRQC_SSBRModel::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new V_MRQC_SSBRModel);

        $form->display('id', __('ID'));
        $form->display('created_at', __('Created At'));
        $form->display('updated_at', __('Updated At'));

        return $form;
    }
}
