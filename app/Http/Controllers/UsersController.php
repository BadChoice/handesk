<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UpdateUser;
use App\RealWorld\Transformers\UserTransformer;

class UsersController extends ApiController
{
    /**
     * UserController constructor.
     *
     * @param UserTransformer $transformer
     */
    public function __construct(UserTransformer $transformer)
    {
        $this->transformer = $transformer;

        $this->middleware('auth.api');
    }

    /**
     * Get the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->respondWithTransformer(auth()->user());
    }

    /**
     * Update the authenticated user and return the user if successful.
     *
     * @param UpdateUser $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUser $request)
    {
        $user = auth()->user();

        if ($request->has('user')) {
            $user->update($request->get('user'));
        }

        return $this->respondWithTransformer($user);
    }
}
