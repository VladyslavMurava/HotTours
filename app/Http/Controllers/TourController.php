<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Models\Tour;
use App\Models\Destination;
use App\Models\Order;
use App\Models\User;

class TourController extends Controller
{
    public function home()
    {
        $tours = Tour::where('is_hot', true)->take(6)->get();
        return view('home')->with('tours', $tours);
    }

    public function index(Request $request)
    {
        $query = Tour::with('destination');

        if ($request->filled('destination_id')) {
            $query->where('destination_id', $request->destination_id);
        }
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }
        if ($request->filled('duration')) {
            $query->where('duration', $request->duration);
        }
        if ($request->filled('departure_from')) {
            $query->where('departure_date', '>=', $request->departure_from);
        }
        if ($request->boolean('is_hot')) {
            $query->where('is_hot', true);
        }

        $tours = $query->get();
        $destinations = Destination::all();

        return view('tours.index')
            ->with('tours', $tours)
            ->with('destinations', $destinations)
            ->with('pageTitle', 'Каталог гарячих турів');
    }

    public function create()
    {
        $destinations = Destination::all();
        return view('tours.create')->with('destinations', $destinations);
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric|min:1',
            'duration' => 'required|numeric|min:1',
            'destination_id' => 'required|exists:destinations,id',
            'image' => 'required|image',
        ];

        $validator = Validator::make($request->all(), $rules, [
            'title.required' => 'Назва туру не може бути пустою.',
            'description.required' => 'Додайте опис туру.',
            'price.required' => 'Вкажіть ціну туру.',
            'price.numeric' => 'Ціна має бути числом.',
            'price.min' => 'Ціна має бути більше 0.',
            'duration.required' => 'Вкажіть тривалість туру.',
            'duration.numeric' => 'Тривалість має бути числом.',
            'duration.min' => 'Тривалість має бути більше 0.',
            'destination_id.required' => 'Оберіть напрямок.',
            'destination_id.exists' => 'Обраний напрямок не існує.',
            'image.required' => 'Додайте зображення туру.',
            'image.image' => 'Обраний файл не є зображенням.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('tours.create')
                ->withErrors($validator)
                ->withInput();
        }

        $filename = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $random_name = Str::random(8);
            $destinationPath = 'assets/tours/';
            $extension = $file->getClientOriginalExtension();
            $filename = $random_name . '_tour.' . $extension;
            $file->move($destinationPath, $filename);
        }

        $tour = new Tour();
        $tour->title = $request->get('title');
        $tour->description = $request->get('description');
        $tour->price = $request->get('price');
        $tour->duration = $request->get('duration');
        $tour->departure_date = $request->get('departure_date');
        $tour->destination_id = $request->get('destination_id');
        $tour->image = $filename;
        $tour->is_hot = $request->has('is_hot') ? true : false;
        $tour->save();

        return redirect()->route('tours.index');
    }

    public function show($id)
    {
        $tour = Tour::find($id);
        $tours = Tour::all();
        return view('tours.show')->with('tour', $tour)
            ->with('tours', $tours);
    }

    public function edit($id)
    {
        $tour = Tour::find($id);
        $destinations = Destination::all();
        return view('tours.edit')->with('tour', $tour)
            ->with('destinations', $destinations);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric|min:1',
            'duration' => 'required|numeric|min:1',
            'destination_id' => 'required|exists:destinations,id',
            'image' => 'nullable|image',
        ];

        $validator = Validator::make($request->all(), $rules, [
            'title.required' => 'Назва туру не може бути пустою.',
            'description.required' => 'Додайте опис туру.',
            'price.required' => 'Вкажіть ціну туру.',
            'price.numeric' => 'Ціна має бути числом.',
            'price.min' => 'Ціна має бути більше 0.',
            'duration.required' => 'Вкажіть тривалість туру.',
            'duration.numeric' => 'Тривалість має бути числом.',
            'duration.min' => 'Тривалість має бути більше 0.',
            'destination_id.required' => 'Оберіть напрямок.',
            'destination_id.exists' => 'Обраний напрямок не існує.',
            'image.image' => 'Обраний файл не є зображенням.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('tours.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $tour = Tour::find($id);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $random_name = Str::random(8);
            $destinationPath = 'assets/tours/';
            $extension = $file->getClientOriginalExtension();
            $filename = $random_name . '_tour.' . $extension;
            $file->move($destinationPath, $filename);
            $tour->image = $filename;
        }

        $tour->title = $request->get('title');
        $tour->description = $request->get('description');
        $tour->price = $request->get('price');
        $tour->duration = $request->get('duration');
        $tour->departure_date = $request->get('departure_date');
        $tour->destination_id = $request->get('destination_id');
        $tour->is_hot = $request->has('is_hot') ? true : false;
        $tour->save();

        return redirect()->route('tours.index');
    }

    public function destroy($id)
    {
        $tour = Tour::find($id);
        $tour->delete();
        return redirect()->route('tours.index');
    }

    public function order(Request $request, $id)
    {
        if (!auth()->check()) {
            return redirect()->route('register');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'persons' => 'required|integer|min:1|max:10',
        ]);

        Order::create([
            'tour_id' => $id,
            'user_id' => auth()->id(),
            'name' => $request->name,
            'phone' => $request->phone,
            'persons' => $request->persons,
            'status' => 'new',
        ]);

        return redirect()->route('tours.show', $id)->with('order_success', true);
    }

    public function cabinet()
    {
        $orders = Order::with('tour')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
        return view('cabinet')->with('orders', $orders);
    }

    public function adminOrders()
    {
        $orders = Order::with('tour')->orderBy('created_at', 'desc')->get();
        return view('admin.orders')->with('orders', $orders);
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:new,confirmed,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->route('admin.orders');
    }

    public function adminStats()
    {
        $totalTours    = Tour::count();
        $totalOrders   = Order::count();
        $totalUsers    = User::count();
        $hotTours      = Tour::where('is_hot', true)->count();

        $ordersByStatus = [
            'new'       => Order::where('status', 'new')->count(),
            'confirmed' => Order::where('status', 'confirmed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];

        $confirmedRevenue = Order::where('status', 'confirmed')
            ->with('tour')
            ->get()
            ->sum(fn($o) => $o->tour ? $o->tour->price * $o->persons : 0);

        $topTours = Tour::withCount('orders')
            ->with('destination')
            ->orderByDesc('orders_count')
            ->take(5)
            ->get();

        $byDestination = Destination::with(['tours' => function ($q) {
            $q->withCount('orders');
        }])->get()->map(function ($dest) {
            $dest->orders_total = $dest->tours->sum('orders_count');
            $dest->tours_count  = $dest->tours->count();
            return $dest;
        })->sortByDesc('orders_total')->values();

        return view('admin.stats', compact(
            'totalTours', 'totalOrders', 'totalUsers', 'hotTours',
            'ordersByStatus', 'confirmedRevenue', 'topTours', 'byDestination'
        ));
    }
}
