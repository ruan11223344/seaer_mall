<?php

namespace Modules\Mall\Entities;
use Cmgmyr\Messenger\Models\Message;


class InquiryMessages extends Message
{
    protected $table = 'inquiry_messages';
    protected $fillable = ['thread_id', 'user_id', 'body','extends'];
    protected $casts = ['extends' => 'array'];
}


