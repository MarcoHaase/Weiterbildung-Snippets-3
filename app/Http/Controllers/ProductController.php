<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function viewproduct ($id = 0) { 

        $path = storage_path() . "/json/werkzeuge.json";
        $json = json_decode(file_get_contents($path), true); 

        $env = [
            'title' => 'Produkte', 
            'kategorie' => 'Werkzeuge',
            'werkzeuge' => $json,
        ];
        return view('products', $env, compact('id')); 
    }
}
