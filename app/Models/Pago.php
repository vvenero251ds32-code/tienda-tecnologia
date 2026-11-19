<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pago extends Model
{
    use HasFactory;

    protected $table = 'pagos';

    protected $fillable = [
        'pedido_id', 'confirmado_por', 'metodo', 'monto',
        'estado', 'referencia', 'pagado_en',
    ];

    protected function casts(): array
    {
        return [
            'monto'     => 'decimal:2',
            'pagado_en' => 'datetime',
        ];
    }

    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class);
    }

    public function validador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirmado_por');
    }
}