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
     * 回复内容
     *
     * @return mixed
     */
    public function projects()
    {
        return $this->hasMany('Project');
    }

    /**
     * 图片
     *
     * @return mixed
     */
    public function images()
    {
        return $this->belongsToMany('Image', 'job_image');
    }

    /**
     * 产品
     *
     * @return mixed
     */
    public function products()
    {
        return $this->belongsToMany('Product', 'job_product');
    }



}
