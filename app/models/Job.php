<?php


class Job extends Eloquent  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'jobs';

    public $timestamps = false;

    /**
     * 问题类型
     *
     * @return mixed
     */
    public function trouble()
    {
        return $this->belongsTo('Trouble');
    }

    /**
     * 标题
     *
     * @return mixed
     */
    public function title()
    {
        return $this->hasOne('Title');
    }

    /**
     *
     *
     * @return mixed
     */
    public function titles()
    {
        return $this->hasMany('Title');
    }

    /**
     * 回复累容
     *
     * @return mixed
     */
    public function projects()
    {
        return $this->hasMany('Project');
    }

}
