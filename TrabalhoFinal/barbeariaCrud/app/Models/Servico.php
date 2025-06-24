<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    use HasFactory;

    protected $table = 'servicos';

    protected $fillable = [
        'nome',
        'preco',
    ];

        public function agendamentos(){
        return $this->belongsToMany(
            Agendamento::class,
            'agendamento_servico',
            'servico_id',
            'agendamento_id'
        );
    }
}