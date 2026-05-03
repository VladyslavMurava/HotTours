<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Models\TourImage;
use App\Models\Tour;

class TourImageController extends Controller
{
    // Форма додавання зображення до туру
    public function create($tour_id)
    {
        return view('images.create')->with('tour_id', $tour_id);
    }

    // Збереження зображення
    public function store(Request $request, $tour_id)
    {
        $rules = ['image' => 'required|image'];

        $validator = Validator::make($request->all(), $rules, [
            'image.required' => 'Необхідно обрати зображення.',
            'image.image' => 'Обраний файл не є зображенням.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $file = $request->file('image');
        $random_name = Str::random(8);
        $destinationPath = 'assets/images/';
        $extension = $file->getClientOriginalExtension();
        $filename = $random_name . '.' . $extension;
        $file->move($destinationPath, $filename);

        $image = new TourImage();
        $image->tour_id = $tour_id;
        $image->description = $request->get('description');
        $image->image = $filename;
        $image->save();

        return redirect()->route('tours.show', $image->tour->id);
    }

    // Видалення зображення
    public function destroy($id)
    {
        $image = TourImage::find($id);
        $tour_id = $image->tour->id;
        $image->delete();
        return redirect()->route('tours.show', $tour_id);
    }

    // Переміщення зображення між турами
    public function move(Request $request, $id)
    {
        $rules = ['new_tour' => 'required|numeric|exists:tours,id'];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back();
        }

        $image = TourImage::find($id);
        $image->tour_id = $request->get('new_tour');
        $image->save();

        return redirect()->route('tours.show', $image->tour->id);
    }
}
