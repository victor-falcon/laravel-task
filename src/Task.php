<?php

declare(strict_types=1);

namespace VictorFalcon\LaravelTask;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Auth\User;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class Task
{
    public ?User $user = null;
    public array $data;

    protected string $redirect;
    protected string $redirectRoute;
    protected string $redirectAction;
    protected string $errorBag = 'default';

    public function user(): User
    {
        return $this->user ?? Auth::user();
    }

    public function withUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function rules(): array
    {
        return [];
    }

    public function messages(): array
    {
        return [];
    }

    public function customAttributes(): array
    {
        return [];
    }

    public function validated(array $data): void
    {
        $this->data = $data;
    }

    public function validationError(Validator $validator): void
    {
        throw (new ValidationException($validator))
                ->errorBag($this->errorBag ?? 'default')
                ->redirectTo($this->getRedirectUrl());
    }

    protected function getRedirectUrl(): string
    {
        $url = app(Redirector::class)->getUrlGenerator();

        if (isset($this->redirect)) {
            return $url->to($this->redirect);
        }

        if (isset($this->redirectRoute)) {
            return $url->route($this->redirectRoute);
        }

        if (isset($this->redirectAction)) {
            return $url->action($this->redirectAction);
        }

        return $url->previous();
    }
}
