<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

      /**
     * @var string
     */
    protected $table = 'messages';
    protected $fillable = ['message', 'type_message', 'user_id', 'conversation_id'];

    const TYPE_MESSAGE_TEXT = 1;
    const TYPE_MESSAGE_FILE = 2;
    const TYPE_MESSAGE_EMOJI = 3;
    const CONVERSATION_PUBLIC = 0;
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
}
