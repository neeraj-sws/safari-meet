<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Helpers\ImageHelper;
use App\Helpers\UserHelper;
use App\Http\Controllers\Api\BaseController;
use App\Mail\DynamicMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class UserAuthController extends BaseController
{
    public function checkAuth()
    {
        $user = Auth::guard('user_api')->user();
        if (empty($user)) {
            return response()->json(['status' => false, 'status_code' => 401, 'message' => 'User not authenticated'], 401);
        }
    }


    public function signUp(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'phone' => 'required|numeric|digits:10',
                'email' => 'required|email|email:rfc,dns|unique:users,email',
                'password' => 'required|string|min:6|confirmed',
                'agree_t_c' => 'accepted',
            ],
            [
                'name.required' => 'Name is required.',
                'name.string' => 'Name must be a valid string.',
                'name.max' => 'Name may not be greater than 255 characters.',

                'phone.required' => 'Phone number is required.',
                'phone.numeric' => 'Phone number must be numeric.',
                'phone.digits_between' => 'Phone number must be between 10 and 12 digits.',

                'email.required' => 'Email is required.',
                'email.email' => 'Please provide a valid email address.',
                'email.email.rfc' => 'The email must comply with RFC standards.',
                'email.email.dns' => 'The email domain must have valid DNS records.',
                'email.unique' => 'This email address is already registered.',

                'password.required' => 'Password is required.',
                'password.min' => 'Password must be at least 6 characters.',
                'password.confirmed' => 'Password confirmation does not match.',

                'agree_t_c.accepted' => 'You must agree to the terms and conditions.',
            ]
        );



        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first(),
                'data' => ""
            ], 200);
        }

        $validated = $validator->validated();
        $existingUser = User::where('email', $validated['email'])->first();
        if ($existingUser) {
            return response()->json([
                'status' => 400,
                'message' => 'This email address is already registered.',
                'data' => "",
                'errors' => ['email' => 'The provided email is already associated with an existing account.']
            ], 200);
        }

        do {
            $otp = rand(100000, 999999);
        } while (User::where('email_verified_otp', $otp)->exists());

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => UserHelper::generateUsername($validated['name']),
            'phone_number' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'otp_expires_at' => Carbon::now()->addMinutes(10),
            'email_verified_otp' => $otp,
            'agree_t_c' => $validated['agree_t_c'],
        ]);

        $data = [
            'username' => $user->name,
            'otp' => $user->email_verified_otp,
            'year' => date('Y'),
        ];

        $parsed = UserHelper::parseTemplate('AGENTEMAILVERIFY', $data);
<<<<<<< HEAD
        // Mail::to($validated['email'])->queue(
        //     new DynamicMail($parsed['subject'], $parsed['body'])
        // );
        dispatch(function () use ($validated, $parsed) {
            Mail::to($validated['email'])->send(
                new DynamicMail($parsed['subject'], $parsed['body'])
            );
        })->afterResponse();
=======
        Mail::to($validated['email'])->queue(
            new DynamicMail($parsed['subject'], $parsed['body'])
        );
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b

        return response()->json([
            'status' => 200,
            'message' => 'User successfully registered.',
            'data' => $user,
        ], 200);
    }

    function verifyOtp(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email:rfc,dns',
                'otp' => 'required|digits:6',
            ],
            [
                'email.required' => 'Email is required.',
                'email.email' => 'Please provide a valid email address.',
                'otp.required' => 'OTP is required.',
                'otp.digits' => 'Please enter a valid 6-digit OTP.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first(),
                'data' => null,
            ], 200);
        }

        $otpCode = $request->otp;

        $user = User::where('email', $request->email)
            ->where('email_verified_otp', $otpCode)
            ->first();

        if (!$user) {
            return response()->json([
                'status' => 400,
                'message' => 'Invalid OTP. Please try again.',
                'data' => null,
            ], 200);
        }

        if (Carbon::parse($user->otp_expires_at)->lt(now())) {
            return response()->json([
                'status' => 400,
                'message' => 'OTP has expired. Please request a new one.',
                'data' => null,
            ], 200);
        }
        $user->email_verified_at = now();
        $user->email_verified_otp = null;
        $user->otp_expires_at = null;

        $data = [
            'username' => ($user->user_type == 1) ? $user->contact_person : $user->name,
            'year' => date('Y'),
        ];

        $parsed = UserHelper::parseTemplate('AFTERREGISTRATION', $data);
