<?php
namespace LaravelRocket\Foundation\Http\Requests;

class PaginationRequest extends Request
{
    /**
     * @return int
     */
    public function offset()
    {
        $offset = $this->get('offset', 0);

        return $offset >= 0 ? (int) $offset : 0;
    }

    /**
     * @param int $default
     *
     * @return int
     */
    public function limit($default = 10)
    {
        $limit = $this->get('limit', $default);

        return ($limit > 0 && $limit <= 100) ? (int) $limit : $default;
    }

    public function order($default = 'id')
    {
        $order = $this->get('order', $default);

        return strtolower($order);
    }

    public function direction($default = 'asc')
    {
        $direction = strtolower($this->get('direction', $default));
        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'asc';
        }

        return strtolower($direction);
    }

    public function filters($keys)
    {
        $filters = [];
        foreach ($keys as $key) {
            $value = $this->get($key);
            if (!empty($value)) {
                $filters[$key] = $value;
            }
        }

        return $filters;
    }
}
