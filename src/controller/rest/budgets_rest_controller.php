<?php

class BudgetsRestController extends AbstractRestController implements InterfaceController
{

    // VARIABLES


    public static $CONTROLLER_NAME = "budgets";

    const URI_BUDGET = 1;

    /**
     * @var DaoContainer
     */
    private $daoContainer;
    /**
     * @var LoginHandler
     */
    private $loginHandler;

    /**
     * @var BudgetListModel
     */
    private $entryBudgets;
    /**
     * @var BudgetModel
     */
    private $budget;
    /**
     * @var CardListModel
     */
    private $cards;
    /**
     * @var TypeListModel
     */
    private $types;
    /**
     * @var IteratorCore
     */
    private $entriesMonths;

    // /VARIABLES


    // CONSTRUCTOR


    /**
     * @see AbstractController::__construct()
     */
    public function __construct( AbstractApi $api, AbstractView $view )
    {
        parent::__construct( $api, $view );

        $this->daoContainer = new DaoContainer( $this->getDbApi() );
        $this->loginHandler = new LoginHandler( $this->getDaoContainer(), $this->getMode( true ) );

        $this->setBudgets( new BudgetListModel() );
        $this->setCards( new CardListModel() );
        $this->setTypes( new TypeListModel() );
        $this->setEntriesMonths( new StandardListModel() );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return BudgetListModel
     */
    public function getBudgets()
    {
        return $this->budgets;
    }

    /**
     * @param BudgetListModel $entryBudgets
     */
    public function setBudgets( BudgetListModel $entryBudgets )
    {
        $this->budgets = $entryBudgets;
    }

    /**
     * @return BudgetModel
     */
    public function getBudget()
    {
        return $this->budget;
    }

    /**
     * @param BudgetModel $budget
     */
    public function setBudget( BudgetModel $budget )
    {
        $this->budget = $budget;
    }

    /**
     * @return CardListModel
     */
    public function getCards()
    {
        return $this->cards;
    }

    /**
     * @return TypeListModel
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * @return StandardListModel
     */
    public function getEntriesMonths()
    {
        return $this->entriesMonths;
    }

    public function setCards( $cards )
    {
        $this->cards = $cards;
    }

    public function setTypes( $types )
    {
        $this->types = $types;
    }

    public function setEntriesMonths( $entryMonths )
    {
        $this->entriesMonths = $entryMonths;
    }

    // ... /GETTERS/SETTERS


    // ... GET


    /**
     * @see InterfaceController::getDaoContainer()
     */
    public function getDaoContainer()
    {
        return $this->daoContainer;
    }

    /**
     * @see InterfaceController::getLoginHandler()
     */
    public function getLoginHandler()
    {
        return $this->loginHandler;
    }

    /**
     * @see InterfaceController::isLoginForce()
     */
    public function isLoginForce()
    {
        return true;
    }

    /**
     * @see AbstractController::getLastModified()
     */
    public function getLastModified()
    {
        return max(
                array ( $this->getBudgets()->getLastModified(), $this->getCards()->getLastModified(),
                        $this->getTypes()->getLastModified(), $this->getEntriesMonths()->getLastModified(),
                        filemtime( __FILE__ ) ) );
    }

    public function getUriBudget()
    {
        return intval( self::getURI( self::URI_BUDGET ) );
    }

    /**
     * @see InterfaceController::getUser()
     */
    public function getUser()
    {
        return $this->getLoginHandler()->getUser();
    }

    // ... /GET


    // ... DO


    // ... ... COMMAND


    private function doBudget()
    {
        // BUDGET


        if ( $this->getUriBudget() )
        {
            $this->budget = $this->daoContainer->getBudgetDao()->getBudget( $this->getUriBudget(),
                    $this->getUser()->getId() );
        }
        else
        {
            $this->budget = $this->getBudgets()->get( 0 );
        }

        if ( !$this->budget )
        {
            throw new BadrequestException( sprintf( "Budget \"%d\" does not exist or no access", $this->getUriBudget() ) );
        }

        // /BUDGET


        $entryMonths = $this->daoContainer->getEntryDao()->getMonths( $this->budget->getId() );
        $entryBudgets = $this->daoContainer->getEntryDao()->getBudgets( $this->budget->getId() );

        for ( $entryBudgets->rewind(); $entryBudgets->valid(); $entryBudgets->next() )
        {
            $budget = BudgetEntryModel::get_( $entryBudgets->current() );
            $month = MonthEntryModel::get_( $entryMonths->getId( $budget->getYearMonth() ) );
            if ( $month )
                $month->addBudget( $budget->getCard(), $budget->getType(), $budget );
        }

        // MONTH BUDGET SUM


        for ( $entryMonths->rewind(); $entryMonths->valid(); $entryMonths->next() )
        {
            $month = MonthEntryModel::get_( $entryMonths->current() );

            $entryBudgetsSum = array ();
            foreach ( $month->getBudgets() as $cardId => $types )
            {
                foreach ( $types as $typeId => $budget )
                {
                    $budget = BudgetEntryModel::get_( $budget );
                    $budgetType = Core::arrayAt( $entryBudgetsSum, $budget->getType() );
                    if ( !$budgetType )
                    {
                        $budgetType = BudgetEntryFactoryModel::createEntryBudget( $budget->getDate(),
                                $budget->getEntries(), $budget->getCostSum(), $budget->getType(), 0 );
                        $entryBudgetsSum[ $budget->getType() ] = $budgetType;
                    }
                    else
                    {
                        $budgetType->setCostSum( $budgetType->getCostSum() + $budget->getCostSum() );
                        $budgetType->setEntries( $budgetType->getEntries() + $budget->getEntries() );
                    }
                }
            }

            foreach ( $entryBudgetsSum as $typeId => $budget )
            {
                $budget->doPrDay();
                $month->addBudget( 0, $typeId, $budget );
            }
        }

        // /MONTH BUDGET SUM


        $this->setEntriesMonths( $entryMonths );

        $this->setCards( $this->daoContainer->getCardDao()->getForeign( array ( $this->budget->getId() ) ) );
        $this->setTypes( $this->daoContainer->getTypeDao()->getForeign( array ( $this->budget->getId() ) ) );
    }

    // ... ... /COMMAND


    // ... /DO


    /**
     * @see AbstractController::request()
     */
    public function request()
    {
        $this->doBudget();
    }

    // /FUNCTIONS


    public function before()
    {
        $this->getLoginHandler()->handle();

        if ( !$this->getLoginHandler()->isLoggedIn() && $this->isLoginForce() )
        {
            throw new UnauthorizedException( "Not logged in" );
        }

        $this->setBudgets( $this->getDaoContainer()->getBudgetDao()->getBudgets( $this->getUser()->getId() ) );
    }

}

?>