<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
            'role_id' => ['required', 'integer', 'exists:roles,id']
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt(['username' => $this->input('username'), 'password' => $this->input('password')], $this->boolean('remember'))) {
            if (! Auth::attempt(['email' => $this->input('username'), 'password' => $this->input('password')], $this->boolean('remember'))) {
                RateLimiter::hit($this->throttleKey());

                throw ValidationException::withMessages([
                    'username' => trans('auth.failed'),
                ]);
            }
        }

        $request_role = request()->role_id;
        $user = Auth::user();
        $user_role = $user->role_id;

        if($user->is_deleted){
            $this->throw_error(['username' => "Requested user account does not exist or been deleted"]);
        }elseif($request_role == 3){
            if($user_role > 3 && $user_role <= 5){
                $this->throw_error(['role_id' => "Requested user is not bound to this login type"]);
            }
        }elseif($request_role > 3 && $request_role <= 5){
            if($user_role != intval($request_role)){
                $this->throw_error(['role_id' => "Requested user is not bound to this login type"]);
            }
        }elseif($user->is_active === false){
            $this->throw_error(["role_id" => "Requested account has been deactivated. Contact admin for help"]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'username' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('username')).'|'.$this->ip());
    }

    /**
     * Throws an exception to the frontend
     */
    private function throw_error(array $messages){
        RateLimiter::hit($this->throttleKey());

        Auth::guard('web')->logout();

        throw ValidationException::withMessages($messages);
    }
}
