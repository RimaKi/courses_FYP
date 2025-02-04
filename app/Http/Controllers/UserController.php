<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\EditProfileRequest;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\Course;
use App\Models\User;
use App\Services\UserService;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->userService->register($request->validationData());
        return self::success($user);
    }

    public function login(LoginRequest $request)
    {
        $data = $this->userService->login($request->validationData());
        return self::success($data);
    }

    public function logout()
    {
        \auth()->user()->tokens()->delete();
        return self::success();
    }

    public function profile()
    {
        return new UserResource(auth()->user()->load(['account', 'courses']));
    }

    public function editProfile(EditProfileRequest $request)
    {
        $user = $this->userService->editProfile($request->validationData());
        return self::success(new UserResource($user));
    }

    public function paymentCourse(Course $course)
    {
        $this->userService->paymentCourse($course);
        return self::success(null, 'payment successfully');
    }

}
