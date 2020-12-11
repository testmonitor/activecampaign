<?php

namespace TestMonitor\ActiveCampaign\Actions;

use TestMonitor\ActiveCampaign\Resources\AccountContact;

trait ManagesAccountContacts
{
    use ImplementsActions;

    /**
     * Retrieve all existing account association.
     *
     * @return array
     */
    public function accountContacts()
    {
        return $this->transformCollection(
            $this->get('accountContacts'),
            AccountContact::class,
            'accountContacts'
        );
    }

    /**
     * Retrieve an existing account association given the contactID and accountID.
     *
     * @param int $contactId
     * @param int $accountId
     *
     * @return AccountContact|null
     */
    public function findAccountContact($contactId, $accountId)
    {
        $accounts = $this->transformCollection(
            $this->get('accountContacts', [
                'query' => [
                    'filters[contact]' => $contactId,
                    'filters[account]' => $accountId,
                ],
            ]),
            AccountContact::class,
            'accountContacts'
        );

        return array_shift($accounts);
    }

    /**
     * Retrieve an existing account association.
     *
     * @param int $id
     *
     * @return AccountContact|null
     */
    public function getAccountContact($id)
    {
        $association = $this->transformCollection(
            $this->get("accountContacts/{$id}"),
            AccountContact::class
        );

        return array_shift($association);
    }

    /**
     * Create a new account association.
     *
     * @param int $contact contact ID
     * @param int $account account ID
     * @param string $jobTitle
     *
     * @return AccountContact|null
     */
    public function createAccountContact($contact, $account, $jobTitle)
    {
        $data = compact(['contact', 'account', 'jobTitle']);

        $accounts = $this->transformCollection(
            $this->post('accountContacts', ['json' => ['accountContact' => $data]]),
            AccountContact::class
        );

        return array_shift($accounts);
    }

    /**
     * Update an existing account association.
     *
     * @param int $associationId
     * @param string $jobTitle
     *
     * @return AccountContact|null
     */
    public function updateAccountContact($associationId, $jobTitle)
    {
        $data = compact('jobTitle');

        $accounts = $this->transformCollection(
            $this->put("accountContacts/{$associationId}", ['json' => ['accountContact' => $data]]),
            AccountContact::class
        );

        return array_shift($accounts);
    }

    /**
     * Find or create an account contact association.
     *
     * @param int $contact contact ID
     * @param int $account account ID
     * @param string $jobTitle
     *
     * @return AccountContact
     */
    public function findOrCreateAccountContact($contact, $account, $jobTitle)
    {
        $association = $this->findAccountContact($contact, $account);

        if ($association instanceof AccountContact) {
            return $association;
        }

        return $this->createAccountContact($contact, $account, $jobTitle);
    }

    /**
     * Update or create an account contact.
     *
     * @param int $contact contact ID
     * @param int $account account ID
     * @param string $jobTitle
     *
     * @return AccountContact
     */
    public function updateOrCreateAccountContact($contact, $account, $jobTitle)
    {
        $association = $this->findAccountContact($contact, $account);

        if ($association instanceof AccountContact) {
            return $this->updateAccountContact($association->id, $jobTitle);
        }

        return $this->createAccountContact($contact, $account, $jobTitle);
    }

    /**
     * Delete an existing account association.
     *
     * @param int $associationId
     *
     * @return void
     */
    public function deleteAccountContact($associationId)
    {
        $this->delete("accountContacts/{$associationId}");
    }
}
