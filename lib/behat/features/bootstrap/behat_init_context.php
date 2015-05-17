<?php


/**
 * Contexts initializer class
 *
 * @category   test
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

use Behat\Behat\Context\BehatContext,
    Behat\MinkExtension\Context\MinkContext,
    Lion\BehatExtension\Context\LionContext;

/**
 * Loads main subcontexts
 *
 * Loading of lion subcontexts is done by the Lion extension
 *
 * Renamed from behat FeatureContext class according
 * to Lion coding styles conventions
 *
 * @category   test
 */
class behat_init_context extends BehatContext {

    /**
     * Initializes subcontexts
     *
     * @param  array $parameters context parameters (set them up through behat.yml)
     * @return void
     */
    public function __construct(array $parameters) {
        $this->useContext('lion', new LionContext($parameters));
    }

}
