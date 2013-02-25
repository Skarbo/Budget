<?php

class DbResource extends AbstractDbResource
{

    // VARIABLES


    private static $CARD, $ENTRY, $TYPE;
    private static $BUDGET, $USER, $AUTHUSER;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return CardDbResource
     */
    public static function card()
    {
        self::$CARD = self::$CARD ? self::$CARD : new CardDbResource();
        return self::$CARD;
    }

    /**
     * @return EntryDbResource
     */
    public static function entry()
    {
        self::$ENTRY = self::$ENTRY ? self::$ENTRY : new EntryDbResource();
        return self::$ENTRY;
    }

    /**
     * @return TypeDbResource
     */
    public static function type()
    {
        self::$TYPE = self::$TYPE ? self::$TYPE : new TypeDbResource();
        return self::$TYPE;
    }

    /**
     * @return UserDbResource
     */
    public static function user()
    {
        self::$USER = self::$USER ? self::$USER : new UserDbResource();
        return self::$USER;
    }

    /**
     * @return AuthUserDbResource
     */
    public static function authUser()
    {
        self::$AUTHUSER = self::$AUTHUSER ? self::$AUTHUSER : new AuthUserDbResource();
        return self::$AUTHUSER;
    }

    /**
     * @return BudgetDbResource
     */
    public static function budget()
    {
        self::$BUDGET = self::$BUDGET ? self::$BUDGET : new BudgetDbResource();
        return self::$BUDGET;
    }

    // /FUNCTIONS


}

?>