<?php

namespace App\Admin\Controllers;

use App\Model\EmergencyAmbulance;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Carbon\Carbon;

class EmergencyController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        $content->title('急救车出诊记录');
//        $content->description('页面描述小标题');
        $grid = $this->grid();
        // 筛选
        $grid->filter(function($filter){
            $filter->scope('trashed', '回收站')->onlyTrashed();
            $filter->disableIdFilter();

            // 在这里添加字段过滤器
//            $filter->month('visit_time', '月份');
            $filter->between('visit_time', '出车时间')->datetime([
//                'defaultDate' => Carbon::now()->startOfMonth(),
                'maxDate' => date('Y-m-d 23:59:59')
            ], true);
            $filter->like('driver', '出车司机');
            $filter->like('patient_name', '患者名字');
            $filter->equal('patient_gender', '患者性别')->radio([
                '' => '全部',
                1 => '男',
                2 => '女',
            ]);

            $filter->like('visit_address', '出车地址');
        });

        $grid->disableRowSelector();

        $content->row($grid);

        return $content;
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header(trans('admin.detail'))
            ->description(trans('admin.description'))
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header(trans('admin.edit'))
            ->description(trans('admin.description'))
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        $create_body = $this->form();
        return $content
            ->header(trans('admin.create'))
            ->description(trans('admin.description'))
            ->body($create_body);
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new EmergencyAmbulance);
        $grid->model()->orderBy('visit_time','desc');

        $grid->id('ID')->sortable();
        $grid->visit_time('出车时间')->sortable();
        $grid->patient_name('患者姓名')->sortable();
/*        $grid->column('patient_name', '患者姓名')->modal('出诊信息', function ($model) {
            $em = new EmergencyController();
            $detail = $em->detail($model->id);
            $detail->disableDelete();
            return $detail;
        });*/
        $grid->patient_gender('患者性别')->using([1 => '男', 2 => '女']);
        $grid->patient_age('患者年龄')->sortable();
        $grid->visit_address('出车地址')->sortable();
//        $grid->visit_cause('出车事由');
        $grid->driver('出车司机');
//        $grid->doctor('跟车医生');
//        $grid->nurse('跟车护士');
//        $grid->remark('备注');
        $grid->created_at(trans('admin.created_at'))->sortable();
        $grid->updated_at(trans('admin.updated_at'))->sortable();

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(EmergencyAmbulance::findOrFail($id));

        $show->id('ID');
        $show->visit_time('出车时间');
        $show->patient_name('患者姓名');
        $show->patient_gender('患者性别')->using([1 => '男', 2 => '女']);
        $show->patient_age('患者年龄');
        $show->visit_address('出车地址');
        $show->visit_cause('出车事由');
        $show->driver('出车司机');
        $show->doctor('跟车医生');
        $show->nurse('跟车护士');
        $show->remark('备注');
        $show->created_at(trans('admin.created_at'));
        $show->updated_at(trans('admin.updated_at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new EmergencyAmbulance);
        $form->setWidth(4, 2);
        $form->datetime('visit_time', '出车时间')->options(['maxDate' => date('Y-m-d 23:59:59')])->required();
        $form->text('patient_name', '患者姓名')->required();
        $form->radio('patient_gender', '患者性别')->options([1 => '男', 2 => '女'])->rules('min:1|max:2')->required();
        $form->text('patient_age', '患者年龄')->rules('required|min:1|max:120');
        $form->distpicker([
            'province_id' => '省份',
            'city_id' => '市',
            'district_id' => '区'
        ], '地域选择')->default([
            'province' => 410000,
            'city'     => 410200,
            'district' => 410223,
        ]);
        $form->text('visit_address', '出车地址')->required();
        $form->text('visit_cause', '出车事由')->required();
        $form->text('driver', '出车司机')->required();
        $form->text('doctor', '跟车医生')->required();
        $form->text('nurse', '跟车护士');
        $form->textarea('remark', '备注')->placeholder('备注 可不填');
        $form->confirm('确定更新吗？', 'edit');

        $form->hidden('create_user_id');

        $form->saving(function (Form $form) {
            $form->create_user_id = Admin::user()->id;
        });
        return $form;
    }
}
