<?php

namespace App\Domain\Room;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property int $capacity
 */
class Room extends Model
{

  use HasUuids;
  use HasFactory;

  protected $fillable = [
    'capacity'
  ];

  public function decreaseCapacity() : void
  {
      throw_if($this->capacity < 1, new \Exception());
      $this->capacity --;
  }
}
