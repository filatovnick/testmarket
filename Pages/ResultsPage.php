<?php

namespace Base\Pages;

use Facebook\WebDriver\WebDriverBy;

class ResultsPage extends Page
{
    private $resultsList = '.snippet-card__table>div>div>h3>a';
    public static $apple = 'Apple iPhone 7 128Gb';

    /**
     * @return string
     */
    public function getApple()
    {
        return $this->apple;
    }

    /**
     * @return string
     */
    public function getResultsList()
    {
        return $this->resultsList;
    }

    public function selectItem()
    {
        $items = $this->driver->findElements(WebDriverBy::cssSelector($this->getResultsList()));
        foreach ($items as $item) {
            $it = $item->getAttribute('title');
            if (self::$apple == $it) {
                $item->click();
                break;
            }

        }
    }

}
