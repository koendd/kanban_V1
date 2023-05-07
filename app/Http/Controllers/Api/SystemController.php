<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\System;

class SystemController extends Controller
{
    public function getSubsytems(System $system)
    {
        return $system->SubSystems;
    }
}
