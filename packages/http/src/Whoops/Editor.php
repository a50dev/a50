<?php

declare(strict_types=1);

namespace A50\Http\Whoops;

enum Editor: string
{
    case Emacs = 'emacs';
    case IDEA = 'idea';
    case MacVim = 'macvim';
    case PhpStorm = 'phpstorm';
    case SublimeText = 'sublime';
    case Textmate = 'textmate';
    case xdebug = 'xdebug';
    case VSCode = 'vscode';
    case Atom = 'atom';
    case Espresso = 'espresso';
    case Netbeans = 'netbeans';
}
