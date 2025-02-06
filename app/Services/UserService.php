<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\Course;
use App\Models\Instructor;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use mysql_xdevapi\Exception;

class UserService
{
    public function register(array $data)
    {
        if (array_key_exists('profile_picture', $data)) {
            $data['profile_picture'] = Storage::disk('public')->put("/profile", $data['profile_picture']);
        }
        $user = User::create($data);
        $user->assignRole('student');
        return [
            'user' => new UserResource($user),
            'role' => $user->getRoleNames()->first(),
            'token' => $user->createToken($user->id)->plainTextToken
        ];

    }

    public function login(array $data)
    {
        if (!Auth::attempt($data)) {
            throw new \Exception("wrong email or password");
        }
        $user = \auth()->user();
        $token = $user->createToken($user->id)->plainTextToken;
        return [
            'user' => new UserResource($user),
            'role' => $user->getRoleNames()->first(),
            'token' => $user->createToken($user->id)->plainTextToken
        ];
    }


    public function editProfile(array $data)
    {
        $data = array_filter($data);
        $user = \auth()->user();
        if (array_key_exists('profile_picture', $data)) {
            $data['profile_picture'] = (new FileService())->updatePhoto($data['profile_picture'], $user->profile_picture,'profile');
        }
        $user->update($data);
        if ($user->hasRole('instructor')) {
            Instructor::where('user_id', $user->id)->first()->update($data);
            $user = $user->load('instructor');
        }
        return $user;
    }

    public function paymentCourse(Course $course){
        DB::transaction(function () use ($course) {
            $account = auth()->user()->account;
            $instructor_account = $course->instructor->account;
            if ($account->balance < $course->price) {
                throw new Exception("There is no balance to complete the payment process.");
            }
            $account->update(['balance' => ($account->balance - $course->price)]);
            $instructor_account->update(['balance' => ($instructor_account->balance + $course->price)]);
            Transaction::create([
                'account_id'=>$account->id,
                'intended_account_id'=>$instructor_account->id,
                'amount'=>$course->price,
                'course_id'=>$course->id
            ]);
            $course->users()->attach(\auth()->user()->id);
        });
    }

    public function store(array $data){
        DB::transaction(function () use ($data){
            if (array_key_exists('profile_picture', $data)) {
                $data['profile_picture'] = Storage::disk('public')->put("/profile", $data['profile_picture']);
            }
            $user = User::create($data);
            $user->assignRole($data['role']);
            if(array_key_exists('instructor',$data)){
                $data['instructor']['user_id']=$user->id;
                if(isset($data['instructor']['cv'])){
                    $data['instructor']['cv'] = Storage::disk('public')->put('/cv', $data['instructor']['cv']);
                }
                Instructor::create($data['instructor']);
            }
        });

    }

    public function update(array $data,$user){
       $user = DB::transaction(function ()use($data,$user){
           $data = array_filter($data);
           if (array_key_exists('profile_picture', $data)) {
               $data['profile_picture'] = (new FileService())->updatePhoto($data['profile_picture'],$user->profile_picture,'/profile');
           }
           $user->update($data);
           if(array_key_exists('instructor',$data) && $user->hasRole('instructor')){
               if (array_key_exists('cv',$data['instructor'])) {
                   $data['instructor']['cv'] = (new FileService())->updatePhoto($data['instructor']['cv'],$user->instructor->cv,'/cv');
               }
               $user->instructor()->update($data['instructor']);
               $user->load('instructor');
           }
           return $user;
       });
       return $user;
    }

}
