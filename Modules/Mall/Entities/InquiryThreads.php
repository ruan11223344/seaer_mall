<?php

namespace Modules\Mall\Entities;
use Cmgmyr\Messenger\Models\Thread;


class InquiryThreads extends Thread
{
    protected $fillable = ['subject','extends'];
    protected $casts = ['extends' => 'array'];
}
