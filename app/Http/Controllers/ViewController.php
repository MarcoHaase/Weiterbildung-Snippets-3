<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function home() {
        $env = ['title' => 'Home'];
        return view('home', $env);
    }

    public function about() { return view('/about', ['title' => 'About Us']); }
    public function service() { return view('/service', ['title' => 'Service']); }
    public function policy() { return view('/policy', ['title' => 'Policy']); }
    public function impressum() { return view('/impressum', ['title' => 'Impressum']); }
    public function agb() { return view('/agb', ['title' => 'AGB']); }
    public function register() { return view('/register', ['title' => 'Register']); }
    public function login() { return view('/login', ['title' => 'Login']); }

    public function contact() { 
        return view('/contact', ['title' => 'Kontakt']); 
    }
    public function vue() { return view('vue'); }
}
