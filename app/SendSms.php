<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class SendSms extends Model
{
	protected $table = 'sms_log';

	protected $fillable = ['message','status','phone'];
}