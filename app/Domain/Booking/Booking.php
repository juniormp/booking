<?php

namespace App\Domain\Booking;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;

/**
 * @property string $id
 * @property string $room_at
 * @property Date $starts_at
 * @property Date $ends_at
 */
class Booking extends Model
{

  use HasUuids;

  protected $fillable = [
    'room_id',
    'starts_at',
    'ends_at'
  ];
}
