<?php
namespace Modules\Admin\Entities;
use Zizaco\Entrust\EntrustRole;
class Role extends EntrustRole
{
    protected $table = 'roles';

    protected $fillable = [
        'id',
        'name',
        'display_name',
        'description',
    ];
}