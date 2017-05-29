<?php 

namespace App\Extensions\Logs;

class UserLog extends DoctrineLogHandler
{
	protected $table = 'user_log';
	protected $addColumn = ['user_id'];
}