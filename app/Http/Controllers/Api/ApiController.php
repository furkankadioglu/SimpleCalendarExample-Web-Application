<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Validator;
use App\User;

class ApiController extends Controller
{
    /**
     * Show API Status
     *
     * @return void
     */
    public function status()
    {
        return [
            "success" => true
        ];
    }
}