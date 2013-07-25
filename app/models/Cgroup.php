<?php


class Cgroup extends Eloquent  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'cgroups';

    public $timestamps = false;

    // 客服
    public function operators()
    {
        return $this->belongsToMany('Operator', 'operator_cgroup');
    }


}
