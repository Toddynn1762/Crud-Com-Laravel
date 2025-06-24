<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    use HasFactory;

    protected $table = 'agendamentos';

    protected $fillable = [
        'cliente_id',
        'data',
        'hora',
    ];

    /**
     * Converte os campos de data para objetos Carbon automaticamente.
     */
    protected $casts = [
        'data' => 'date',
    ];

    public function cliente(){
    return $this->belongsTo(Cliente::class, 'cliente_id');
}

    public function servicos(){
        // Relação Muitos-para-Muitos
        return $this->belongsToMany(
            Servico::class,
            'agendamento_servico', // Nome da tabela pivot
            'agendamento_id',      // Chave estrangeira desta tabela
            'servico_id'           // Chave estrangeira da outra tabela
        );
    }
}