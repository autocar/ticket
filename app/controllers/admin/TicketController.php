<?php namespace Controllers\Admin;

use Auth;
use View;
use Job;
use Member;
use Redirect;
use Project;
use Validator;
use Input;
use DateTime;
use Operator;
use URL;
use Mail;
use Image;


class TicketController extends AdminController {

    /**
     * Show the administration dashboard page.
     *
     * @return View
     */
    public function getIndex()
    {
        $allowed = array(
            'id',
            'level',
            'title',
            'status',
            'start_time'
        );
        $sort    = in_array(Input::get('sort'), $allowed) ? Input::get('sort') : 'id';
        $order   = Input::get('order') === 'asc' ? 'asc' : 'desc';

        // 客服
        if (Auth::user()->lv == 0)
        {
            $o       = Operator::find(Auth::user()->id);
            $cgroups = $o->cgroups()->lists('cgroup_id', 'cgroup_id');

            if (Input::get('order'))
            {
                $jobs = Job::whereIn('cgroup_id', $cgroups)->orderBy($sort, $order)->paginate();
            }
            else
            {
                $jobs = Job::whereIn('cgroup_id', $cgroups)->orderBy('status', 'asc')->orderBy('invalid', 'asc')->orderBy('level', 'desc')->orderBy('id', 'desc')->paginate();
            }
        }
        else
        {
            if (Input::get('order'))
            {
                $jobs = Job::query()->orderBy('status', 'asc')->orderBy($sort, $order)->paginate();
            }
            else
            {
                $jobs = Job::query()->orderBy('status', 'asc')->orderBy('invalid', 'asc')->orderBy('level', 'desc')->orderBy('id', 'desc')->paginate();
            }
        }

        $querystr = '&order=' . (Input::get('order') == 'asc' || NULL ? 'desc' : 'asc');

        // Show the page.
        //
        return View::make('admin/ticket/index', compact('jobs', 'querystr'));
    }

    /**
     * getMember
     *
     * @param null $member_id
     */
    public function getMember($member_id = NULL)
    {

        if (is_null($member = Member::find($member_id)))
        {
            return Redirect::to('admin/member')->with('error', '客户不存在');
        }

        $allowed = array(
            'id',
            'level',
            'title',
            'status',
            'start_time'
        );

        $sort     = in_array(Input::get('sort'), $allowed) ? Input::get('sort') : 'id';
        $order    = Input::get('order') === 'asc' ? 'asc' : 'desc';
        $jobs     = Job::where('member_id', '=', $member_id)->orderBy($sort, $order)->paginate();
        $querystr = '&order=' . (Input::get('order') == 'asc' || NULL ? 'desc' : 'asc');

        return View::make('admin/ticket/index', compact('jobs', 'querystr', 'member'));
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
            'file'    => 'image',
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

        // 图片附件
        $file = Input::file('file');

        if (!empty($file))
        {
            if ($file->getSize() > (1024 * 1024))
            {
                return Redirect::back()->with('error', '上传图片过大，请控制在1M以内！');
            }
            else
            {
                $destinationPath = 'uploads/' . date('Y/m/d');
                $extension       = $file->getClientOriginalExtension();
                $filename        = str_random(8) . '.' . $extension;
                $upload_success  = $file->move($destinationPath, $filename);

                if ($upload_success)
                {
                    $image              = new Image();
                    $image->url         = $destinationPath . '/' . $filename;
                    $image->create_time = new DateTime();

                    if ($image->save())
                    {
                        $project->image_id = $image->id;
                    }

                }
                else
                {
                    return Redirect::back()->with('error', '上传图片失败！');
                }
            }
        }

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
                                                'operator_id' => Auth::user()->id,
                                           ));

        return Redirect::to('admin/ticket/' . $job_id . '/view')->with('success', '工单申请成功');
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
                                                'status' => 2
                                           ));

        return Redirect::to('admin/ticket')->with('success', '工单关闭成功');
    }


}