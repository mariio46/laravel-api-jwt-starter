<?php

namespace App\Contracts;

interface AuthContract
{
    /**
     * Register new user
     * 
     * @param array{name:string,email:string,password:string} $data
     * @return array{message:string}
     */
    public function register(array $data): array;

    /**
     * Register new user
     * 
     * @param array{email:string,password:string} $data
     * @return array{data:array{access_token:string,token_type:string,expires_in:int},message:string}
     */
    public function login(array $data): array;
}
