<?php


class Product extends Eloquent  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'products';

    public $timestamps = false;

    /**
     * 用户
     *
     * @return mixed
     */
    public function members()
    {
        return $this->hasMany('MP');
    }

}
