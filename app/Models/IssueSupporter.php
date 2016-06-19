<?php

namespace Muhit\Models;

class IssueSupporter extends \Eloquent
{
	protected $guarded = ['id'];

	protected $fillable = [
		'issue_id',
		'user_id'
	];
}
