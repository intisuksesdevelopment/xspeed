<?php
namespace App\Services;

class PosService
{
    public static function save($request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'category_id' => 'required',
        ]);

        $pos = new Pos();
        $pos->name = $request->name;
        $pos->description = $request->description;
        $pos->price = $request->price;
        $pos->stock = $request->stock;
        $pos->category_id = $request->category_id;
        $pos->save();
    }
}