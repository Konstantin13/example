<?php

namespace App\Http\Requests;

use App\Models\Client;
use App\Models\Direction;
use App\Models\Manager;
use App\Rules\ExistsByModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Orchid\Attachment\Models\Attachment;


class ClipRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'max:255',
            ],
            'direction_id' => [
                'required',
                'integer',
                new ExistsByModel(Direction::class, 'id'),
            ],
            'client_id' => [
                'required',
                'integer',
                new ExistsByModel(Client::class, 'id'),
            ],
            'manager_id' => [
                'required',
                'integer',
                new ExistsByModel(Manager::class, 'id'),
            ],
            'date_start' => [
                'required',
                'date',
            ],
            'date_end' => [
                'required',
                'date',
            ],
            'archived' => [
                'required',
                'boolean',
            ],
            'file.*' => [
                'required',
                new ExistsByModel(Attachment::class, 'id'),
            ],
        ];
    }
}
