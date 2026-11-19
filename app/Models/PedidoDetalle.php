<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PedidoDetalle extends Model
{
    use HasFactory;

    protected $table = 'pedido_detalles';

    protected $fillable = [
        'pedido_id', 'producto_id', 'sku_producto', 'nombre_producto',
        'cantidad', 'precio_regular_unitario', 'precio_unitario_aplicado',
        'meses_garantia_aplicados', 'subtotal_linea',
    ];

    protected function casts(): array
    {
        return [
            'precio_regular_unitario'  => 'decimal:2',
            'precio_unitario_aplicado' => 'decimal:2',
            'subtotal_linea'           => 'decimal:2',
        ];
    }

    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class);
    }

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }
}