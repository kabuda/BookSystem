<?php

namespace App\Http\Controllers;

use App\Book;
use App\BookList;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Excel;
use Illuminate\Support\Facades\Auth;

class ExcelController extends Controller
{

    public function export($serialNumber)
    {
        $booklists = BookList::where('serialNumber', $serialNumber)->get();
        $file_name = $serialNumber;   //文件名是下载时间
        $cellData[] =['图书名称','作者','ISBN','单价','数量','总价','审核状态','发票号','录入时间'];
        foreach ($booklists as $key => $booklist) {
            $cellData[] = array(
                '图书名称' => $booklist->book()->book_author,
                '作者'   => $booklist->book()->book_author,
                'ISBN' => $booklist->book()->book_isbn,
                '单价'   => $booklist->book()->book_price,
                '数量'   => $booklist->book()->book_count,
                '总价'   => $booklist->book()->book_total_price,
                '审核状态' => $booklist->book()->readStatus(),
                '发票号'  => $booklist->book()->book_invNum,
                '录入时间' => $booklist->book()->created_at,
            );
        }
        Excel::create($file_name, function ($excel) use ($cellData) {
            $excel->sheet('sheet1', function ($sheet) use ($cellData) {
                $sheet->rows($cellData);
            });
        })->export('xls');
    }


    public function import(Request $request)
    {
        //$filePath = ''.iconv('UTF-8', 'GBK', 'text').'.xls';    //读取保存在laravel下的text.xls文件
        $file = $request->file('myfile');   //获取提交的文件，name为myfile
        if ($file) {
            $realPath = $file->getRealPath();
            $name = $file->getClientOriginalName();

//            $entension = $file->getClientOriginalExtension(); //上传文件的后缀.
            $filePath = $realPath.$name;
            $src = sprintf("%s.%s", $request->user()->id.random_int(0,99), $file->getClientOriginalExtension());
            $file->move('importExcel', $src);
            Excel::load('importExcel/'.$src, function ($reader) {

                //默认获取excel的第1张表
                $reader = $reader->getSheet(0);
                //获取表中的数据
                $data = $reader->toArray();
                //插入数据库
                $result = $this->insert_table($data);
                return ($result);
//                return back();
                //dd($data);
            });
        }
        return back();
    }

    public function insert_table($arr_field)
    {
        $data = $arr_field;
        //$value_str= array();

        foreach ($data as $key => $value) {
            if ($key != 0) {
                $content = implode(",", $value);
                $content2 = explode(",", $content);
                $book_name = $content2[0];//名字
                $book_price = $content2[1];//价格
                $book_author = $content2[2];//作者
                $book_count = $content2[3];//数量
                $book_isbn = $content2[4];//ISBN
                $book_total_price = $content2[5];//总价
                $book_invNum = $content2[6];//发票号

//                DB::insert("insert into books /*################不知道数据表名################*/ (book_name,book_price,book_author,book_count,book_isbn,book_total_price,book_invNum)
//                values (?,?,?,?,?,?,?",[$book_name,$book_price,$book_author,$book_count,$book_isbn,$book_total_price,$book_invNum]);

                Auth::user()->books()->create(compact(['book_name', 'book_price', 'book_author', 'book_count', 'book_isbn', 'book_total_price', 'book_invNum']));
            }
        }
        return 1;
    }
}
