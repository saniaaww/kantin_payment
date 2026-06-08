<?php

namespace App\Http\Controllers;
use App\Models\Menu;
use App\Models\Vendor;

use Illuminate\Http\Request;

class MenuController extends Controller
{
   public function index()
    {
    $vendors = Vendor::all();
    $menus = Menu::all();

    return view('menu',compact('vendors','menus'));
    }

    public function getMenu($idvendor)
    {
    return Menu::where('idvendor',$idvendor)->get();
    }
}
