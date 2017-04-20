<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    protected $fillable=[
        'serialNumber','status','user_id'
    ];

    public function readStatus()
    {
        switch ($this->status) {
            case 0:
                return "未审核";
                break;
            case 1:
                return "审核通过";
                break;
            case 2:
                return "已撤回";
                break;
            default:
                break;
        }

        return true;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function applicant()
    {
        $booklist = BookList::where('serialNumber',$this->serialNumber)->first();
        return $booklist->user();
    }

    public function booklists()
    {
        return BookList::where('serialNumber',$this->serialNumber)->get();
    }
}
