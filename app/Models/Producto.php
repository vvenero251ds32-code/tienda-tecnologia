<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'categoria_id', 'marca_id', 'sku', 'nombre', 'modelo',
        'descripcion', 'especificaciones', 'meses_garantia',
        'precio_regular', 'precio_oferta', 'inicio_oferta',
        'fin_oferta', 'stock', 'imagen_path', 'activo',
    ];

    protected function casts(): array
    {
        return [
            'especificaciones' => 'array',
            'precio_regular'   => 'decimal:2',
            'precio_oferta'    => 'decimal:2',
            'inicio_oferta'    => 'datetime',
            'fin_oferta'       => 'datetime',
            'activo'           => 'boolean',
        ];
    }

    protected function precioVigente(): Attribute
    {
        return Attribute::get(function () {
            $ahora = now();
            $tieneOferta = $this->precio_oferta !== null
                && ($this->inicio_oferta === null || $ahora->gte($this->inicio_oferta))
                && ($this->fin_oferta === null || $ahora->lte($this->fin_oferta));

            return $tieneOferta ? $this->precio_oferta : $this->precio_regular;
        });
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function marca(): BelongsTo
    {
        return $this->belongsTo(Marca::class);
    }

    public function carritoDetalles(): HasMany
    {
        return $this->hasMany(CarritoDetalle::class);
    }

    public function pedidoDetalles(): HasMany
    {
        return $this->hasMany(PedidoDetalle::class);
    }

    public function resenas(): HasMany
    {
        return $this->hasMany(Resena::class);
    }
}