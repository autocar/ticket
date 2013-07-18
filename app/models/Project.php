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
     * 标题
     *
     * @return mixed
     */
    public function title()
    {
        return $this->belongsTo('Title');
    }

}
