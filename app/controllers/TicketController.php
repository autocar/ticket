<?php

class TicketController extends AuthorizedController {

    public function getIndex()
    {
        $jobs = Job::where('member_id', '=', Auth::user()->id)->orderBy('id', 'desc')->paginate();

        // Show the page.
        //
        return View::make('ticket/index', compact('jobs'));
    }

    /**
     * getCreate
     *
     * @return mixed
     */
    public function getCreate()
    {
        $troubles = Trouble::all();

        // Show the page.
        //
        return View::make('ticket/create')->with('troubles', $troubles);
    }

    /**
     * postCreate
     *
     * @return mixed
     */
    public function postCreate()
    {
        $rules = array(
            'title'      => 'required|min:4',
            'trouble_id' => 'required',
            'content'    => 'required|min:10',
            //'product'    => 'Required',
            'file'       => 'image',
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails())
        {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $job = new Job;

        // 判断是否存在相同工单
        $j = $job->where('member_id', '=', Auth::user()->id)->where('title', '=', e(Input::get('title')))->first();

        if (isset($j->id))
        {
            return Redirect::to("ticket/view/" . $j->id)->with('error', '存在相同工单！');
        }

        $job->member_id   = Auth::user()->id;
        $job->cgroup_id   = Auth::user()->cgroup_id;
        $job->trouble_id  = e(Input::get('trouble_id'));
        $job->level       = e(Input::get('level'));
        $job->status      = '0';
        $job->title       = e(Input::get('title'));
        $job->content     = e(Input::get('content'));
        $job->start_time  = new DateTime;

        // 工单附件
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
                    $image = new Image();
                    $image->url = $destinationPath . '/' . $filename;
                    $image->create_time = new DateTime();

                    if($image->save()){
                        $job->image_id = $image->id;
                    }

                }
                else
                {
                    return Redirect::back()->with('error', '上传图片失败！');
                }
            }
        }

        if ($job->save())
        {

            if (is_array(Input::get('product')))
            {
                $jp = new JP;

                $jp_array = array();

                foreach (Input::get('product') as $key => $val)
                {
                    $jp_array[$key]['job_id']     = $job->id;
                    $jp_array[$key]['product_id'] = $val;
                }

                $jp->insert($jp_array);
            }

            return Redirect::to("ticket")->with('success', '工单提交成功');

        }

        return Redirect::to('ticket/create')->with('error', '工单提交失败');
    }

    /**
     * getView
     *
     * @param null $job_id
     *
     * @return mixed
     */
    public function getView($job_id = NULL)
    {
        if (is_null($job = Job::where('member_id', '=', Auth::user()->id)->find($job_id)))
        {
            return Redirect::to('ticket')->with('error', '工单不存在');
        }

        return View::make('ticket/view', compact('job'));
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
        if (is_null($job = Job::where('member_id', '=', Auth::user()->id)->find($job_id)))
        {
            return Redirect::to('ticket')->with('error', '工单不存在');
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

        $project->member_id  = Auth::user()->id;
        $project->job_id     = e(Input::get('job_id'));
        $project->content    = e(Input::get('content'));
        $project->type       = '0';
        $project->reply_time = new DateTime;

        if ($project->save())
        {
            $job = Job::find($project->job_id);

            $job->status = '0';

            if ($job->save())
            {
                return Redirect::to("ticket/view/" . $project->job_id)->with('success', '回复成功');
            }
        }

        return Redirect::to('ticket/view/' . $project->job_id)->with('error', '回复失败');
    }

    /**
     * getAppend
     *
     * @param null $job_id
     *
     * @return mixed
     */
    public function getAppend($job_id = NULL)
    {
        if (is_null($job = Job::where('member_id', '=', Auth::user()->id)->find($job_id)))
        {
            return Redirect::to('ticket')->with('error', '工单不存在');
        }

        return View::make('ticket/append', compact('job'));
    }

    /**
     * postAppend
     *
     * @param null $job_id
     *
     * @return mixed
     */
    public function postAppend($job_id = NULL)
    {
        if (is_null($job = Job::where('member_id', '=', Auth::user()->id)->find($job_id)))
        {
            return Redirect::to('ticket')->with('error', '工单不存在');
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

        $project->member_id  = Auth::user()->id;
        $project->job_id     = e(Input::get('job_id'));
        $project->content    = e(Input::get('content'));
        $project->type       = '0';
        $project->append     = '1';
        $project->reply_time = new DateTime;

        if ($project->save())
        {
            $job = Job::find($project->job_id);

            $job->status = '0';

            if ($job->save())
            {
                return Redirect::to("ticket/view/" . $project->job_id)->with('success', '工单追加成功');
            }
        }

        return Redirect::to('ticket/view/' . $project->job_id)->with('error', '工单追加失败');
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
        if (is_null($job = Job::where('member_id', '=', Auth::user()->id)->find($job_id)))
        {
            return Redirect::to('ticket')->with('error', '工单不存在');
        }

        $job->where('id', $job_id)->update(array(
                                                'status'   => 2,
                                                'end_time' => new Datetime
                                           ));

        return Redirect::to('ticket')->with('success', '工单关闭成功');
    }

    /**
     * getInvalid
     *
     * @param $job_id
     *
     * @return mixed
     */
    public function getInvalid($job_id = NULL)
    {
        if (is_null($job = Job::where('member_id', '=', Auth::user()->id)->find($job_id)))
        {
            return Redirect::to('ticket')->with('error', '工单不存在');
        }

        $job->where('id', $job_id)->update(array(
                                                'status'   => 3,
                                                'end_time' => new Datetime
                                           ));

        return Redirect::to('ticket')->with('success', '工单作废成功');
    }

}