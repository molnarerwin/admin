<?php

declare(strict_types=1);
/**
 * Contains the CreateTaxon class.
 *
 * @copyright   Copyright (c) 2018 Hunor Kedves
 * @author      Hunor Kedves
 * @license     MIT
 * @since       2018-10-22
 *
 */

namespace Vanilo\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Vanilo\Admin\Contracts\Requests\CreateTaxon as CreateTaxonContract;

class CreateTaxon extends FormRequest implements CreateTaxonContract
{
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:255',
            'parent_id' => 'nullable|exists:taxons,id',
            'priority' => 'nullable|integer',
            'images' => 'nullable',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
