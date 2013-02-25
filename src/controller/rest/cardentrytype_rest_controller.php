<?php

abstract class CardentrytypeRestController extends RestController
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see AbstractStandardRestController::getForeignStandardDao()
     */
    protected function getForeignStandardDao()
    {
        return $this->getDaoContainer()->getBudgetDao();
    }

    /**
     * @see RestController::getLastModified()
     */
    public function getLastModified()
    {
        return max( array ( parent::getLastModified(), filemtime( __FILE__ ) ) );
    }

    // ... COMMAND


    /**
     * @see AbstractStandardRestController::doGetAllCommand()
     */
    protected function doGetAllCommand()
    {
        throw new UnsupportedException();
    }

    /**
     * @see AbstractStandardRestController::doGetCommand()
     */
    protected function doGetCommand()
    {
        throw new UnsupportedException();
    }

    /**
     * @see AbstractStandardRestController::doGetMultipleCommand()
     */
    protected function doGetMultipleCommand()
    {
        throw new UnsupportedException();
    }

    // ... /COMMAND


    /**
     * @param int $budgetId
     * @throws BadrequestException
     * @return BudgetModel
     */
    private function doCheckAccess( $budgetId )
    {
        $budget = $this->getForeignStandardDao()->getBudget( $budgetId, $this->getUser()->getId() );

        if ( !$budget )
        {
            throw new BadrequestException( sprintf( "User has not access to Budget \"%d\"", $budgetId ) );
        }

        return $budget;
    }

    /**
     * @see AbstractStandardRestController::beforeIsAdd()
     */
    protected function beforeIsAdd()
    {
        parent::beforeIsAdd();
        $this->doCheckAccess( $this->getForeignModel()->getId() );
    }

    /**
     * @see AbstractStandardRestController::beforeIsEditDelete()
     */
    protected function beforeIsEditDelete()
    {
        parent::beforeIsEditDelete();
        $this->doCheckAccess( $this->getModel()->getForeignId() );
    }

    /**
     * @see AbstractStandardRestController::doGetForeign()
     */
    protected function doGetForeign( array $ids )
    {
        $budget = $this->doCheckAccess( Core::arrayAt( $ids, 0 ) );

        return $this->getStandardDao()->getForeign( array ( $budget->getId() ) );
    }

    // /FUNCTIONS


}

?>