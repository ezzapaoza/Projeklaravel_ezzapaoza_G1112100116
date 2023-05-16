<?php

namespace App\Http\Controllers\resto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
    $this->middleware('auth');
    }
    public function index()
    {
    return view('resto.home.index');
    }
}
