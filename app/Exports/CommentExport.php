<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class CommentExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    private $comments;

    function __construct($comments_collection){
        $this->comments = $comments_collection;
    }

    public function view(): View{
        return view('exports.comments_export', [ 'comment_list' => $this->comments ]);
    }
}
