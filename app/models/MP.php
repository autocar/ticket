<?php


class MP extends Eloquent  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'member_product';

    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo('Product');
    }

}
