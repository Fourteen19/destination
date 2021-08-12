<?php

namespace App\Extensions\Passwords;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\Passwords\DatabaseTokenRepository as DatabaseTokenRepositoryBase;

class CustomDatabaseTokenRepository extends DatabaseTokenRepositoryBase
{


    /**
     * Create a new token record.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @return string
     */
    public function create(CanResetPasswordContract $user)
    {

        //needs to the email from the form as the user has 2 email addresses
        //He could use his school email or personal email
        $email = filter_var( request()['email'], FILTER_SANITIZE_EMAIL);//$user->getEmailForPasswordReset();

        $this->deleteExisting($user);

        // We will create a new, random token for the user so that we can e-mail them
        // a safe link to the password reset form. Then we will insert a record in
        // the database so that we can verify the token within the actual reset.
        $token = $this->createNewToken();

        $this->getTable()->insert($this->getPayload($email, $token));

        return $token;
    }




    /**
     * Delete all existing reset tokens from the database.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @return int
     */
    protected function deleteExisting(CanResetPasswordContract $user)
    {
        //gets user personal email
        $personalEmail = $user->getPersonalEmailForPasswordReset();

        $query = $this->getTable()->where('email', $user->getEmailForPasswordReset());

        //if the user has a personal email, extends the query
        if ($personalEmail)
        {
            $query = $query->orWhere('email', $personalEmail);
        }

        return $query->delete();

    }



    /**
     * Determine if a token record exists and is valid.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $token
     * @return bool
     */
    public function exists(CanResetPasswordContract $user, $token)
    {
        //gets user personal email
        $personalEmail = $user->getPersonalEmailForPasswordReset();

        $record = (array) $this->getTable()->where(
            'email', $user->getEmailForPasswordReset()
        );

        //if the user has a personal email, extends the query
        if ($personalEmail)
        {
            $record = $record->orWhere('email', $personalEmail);
        }

        $record = $record->first();

        return $record &&
               ! $this->tokenExpired($record['created_at']) &&
                 $this->hasher->check($token, $record['token']);
    }



    /**
     * Determine if the given user recently created a password reset token.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @return bool
     */
    public function recentlyCreatedToken(CanResetPasswordContract $user)
    {

        //gets user personal email
        $personalEmail = $user->getPersonalEmailForPasswordReset();

        $record = $this->getTable()->where(
            'email', $user->getEmailForPasswordReset()
        );

        //if the user has a personal email, extends the query
        if ($personalEmail)
        {
            $record = $record->orWhere('email', $personalEmail);
        }

        $record = (array)  $record->first();

        return $record && $this->tokenRecentlyCreated($record['created_at']);
    }



}
