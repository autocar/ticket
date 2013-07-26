<?php namespace Controllers\Admin;

use Auth;
use View;
use Job;
use Redirect;
use Project;
use Validator;
use Input;
use DateTime;
use Operator;
use URL;
use Mail;


class TicketController extends AdminController {

    /**
     * Show the administration dashboard page.
     *
     * @return View
     */
    public function getIndex()
    {
        // 客服
        if (Auth::user()->lv == 0)
        {
            $o       = Operator::find(Auth::user()->id);
            $cgroups = $o->cgroups()->lists('cgroup_id', 'cgroup_id');
            $jobs = Job::whereIn('cgroup_id', $cgroups)->orderBy('id', 'desc')->paginate();
        }
        else
        {
            $jobs = Job::query()->orderBy('id', 'desc')->paginate();
        }

        // Show the page.
        //
        return View::make('admin/ticket/index', compact('jobs'));
    }

    /**
     *
     * @param null $job_id
     *
     * @return mixed
     */
    public function getView($job_id = NULL)
    {
        if (is_null($job = Job::find($job_id)))
        {
            return Redirect::to('admin/ticket')->with('error', '工单不存在');
        }

        return View::make('admin/ticket/view', compact('job'));
    }

    /**
     * postView
     *
     * @param null $job_id
     *
     * @return mixed
     */
    public function postView($job_id = NULL)
    {
        if (is_null($job = Job::find($job_id)))
        {
            return Redirect::to('admin/ticket')->with('error', '工单不存在');
        }

        $rules = array(
            'content' => 'required|min:10',
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails())
        {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $project = new Project;

        $project->job_id      = e(Input::get('job_id'));
        $project->content     = e(Input::get('content'));
        $project->operator_id = Auth::user()->id;
        $project->type        = '1';
        $project->reply_time  = new DateTime;

        if ($project->save())
        {
            $job = Job::find($project->job_id);

            $job->status = '1';

            if ($job->save())
            {
                // 邮件数据
                $d = array(
                    'url'   => URL::to('ticket/view/' . $job->id) . '#c_' . $project->id,
                    'reply' => $project->content,
                );

                $u = array(
                    'email' => $job->member->email,
                    'name'  => $job->member->name,
                    'title' => $job->title,
                );

                // 发送邮件
//                Mail::send('emails.ticket.reply', $d, function ($m) use ($u)
//                {
//                    $m->to($u['email'], $u['name']);
//                    $m->subject('回复工单：' . $u['title']);
//                });

                return Redirect::to("admin/ticket/{$job_id}/view")->with('success', '工单回复成功');
            }
        }

        return Redirect::to("admin/ticket/{$job_id}/view")->with('error', '工单回复失败');
    }

    /**
     * getAssign
     *
     * @param null $job_id
     *
     * @return mixed
     */
    public function getAssign($job_id = NULL)
    {
        if (is_null($job = Job::find($job_id)))
        {
            return Redirect::to('admin/ticket')->with('error', '工单不存在');
        }

        $operators = Operator::where('lv', '0')->get();

        return View::make('admin/ticket/assign', compact('job', 'operators'));

    }

    /**
     * postAssign
     *
     * @param null $job_id
     *
     * @return mixed
     */
    public function postAssign($job_id = NULL)
    {
        if (is_null($job = Job::find($job_id)))
        {
            return Redirect::to('admin/ticket')->with('error', '工单不存在');
        }

        $job = Job::find($job_id);

        $job->operator_id = Input::get('operator_id');

        if ($job->save())
        {
            return Redirect::to("admin/ticket/{$job_id}/assign")->with('success', '工单客服分配成功');
        }

        return Redirect::to("admin/ticket/{$job_id}/assign")->with('error', '工单客服分配失败');
    }

    /**
     * getApply
     *
     * @param null $job_id
     *
     * @return mixed
     */
    public function getApply($job_id = NULL)
    {
        if (is_null($job = Job::find($job_id)))
        {
            return Redirect::to('admin/ticket')->with('error', '工单不存在');
        }

        $job->where('id', $job_id)->update(array(
                                                'operator_id'   => Auth::user()->id,
                                           ));

        return Redirect::to('admin/ticket/'.$job_id.'/view')->with('success', '工单申请成功');
    }

    /**
     *
     * getClose
     *
     * @param $job_id
     *
     * @return mixed
     */
    public function getClose($job_id = NULL)
    {
        if (is_null($job = Job::find($job_id)))
        {
            return Redirect::to('admin/ticket')->with('error', '工单不存在');
        }

        $job->where('id', $job_id)->update(array(
                                                'status'   => 2
                                           ));

        return Redirect::to('admin/ticket')->with('success', '工单关闭成功');
    }


}