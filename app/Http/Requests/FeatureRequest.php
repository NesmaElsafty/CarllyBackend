<?php 
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeatureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('feature');

        return [
            'name' => 'nullable|string|max:255|unique:features,name' . ($id ? ",$id" : ''),
            'priority' => 'required|integer',
        ];
    }
}
?>