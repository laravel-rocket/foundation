<?php
namespace LaravelRocket\Foundation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    public function messages()
    {
        return [];
    }

    public function onlyExists($keys)
    {
        $keys = is_array($keys) ? $keys : func_get_args();

        $results = [];

        foreach ($keys as $key) {
            if ($this->has($key)) {
                $results[$key] = $this->get($key);
            }
        }

        return $results;
    }
}
