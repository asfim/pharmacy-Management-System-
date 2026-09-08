<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * 
 * @property int $id
 * @property string|null $sku
 * @property string|null $barcode
 * @property string $name
 * @property int|null $generic_id
 * @property int|null $brand_id
 * @property int|null $manufacturer_id
 * @property int|null $category_id
 * @property int|null $sub_category_id
 * @property int|null $unit_id
 * @property string|null $medicine_type
 * @property string|null $strength
 * @property string|null $dosage_form
 * @property string|null $pack_size
 * @property float $purchase_price
 * @property float $sale_price
 * @property float $wholesale_price
 * @property float $mrp
 * @property float $tax
 * @property float $discount
 * @property int $min_stock
 * @property int $reorder_level
 * @property bool $prescription_required
 * @property string|null $description
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Brand|null $brand
 * @property Category|null $category
 * @property Generic|null $generic
 * @property Manufacturer|null $manufacturer
 * @property SubCategory|null $sub_category
 * @property Unit|null $unit
 * @property Collection|Batch[] $batches
 * @property Collection|DamageWastage[] $damage_wastages
 * @property Collection|OrderItem[] $order_items
 * @property Collection|PrescriptionItem[] $prescription_items
 * @property Collection|ProductImage[] $product_images
 * @property Collection|ProductReview[] $product_reviews
 * @property Collection|PurchaseItem[] $purchase_items
 * @property Collection|PurchaseReturnItem[] $purchase_return_items
 * @property Collection|ReturnItem[] $return_items
 * @property Collection|SaleItem[] $sale_items
 * @property Collection|SalesReturnItem[] $sales_return_items
 * @property Collection|StockAdjustmentItem[] $stock_adjustment_items
 * @property Collection|StockBalance[] $stock_balances
 * @property Collection|StockLedger[] $stock_ledgers
 * @property Collection|StockTransferItem[] $stock_transfer_items
 * @property Collection|Wishlist[] $wishlists
 *
 * @package App\Models
 */
class Product extends Model
{
	protected $table = 'products';

	protected $casts = [
		'generic_id' => 'int',
		'brand_id' => 'int',
		'manufacturer_id' => 'int',
		'category_id' => 'int',
		'sub_category_id' => 'int',
		'unit_id' => 'int',
		'purchase_price' => 'float',
		'sale_price' => 'float',
		'wholesale_price' => 'float',
		'mrp' => 'float',
		'tax' => 'float',
		'discount' => 'float',
		'min_stock' => 'int',
		'reorder_level' => 'int',
		'prescription_required' => 'bool'
	];

	protected $fillable = [
		'sku',
		'barcode',
		'name',
		'generic_id',
		'brand_id',
		'manufacturer_id',
		'category_id',
		'sub_category_id',
		'unit_id',
		'medicine_type',
		'strength',
		'dosage_form',
		'pack_size',
		'purchase_price',
		'sale_price',
		'wholesale_price',
		'mrp',
		'tax',
		'discount',
		'min_stock',
		'reorder_level',
		'prescription_required',
		'description',
		'status'
	];

	public function brand()
	{
		return $this->belongsTo(Brand::class);
	}

	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function generic()
	{
		return $this->belongsTo(Generic::class);
	}

	public function manufacturer()
	{
		return $this->belongsTo(Manufacturer::class);
	}

	public function sub_category()
	{
		return $this->belongsTo(SubCategory::class);
	}

	public function unit()
	{
		return $this->belongsTo(Unit::class);
	}

	public function batches()
	{
		return $this->hasMany(Batch::class);
	}

	public function activeBatches()
	{
		return $this->hasMany(Batch::class)->where('quantity', '>', 0);
	}

	public function damage_wastages()
	{
		return $this->hasMany(DamageWastage::class);
	}

	public function order_items()
	{
		return $this->hasMany(OrderItem::class);
	}

	public function prescription_items()
	{
		return $this->hasMany(PrescriptionItem::class);
	}

	public function product_images()
	{
		return $this->hasMany(ProductImage::class);
	}

	public function product_reviews()
	{
		return $this->hasMany(ProductReview::class);
	}

	public function purchase_items()
	{
		return $this->hasMany(PurchaseItem::class);
	}

	public function purchase_return_items()
	{
		return $this->hasMany(PurchaseReturnItem::class);
	}

	public function return_items()
	{
		return $this->hasMany(ReturnItem::class);
	}

	public function sale_items()
	{
		return $this->hasMany(SaleItem::class);
	}

	public function sales_return_items()
	{
		return $this->hasMany(SalesReturnItem::class);
	}

	public function stock_adjustment_items()
	{
		return $this->hasMany(StockAdjustmentItem::class);
	}

	public function stock_balances()
	{
		return $this->hasMany(StockBalance::class);
	}

	public function stock_ledgers()
	{
		return $this->hasMany(StockLedger::class);
	}

	public function stock_transfer_items()
	{
		return $this->hasMany(StockTransferItem::class);
	}

	public function wishlists()
	{
		return $this->hasMany(Wishlist::class);
	}
}
