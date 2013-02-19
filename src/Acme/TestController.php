<?php

namespace Acme;

class TestController extends Controller
{
    public function indexAction()
    {
        return $this->render('test/index.twig');
    }
}

