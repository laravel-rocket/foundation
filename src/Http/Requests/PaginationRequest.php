<?php

namespace LaravelRocket\Foundation\Http\Requests;

use LaravelRocket\Foundation\Http\Requests\Traits\PaginationTrait;

class PaginationRequest extends Request
{
    use PaginationTrait;
}
