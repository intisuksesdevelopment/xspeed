<?php

namespace App\Services;

use App\Models\Warehouse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class WarehouseService
{
    public function create(array $data)
    {
        $validator = $this->validate($data);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return Warehouse::create($data);
    }

    public function read($id)
    {
        $warehouse = Warehouse::where('status', 0)->findOrFail($id);

    }

    public function update($id, array $data)
    {
        $warehouse = Warehouse::where('status', 0)->findOrFail($id);


        $validator = $this->validate($data, $id);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $warehouse->update($data);

        return $warehouse;
    }

    public function delete($id)
    {
        $warehouse = Warehouse::where('status', 0)->findOrFail($id);
        $warehouse->delete();

        return $warehouse;
    }

    private function validate(array $data, $id = null)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:warehouses,code,' . $id,
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'image_url' => 'nullable|string|url',
            'status' => 'required|in:active,inactive',
            'created_by' => 'nullable|integer',
            'updated_by' => 'nullable|integer',
        ];

        return Validator::make($data, $rules);
    }
}
