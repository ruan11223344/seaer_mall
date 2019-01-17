<?php

namespace Modules\Mall\Entities;
use Cmgmyr\Messenger\Models\Participant;


class InquiryParticipants extends Participant
{
    protected $fillable = ['thread_id', 'user_id', 'last_read','extends'];
}
