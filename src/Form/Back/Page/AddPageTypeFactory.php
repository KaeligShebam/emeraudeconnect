<?php
// src/Form/Back/Page/AddPageTypeFactory.php

namespace App\Form\Back\Page;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class AddPageTypeFactory
{
    private $formFactory;
    private $translator;
    private $yamlFilePath;

    public function __construct(FormFactoryInterface $formFactory, TranslatorInterface $translator, string $yamlFilePath)
    {
        $this->formFactory = $formFactory;
        $this->translator = $translator;
        $this->yamlFilePath = $yamlFilePath;
    }

    public function create()
    {
        return new AddPageType($this->formFactory, $this->translator, $this->yamlFilePath);
    }
}