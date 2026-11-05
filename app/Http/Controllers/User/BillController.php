<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class BillController extends Controller
{
    public function Bills()
    {
        return view('user.bills.index'); // Load the dashboard view
    }
}
