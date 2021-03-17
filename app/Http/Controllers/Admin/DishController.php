<?php

namespace App\Http\Controllers\Admin;

use App\Dish;
use App\Restaurant;
<<<<<<< HEAD

=======
>>>>>>> 6382f30480992c0077d23b2022b5f70db8b2981a
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class DishController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $dishes = $user->dishes;
        return view('admin.dishes.index', compact('dishes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();
        $restaurants = $user->restaurants;
        return view('admin.dishes.create', compact('restaurants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::id();
        $request['slug'] = Str::slug($request->name);
        $request['user_id'] = $user;
<<<<<<< HEAD
        
        if(!$request->hasFile('cover')){
=======
        {
>>>>>>> 6382f30480992c0077d23b2022b5f70db8b2981a
            $validatedData = $request->validate([
                'name' => 'required',
                'slug' => 'required',
                'ingredients' => 'required',
                'visibility' => 'required',
                'price' => 'required',
                'cover' => 'nullable | image',
                'user_id' => 'exists:users,id',
<<<<<<< HEAD
                'restaurant_id' => 'required | exists:restaurants,id'
            ]);
        }else{
            $validatedData = $request->validate([
                'name' => 'required',
                'slug' => 'required',
                'ingredients' => 'required',
                'visibility' => 'required',
                'price' => 'required',
                'cover' => 'nullable | image',
                'user_id' => 'exists:users,id',
                'restaurant_id' => 'required | exists:restaurants,id'
=======
                'restaurant_id' => 'required',
>>>>>>> 6382f30480992c0077d23b2022b5f70db8b2981a
            ]);
            $cover = Storage::put('dish_img', $request->cover);
            $validatedData['cover'] = $cover;
        }

        Dish::create($validatedData);
        $new_dish = Dish::orderBy('id', 'desc')->first();
        $new_dish->user()->associate($request->user_id)->save();
        $new_dish->restaurant()->associate($request->restaurant_id)->save();

        return redirect()->route('admin.dishes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function show(Dish $dish)
    {
<<<<<<< HEAD
        $user = Auth::id();
=======
        $user = auth()->user();
        $dishes = $user->dishes;
>>>>>>> 6382f30480992c0077d23b2022b5f70db8b2981a

        if ($user !== $dish->user_id) {
            return redirect("/");
        } else {
            return view('admin.dishes.show', compact('dish'));
        } 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function edit(Dish $dish)
    {
<<<<<<< HEAD
        $user = Auth::id();

        if ($user !== $dish->user_id) {
            return redirect("/");
        } else {
            $user = auth()->user();
            $restaurants = $user->restaurants;
            return view('admin.dishes.edit', compact('dish', 'restaurants'));
        }
=======
        $user = auth()->user();
        $restaurants = $user->restaurants;

        // if ($user !== $dish->user_id) {
            // return redirect("/");
        // } else {
            return view('admin.dishes.edit', compact('dish', 'restaurants'));
        // }
>>>>>>> 6382f30480992c0077d23b2022b5f70db8b2981a
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dish $dish)
    {
        $request['slug'] = Str::slug($request->name);

        if($request->hasFile('cover')){
            Storage::delete($dish->cover);
            $validatedData = $request->validate([
                'name' => 'required',
                'slug' => 'required',
                'ingredients' => 'required',
                'visibility' => 'required',
                'price' => 'required',
                'cover' => 'nullable | image | mimes:jpeg,png,jpg,gif,svg',
                'user_id' => 'exists:users,id',
                'restaurant_id' => 'required | exists:restaurants,id'
            ]);
            $cover = Storage::put('dish_img', $request->cover);
            $validatedData['cover'] = $cover;
            $dish->update($validatedData);
        }else{
            $validatedData = $request->validate([
                'name' => 'required',
                'slug' => 'required',
                'ingredients' => 'required',
                'visibility' => 'required',
                'price' => 'required',
                'cover' => 'nullable | image | mimes:jpeg,png,jpg,gif,svg',
                'user_id' => 'exists:users,id',
                'restaurant_id' => 'required | exists:restaurants,id'
            ]);
            $dish->update($validatedData);
        }

        $new_dish = Dish::orderBy('id', 'desc')->first();
        $new_dish->user()->associate($request->user_id)->save();
        $new_dish->restaurant()->associate($request->restaurant_id)->save();

        return redirect()->route('admin.dishes.index', $dish);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Dish  $dish
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dish $dish)
    {

        $dish->delete();
        return redirect()->route('admin.dishes.index');
    }
}
