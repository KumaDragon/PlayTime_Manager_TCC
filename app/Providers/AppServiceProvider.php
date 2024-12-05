<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Validação personalizada para CPF
        Validator::extend('cpf', function ($attribute, $value, $parameters, $validator) {
            return $this->isValidCpf($value);
        });
    }

    protected function isValidCpf($cpf)
{
    // Lógica para validação do CPF
    // Remover caracteres não numéricos
    $cpf = preg_replace('/\D/', '', $cpf);

    // Verificar se o CPF tem 11 caracteres
    if (strlen($cpf) != 11) {
        return false;
    }

    // CPF inválido (validação simples de dígitos repetidos como 111.111.111-11)
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Validação dos dígitos verificadores
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }

    return true;
}
}
