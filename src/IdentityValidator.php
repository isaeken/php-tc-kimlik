<?php


namespace IsaEken\PhpTcKimlik;


use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use IsaEken\PhpTcKimlik\Helpers;

class IdentityValidator
{
    /**
     * @var string $identity_number_key
     */
    public string $identity_number_key;

    /**
     * @var string $first_name_key
     */
    public string $first_name_key;

    /**
     * @var string $last_name_key
     */
    public string $last_name_key;

    /**
     * @var string $birth_year_key
     */
    public string $birth_year_key;

    /**
     * @var string|null $method
     */
    public ?string $method;

    /**
     * @var Request|null $request
     */
    public ?Request $request;

    /**
     * IdentityValidator constructor.
     * @param string $identity_number_key
     * @param string $first_name_key
     * @param string $last_name_key
     * @param string $birth_year_key
     * @param string|null $method
     * @param Request|null $request
     */
    public function __construct(string $identity_number_key = "identity_number", string $first_name_key = "first_name", string $last_name_key = "last_name", string $birth_year_key = "birth_year", string $method = null, Request $request = null)
    {
        $this->identity_number_key = $identity_number_key;
        $this->first_name_key = $first_name_key;
        $this->last_name_key = $last_name_key;
        $this->birth_year_key = $birth_year_key;
        $this->method = $method;
        $this->request = $request;
    }

    /**
     * @return array
     */
    public function validate() : array
    {
        $method = "input";
        $request = $this->request;
        $identity_number = "";
        $first_name = "";
        $last_name = "";
        $birth_year = "";

        if (!is_null($this->method)) {
            $method = strtolower($this->method);

            if (!in_array($method, ["get", "post", "put", "delete", "patch"])) {
                print redirect()->back()->withErrors([
                    __("Please enter valid identity."),
                ]);
                return [];
            }
        }

        if (is_null($request)) {
            $request = request();
        }

        $identity_number = $request->$method($this->identity_number_key);
        $first_name = $request->$method($this->first_name_key);
        $last_name = $request->$method($this->last_name_key);
        $birth_year = $request->$method($this->birth_year_key);

        $isValidIdentity = PhpTcKimlik::isValidIdentity($identity_number, $first_name, $last_name, Carbon::make("01/01/" . $birth_year));

        if (!$isValidIdentity) {
            print redirect()->back()->withErrors([
                __("Please enter valid identity."),
            ]);
            return [];
        }

        return [
            $this->identity_number_key => $identity_number,
            $this->first_name_key => $first_name,
            $this->last_name_key => $last_name,
            $this->birth_year_key => $birth_year,
        ];
    }
}
