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
}
