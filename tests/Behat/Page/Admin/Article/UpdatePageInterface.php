<?php

namespace Tests\Odiseo\SyliusBlogPlugin\Behat\Page\Admin\Article;

use Sylius\Behat\Page\Admin\Crud\UpdatePageInterface as BaseUpdatePageInterface;
use Tests\Odiseo\SyliusBlogPlugin\Behat\Behaviour\ContainsErrorInterface;

interface UpdatePageInterface extends BaseUpdatePageInterface, ContainsErrorInterface
{
    /**
     * @param string $code
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function fillCode($code);

    /**
     * @param string $slug
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function fillSlug($slug);

    /**
     * @param string $title
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function fillTitle($title);

    /**
     * @param string $content
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function fillContent($content);
}