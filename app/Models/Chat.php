<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chat extends Model
{
    use HasFactory, Uuids;

    protected $guarded = [];

    public function name(): Attribute
    {
        return Attribute::make(function ($val) {
            if ($this->type === 'private') {
                return $this->chat_users()->where('user_id', '!=', auth()->id())->first()->user->name;
            }

            return $val;
        });
    }

    public function chat_users(): HasMany
    {
        return $this->hasMany(ChatUser::class);
    }

    public function image(): Attribute
    {
        return Attribute::make(function ($value) {
            if ($this->type === 'private') {
                return $this->chat_users()->where('user_id', '!=', auth()->id())->first()->user->avatar_url;
            }

            return $value;
        });
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
