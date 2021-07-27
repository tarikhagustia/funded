<?php

namespace App\Http\Controllers\Af;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Af;

class TreeviewController extends Controller
{
    public function index()
    {
        $query = Af::descendantsAndSelf(auth()->id());
        $tree = $query->toTree();

        ob_start();
        $traverse = function ($tree, $prefix = '-') use (&$traverse) {
            foreach ($tree as $category) {
                echo "<ul>";
                echo "<li style='display: list-item;'>";
                echo "<a href='#' data-toggle='modal' data-account='{$category->account}' class='detail-member' data-target='#modalDetail'>{$category->agentname}</a>";
                if ($category->hasChildren()) {
                    $traverse($category->children, $prefix.'-');
                    echo "</li>";
                } else {
                    echo "</li>";
                }
                echo "</ul>";
            }
        };

        $traverse($tree);
        $trees = ob_get_clean();
        return view('af.members.treeview', compact('trees'));
    }
}
