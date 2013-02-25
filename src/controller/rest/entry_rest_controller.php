<?php

class EntryRestController extends CardentrytypeRestController
{

    // VARIABLES


    const COMMAND_MONTH = "month";
    const URI_BUDGET = 3;
    const URI_MONTH = 2;

    public static $CONTROLLER_NAME = "entry";

    public static $POST_FIELD_NEW = "_new";
    public static $POST_FIELD_TYPE_TITLE = "type_title";
    public static $POST_FIELD_CARD_TITLE = "card_title";
    public static $POST_FIELD_CARD_NUMBER = "card_number";

    /**
     * @var EntryValidator
     */
    private $entryValidator;
    /**
     * @var EntryHandler
     */
    private $entryHandler;

    // /VARIABLES


    // CONSTRUCTOR


    /**
     * @see RestController::__construct()
     */
    public function __construct( AbstractApi $api, AbstractView $view )
    {
        parent::__construct( $api, $view );

        $this->entryValidator = new EntryValidator( $this->getLocale() );
        $this->entryHandler = new EntryHandler( $this->getDaoContainer(), $this->entryValidator,
                new TypeValidator( $this->getLocale() ), new CardValidator( $this->getLocale() ) );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see CardentrytypeRestController::getLastModified()
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

        $entry = EntryFactoryModel::createEntry( Core::arrayAt( $postObject, EntryModel::COST ),
                Core::arrayAt( $postObject, EntryModel::TYPE ), Core::arrayAt( $postObject, EntryModel::CARD ),
                Core::arrayAt( $postObject, EntryModel::DATE ), Core::arrayAt( $postObject, EntryModel::COMMENT ),
                Core::arrayAt( $postObject, EntryModel::SINGLE ), Core::arrayAt( $postObject, EntryModel::CREDIT ) );

        $this->entryValidator->doValidate( $entry );

        return $entry;
    }

    /**
     * @see AbstractStandardRestController::getStandardDao()
     */
    protected function getStandardDao()
    {
        return $this->getDaoContainer()->getEntryDao();
    }

    public static function getUriMonth()
    {
        return self::getURI( self::URI_MONTH );
    }

    public static function getUriBudget()
    {
        return self::getURI( self::URI_BUDGET );
    }

    /**
     * @return array Array of new type card fields
     */
    private static function getNewTypeCardObject()
    {
        $object = self::getPostObject();
        $newTypeCard = array ();

        if ( Core::arrayAt( $object, EntryModel::TYPE ) == self::$POST_FIELD_NEW )
        {
            $newTypeCard[ EntryHandler::TYPE_TITLE ] = Core::arrayAt( $object, self::$POST_FIELD_TYPE_TITLE );
        }
        if ( Core::arrayAt( $object, EntryModel::CARD ) == self::$POST_FIELD_NEW )
        {
            $newTypeCard[ EntryHandler::CARD_TITLE ] = Core::arrayAt( $object, self::$POST_FIELD_CARD_TITLE );
            $newTypeCard[ EntryHandler::CARD_NUMBER ] = Core::arrayAt( $object, self::$POST_FIELD_CARD_NUMBER );
        }

        DebugHandler::doDebug( DebugHandler::LEVEL_LOW, new DebugException( "New type card object", $newTypeCard ) );

        return $object;
    }

    // ... /GET


    // ... IS


    public static function isGetMonthCommand()
    {
        return self::getUriCommand() == self::COMMAND_MONTH && self::getUriMonth();
    }

    // ... /IS


    // ... DO


    /**
     * @see AbstractStandardRestController::doAddModel()
     */
    protected function doAddModel( StandardModel $model, $foreignId )
    {
        return $this->entryHandler->handleNew( $this->getForeignModel()->getId(), $model,
                $this->getNewTypeCardObject() );
    }

    /**
     * @see AbstractStandardRestController::doEditModel()
     */
    protected function doEditModel( $id, StandardModel $model, $foreignId )
    {
        return $this->entryHandler->handleEdit( $this->getForeignModel()->getId(), $id, $model,
                $this->getNewTypeCardObject() );
    }

    private function doGetMonthCommand()
    {
        // BUDGET


        if ( self::getUriBudget() )
        {
            $this->setForeignModel(
                    $this->getForeignStandardDao()->getBudget( self::getUriBudget(), $this->getUser()->getId() ) );
        }
        else
        {
            $this->setForeignModelList( $this->getForeignStandardDao()->getBudgets( $this->getUser()->getId() ) );
            $this->setForeignModel( $this->getForeignModelList()->get( 0 ) );
        }

        if ( !$this->getForeignModel() )
        {
            throw new BadrequestException( sprintf( "Budget \"%s\" does not exist or no access", self::getUriBudget() ) );
        }

        // /BUDGET


        $year = intval( substr( self::getUriMonth(), 0, 2 ) );
        $month = intval( substr( self::getUriMonth(), 2, 2 ) );
        $time = strtotime( sprintf( "%d-%d-1 01:00:00", $year, $month ) );

        $this->setModelList(
                $this->getDaoContainer()->getEntryDao()->getMonth( $this->getForeignModel()->getId(), $time ) );

        if ( !$this->getModelList()->isEmpty() )
            $this->setModel( $this->getModelList()->get( 0 ) );

        $this->setStatusCode( self::STATUS_OK );
    }

    // ... /DO


    /**
     * @see AbstractStandardRestController::request()
     */
    public function request()
    {
        if ( self::isGetMonthCommand() )
        {
            $this->doGetMonthCommand();
        }
        else
        {
            parent::request();
        }
    }

    // /FUNCTIONS


}

?>