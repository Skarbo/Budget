<?php

class DaoContainer extends AbstractDaoContainer
{

    // VARIABLES


    /**
     * @var BudgetDao
     */
    private $budgetDao;
    /**
     * @var CardDao
     */
    private $cardDao;
    /**
     * @var EntryDao
     */
    private $entryDao;
    /**
     * @var TypeDao
     */
    private $typeDao;
    /**
     * @var UserDao
     */
    private $userDao;
    /**
     * @var AuthUserDao
     */
    private $authUserDao;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( DbApi $dbApi )
    {
        $this->budgetDao = new BudgetDbDao( $dbApi );
        $this->cardDao = new CardDbDao( $dbApi );
        $this->entryDao = new EntryDbDao( $dbApi );
        $this->typeDao = new TypeDbDao( $dbApi );
        $this->userDao = new UserDbDao( $dbApi );
        $this->authUserDao = new AuthUserDbDao( $dbApi );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return CardDao
     */
    public function getCardDao()
    {
        return $this->cardDao;
    }

    /**
     * @return EntryDao
     */
    public function getEntryDao()
    {
        return $this->entryDao;
    }

    /**
     * @return TypeDao
     */
    public function getTypeDao()
    {
        return $this->typeDao;
    }

    /**
     * @return UserDao
     */
    public function getUserDao()
    {
        return $this->userDao;
    }

    /**
     * @return AuthUserDao
     */
    public function getAuthUserDao()
    {
        return $this->authUserDao;
    }

    // /FUNCTIONS


    /**
     * @return BudgetDao
     */
    public function getBudgetDao()
    {
        return $this->budgetDao;
    }

}

?>