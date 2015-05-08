<?php

/**
 * Lion-specific selectors.
 *
 * @package    core
 * @category   test
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Lion selectors manager.
 *
 */
class behat_selectors {

    /**
     * @var Allowed types when using text selectors arguments.
     */
    protected static $allowedtextselectors = array(
        'activity' => 'activity',
        'block' => 'block',
        'css_element' => 'css_element',
        'dialogue' => 'dialogue',
        'fieldset' => 'fieldset',
        'list_item' => 'list_item',
        'question' => 'question',
        'region' => 'region',
        'section' => 'section',
        'table' => 'table',
        'table_row' => 'table_row',
        'xpath_element' => 'xpath_element',
    );

    /**
     * @var Allowed types when using selector arguments.
     */
    protected static $allowedselectors = array(
        'activity' => 'activity',
        'block' => 'block',
        'button' => 'button',
        'checkbox' => 'checkbox',
        'css_element' => 'css_element',
        'dialogue' => 'dialogue',
        'field' => 'field',
        'fieldset' => 'fieldset',
        'file' => 'file',
        'filemanager' => 'filemanager',
        'link' => 'link',
        'link_or_button' => 'link_or_button',
        'list_item' => 'list_item',
        'optgroup' => 'optgroup',
        'option' => 'option',
        'question' => 'question',
        'radio' => 'radio',
        'region' => 'region',
        'section' => 'section',
        'select' => 'select',
        'table' => 'table',
        'table_row' => 'table_row',
        'text' => 'text',
        'xpath_element' => 'xpath_element'
    );

    /**
     * Behat by default comes with XPath, CSS and named selectors,
     * named selectors are a mapping between names (like button) and
     * xpaths that represents that names and includes a placeholder that
     * will be replaced by the locator. These are Lion's own xpaths.
     *
     * @var XPaths for lion elements.
     */
    protected static $lionselectors = array(
        'activity' => <<<XPATH
.//li[contains(concat(' ', normalize-space(@class), ' '), ' activity ')][normalize-space(.) = %locator% ]
XPATH
        , 'block' => <<<XPATH
.//div[contains(concat(' ', normalize-space(@class), ' '), ' block ') and
    (contains(concat(' ', normalize-space(@class), ' '), concat(' ', %locator%, ' ')) or
     descendant::h2[normalize-space(.) = %locator%] or
     @aria-label = %locator%)]
XPATH
        , 'dialogue' => <<<XPATH
.//div[contains(concat(' ', normalize-space(@class), ' '), ' lion-dialogue ') and
    normalize-space(descendant::div[
        contains(concat(' ', normalize-space(@class), ' '), ' lion-dialogue-hd ')
        ]) = %locator%] |
.//div[contains(concat(' ', normalize-space(@class), ' '), ' yui-dialog ') and
    normalize-space(descendant::div[@class='hd']) = %locator%]
XPATH
        , 'filemanager' => <<<XPATH
.//div[contains(concat(' ', normalize-space(@class), ' '), ' ffilemanager ')]
    /descendant::input[@id = //label[contains(normalize-space(string(.)), %locator%)]/@for]
XPATH
        , 'list_item' => <<<XPATH
.//li[contains(normalize-space(.), %locator%) and not(.//li[contains(normalize-space(.), %locator%)])]
XPATH
        , 'question' => <<<XPATH
.//div[contains(concat(' ', normalize-space(@class), ' '), ' que ')]
    [contains(div[@class='content']/div[@class='formulation'], %locator%)]
XPATH
        , 'region' => <<<XPATH
.//*[self::div | self::section | self::aside | self::header | self::footer][./@id = %locator%]
XPATH
        , 'section' => <<<XPATH
.//li[contains(concat(' ', normalize-space(@class), ' '), ' section ')][./descendant::*[self::h3]
    [normalize-space(.) = %locator%][contains(concat(' ', normalize-space(@class), ' '), ' sectionname ') or
    contains(concat(' ', normalize-space(@class), ' '), ' section-title ')]] |
.//div[contains(concat(' ', normalize-space(@class), ' '), ' sitetopic ')]
    [./descendant::*[self::h2][normalize-space(.) = %locator%] or %locator% = 'frontpage']
XPATH
        , 'table' => <<<XPATH
.//table[(./@id = %locator% or contains(.//caption, %locator%) or contains(concat(' ', normalize-space(@class), ' '), %locator% ))]
XPATH
        , 'table_row' => <<<XPATH
.//tr[contains(normalize-space(.), %locator%) and not(.//tr[contains(normalize-space(.), %locator%)])]
XPATH
        , 'text' => <<<XPATH
.//*[contains(., %locator%) and not(.//*[contains(., %locator%)])]
XPATH
    );

    /**
     * Returns the behat selector and locator for a given lion selector and locator
     *
     * @param string $selectortype The lion selector type, which includes lion selectors
     * @param string $element The locator we look for in that kind of selector
     * @param Session $session The Mink opened session
     * @return array Contains the selector and the locator expected by Mink.
     */
    public static function get_behat_selector($selectortype, $element, Behat\Mink\Session $session) {

        // CSS and XPath selectors locator is one single argument.
        if ($selectortype == 'css_element' || $selectortype == 'xpath_element') {
            $selector = str_replace('_element', '', $selectortype);
            $locator = $element;
        } else {
            // Named selectors uses arrays as locators including the type of named selector.
            $locator = array($selectortype, $session->getSelectorsHandler()->xpathLiteral($element));
            $selector = 'named';
        }

        return array($selector, $locator);
    }

    /**
     * Adds lion selectors as behat named selectors.
     *
     * @param Session $session The mink session
     * @return void
     */
    public static function register_lion_selectors(Behat\Mink\Session $session) {

        foreach (self::get_lion_selectors() as $name => $xpath) {
            $session->getSelectorsHandler()->getSelector('named')->registerNamedXpath($name, $xpath);
        }
    }

    /**
     * Allowed selectors getter.
     *
     * @return array
     */
    public static function get_allowed_selectors() {
        return self::$allowedselectors;
    }

    /**
     * Allowed text selectors getter.
     *
     * @return array
     */
    public static function get_allowed_text_selectors() {
        return self::$allowedtextselectors;
    }

    /**
     * Lion selectors attribute accessor.
     *
     * @return array
     */
    protected static function get_lion_selectors() {
        return self::$lionselectors;
    }
}
