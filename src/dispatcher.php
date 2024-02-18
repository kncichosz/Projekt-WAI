<?php

function dispatch($routingTab, $action)
{
    $controller_name = $routingTab[$action];

    $model = [];
    $view_name = $controller_name($model);

    build_response($view_name, $model);
}

function build_response($view, $model)
{

    if (strpos($view, 'redirect:') === 0) {
        $url = substr($view, strlen('redirect:'));
        header("Location: " . $url);
        exit;

    } else {
        render($view, $model);
    }
}

function render($view_name, $model)
{
    global $routingTab;
    extract($model);
    
    include 'views/' . $view_name . '.php';
}
