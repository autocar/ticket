<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Member extends Eloquent implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'members';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

    /**
     * @var bool
     */
    protected $softDelete = true;

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
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
     * 产品
     *
     * @return mixed
     */
    public function products()
    {
        return $this->belongsToMany('Product', 'member_product');
    }

    /**
     * 头像
     *
     * @return mixed
     */
    public function image()
    {
        return $this->belongsTo('Image');
    }


}
