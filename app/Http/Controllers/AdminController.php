<?php

namespace App\Http\Controllers;

use App\Book;
use App\BookList;
use App\Checklist;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    protected $admin;

    public function __construct()
    {
        $this->middleware('auth');
        $this->admin = Auth::user();
    }

    public function index()
    {
        return view('admin.index');
    }

    public function showCheckedList()
    {
//        $booklists = BookList::where('status', 1)->get();
        $checklists = Checklist::where('status', '>', 0)->get();
        return view('admin.checked', compact('checklists'));
    }

    public function showUncheckedList()
    {
        $booklists = BookList::where('status', 1)->groupBy('serialNumber')->get();
//        $checklists = Checklist::where('status',0)->get();
        return view('admin.uncheck', compact('booklists'));
    }

    public function showTheCheckList($serialNumber)
    {
        $b = BookList::where('serialNumber', $serialNumber)->first();
        $booklists = BookList::where('serialNumber', $serialNumber)->get();

        return view('admin.checking', compact(['booklists', 'b']));
    }

    public function checkTheList($serialNumber)
    {
        $checklist = $this->admin->checklists()->create([
            'serialNumber' => $serialNumber,
            'status'       => 1
        ]);

        $booklists = $this->admin->booklists()->where('status', 1)->get();
        foreach ($booklists as $booklist) {

            $booklist->book()->update([
                'status' => 3
            ]);
            $booklist->status = 3;
            $booklist->save();
        }

        return $checklist ? redirect('/admin') : back();
    }

    public function rejectTheList($serialNumber)
    {
        $checklist = $this->admin->checklists()->create([
            'serialNumber' => $serialNumber,
            'status'       => 2
        ]);

        $booklists = BookList::where('serialNumber', $serialNumber)->get();
        foreach ($booklists as $booklist) {
            $booklist->book()->update([
                'status' => 2
            ]);

            $booklist->status = 2;
            $booklist->save();
        }

        return $checklist ? redirect('/admin') : back();
    }

    public function getTheBookList($serialNumber)
    {
        $b = BookList::where('serialNumber', $serialNumber)->first();
        $booklists = BookList::where('serialNumber', $serialNumber)->get();

        return view('admin.pass', compact(['booklists', 'b']));
    }

}
