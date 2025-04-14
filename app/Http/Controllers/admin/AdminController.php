<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(){
        return View('admin.dashboard');
    }


    public function login(){
        return View('admin.login');
    }
}
