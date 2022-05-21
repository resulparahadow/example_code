<?php

namespace App\Http\Admin\Controllers;

use App\Http\BaseController;
use Illuminate\Http\Request;

class SettingsController extends BaseController
{
    public function index(Request $r)
    {
        return view('admin.settings.index');
    }
}
