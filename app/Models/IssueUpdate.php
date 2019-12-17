<?php namespace Muhit\Models;

use Illuminate\Database\Eloquent\Model;

class IssueUpdate extends \Eloquent
{
   protected $hidden = [
        'issue_id',
        'updated_at',
   ];
}
