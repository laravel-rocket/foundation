<?php
namespace LaravelRocket\Foundation\Helpers;

interface RedirectHelperInterface
{
    /**
     * @param string    $path
     * @param int       $status
     * @param array     $headers
     * @param bool|null $secure
     * @param string    $guardName
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function guest($path, $guardName = '', $status = 302, $headers = [], $secure = null);

    /**
     * @param string    $default
     * @param int       $status
     * @param array     $headers
     * @param bool|null $secure
     * @param string    $guardName
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function intended($default = '/', $guardName = '', $status = 302, $headers = [], $secure = null);
}
