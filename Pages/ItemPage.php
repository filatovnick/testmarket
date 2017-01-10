<?php

namespace Base\Pages;

use Facebook\WebDriver\Exception\NoSuchElementException;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

class ItemPage extends Page
{
    private $costsLink = 'li[data-name="offers"]>a';
    private $checkboxBuyOnTheMarket = '#cpa';
    private $sortOfCost = '/html/body/div[1]/div[5]/div[1]/div[2]/div[1]/div[1]/div[3]';
    private $price = 'snippet-card__price i-bem snippet-card__price_js_inited>span>span';
    private $checkboxIncDelivery = '#includedelivery';
    private $addToCart = '//div[@class=\'n-offer-info__action\']/div[1]/div[2]/a';
    private $goToCart = '[class*="personal-basket"]';
    private $priceFirstSortElement = '/html/body/div[1]/div[5]/div[2]/div[1]/div[2]/div[1]/div[2]/div[1]/span/span';

    /**
     * @return string
     */
    public function getPriceFirstSortElement()
    {
        return $this->priceFirstSortElement;
    }

    /**
     * @return string
     */
    public function getCostsLink()
    {
        return $this->costsLink;
    }

    /**
     * @return string
     */
    public function getCheckboxBuyOnTheMarket()
    {
        return $this->checkboxBuyOnTheMarket;
    }

    /**
     * @return string
     */
    public function getSortOfCost()
    {
        return $this->sortOfCost;
    }

    /**
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getCheckboxIncDelivery()
    {
        return $this->checkboxIncDelivery;
    }

    /**
     * @return string
     */
    public function getAddToCart()
    {
        return $this->addToCart;
    }

    /**
     * @return string
     */
    public function getGoToCart()
    {
        return $this->goToCart;
    }

    public function selectItemsAvailableToOrder()
    {
        $this->driver->findElement(WebDriverBy::cssSelector($this->getCostsLink()))->click();
        $this->driver->wait(10, 500);
        $isSelectDelivery = $this->driver->findElement(WebDriverBy::cssSelector($this->getCheckboxIncDelivery()))->isSelected();
        if($isSelectDelivery == false){
            $this->driver->findElement(WebDriverBy::xpath($this->getSortOfCost()))->click();
        }

        $isSelectBuyOnMarket = $this->driver->findElement(WebDriverBy::cssSelector($this->getCheckboxBuyOnTheMarket()))->isSelected();
        if($isSelectBuyOnMarket == false){
            $this->driver->findElement(WebDriverBy::cssSelector($this->getCheckboxBuyOnTheMarket()))->click();
        }


    }
/*
    public function selectLowCostAndAddToCart()
    {
        $costs = $this->driver->findElements(WebDriverBy::cssSelector($this->getPrice()));
        foreach ($costs as $cost) {
            $costs_price = array();
            foreach ($costs as $key => $arr) {
                $costs_price[$key] = $arr['price'];
            }
            for ($i = 0; $i < 100000; $i++) {
                $costs_tmp = $costs;
                array_multisort($costs_price, SORT_NUMERIC, $costs_tmp);
            }
            $sortOfCost = $costs;
            if($sortOfCost[0] == $cost){
                $cost->click();
            }
        }
    }
*/
    public function selectLowCost()
    {
        // ждем когда элемент будет кликабельный
        $this->driver->wait(14, 500)->until(
            WebDriverExpectedCondition::elementToBeClickable(
                WebDriverBy::xpath($this->getPriceFirstSortElement())));
        // получаем массив цен
//        $costs = $this->driver->findElements(WebDriverBy::cssSelector($this->getPrice()));

        // берем первое (минимальное) значение стоимости, отсортированное по цене фильтром
        /*$firstItemPrice = */
        $this->driver->findElement(WebDriverBy::xpath($this->getPriceFirstSortElement()))->click();

//        $firstElementValue = $firstItemPrice->getText();
//
//        $sortedCosts = usort($costs, function($a, $b) {
//            if ($a == $b) {
//                return 0;
//            }
//            return ($a < $b) ? -1 : 1;
//        });
//        foreach ($costs as $key => $value){
//            if ($value == $sortedCosts[0] && $sortedCosts[0] == $firstElementValue){
//                $value->click();
//            }else{
//                $firstItemPrice->click();
//            }
//        }

    }
//
//        /*
//         foreach ($costs as $key => $value){
//            if ($value == min($costs)){
//                $value->click();
//            }
//        }
//        */
//        $sortedCosts = usort($costs, function($a, $b) {
//            if ($a == $b) {
//                return 0;
//            }
//            return ($a < $b) ? -1 : 1;
//        });
//
//        foreach ($costs as $price){
//            foreach ($sortedCosts as $sc){
//                $sc = preg_replace("/[^0-9]/", '', $sortedCosts);
//
//            }
//            $price = preg_replace("/[^0-9]/", '', $costs);
//            if($price == min($sc)) {
//                $price->click();
//            }
//
//        }


    public function addItemToCartAndOpenCart()
    {
        $this->driver->wait(10, 500)->until(
            WebDriverExpectedCondition::presenceOfElementLocated(
                WebDriverBy::xpath($this->getAddToCart())));
        $this->driver->findElement(WebDriverBy::xpath($this->getAddToCart()))->click();
        $this->driver->wait(10, 500)->until(
            WebDriverExpectedCondition::presenceOfElementLocated(
                WebDriverBy::cssSelector($this->getGoToCart())));
        $this->driver->findElement(WebDriverBy::cssSelector($this->getGoToCart()))->click();
    }



}
