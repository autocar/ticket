<?php


class Title extends Eloquent  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'titles';

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
     * 客服
     *
     * @return mixed
     */
    public function member()
    {
        return $this->belongsTo('Member');
    }

    /**
     * 回复
     *
     * @return mixed
     */
    public function projects()
    {
        return $this->hasMany('Project');
    }

}
