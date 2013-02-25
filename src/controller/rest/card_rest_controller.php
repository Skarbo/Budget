<?php

class CardRestController extends CardentrytypeRestController
{

    // VARIABLES


    public static $CONTROLLER_NAME = "card";

    /**
     * @var CardValidator
     */
    private $cardValidator;

    // /VARIABLES


    // CONSTRUCTOR


    /**
     * @see RestController::__construct()
     */
    public function __construct( AbstractApi $api, AbstractView $view )
    {
        parent::__construct( $api, $view );

        $this->cardValidator = new CardValidator( $this->getLocale() );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see AbstractStandardRestController::getLastModified()
     */
    public function getLastModified()
    {
        return max( array ( parent::getLastModified(), filemtime( __FILE__ ) ) );
    }

    /**
     * @see AbstractStandardRestController::getModelPost()
     */
    protected function getModelPost()
    {
        $postObject = self::getPostObject();

        $card = CardFactoryModel::createCard( Core::arrayAt( $postObject, CardModel::TITLE ),
                Core::arrayAt( $postObject, CardModel::NUMBER ), Core::arrayAt( $postObject, CardModel::JOINT ) );

        $this->cardValidator->doValidate( $card );

        return $card;
    }

    /**
     * @see AbstractStandardRestController::getStandardDao()
     */
    protected function getStandardDao()
    {
        return $this->getDaoContainer()->getCardDao();
    }

    // /FUNCTIONS


}

?>