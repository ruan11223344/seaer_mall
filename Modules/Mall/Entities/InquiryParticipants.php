<?php

namespace Modules\Mall\Entities;
use Cmgmyr\Messenger\Models\Participant;


class InquiryParticipants extends Participant
{
    protected $table = 'inquiry_participants';

    protected $fillable = ['thread_id', 'user_id', 'last_read','extends'];
    protected $casts = ['extends' => 'array'];
}