<<<<<<< HEAD
        // Mail::to($request->email)->queue(
        //     new DynamicMail($parsed['subject'], $parsed['body'])
        // );

         dispatch(function () use ($user, $parsed) {
                Mail::to($user->email)->send( 
                    new DynamicMail($parsed['subject'], $parsed['body'])
                );
        })->afterResponse();
=======
        Mail::to($request->email)->queue(
            new DynamicMail($parsed['subject'], $parsed['body'])
        );
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b

        if ($user->user_type == 0) {
            $user->status = 0;
            $data = [
                'user_name' => $user->name,
                'status' => 'Approved',
                'remark' => "Thank you for registering with us! We're happy to inform you that your account has been successfully approved.<br><br>
                You can now log in and start using all of our features.<br><br>
                If you have any questions or need assistance, feel free to reach out to our support team.",
                'year' => date('Y'),
            ];

            $parsed = UserHelper::parseTemplate('REGISTRATIONSTATUS', $data);
<<<<<<< HEAD
            // Mail::to($user->email)->queue(
            //     new DynamicMail($parsed['subject'], $parsed['body'])
            // );

            dispatch(function () use ($user, $parsed) {
                    Mail::to($user->email)->send(  
                        new DynamicMail($parsed['subject'], $parsed['body'])
                    );
             })->afterResponse();
=======
            Mail::to($user->email)->queue(
                new DynamicMail($parsed['subject'], $parsed['body'])
            );
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
        }

        $user->save();
        $user->tokens()->delete();
        $token = $user->createToken('UserToken')->plainTextToken;

        return response()->json([
            'status' => 200,
            'message' => 'User successfully registered.',
            'data' => $user->only('name', 'username', 'email'),
            'token' => $token,
        ], 200);
    }

    public function requestNewOtp(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email|exists:users,email',
            ],
            [
                'email.required' => 'Email address is required.',
                'email.email' => 'Please provide a valid email address.',
                'email.exists' => 'No user found with this email address.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first(),
                'data' => null,
            ], 200);
        }

        $otp = rand(100000, 999999);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => 400,
                'message' => 'User not found with this email address.',
                'data' => null,
            ], 200);
        }

        $user->email_verified_otp = $otp;
        $user->otp_expires_at = now()->addMinutes(10);
        $user->save();

        $data = [
            'username' => $user->contact_person,
            'otp' => $otp,
            'year' => now()->year,
        ];

        $parsed = UserHelper::parseTemplate('AGENTEMAILVERIFY', $data);
        try {
<<<<<<< HEAD
            // Mail::to($request->email)->queue(new DynamicMail($parsed['subject'], $parsed['body']));
            dispatch(function () use ($request, $parsed) {
                Mail::to($request->email)->send(new DynamicMail($parsed['subject'], $parsed['body']));
            })->afterResponse(); 
=======
            Mail::to($request->email)->queue(new DynamicMail($parsed['subject'], $parsed['body']));
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => 'Failed to send OTP email. Please try again later.',
                'data' => null,
            ], 200);
        }

        return response()->json([
            'status' => 200,
            'message' => 'OTP sent successfully.',
            'data' => null,
        ], 200);
    }

    public function login(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required',
            ],
            [
                'email.required' => 'Email address is required.',
                'email.email' => 'Please provide a valid email address.',
                'password.required' => 'Password is required.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first(),
                'data' => null,
            ], 200);
        }

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => 400,
                'message' => 'User not found.',
                'data' => null,
            ], 200);
        }

        if (empty($user->email_verified_at)) {
            $otp = rand(100000, 999999);

            $user->email_verified_otp = $otp;
            $user->otp_expires_at = now()->addMinutes(10);
            $user->save();

            return response()->json([
                'status' => 400,
                'message' => 'Please verify your email.',
                'data' => [
                    'OTP' => $otp,
                ],
            ], 200);
        }


        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 400,
                'message' => 'Invalid credentials.',
                'data' => null,
            ], 200);
        }

        $user->tokens()->delete();
        $token = $user->createToken('UserToken')->plainTextToken;

        return response()->json([
            'status' => 200,
            'message' => 'Login successful',
            'user' => $user->only('name', 'username', 'email'),
            'token' => $token,
        ], 200);
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $user->currentAccessToken()->delete();
            return response()->json([
                "status" => true,
                "message" => "Logged out successfully",
            ]);
        }

        return response()->json([
            "status" => false,
            "message" => "No authenticated user found",
        ], 401);
    }

    public function profile(Request $request)
    {

        $user = Auth::guard('user_api')->user();
        if (empty($user)) {
            return response()->json([
                'status' => false,
                'status_code' => 401,
                'message' => 'User not authenticated'
            ], 401);
        }
        $user->load(['country:country_id,name', 'state:state_id,name', 'city:city_id,name']);
        return response()->json([
            'status' => true,
            'status_code' => 200,
            'message' => 'Profile photo path fetched successfully.',
            'data' => [

                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'phone_number' => $user->phone_number,
                'dob' => $user->dob,
                'gender' => $user->gender,
                'short_title' => $user->short_title,
                'short_description' => $user->short_description,
                'facebook' => $user->facebook,
                'instagram' => $user->instagram,
                'youtube' => $user->youtube,
                'twitter' => $user->twitter,
                'profile_photo_path' => empty($user->profile_photo_path) ? null : url($user->profile_photo_path) ,
                'country' => $user->country ? [
                    'id' => $user->country->country_id,
                    'name' => $user->country->name,
                ] : null,
                'state' => $user->state ? [
                    'id' => $user->state->state_id,
                    'name' => $user->state->name,
                ] : null,
                'city' => $user->city ? [
                    'id' => $user->city->city_id,
                    'name' => $user->city->name,
                ] : null,
            ],

        ], 200);
    }


    public function profileUpdate(Request $request)
    {
        $this->checkAuth();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'profile_desription' => 'nullable|string|max:500',
            'about' => 'nullable|string|max:1000',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'youtube' => 'nullable|url',
            'twitter' => 'nullable|url',
            'country_id' => 'required|exists:countries,country_id',
            'state_id' => 'required|exists:states,state_id',
            'city_id' => 'required|exists:cities,city_id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'data' => [],
            ], 200);
        }

        $user = Auth::guard('user_api')->user();
        $user->name = $request->name;
        $user->dob = $request->dob;
        $user->gender = $request->gender;
        $user->short_title = $request->profile_desription;
        $user->short_description = $request->about;
        $user->facebook = $request->facebook;
        $user->instagram = $request->instagram;
        $user->youtube = $request->youtube;
        $user->twitter = $request->twitter;
        $user->country_id = $request->country_id;
        $user->state_id = $request->state_id;
        $user->city_id = $request->city_id;
        $user->save();

        $user->load(['country:country_id,name', 'state:state_id,name', 'city:city_id,name']);

        return response()->json([
            'status' => true,
            'status_code' => 200,
            'message' => 'Profile updated successfully.',
            'data' => [ ],
        ], 200);
    }

    public function ProfilePhotoUpdate(Request $request)
    {
        $this->checkAuth();

        $validator = Validator::make($request->all(), [
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'profile_photo.required' => 'Please upload a profile photo.',
            'profile_photo.image' => 'The file must be a valid image.',
            'profile_photo.mimes' => 'Only jpeg, png, jpg and webp formats are allowed.',
            'profile_photo.max' => 'The image must not be larger than 2MB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first(),
                'data' => null,
            ], 200);
        }



        $user = Auth::guard('user_api')->user();

        try {
            $image = $request->file('profile_photo');
            $path = 'uploads/front/users';
            $storedPath = $image->store($path, 'public_root');

            $avifPath = ImageHelper::convertToAvif($storedPath, $path);

            if (!$avifPath) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Failed to convert image to AVIF format.',
                    'data' => null,
                ], 400);
            }
            $user->profile_photo_path = $avifPath;
            $user->save();
            $imageUrl = url($avifPath);

            return response()->json([
                'status' => 200,
                'message' => 'Profile photo updated successfully.',
                'data' => [
                    'image_url' => $imageUrl,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => 'Something went wrong while uploading the image.',
                'error' => $e->getMessage(),
            ], 400);
        }
    }
}
