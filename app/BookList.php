<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BookList extends Model
{
    protected $fillable = [
        'serialNumber', 'book_id', 'status'
    ];

    public function getCurrentBooklist()
    {
        return BookList::where('serialNumber', $this->serialNumber)->get();
    }

    public function book()
    {
        return Book::where('id',$this->book_id)->first();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function readStatus()
    {
        switch ($this->status) {
            case 0:
                return "未提交";
                break;
            case 1:
                return "未审核";
                break;
            case 2:
                return "被撤回";
                break;
            case 3:
                return "已通过";
                break;
            default:
                break;
        }

    }

}
