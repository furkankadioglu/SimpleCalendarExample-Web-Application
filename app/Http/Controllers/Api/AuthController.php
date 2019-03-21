<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Validator;
use App\User;
use Hash;
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        $email = request()->email;
        $password = request()->password;

        $user = User::where('email', '=', $email)->first();

        $unauthorizedResponse = [
            'success' => false,
            'errors' => [
                "unauthorized" => [
                        'error_code' => 401,
                        'error_description' => 'Unauthorized, wrong credentials.'
                ]
            ]
        ];

        if($user)
        {
            if(!Hash::check($password, $user->password)) {
                return response()->json($unauthorizedResponse, 401);
            }

            if (! $token = auth()->attempt($credentials)) {
                return response()->json($unauthorizedResponse, 401);
            }
    
            return $this->respondWithToken($token);
        }

        return response()->json($unauthorizedResponse, 401);
        
    }


    /**
     * Get a JWT and create an user via given credentials.
     *
     * @param   Illuminate\Http\Request $request
     * @return  \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'errors' => $validator->errors()
            ];
        }

        $user = new User;
        $user->name = request()->name;
        $user->email = request()->email;
        $user->password = bcrypt(request()->password);
        $user->save();

        return [
            "success" => true,
            "payload" => new UserResource($user)
        ];

    }


    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        return [
            "success" => true,
            "payload" => new UserResource(auth()->user())
        ];

    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json([
            "success" => true
        ]);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            "success" => true,
            "payload" => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
                'user' => auth()->user()
            ]
        ]);
    }
}