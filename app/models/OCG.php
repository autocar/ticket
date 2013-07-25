<?php


class OCG extends Eloquent  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'operator_cgroup';

    public $timestamps = false;

    public function cgroup()
    {
        return $this->belongsTo('Cgroup');
    }

    public function operator()
    {
        return $this->belongsTo('Operator');
    }

}
