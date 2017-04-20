<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'loginNumber', 'attributes'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /*
     * relation to books
     */
    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function getBooks()
    {
        return self::books()->where('status', 0)->get();
    }

    public function isAdmin()
    {
//        switch ($this->loginNumber) {
//            case '1400002116':
//                return "Admin";
//                break;
//            default:
//                return false;
//                break;
//        }

        if ($this->loginNumber == "1400002116") {
            return true;
        }
        return false;
    }


    public function booklists()
    {
        return $this->hasMany(BookList::class);
    }

    public function unuploadedBookList()
    {
        return BookList::where('user_id', $this->id)->where('status', 0)->get();
    }

    public function uploadedBookList()
    {
        return BookList::where('user_id', $this->id)->where('status', 1)->get();
    }

    public function checklists()
    {
        return $this->isAdmin() ? $this->hasMany(Checklist::class) : null;
    }

    public function uncheckedBooklists()
    {
        return $this->isAdmin() ? Checklist::where("user_id", 1)->where('status', 0)->get() : null;
    }

    public function checkedBooklists()
    {
        return $this->id == 1 ? Checklist::where("user_id", 1)->where('status', 1)->get() : null;
    }

    /**
     * Create or retrieve the user.
     *
     * @param $attr
     * @return static
     */
    public static function storeOrRetrieve($attr)
    {
        if ($user = self::where('loginNumber', $attr['login'])->first()) {
            return $user;
        } else {
            return false;
        }
//        return self::create([
//            'loginNumber' => $attr['login'],
//            'attributes'  => null
//        ]);
    }
}
