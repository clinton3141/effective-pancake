<?php

namespace App\Repositories;

use Illuminate\Contracts\Session\Session;

class ListRepository {
    const SESSION_TAG = 'shoppingList';

    function __construct(private Session $session) {

    }
    public function getAll(): array {
        return $this->session->get(self::SESSION_TAG) ?? [];
    }
}
