<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    /**
     * Informa ao Laravel o nome da nossa tabela em português.
     */
    protected $table = 'clientes';

    /**
     * Define os campos que podem ser preenchidos em massa.
     */
    protected $fillable = [
        'nome',
        'telefone',
        'email',
    ];

        public function agendamentos(){
            return $this->hasMany(Agendamento::class, 'cliente_id');
        }
}