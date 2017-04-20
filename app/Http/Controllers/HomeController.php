<?php

namespace App\Http\Controllers;

use App\Book;
use App\BookList;
use App\User;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    protected $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->user = Auth::user();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return redirect('/book');
    }

    /*
     * Show the add book page
     * 显示添加图书页面
     */
    public function showAddBook()
    {
        $books = $this->user->getBooks();
        if ($books == null) {
            return view('welcome');
        } else {
            return view('welcome', compact('books'));
        }
    }

    /*
     *Add a new book
     */
    public function addBook(Request $request)
    {
//        dd($request);
        $amount = $request->input('book_count');
        $total_price = $request->input('book_price') * $amount;
        $book = $request->user()->books()->create([
            'book_name'        => $request->input('book_name'),
            'book_price'       => $request->input('book_price'),
            'book_author'      => $request->input('book_author'),
            'book_count'       => $amount,
            'book_isbn'        => $request->input('book_isbn'),
            'book_total_price' => $total_price,
            'book_invNum'      => $request->input('book_invNum')
        ]);
        return redirect('/book');

    }

    /*
     * show the update page
     *
     */
    public function showUpdateBook(Book $book)
    {
        $books = $this->user->getBooks();
        $b = Auth::user()->books()->find($book->id);
        return view('editbook', compact('books', 'b'));
    }

    /*
     * Update the book
     */
    public function updateBook(Book $book, Request $request)
    {
        $amount = $request->input('book_count');
        $total_price = $request->input('book_price') * $amount;

        return $book->update([
            'book_name'        => $request->input('book_name'),
            'book_price'       => $request->input('book_price'),
            'book_author'      => $request->input('book_author'),
            'book_count'       => $amount,
            'book_isbn'        => $request->input('book_isbn'),
            'book_total_price' => $total_price,
            'book_invNum'      => $request->input('book_invNum'),
            'status'           => 0
        ]) ? redirect('/')->with([
            'status'  => 'success',
            'message' => 'Successfully updated'
        ]) : back()->with([
            'status'  => 'error',
            'message' => 'An error occurred while updating'
        ]);
    }

    /*
     * delete the book
     */
    public function deleteBook(Book $book)
    {
        return $book->delete() ? [
            'status'  => 'success',
            'message' => 'Successfully deleted book'
        ] : [
            'status'  => 'error',
            'message' => 'An error occurred while deleting'
        ];
    }

    public function getUpload()
    {
        $books = $this->user->getBooks();
        return view('upload', compact('books'));
    }

    public function createBookList()
    {
        $books = $this->user->getBooks();
        $serialNumber = $this->makeSerialNumber();
        foreach ($books as $book) {

            Auth::user()->booklists()->create([
                'serialNumber' => $serialNumber,
                'book_id'      => $book->id,
                'status'       => 1
            ]);
            $book->update(['status' => 1]);
        }
        return redirect('/book');
    }

    public function showUpdateBooklist($serialNumber)
    {
        $b = BookList::where('serialNumber', $serialNumber)->first();
        $booklists = $this->getUploadBooks($serialNumber);

        foreach ($booklists as $booklist) {
            $booklist->book()->update([
                'status' => 0
            ]);
        }

        return redirect('/book')->with(compact('b'));
    }

    public function showHistory()
    {
        $booklists = $this->user->booklists()->groupBy('serialNumber')->orderBy('id', 'desc')->get();

        return view('history', compact('booklists'));
    }

    public function getCheckedBooks()
    {
        $booklists = $this->user->booklists()->where('status', '>', 1)->groupBy('serialNumber')->orderBy('id', 'desc')->get();
        return $booklists;
    }

    public function getUnpassBooks()
    {
        $booklists = $this->user->booklists()->where('status', 1)->groupBy('serialNumber')->orderBy('id', 'desc')->get();
        return $booklists;
    }


    public function showDetail($serialNumber)
    {
        $info = BookList::where('serialNumber', $serialNumber)->first();
        $booklists = BookList::where('serialNumber', $serialNumber)->get();


        $total = 0.0;
        $invNum=null;
        foreach ($booklists as $booklist) {
            $total += $booklist->book()->book_total_price;
            $invNum .=$booklist->book()->book_invNum.' , ';
        }
        $total=sprintf("%.2f", $total);
        $cny = $this->cny($total);

        return view('detail', compact(['info', 'booklists', 'total', 'cny','invNum']));

    }


    /*
    *   生成流水号
    */
    public function makeSerialNumber()
    {
        $time = (string)((int)(Carbon::now()->format("Ymd")) - 20000000);
        $random = (string)random_int(10, 99);
        $serial_number = $time . $random;
        if (is_null(\App\BookList::where('serialNumber', $serial_number)->first())) {
            return $serial_number;
        } else {
            return $this->makeSerialNumber();
        }
    }


    public function getUploadBooks($serialNumber)
    {
        return BookList::where('serialNumber', $serialNumber)->get();
    }

    /*
     * 人民币写法
     */
    function _cny_map_unit($list, $units)
    {
        $ul = count($units);
        $xs = array();
        foreach (array_reverse($list) as $x) {
            $l = count($xs);
            if ($x != "0" || !($l % 4)) $n = ($x == '0' ? '' : $x) . (isset($units[($l - 1) % $ul]) ? $units[($l - 1) % $ul] : '');
            //之前为if ($x!="0" || !($l%4)) $n=($x=='0'?'':$x).($units[($l-1)%$ul]);
            else $n = is_numeric($xs[0][0]) ? $x : '';
            array_unshift($xs, $n);
        }
        return $xs;
    }


    /*
     * 人民币大写
     */
    function cny($ns)
    {
        static $cnums = array("零", "壹", "贰", "叁", "肆", "伍", "陆", "柒", "捌", "玖"),
        $cnyunits = array("圆", "角", "分"),
        $grees = array("拾", "佰", "仟", "万", "拾", "佰", "仟", "亿");
        list($ns1, $ns2) = explode(".", $ns, 2);
        $ns2 = str_split($ns2);//此处为新增
        if (isset($ns2[1]))
            $ns2 = array_filter(array($ns2[1], $ns2[0]));
        else
            $ns2 = array_filter(array($ns2[0]));
        //之前为$ns2=array_filter(array($ns2[1],$ns2[0]));
        $ret = array_merge($ns2, array(implode("", $this->_cny_map_unit(str_split($ns1), $grees)), ""));
        $ret = implode("", array_reverse($this->_cny_map_unit($ret, $cnyunits)));
        $out = str_replace(array_keys($cnums), $cnums, $ret);
        if ($ns == round($ns)) $out .= "整";
        return $out;
    }

}

