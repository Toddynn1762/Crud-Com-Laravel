<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes'; // Nome da tabela no banco de dados
    protected $primaryKey = 'cliente_id'; // Se sua chave primária não for 'id'

    // CORREÇÃO: Define que o modelo não usa as colunas created_at e updated_at
    // porque elas não existem na sua tabela 'clientes'.
    public $timestamps = false;

    // Campos que podem ser preenchidos via atribuição em massa (mass assignment)
    protected $fillable = [
        'nome_completo',
        'telefone',
        'email',
    ];
}
