<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PlayerDrafted implements ShouldBroadcast
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $message;
  public $draftStatus;

  public function __construct($message, $draftStatus)
  {
      $this->message = $message;
      $this->draftStatus = $draftStatus;
  }

  public function broadcastOn()
  {
      return ['draft-page'];
  }

  public function broadcastAs()
  {
      return 'player-drafted';
  }
}