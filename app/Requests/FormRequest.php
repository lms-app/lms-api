<?php
declare(strict_types=1);


namespace App\Requests;


use App\ValueObjects\LimitValue;
use App\ValueObjects\OrderByValue;
use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;
use Modules\User\Entities\User;

class FormRequest extends BaseFormRequest
{
    public function rules():array
    {
        return [];
    }

    public function getPage():int
    {
        $page = (int) $this->page;
        if ($page <= 0) {
            $page = 1;
        }

        return $page;
    }

    public function getLimit():int
    {
        $this->limit = (int) $this->limit;

        if (!$this->limit) {
            $this->limit = LimitValue::LIMIT_DEFAULT;
        }

        return $this->limit;
    }

    public function getOrderByValue():?OrderByValue
    {
        if (!$this->orderBy) {
            return null;
        }

        if (!$this->sortedBy) {
            $this->sortedBy = OrderByValue::DIRECTION_ASC;
        }

        return OrderByValue::create($this->orderBy, $this->sortedBy);
    }

    public function authorize():bool
    {
        return false;
    }

    public function getUserModel():?User
    {
        return $this->user();
    }
}
