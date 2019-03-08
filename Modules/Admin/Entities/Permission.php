<?php
namespace Modules\Admin\Entities;
use Zizaco\Entrust\EntrustPermission;
class Permission extends EntrustPermission
{
    protected $table = 'permissions';

    protected $fillable = [
        'id',
        'name',
        'display_name',
        'description',
    ];
}