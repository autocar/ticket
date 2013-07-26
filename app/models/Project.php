<?php


class Project extends Eloquent  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'projects';

    public $timestamps = false;

    /**
     * 工单
     *
     * @return mixed
     */
    public function job()
    {
        return $this->belongsTo('Job');
    }

    /**
     * 客户
     *
     * @return mixed
     */
    public function member()
    {
        return $this->belongsTo('Member');
    }

    /**
     * 客服
     *
     * @return mixed
     */
    public function operator()
    {
        return $this->belongsTo('Operator');
    }

    /**
     * 图片
     *
     * @return mixed
     */
    public function image()
    {
        return $this->belongsTo('Image');
    }



}
