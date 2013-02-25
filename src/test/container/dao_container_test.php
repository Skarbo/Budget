<?php

class DaoContainerTest extends DaoContainer implements InterfaceDaoContainerTest
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... CREATE


    /**
     * @param string $title
     * @return BudgetModel
     */
    public function createBudget( $title = "Budget" )
    {
        return BudgetFactoryModel::createBudget( $title );
    }

    /**
     * @param unknown_type $title
     * @return TypeModel
     */
    public function createType( $title = "Type" )
    {
        return TypeFactoryModel::createType( $title );
    }

    /**
     * @param unknown_type $title
     * @param unknown_type $number
     * @return CardModel
     */
    public function createCard( $title = "Card", $number = "1234" )
    {
        return CardFactoryModel::createCard( $title, $number );
    }

    /**
     * @return EntryModel
     */
    public function createEntry( $budgetId, $typeId, $cardId, $cost = 123, $date = null )
    {
        $date = $date ? $date : strtotime( "00:00" );
        $entry = EntryFactoryModel::createEntry( $cost, $typeId, $cardId, $date );
        $entry->setBudgetId( $budgetId );
        return $entry;
    }

    /**
     * @param string $name
     * @param string $email
     * @return UserModel
     */
    public function createUser( $name = "User Test", $email = "test@email.com" )
    {
        return UserFactoryModel::createUser( $name, $email );
    }

    /**
     * @param int $userId
     * @param string $userAuthId
     * @param string $userAuthType
     * @param int $userAuthLastLoggedin
     * @return AuthUserModel
     */
    public function createAuthUser( $userId, $userAuthId = "1234", $userAuthType = AuthUserModel::AUTH_TYPE_DEMO, $userAuthLastLoggedin = null )
    {
        return AuthUserFactoryModel::createAuthUser( $userAuthId, $userId, $userAuthType, $userAuthLastLoggedin );
    }

    // ... /CREATE


    // ... ADD


    /**
     * @param BudgetModel $budget
     * @return BudgetModel
     */
    public function addBudget( BudgetModel $budget = null )
    {
        $budget = $budget ? $budget : $this->createBudget();
        $budget->setId( $this->getBudgetDao()->add( $budget, null ) );
        return $budget;
    }

    /**
     * @param TypeModel $type
     * @return TypeModel
     */
    public function addType( TypeModel $type = null )
    {
        $type = $type ? $type : $this->createType();
        $this->getTypeDao()->add( $type, null );
        return $type;
    }

    /**
     * @param CardModel $card
     * @return CardModel
     */
    public function addCard( CardModel $card = null )
    {
        $card = $card ? $card : $this->createCard();
        $card->setId( $this->getCardDao()->add( $card, null ) );
        return $card;
    }

    /**
     * @param UserModel $user
     * @return UserModel
     */
    public function addUser( UserModel $user = null )
    {
        $user = $user ? $user : $this->createUser();
        $user->setId( $this->getUserDao()->add( $user, null ) );
        return $user;
    }

    /**
     * @param int $userId
     * @param AuthUserModel $authUser
     * @return AuthUserModel
     */
    public function addAuthUser( $userId, AuthUserModel $authUser = null )
    {
        $authUser = $authUser ? $authUser : $this->createAuthUser( $userId );
        $this->getAuthUserDao()->add( $authUser, $userId );
        return $authUser;
    }

    // ... /ADD


    public function removeAll()
    {
        $this->getBudgetDao()->removeAll();
        $this->getEntryDao()->removeAll();
        $this->getCardDao()->removeAll();
        $this->getTypeDao()->removeAll();
        $this->getUserDao()->removeAll();
    }

    // /FUNCTIONS


}

?>