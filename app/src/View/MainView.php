<?php
declare(strict_types=1);

namespace App\View;

use App\Auth\Session;

class MainView
{
    public static function render(Header $header, ArticleListView $articleListView): string
    {
        $html = '';
        if (Session::has(Session::USER_ID_KEY)) {
            $html .= $header->renderLogout();
        } else {
            $html .= $header->renderLogin();
        }
        $html .= $articleListView->render();
        return $html;
    }
}
