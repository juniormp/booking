<?php

namespace App\Domain\Booking;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;

/**
 * @property string $id
 * @property string $roomId
 * @property Date $startsAt
 * @property Date $endsAt
 */
class Block extends Model
{

  use HasUuids;

  protected $fillable = [
    'room_id',
    'starts_at',
    'ends_at'
  ];
}
