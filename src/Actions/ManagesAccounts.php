<?php

namespace TestMonitor\ActiveCampaign\Actions;

use TestMonitor\ActiveCampaign\Resources\Account;

trait ManagesAccounts
{
    use ImplementsActions;

    /**
     * Get all accounts.
     *
     * @return array
     */
    public function accounts()
    {
        return $this->transformCollection(
            $this->get('accounts'),
            Account::class,
            'accounts'
        );
    }

    /**
     * Find account by name.
     *
     * @param string $name
     *
     * @return Account|null
     */
    public function findAccount($name)
    {
        $accounts = $this->transformCollection(
            $this->get('accounts', ['query' => ['search' => $name]]),
            Account::class,
            'accounts'
        );

        return array_shift($accounts);
    }

    /**
     * Create new account.
     *
     * @param array $data
     *
     * @return Account|null
     */
    public function createAccount(array $data = [])
    {
        $accounts = $this->transformCollection(
            $this->post('accounts', ['json' => ['account' => $data]]),
            Account::class
        );

        return array_shift($accounts);
    }

    /**
     * Update an account.
     *
     * @param int $accountId
     * @param array $data
     *
     * @return Account|null
     */
    public function updateAccount($accountId, array $data = [])
    {
        $accounts = $this->transformCollection(
            $this->put("accounts/{$accountId}", ['json' => ['account' => $data]]),
            Account::class
        );

        return array_shift($accounts);
    }

    /**
     * Find or create an account.
     *
     * @param string $name
     * @param array $data
     *
     * @return Account
     */
    public function findOrCreateAccount($name, array $data = [])
    {
        $account = $this->findAccount($name);

        if ($account instanceof Account) {
            return $account;
        }

        if (empty($data)) {
            $data = ['name' => $name];
        }

        return $this->createAccount($data);
    }

    /**
     * Update or create an account.
     *
     * @param string $name
     * @param array $data
     *
     * @return Account
     */
    public function updateOrCreateAccount($name, array $data = [])
    {
        $account = $this->findAccount($name);

        if ($account instanceof Account) {
            return $this->updateAccount($account->id, $data);
        }

        if (empty($data)) {
            $data = ['name' => $name];
        }

        return $this->createAccount($data);
    }
}
