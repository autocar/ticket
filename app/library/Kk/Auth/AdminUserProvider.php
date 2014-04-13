<?php namespace Kk\Auth;

use Illuminate\Auth\UserInterface;
//use Illuminate\Auth\GenericUser;
//use Illuminate\Support\Facades\Hash;


class AdminUserProvider implements \Illuminate\Auth\UserProviderInterface {


    /**
     * The hasher implementation.
     *
     * @var \Illuminate\Hashing\HasherInterface
     */
    protected $hasher;

    /**
     * The Eloquent user model.
     *
     * @var string
     */
    protected $Omodel; // 后台
    protected $Mmodel; // 前台

    /**
     * __construct
     */
    public function __construct()
	{
		$this->Omodel  = 'Operator';
		$this->hasher = new \Illuminate\Hashing\BcryptHasher();
	}

	/**
	 * Retrieve a user by their unique identifier.
	 *
	 * @param  mixed  $identifier
	 * @return \Illuminate\Auth\UserInterface|null
	 */
	public function retrieveById($identifier)
	{
        return $this->createOModel()->newQuery()->find($identifier);
	}

	/**
	 * Retrieve a user by the given credentials.
	 *
	 * @param  array  $credentials
	 * @return \Illuminate\Auth\UserInterface|null
	 */
	public function retrieveByCredentials(array $credentials)
	{
		$query = $this->createOModel()->newQuery();
        // $query->where('username', $credentials['username']));

		foreach ($credentials as $key => $value)
		{
			if ( ! str_contains($key, 'password')) $query->where($key, $value);
		}

		return $query->first();
	}

	/**
	 * Validate a user against the given credentials.
	 *
	 * @param  \Illuminate\Auth\UserInterface  $user
	 * @param  array  $credentials
	 * @return bool
	 */
	public function validateCredentials(UserInterface $user, array $credentials)
	{
		$plain = $credentials['password'];

		return $this->hasher->check($plain, $user->getAuthPassword());
	}

	/**
	 * Create a new instance of the OModel.
	 *
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function createOModel()
	{
		$class = '\\'.ltrim($this->Omodel, '\\');

		return new $class;
	}

    /**
     *
     * Create a new instance of the MModel.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createMModel()
    {
        $class = '\\'.ltrim($this->Mmodel, '\\');

        return new $class;
    }

}
