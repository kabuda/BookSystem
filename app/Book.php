<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable=[
        'book_name','book_price','book_author','book_count','book_isbn','book_total_price','book_invNum','status'
    ];


    public function readStatus()
    {
        switch ($this->status) {
            case 0:
                return "未提交";
                break;
            case 1:
                return "提交未审核";
                break;
            case 2:
                return "审核不通过";
                break;
            case 3:
                return "已审核通过";
                break;
            default:
                break;
        }
        return true;
    }
    
    /*
     * relation to User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
