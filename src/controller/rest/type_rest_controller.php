<?php

class TypeRestController extends CardentrytypeRestController
{

    // VARIABLES


    public static $CONTROLLER_NAME = "type";

    /**
     * @var TypeValidator
     */
    private $typeValidator;

    // /VARIABLES


    // CONSTRUCTOR


    /**
     * @see RestController::__construct()
     */
    public function __construct( AbstractApi $api, AbstractView $view )
    {
        parent::__construct( $api, $view );

        $this->typeValidator = new TypeValidator( $this->getLocale() );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see RestController::getLastModified()
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

        $type = TypeFactoryModel::createType( Core::arrayAt( $postObject, TypeModel::TITLE ) );
        $match = preg_match( Validator::$REGEX_TITLE, $type->getTitle(), $matches );

        $this->typeValidator->doValidate( $type );

        return $type;
    }

    /**
     * @see AbstractStandardRestController::getStandardDao()
     */
    protected function getStandardDao()
    {
        return $this->getDaoContainer()->getTypeDao();
    }

    // /FUNCTIONS


}

?>