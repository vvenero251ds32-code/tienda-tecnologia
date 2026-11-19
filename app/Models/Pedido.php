<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';

    protected $fillable = [
        'user_id', 'direccion_id', 'subtotal', 'descuento_total',
        'costo_envio', 'impuestos', 'tasa_impuesto', 'total',
        'estado', 'numero_comprobante', 'empresa_envio', 'codigo_seguimiento',
        'pagado_en', 'enviado_en', 'entregado_en', 'cancelado_en',
        'comprobante_anulado_en',
    ];

    protected function casts(): array
    {
        return [
            'subtotal'               => 'decimal:2',
            'descuento_total'        => 'decimal:2',
            'costo_envio'            => 'decimal:2',
            'impuestos'              => 'decimal:2',
            'tasa_impuesto'          => 'decimal:2',
            'total'                  => 'decimal:2',
            'pagado_en'              => 'datetime',
            'enviado_en'             => 'datetime',
            'entregado_en'           => 'datetime',
            'cancelado_en'           => 'datetime',
            'comprobante_anulado_en' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function direccion(): BelongsTo
    {
        return $this->belongsTo(Direccion::class)->withTrashed();
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(PedidoDetalle::class);
    }

    public function pagos(): HasMany
    {
        return $this->hasMany(Pago::class);
    }
}